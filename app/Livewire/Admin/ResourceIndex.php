<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Cv;
use App\Models\Infra;
use App\Models\Post;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ResourceIndex extends Component
{
    use WithPagination;

    public string $resource;

    public string $search = '';

    public function mount(string $resource): void
    {
        abort_unless(array_key_exists($resource, self::resources()), 404);
        $this->resource = $resource;
    }

    public function getTitleProperty(): string
    {
        return self::resources()[$this->resource]['title'];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $model = $this->query()->findOrFail($id);
        abort_unless($model instanceof Model, 404);
        $model->delete();
        session()->flash('success', 'Élément supprimé.');
    }

    public function markRead(int $id): void
    {
        abort_unless($this->resource === 'messages', 404);
        ContactMessage::query()->findOrFail($id)->markAsRead();
    }

    public function render(): View
    {
        return view('livewire.admin.resource-index', [
            'definition' => self::resources()[$this->resource],
            'records' => $this->query()->latest()->paginate(15),
        ])->title($this->getTitleProperty());
    }

    protected function query()
    {
        $definition = self::resources()[$this->resource];
        $query = $definition['model']::query();

        if ($this->search !== '') {
            $query->where(function ($query) use ($definition): void {
                foreach ($definition['search'] as $column) {
                    $query->orWhere($column, 'like', '%'.$this->search.'%');
                }
            });
        }

        return $query;
    }

    /** @return array<string, array{title: string, model: class-string<Model>, search: array<int, string>, columns: array<string, string>}> */
    protected static function resources(): array
    {
        return [
            'posts' => ['title' => 'Articles', 'model' => Post::class, 'search' => ['title', 'slug'], 'columns' => ['title' => 'Titre', 'status' => 'Statut', 'published_at' => 'Publication']],
            'cvs' => ['title' => 'CV et parcours', 'model' => Cv::class, 'search' => ['title', 'version_label'], 'columns' => ['title' => 'Titre', 'version_label' => 'Version', 'status' => 'Statut']],
            'skills' => ['title' => 'Compétences', 'model' => Skill::class, 'search' => ['name', 'description'], 'columns' => ['name' => 'Nom', 'level' => 'Niveau', 'is_active' => 'Actif']],
            'stacks' => ['title' => 'Stacks', 'model' => Stack::class, 'search' => ['name', 'description'], 'columns' => ['name' => 'Nom', 'is_active' => 'Actif']],
            'infras' => ['title' => 'Infrastructure', 'model' => Infra::class, 'search' => ['name', 'description'], 'columns' => ['name' => 'Nom', 'environment' => 'Environnement', 'is_active' => 'Actif']],
            'testimonials' => ['title' => 'Témoignages', 'model' => Testimonial::class, 'search' => ['name', 'company', 'content'], 'columns' => ['name' => 'Nom', 'company' => 'Entreprise', 'is_visible' => 'Visible']],
            'messages' => ['title' => 'Messages', 'model' => ContactMessage::class, 'search' => ['name', 'email', 'subject'], 'columns' => ['name' => 'Expéditeur', 'subject' => 'Sujet', 'read_at' => 'État']],
            'categories' => ['title' => 'Catégories', 'model' => Category::class, 'search' => ['name', 'slug'], 'columns' => ['name' => 'Nom', 'slug' => 'Slug', 'sort_order' => 'Ordre']],
        ];
    }
}
