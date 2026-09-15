<?php

namespace App\Livewire\Admin\Projects;

use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use App\Models\Category;
use App\Models\Infra;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Stack;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
#[Title('Éditer un projet')]
class ProjectForm extends Component
{
    use WithFileUploads;

    public ?Project $project = null;

    public bool $editing = false;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $version = '1.0.0';

    public string|int|float|null $price = 0;

    public string $url = '';

    public string $repositoryUrl = '';

    public string $status = 'development';

    public string $type = 'web';

    public string $complexity = 'simple';

    public string $visibility = 'public';

    public ?string $startedAt = null;

    public ?string $endedAt = null;

    public ?int $stackId = null;

    public ?int $infraId = null;

    public array $skillIds = [];

    public array $categoryIds = [];

    public $cover;

    public array $gallery = [];

    public function mount(?Project $project = null): void
    {
        $this->project = $project;
        $this->editing = $project?->exists ?? false;

        if (! $this->editing) {
            return;
        }

        $this->name = (string) $project->name;
        $this->slug = (string) $project->slug;
        $this->description = (string) ($project->description ?? '');
        $this->version = (string) ($project->version ?? '1.0.0');
        $this->price = $project->price ?? 0;
        $this->url = (string) ($project->url ?? '');
        $this->repositoryUrl = (string) ($project->repository_url ?? '');
        $this->status = $project->status?->value ?? 'development';
        $this->type = $project->type?->value ?? 'web';
        $this->complexity = $project->complexity?->value ?? 'simple';
        $this->visibility = $project->visibility?->value ?? 'public';
        $this->startedAt = $project->started_at?->format('Y-m-d');
        $this->endedAt = $project->ended_at?->format('Y-m-d');
        $this->stackId = $project->stack_id;
        $this->infraId = $project->infra_id;
        $this->skillIds = $project->skills()->pluck('skills.id')->map(fn ($id): int => (int) $id)->all();
        $this->categoryIds = $project->categories()->pluck('categories.id')->map(fn ($id): int => (int) $id)->all();
    }

    public function save(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($this->project?->id)],
            'description' => ['nullable', 'string'],
            'version' => ['nullable', 'string', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'url' => ['nullable', 'url', 'max:255'],
            'repositoryUrl' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::in(array_keys(ProjectStatus::options()))],
            'type' => ['required', Rule::in(array_keys(ProjectType::options()))],
            'complexity' => ['required', Rule::in(array_keys(ProjectComplexity::options()))],
            'visibility' => ['required', Rule::in(array_keys(ProjectVisibility::options()))],
            'startedAt' => ['nullable', 'date'],
            'endedAt' => ['nullable', 'date', 'after_or_equal:startedAt'],
            'stackId' => ['nullable', 'exists:stacks,id'],
            'infraId' => ['nullable', 'exists:infras,id'],
            'skillIds' => ['array'],
            'skillIds.*' => ['integer', 'exists:skills,id'],
            'categoryIds' => ['array'],
            'categoryIds.*' => ['integer', 'exists:categories,id'],
            'cover' => ['nullable', 'image', 'max:10240'],
            'gallery' => ['array', 'max:20'],
            'gallery.*' => ['image', 'max:10240'],
        ]);

        $project = $this->project ?? new Project;
        $project->fill([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?: null,
            'version' => $data['version'] ?: null,
            'price' => $data['price'] ?: 0,
            'url' => $data['url'] ?: null,
            'repository_url' => $data['repositoryUrl'] ?: null,
            'status' => $data['status'],
            'type' => $data['type'],
            'complexity' => $data['complexity'],
            'visibility' => $data['visibility'],
            'started_at' => $data['startedAt'] ?: null,
            'ended_at' => $data['endedAt'] ?: null,
            'stack_id' => $data['stackId'] ?: null,
            'infra_id' => $data['infraId'] ?: null,
        ]);

        if ($this->cover) {
            $upload = app(CloudinaryService::class)->upload($this->cover->getRealPath(), 'sena-studio/projects');
            $project->image = $upload['secure_url'];
            $project->cloudinary_public_id = $upload['public_id'];
        }

        DB::transaction(function () use ($project, $data): void {
            $project->save();
            $project->skills()->sync($data['skillIds'] ?? []);
            $project->categories()->sync($data['categoryIds'] ?? []);

            foreach ($this->gallery as $file) {
                $upload = app(CloudinaryService::class)->upload($file->getRealPath(), 'sena-studio/gallery');
                $project->projectImages()->create([
                    'path' => $upload['secure_url'],
                    'cloudinary_public_id' => $upload['public_id'],
                    'sort_order' => $project->projectImages()->count(),
                ]);
            }
        });

        session()->flash('success', $this->editing ? 'Projet mis à jour.' : 'Projet créé.');
        $this->redirectRoute('backoffice.projects.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.projects.form', [
            'stacks' => Stack::query()->where('is_active', true)->orderBy('name')->get(),
            'infras' => Infra::query()->orderBy('name')->get(),
            'skills' => Skill::query()->where('is_active', true)->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
            'statusOptions' => ProjectStatus::options(),
            'typeOptions' => ProjectType::options(),
            'complexityOptions' => ProjectComplexity::options(),
            'visibilityOptions' => ProjectVisibility::options(),
        ]);
    }
}
