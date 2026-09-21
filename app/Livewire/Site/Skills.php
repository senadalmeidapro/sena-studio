<?php

namespace App\Livewire\Site;

use App\Models\Skill;
use App\Models\Stack as StackModel;
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
            'TypeScript' => 'languages',
            'JavaScript' => 'languages',
            'PHP' => 'languages',
            'Node.js' => 'backend',
            'NestJS' => 'backend',
            'Express.js' => 'backend',
            'Laravel' => 'backend',
            'Filament' => 'backend',
            'REST API' => 'backend',
            'WebSockets' => 'backend',
            'React' => 'frontend',
            'Vue.js' => 'frontend',
            'Blade' => 'frontend',
            'Livewire' => 'frontend',
            'Alpine.js' => 'frontend',
            'Tailwind CSS' => 'frontend',
            'MySQL' => 'database',
            'PostgreSQL' => 'database',
            'Prisma' => 'database',
            'TypeORM' => 'database',
            'Redis' => 'cache',
            'Docker' => 'devops',
            'Linux' => 'devops',
            'GitHub Actions' => 'devops',
            'Git' => 'tools',
            'GitHub' => 'tools',
            'Postman' => 'tools',
            'Swagger / OpenAPI' => 'tools',
            'Pest' => 'testing',
            'Figma' => 'design',
        ];

        $roleOrder = ['languages', 'backend', 'frontend', 'database', 'cache', 'devops', 'testing', 'tools', 'design'];

        $grouped = Skill::query()
            ->where('is_active', true)
            ->with([
                'categories',
                'projects' => fn ($q) => $q
                    ->where('visibility', 'public')
                    ->where('status', '!=', 'cancelled')
                    ->where('slug', '!=', 'portfolio-sena-studio'),
            ])
            ->get()
            ->groupBy(fn ($skill): string => $primaryRoleBySkill[$skill->name] ?? 'other');

        return collect($roleOrder)
            ->mapWithKeys(fn (string $role): array => [$role => $grouped->get($role, collect())])
            ->filter(fn ($skills) => $skills->isNotEmpty())
            ->union($grouped->except($roleOrder));
    }

    #[Computed]
    public function stacks()
    {
        return StackModel::query()
            ->where('is_active', true)
            ->with(['stackItems', 'projects' => fn ($q) => $q
                ->where('visibility', 'public')
                ->where('status', '!=', 'cancelled')
                ->where('slug', '!=', 'portfolio-sena-studio')])
            ->get();
    }

    public function render()
    {
        return view('pages.public.skills');
    }
}
