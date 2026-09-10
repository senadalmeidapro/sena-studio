<?php

namespace App\Services;

use Cloudinary\Uploader;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;

class CloudinaryService
{
    private function configure(): void
    {
        \Cloudinary::config([
            'cloud_name' => config('cloudinary.cloud_name'),
            'api_key' => config('cloudinary.api_key'),
            'api_secret' => config('cloudinary.api_secret'),
            'secure' => true,
        ]);
    }

    public function upload(
        string $filePath,
        string $folder = 'sena-studio'
    ): array {
        $this->configure();

        return Uploader::upload(
            $filePath,
            [
                'folder' => $folder,
            ]
        );
    }

    public function delete(string $publicId): array
    {
        $this->configure();

        return Uploader::destroy($publicId);
    }

    /**
     * FileUpload apte à prévisualiser aussi bien un fichier local
     * qu'une URL Cloudinary (qui n'existe pas sur le disque local).
     */
    public function fileUpload(string $name): FileUpload
    {
        return FileUpload::make($name)
            ->fetchFileInformation(false)
            ->getUploadedFileUsing(static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
                if (Str::startsWith($file, ['http://', 'https://'])) {
                    return [
                        'url' => $file,
                        'openableUrl' => $file,
                        'downloadableUrl' => $file,
                    ];
                }

                return $component->getUploadedFile($file, $storedFileNames);
            });
    }
}
