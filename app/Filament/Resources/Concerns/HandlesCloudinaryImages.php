<?php

namespace App\Filament\Resources\Concerns;

use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait HandlesCloudinaryImages
{
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
        $oldValue = $this->record->getRawOriginal($field);
        $oldPublicId = $this->record->cloudinary_public_id;
        $service = app(CloudinaryService::class);

        Log::info('DIAG_SAVE', [
            'field' => $field,
            'value' => $value,
            'oldValue' => $oldValue,
            'oldPublicId' => $oldPublicId,
            'exists_public' => is_string($value) ? $disk->exists($value) : null,
            'exists_local' => is_string($value) ? Storage::disk('local')->exists($value) : null,
            'projectImages.paths' => collect(($data['projectImages'] ?? []))->map(fn ($row) => $row['path'] ?? null)->values()->toArray(),
            'projectImages.count' => count($data['projectImages'] ?? []),
            'livewire_tmp' => collect(Storage::disk('local')->files('livewire-tmp'))->toArray(),
        ]);

        /*
         * Image retirée : suppression de l'ancien asset Cloudinary
         * et de l'éventuel fichier local historique.
         */
        if (blank($value)) {
            $this->deleteCloudinaryAsset($oldPublicId);

            $this->deleteLocalImage($disk, $oldValue);

            $data[$field] = null;
            $data['cloudinary_public_id'] = null;

            return $data;
        }

        /*
         * Image inchangée : URL Cloudinary déjà en base ou même chemin local.
         */
        if (Str::startsWith($value, ['http://', 'https://']) || $value === $oldValue) {
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

            $this->deleteCloudinaryAsset($oldPublicId);

            $disk->delete($value);

            $this->deleteLocalImage($disk, $oldValue);
        } catch (Throwable $e) {
            report($e);

            throw $e;
        }

        Log::info('DIAG_EDIT_RESULT', ['field' => $field, 'data_image' => $data[$field] ?? null]);

        return $data;
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
