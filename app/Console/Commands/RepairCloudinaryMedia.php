<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Testimonial;
use App\Services\CloudinaryService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RepairCloudinaryMedia extends Command
{
    protected $signature = 'media:repair {--dry-run : Inspect media without changing database records}';

    protected $description = 'Inspect and repair legacy Cloudinary media URLs.';

    public function handle(CloudinaryService $cloudinary): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $repaired = 0;
        $unresolved = 0;

        $repaired += $this->repairModels($cloudinary, Project::query()->whereNotNull('image')->cursor(), 'image', $dryRun, $unresolved);
        $repaired += $this->repairModels($cloudinary, ProjectImage::query()->whereNotNull('path')->cursor(), 'path', $dryRun, $unresolved);
        $repaired += $this->repairModels($cloudinary, Post::query()->whereNotNull('cover_image')->cursor(), 'cover_image', $dryRun, $unresolved);
        $repaired += $this->repairModels($cloudinary, Testimonial::query()->whereNotNull('avatar')->cursor(), 'avatar', $dryRun, $unresolved);

        $action = $dryRun ? 'à réparer' : 'réparé(s)';
        $this->info("Médias {$action} : {$repaired}.");

        if ($unresolved > 0) {
            $this->warn("Médias non résolus : {$unresolved}.");
        }

        return self::SUCCESS;
    }

    /**
     * @param  iterable<Model>  $models
     */
    private function repairModels(
        CloudinaryService $cloudinary,
        iterable $models,
        string $field,
        bool $dryRun,
        int &$unresolved,
    ): int {
        $count = 0;

        foreach ($models as $model) {
            $value = $model->getAttribute($field);

            if (! is_string($value) || blank($value)) {
                continue;
            }

            if (Str::startsWith($value, ['images/screenshots/', 'images/brand/'])) {
                continue;
            }

            $candidateUrl = Str::startsWith($value, ['http://', 'https://'])
                ? $value
                : Storage::disk('cloudinary')->url($value);

            if (! is_string($candidateUrl) || blank($candidateUrl)) {
                $unresolved++;

                continue;
            }

            $resolved = $cloudinary->resolveSecureUrl($candidateUrl) ?? [
                'url' => $candidateUrl,
                'public_id' => $cloudinary->publicIdFromUrl($candidateUrl) ?: ltrim($value, '/'),
            ];

            if (blank($resolved['public_id'] ?? null)) {
                $unresolved++;
                $this->warn('Impossible de résoudre '.$model::class.' #'.$model->getKey().' ('.$field.').');

                continue;
            }

            $count++;

            if ($dryRun) {
                $this->line($model::class.' #'.$model->getKey().' : '.$resolved['url']);

                continue;
            }

            $model->forceFill([
                $field => $resolved['url'],
                'cloudinary_public_id' => $resolved['public_id'],
            ])->saveQuietly();
        }

        return $count;
    }
}
