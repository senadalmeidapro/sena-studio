<?php

namespace App\Livewire\Site;

use App\Models\Skill;
use App\Services\Seo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Compétences — Sena Studio')]
#[Layout('layouts.public')]
class Skills extends Component
{
    public function mount(): void
    {
        app(Seo::class)->set(
            title: 'Compétences',
            description: 'Les technologies et expertises mobilisées par Sena Studio : PHP, Laravel, Livewire, Filament et plus encore.',
            canonical: localized_route('skills.index'),
        );
    }

    #[Computed]
    public function byRole()
    {
        $primaryRoleBySkill = [
            'TypeScript' => 'language',
            'JavaScript' => 'language',
            'Python' => 'language',
            'Rust' => 'language',
            'Node.js' => 'runtime',
            'NestJS' => 'backend',
            'Express.js' => 'backend',
            'Prisma' => 'orm',
            'React' => 'frontend',
            'Vue.js' => 'frontend',
            'REST API' => 'backend',
            'WebSockets' => 'backend',
            'GitHub' => 'tools',
            'Linux' => 'devops',
            'GitHub Actions' => 'devops',
            'Git' => 'tools',
            'MySQL' => 'database',
            'TypeORM' => 'orm',
            'Eloquent' => 'orm',
            'Postman' => 'tools',
            'Swagger' => 'backend',
            'OpenAPI' => 'backend',
            'Laravel' => 'backend',
            'Filament' => 'backend',
            'Livewire' => 'backend',
            'Redis' => 'database',
            'Docker' => 'devops',
            'PostgreSQL' => 'database',
            'SQLite' => 'database',
            'Redis Queue' => 'backend',
            'Markdown' => 'tools',
        ];

        $roleOrder = ['language', 'runtime', 'frontend', 'backend', 'orm', 'database', 'devops', 'tools'];

        $grouped = Skill::query()
            ->where('is_active', true)
            ->with([
                'projects' => fn ($q) => $q
                    ->where('visibility', 'public')
                    ->where('status', '!=', 'cancelled')
                    ->where('slug', '!=', 'portfolio-sena-studio'),
            ])
            ->get()
            ->groupBy(fn ($skill): string => $primaryRoleBySkill[$skill->name] ?? 'other');

        $ordered = collect($roleOrder)
            ->mapWithKeys(fn (string $role): array => [$role => $grouped->get($role, collect())])
            ->filter(fn ($skills) => $skills->isNotEmpty());

        $remaining = $grouped->keys()
            ->diff($roleOrder)
            ->mapWithKeys(fn (string $role): array => [$role => $grouped->get($role)]);

        return $ordered->union($remaining);
    }

    public function render()
    {
        return view('pages.public.skills');
    }
}
