<?php

namespace App\Services;

use Cloudinary\Api\Exception\NotFound;
use Cloudinary\Cloudinary;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class CloudinaryService
{
    private function configure(): Cloudinary
    {
        $cloudName = config('cloudinary.cloud_name');
        $apiKey = config('cloudinary.api_key');
        $apiSecret = config('cloudinary.api_secret');

        if (blank($cloudName) || blank($apiKey) || blank($apiSecret)) {
            throw new InvalidArgumentException('Cloudinary is not configured. Set CLOUDINARY_URL or CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY and CLOUDINARY_API_SECRET.');
        }

        return new Cloudinary([
            'cloud' => [
                'cloud_name' => $cloudName,
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    public function delete(string $publicId): array
    {
        $cloudinary = $this->configure();

        return $cloudinary->uploadApi()->destroy($publicId, ['invalidate' => true])->getArrayCopy();
    }

    public function secureUrl(string $publicId, string $resourceType = 'image'): ?string
    {
        try {
            $response = $this->configure()->uploadApi()->explicit($publicId, [
                'type' => 'upload',
                'resource_type' => $resourceType,
            ]);

            $url = data_get($response->getArrayCopy(), 'secure_url');

            return filled($url) ? $url : null;
        } catch (NotFound) {
            return null;
        } catch (Throwable $e) {
            report($e);

            return null;
        }
    }

    public function publicIdFromUrl(string $url): ?string
    {
        if (! Str::startsWith($url, ['http://', 'https://'])) {
            return ltrim($url, '/');
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || ! Str::contains($path, '/upload/')) {
            return null;
        }

        $assetPath = Str::after($path, '/upload/');
        $segments = explode('/', trim($assetPath, '/'));

        if (isset($segments[0]) && preg_match('/^v\d+$/', $segments[0])) {
            array_shift($segments);
        }

        $publicId = implode('/', $segments);

        return preg_replace('/\.[^.]+$/', '', $publicId) ?: $publicId;
    }

    /**
     * Resolves both legacy disk URLs and current Cloudinary delivery URLs.
     * Legacy URLs may contain the asset extension only once, while Cloudinary
     * delivery adds the format extension a second time.
     *
     * @return array{url: string, public_id: string}|null
     */
    public function resolveSecureUrl(string $url): ?array
    {
        if (! Str::startsWith($url, ['http://', 'https://'])) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (! is_string($path) || ! Str::contains($path, '/upload/')) {
            return null;
        }

        $assetPath = Str::after($path, '/upload/');
        $segments = explode('/', trim($assetPath, '/'));

        if (isset($segments[0]) && preg_match('/^v\d+$/', $segments[0])) {
            array_shift($segments);
        }

        $assetPath = implode('/', $segments);
        $candidates = array_unique([
            $this->publicIdFromUrl($url),
            $assetPath,
        ]);

        foreach ($candidates as $publicId) {
            if (blank($publicId)) {
                continue;
            }

            $secureUrl = $this->secureUrl($publicId);

            if (filled($secureUrl)) {
                return [
                    'url' => $secureUrl,
                    'public_id' => $publicId,
                ];
            }
        }

        return null;
    }

    /**
     * FileUpload apte à prévisualiser aussi bien un fichier local,
     * une ressource du dossier public/ (ex. seed des screenshots)
     * qu'une URL Cloudinary (qui n'existe pas sur le disque local).
     */
    public function fileUpload(string $name): FileUpload
    {
        return FileUpload::make($name)
            ->disk('cloudinary')
            ->fetchFileInformation(false)
            ->preventFilePathTampering(
                allowFilePathUsing: static function (string $file): bool {
                    if (Str::startsWith($file, ['images/screenshots/', 'images/brand/'])) {
                        return true;
                    }

                    $host = parse_url($file, PHP_URL_HOST);

                    return in_array($host, [
                        'res.cloudinary.com',
                        'cloudinary.com',
                    ], true);
                },
            )
            ->deleteUploadedFileUsing(static function (mixed $file): void {
                if (! is_string($file)) {
                    return;
                }

                $service = app(self::class);
                $publicId = $service->resolveSecureUrl($file)['public_id']
                    ?? $service->publicIdFromUrl($file);

                if (filled($publicId)) {
                    $service->delete($publicId);
                }
            })
            ->getUploadedFileUsing(static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
                if (Str::startsWith($file, ['http://', 'https://'])) {
                    return [
                        'name' => basename($file),
                        'size' => 0,
                        'type' => null,
                        'url' => $file,
                        'openableUrl' => $file,
                        'downloadableUrl' => $file,
                    ];
                }

                $disk = $component->getDisk();

                if ($disk->exists($file)) {
                    return $component->getUploadedFile($file, $storedFileNames);
                }

                $sourcePath = public_path($file);

                return [
                    'name' => basename($file),
                    'size' => is_file($sourcePath) ? filesize($sourcePath) : 0,
                    'type' => is_file($sourcePath) ? mime_content_type($sourcePath) : null,
                    'url' => asset($file),
                    'openableUrl' => asset($file),
                    'downloadableUrl' => asset($file),
                ];
            });
    }
}
