<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use InvalidArgumentException;
use UnexpectedValueException;

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

    public function upload(
        string $filePath,
        string $folder = 'sena-studio'
    ): array {
        $cloudinary = $this->configure();

        if (! is_file($filePath) || ! is_readable($filePath)) {
            throw new InvalidArgumentException('The file to upload does not exist or is not readable.');
        }

        $result = $cloudinary->uploadApi()->upload(
            $filePath,
            [
                'folder' => $folder,
            ]
        );

        $result = $result->getArrayCopy();

        if (blank(data_get($result, 'secure_url')) || blank(data_get($result, 'public_id'))) {
            throw new UnexpectedValueException('Cloudinary returned an incomplete upload response.');
        }

        return $result;
    }

    public function delete(string $publicId): array
    {
        $cloudinary = $this->configure();

        return $cloudinary->uploadApi()->destroy($publicId, ['invalidate' => true])->getArrayCopy();
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
