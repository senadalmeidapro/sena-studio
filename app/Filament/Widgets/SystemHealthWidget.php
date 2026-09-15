<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class SystemHealthWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Santé de l’application';

    protected ?string $description = 'Contrôles rapides du runtime et des services critiques.';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $databaseHealthy = $this->checkDatabase();
        $cacheHealthy = $this->checkCache();
        $cloudinaryConfigured = filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));

        return [
            Stat::make('Base de données', $databaseHealthy ? 'Opérationnelle' : 'Erreur')
                ->description(config('database.default'))
                ->descriptionIcon($databaseHealthy ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle')
                ->color($databaseHealthy ? 'success' : 'danger'),

            Stat::make('Cache', $cacheHealthy ? 'Opérationnel' : 'Erreur')
                ->description(config('cache.default'))
                ->descriptionIcon($cacheHealthy ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle')
                ->color($cacheHealthy ? 'success' : 'danger'),

            Stat::make('Cloudinary', $cloudinaryConfigured ? 'Configuré' : 'À vérifier')
                ->description($cloudinaryConfigured ? 'Identifiants présents' : 'Identifiants manquants')
                ->descriptionIcon($cloudinaryConfigured ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                ->color($cloudinaryConfigured ? 'success' : 'warning'),

            Stat::make('Environnement', app()->environment())
                ->description(config('app.debug') ? 'Mode debug actif' : 'Mode debug désactivé')
                ->descriptionIcon(config('app.debug') ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-shield-check')
                ->color(config('app.debug') ? 'warning' : 'success'),
        ];
    }

    private function checkDatabase(): bool
    {
        try {
            DB::select('select 1');

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function checkCache(): bool
    {
        $key = 'filament:health:cache-probe';

        try {
            Cache::put($key, true, 10);
            $healthy = Cache::get($key) === true;
            Cache::forget($key);

            return $healthy;
        } catch (Throwable) {
            return false;
        }
    }
}
