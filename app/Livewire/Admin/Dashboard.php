<?php

namespace App\Livewire\Admin;

use App\Enums\InfraEnvironment;
use App\Enums\ProjectStatus;
use App\Enums\SkillLevel;
use App\Models\AdminActivityLog;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Cv;
use App\Models\Infra;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin')]
#[Title('Tableau de bord')]
class Dashboard extends Component
{
    public function render(): View
    {
        $traffic = PageView::query()->public();
        $viewsToday = (clone $traffic)->where('created_at', '>=', today())->count();
        $uniqueToday = (clone $traffic)->where('created_at', '>=', today())->distinct('ip_hash')->count('ip_hash');

        return view('livewire.admin.dashboard', [
            'overview' => [
                ['label' => 'Utilisateurs', 'value' => User::query()->count(), 'detail' => 'Comptes administrateurs', 'tone' => 'slate'],
                ['label' => 'Projets', 'value' => Project::query()->count(), 'detail' => 'Projets référencés', 'tone' => 'blue'],
                ['label' => 'En production', 'value' => Project::query()->where('status', ProjectStatus::Production)->count(), 'detail' => 'Disponibles publiquement', 'tone' => 'emerald'],
                ['label' => 'Messages non lus', 'value' => ContactMessage::unread()->count(), 'detail' => 'Demandes en attente', 'tone' => 'amber'],
                ['label' => 'Compétences', 'value' => Skill::query()->count(), 'detail' => 'Compétences listées', 'tone' => 'sky'],
                ['label' => 'Stacks et infra', 'value' => Stack::query()->count() + Infra::query()->count(), 'detail' => Stack::query()->count().' stacks · '.Infra::query()->count().' infra', 'tone' => 'slate'],
            ],
            'trafficStats' => [
                ['label' => 'Vues aujourd’hui', 'value' => $viewsToday, 'detail' => 'Pages vues'],
                ['label' => 'Visiteurs uniques', 'value' => $uniqueToday, 'detail' => 'Aujourd’hui'],
                ['label' => 'Vues · 7 jours', 'value' => (clone $traffic)->since(7)->count(), 'detail' => 'Dernière semaine'],
                ['label' => 'Vues · 30 jours', 'value' => (clone $traffic)->since(30)->count(), 'detail' => 'Dernier mois'],
            ],
            'trafficSeries' => $this->dailySeries($traffic, 30),
            'activitySeries' => $this->activitySeries(),
            'messageSeries' => $this->monthlySeries(ContactMessage::query(), 6, 'created_at'),
            'publicationSeries' => $this->monthlySeries(Post::query()->where('status', Post::STATUS_PUBLISHED), 12, 'published_at'),
            'localeSeries' => $this->localeSeries(),
            'topPages' => PageView::query()->public()->since(30)->get(['path'])->groupBy('path')->map->count()->sortDesc()->take(10),
            'projectStatuses' => $this->enumCounts(Project::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'), ProjectStatus::cases()),
            'stackDistribution' => Stack::query()->withCount('projects')->orderByDesc('projects_count')->limit(10)->get(['id', 'name', 'projects_count']),
            'skillLevels' => $this->enumCounts(Skill::query()->get(['level'])->groupBy(fn (Skill $skill): string => $skill->level?->value ?? 'unknown')->map->count(), SkillLevel::cases()),
            'skillsByCategory' => Category::query()->withCount('skills')->orderByDesc('skills_count')->limit(10)->get(['id', 'name', 'skills_count']),
            'contentStats' => [
                ['title' => 'Portefeuille', 'items' => [['label' => 'Total', 'value' => Project::count()], ['label' => 'Production', 'value' => Project::where('status', ProjectStatus::Production)->count()], ['label' => 'Public', 'value' => Project::where('visibility', 'public')->count()], ['label' => 'Cette année', 'value' => Project::where('status', '!=', 'cancelled')->where('started_at', '>=', now()->startOfYear())->count()]]],
                ['title' => 'Articles', 'items' => [['label' => 'Total', 'value' => Post::count()], ['label' => 'Publiés', 'value' => Post::where('status', Post::STATUS_PUBLISHED)->count()], ['label' => 'Brouillons', 'value' => Post::where('status', Post::STATUS_DRAFT)->count()], ['label' => 'Ce mois', 'value' => Post::where('status', Post::STATUS_PUBLISHED)->where('published_at', '>=', now()->startOfMonth())->count()]]],
                ['title' => 'CV', 'items' => [['label' => 'Total', 'value' => Cv::count()], ['label' => 'Publiés', 'value' => Cv::where('status', 'published')->count()], ['label' => 'Brouillons', 'value' => Cv::where('status', 'draft')->count()], ['label' => 'Principal', 'value' => Cv::where('is_primary', true)->count()]]],
                ['title' => 'Compétences', 'items' => [['label' => 'Total', 'value' => Skill::count()], ['label' => 'Actives', 'value' => Skill::where('is_active', true)->count()], ['label' => 'Expertise', 'value' => Skill::where('level', 'expert')->count()]]],
                ['title' => 'Stacks techniques', 'items' => [['label' => 'Total', 'value' => Stack::count()], ['label' => 'Actives', 'value' => Stack::where('is_active', true)->count()], ['label' => 'Composants', 'value' => Stack::withCount('stackItems')->get()->sum('stack_items_count')], ['label' => 'Projets liés', 'value' => Stack::withCount('projects')->get()->sum('projects_count')]]],
                ['title' => 'Témoignages', 'items' => [['label' => 'Total', 'value' => Testimonial::count()], ['label' => 'Affichés', 'value' => Testimonial::where('is_visible', true)->count()], ['label' => 'Masqués', 'value' => Testimonial::where('is_visible', false)->count()]]],
            ],
            'infraStats' => [
                ['label' => 'Actives', 'value' => Infra::where('is_active', true)->count()], ['label' => 'Inactives', 'value' => Infra::where('is_active', false)->count()], ['label' => 'Production', 'value' => Infra::where('environment', InfraEnvironment::Production->value)->count()], ['label' => 'CPU', 'value' => Infra::sum('cpu_cores').' cœurs'], ['label' => 'Mémoire', 'value' => Infra::sum('memory_mb').' Mo'], ['label' => 'Stockage', 'value' => Infra::sum('storage_gb').' Go'],
            ],
            'auditStats' => [['label' => 'Aujourd’hui', 'value' => AdminActivityLog::whereDate('created_at', today())->count()], ['label' => '7 derniers jours', 'value' => AdminActivityLog::where('created_at', '>=', now()->subDays(7))->count()], ['label' => 'Total', 'value' => AdminActivityLog::count()], ['label' => 'Admins actifs', 'value' => AdminActivityLog::whereNotNull('user_id')->distinct('user_id')->count('user_id')]],
            'messages' => ContactMessage::latest()->take(6)->get(),
            'missingMedia' => Project::query()->whereNull('image')->orWhereDoesntHave('projectImages')->latest()->take(8)->get(),
            'recentProjects' => Project::query()->latest('started_at')->take(5)->get(),
            'activities' => AdminActivityLog::query()->with('user')->latest()->take(12)->get(),
        ]);
    }

    protected function dailySeries($query, int $days): array
    {
        $start = now()->subDays($days - 1)->startOfDay();
        $counts = (clone $query)->where('created_at', '>=', $start)->get(['created_at'])->groupBy(fn (PageView $view): string => $view->created_at->format('Y-m-d'))->map(fn (Collection $day): int => $day->count());

        return collect(range($days - 1, 0))->map(fn (int $i): array => ['label' => now()->subDays($i)->format('d M'), 'value' => (int) ($counts[now()->subDays($i)->format('Y-m-d')] ?? 0)])->all();
    }

    protected function localeSeries(): array
    {
        $counts = PageView::query()->public()->since(30)->get(['locale'])->groupBy(fn (PageView $view): string => $view->locale ?: 'fr')->map->count();

        return [['label' => 'English', 'value' => (int) ($counts['en'] ?? 0)], ['label' => 'Français', 'value' => (int) ($counts['fr'] ?? 0)]];
    }

    protected function activitySeries(): array
    {
        $start = now()->subDays(13)->startOfDay();
        $counts = AdminActivityLog::query()->where('created_at', '>=', $start)->get(['created_at'])->groupBy(fn (AdminActivityLog $log): string => $log->created_at->format('Y-m-d'))->map->count();

        return collect(range(13, 0))->map(fn (int $i): array => ['label' => now()->subDays($i)->format('d M'), 'value' => (int) ($counts[now()->subDays($i)->format('Y-m-d')] ?? 0)])->all();
    }

    protected function monthlySeries($query, int $months, string $dateColumn): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();
        $counts = $query->where($dateColumn, '>=', $start)->get([$dateColumn])->groupBy(fn ($record): string => $record->{$dateColumn}->format('Y-m'))->map->count();

        return collect(range($months - 1, 0))->map(fn (int $i): array => ['label' => now()->subMonths($i)->format('M Y'), 'value' => (int) ($counts[now()->subMonths($i)->format('Y-m')] ?? 0)])->all();
    }

    protected function enumCounts(Collection $counts, array $cases): array
    {
        return collect($cases)->map(fn ($case): array => ['label' => $case->label(), 'value' => (int) ($counts[$case->value] ?? 0)])->all();
    }
}
