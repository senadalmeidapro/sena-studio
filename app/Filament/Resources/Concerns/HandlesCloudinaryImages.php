<?php

namespace App\Filament\Resources\Concerns;

use App\Models\ProjectImage;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait HandlesCloudinaryImages
{
    protected ?string $pendingCloudinaryPublicId = null;

    protected ?string $pendingLocalImagePath = null;

    protected bool $hasPendingCloudinaryCleanup = false;

    /**
     * Uploade l'image locale (déjà stockée par FileUpload)
     * puis met à jour le record avec l'URL et le public_id Cloudinary.
     */
    protected function uploadLocalImageToCloudinary(string $field, string $folder): void
    {
        $path = $this->record->getAttribute($field);

        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return;
        }

        try {
            $result = app(CloudinaryService::class)->upload($disk->path($path), $folder);

            $this->record->update([
                $field => $result['secure_url'],
                'cloudinary_public_id' => $result['public_id'] ?? null,
            ]);

            $disk->delete($path);
        } catch (Throwable $e) {
            $disk->delete($path);
            $this->record->forceFill([
                $field => null,
                'cloudinary_public_id' => null,
            ])->saveQuietly();

            report($e);

            throw $e;
        }
    }

    /**
     * Prépare les données du formulaire avant sauvegarde :
     * - image retirée  -> supprime l'ancien asset Cloudinary / fichier local ;
     * - URL inchangée  -> conservation ;
     * - nouveau fichier -> upload Cloudinary + nettoyage de l'ancien asset.
     */
    protected function cloudinaryFormImage(array $data, string $field, string $folder): array
    {
        $disk = Storage::disk('public');
        $value = $data[$field] ?? null;
        $oldValue = $this->record?->getRawOriginal($field);
        $oldPublicId = $this->record?->cloudinary_public_id;
        $service = app(CloudinaryService::class);

        if (is_string($oldValue) && Str::startsWith($oldValue, ['http://', 'https://'])) {
            $resolvedOldImage = $service->resolveSecureUrl($oldValue);
            $oldPublicId = $resolvedOldImage['public_id'] ?? $oldPublicId;
        }

        /*
         * Image retirée : suppression de l'ancien asset Cloudinary
         * et de l'éventuel fichier local historique.
         */
        if (blank($value)) {
            $this->queueCloudinaryCleanup($oldPublicId, $oldValue);

            $data[$field] = null;
            $data['cloudinary_public_id'] = null;

            return $data;
        }

        /*
         * Image inchangée : URL Cloudinary déjà en base ou même chemin local.
         */
        if (Str::startsWith($value, ['http://', 'https://'])) {
            $resolved = $service->resolveSecureUrl($value);

            if ($resolved !== null) {
                $data[$field] = $resolved['url'];
                $data['cloudinary_public_id'] = $resolved['public_id'];
            }

            return $data;
        }

        if ($value === $oldValue) {
            return $data;
        }

        $cloudinaryDisk = Storage::disk('cloudinary');

        if ($cloudinaryDisk->exists($value)) {
            $data['cloudinary_public_id'] = ltrim($value, '/');
            $data[$field] = $service->secureUrl($data['cloudinary_public_id'])
                ?? $cloudinaryDisk->url($value);
            $this->queueCloudinaryCleanup($oldPublicId, $oldValue);

            return $data;
        }

        /*
         * Nouveau fichier local envoyé par FileUpload.
         */
        if (! $disk->exists($value)) {
            return $data;
        }

        try {
            $result = $service->upload($disk->path($value), $folder);

            $data[$field] = $result['secure_url'];
            $data['cloudinary_public_id'] = $result['public_id'] ?? null;

            $disk->delete($value);
            $this->queueCloudinaryCleanup($oldPublicId, $oldValue);
        } catch (Throwable $e) {
            report($e);

            throw $e;
        }

        return $data;
    }

    protected function finalizeCloudinaryCleanup(): void
    {
        if (! $this->hasPendingCloudinaryCleanup) {
            return;
        }

        $this->deleteCloudinaryAsset($this->pendingCloudinaryPublicId);
        $this->deleteLocalImage(Storage::disk('public'), $this->pendingLocalImagePath);

        $this->pendingCloudinaryPublicId = null;
        $this->pendingLocalImagePath = null;
        $this->hasPendingCloudinaryCleanup = false;
    }

    protected function normalizeCloudinaryProjectImages(): void
    {
        if (! method_exists($this->record, 'projectImages')) {
            return;
        }

        $disk = Storage::disk('cloudinary');

        foreach ($this->record->projectImages()->get() as $image) {
            if (
                ! $image instanceof ProjectImage
                || blank($image->path)
                || Str::startsWith($image->path, ['http://', 'https://'])
                || ! $disk->exists($image->path)
            ) {
                continue;
            }

            $path = $image->path;
            $publicId = $image->cloudinary_public_id
                ?: ltrim($path, '/');

            $image->forceFill([
                'path' => app(CloudinaryService::class)->secureUrl($publicId) ?? $disk->url($path),
                'cloudinary_public_id' => $publicId,
            ])->saveQuietly();
        }
    }

    private function queueCloudinaryCleanup(?string $publicId, ?string $localPath): void
    {
        $this->pendingCloudinaryPublicId = $publicId;
        $this->pendingLocalImagePath = $localPath;
        $this->hasPendingCloudinaryCleanup = filled($publicId) || filled($localPath);
    }

    protected function deleteCloudinaryAsset(?string $publicId): void
    {
        if (blank($publicId)) {
            return;
        }

        try {
            app(CloudinaryService::class)->delete($publicId);
        } catch (Throwable $e) {
            report($e);
        }
    }

    private function deleteLocalImage($disk, ?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://']) || ! $disk->exists($path)) {
            return;
        }

        $disk->delete($path);
    }
}
