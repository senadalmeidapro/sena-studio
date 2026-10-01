<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('skills', 'category')) {
            Schema::table('skills', function (Blueprint $table): void {
                $table->string('category', 80)->nullable()->after('description');
            });
        }

        Schema::table('projects', function (Blueprint $table): void {
            $table->text('deployment')->nullable()->after('description');
        });

        foreach (DB::table('stack_items')->orderBy('id')->get() as $item) {
            $skill = DB::table('skills')->where('name', $item->value)->first(['id', 'category', 'icon']);
            $skillId = $skill?->id;

            if ($skillId === null) {
                $skillId = DB::table('skills')->insertGetId([
                    'name' => $item->value,
                    'description' => null,
                    'category' => $item->category,
                    'level' => 'expert',
                    'is_active' => true,
                    'icon' => $item->icon,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('skills')
                    ->where('id', $skillId)
                    ->update([
                        'category' => $skill->category ?: $item->category,
                        'icon' => $skill->icon ?: $item->icon,
                    ]);
            }

            foreach (DB::table('projects')->where('stack_id', $item->stack_id)->get(['id']) as $project) {
                DB::table('project_skill')->insertOrIgnore([
                    'project_id' => $project->id,
                    'skill_id' => $skillId,
                    'proficiency' => 'secondary',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach (DB::table('projects')->whereNotNull('infra_id')->get() as $project) {
            $infra = DB::table('infras')->where('id', $project->infra_id)->first();

            if ($infra === null) {
                continue;
            }

            $deployment = collect([
                $infra->name,
                $infra->environment ? 'Environment: '.$infra->environment : null,
                $infra->description,
                $infra->docker_image ? 'Container: '.$infra->docker_image : null,
                $infra->kubernetes_config ? 'Kubernetes: '.$infra->kubernetes_config : null,
                $infra->helm_chart ? 'Helm: '.$infra->helm_chart : null,
            ])->filter()->unique()->implode("\n");

            DB::table('projects')->where('id', $project->id)->update(['deployment' => $deployment]);
        }

        $curatedCategories = [
            ['Backend engineering', 'backend-engineering'],
            ['APIs & integrations', 'apis-integrations'],
            ['Fintech', 'fintech'],
            ['EdTech', 'edtech'],
            ['Data platforms', 'data-platforms'],
            ['Product engineering', 'product-engineering'],
        ];

        $categoryIds = [];
        foreach ($curatedCategories as [$name, $slug]) {
            $categoryIds[$slug] = DB::table('categories')->where('slug', $slug)->value('id')
                ?? DB::table('categories')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => null,
                    'sort_order' => count($categoryIds) + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        }

        $categoryMapping = [
            'backend' => 'backend-engineering',
            'programming' => 'backend-engineering',
            'api' => 'apis-integrations',
            'database' => 'data-platforms',
            'architecture' => 'backend-engineering',
            'frontend' => 'product-engineering',
            'web' => 'product-engineering',
            'devops' => 'backend-engineering',
            'security' => 'backend-engineering',
            'testing' => 'backend-engineering',
            'cloud' => 'data-platforms',
            'infrastructure' => 'data-platforms',
            'tools' => 'apis-integrations',
            'open-source' => 'backend-engineering',
            'application' => 'product-engineering',
            'automation' => 'apis-integrations',
            'ui-ux' => 'product-engineering',
            'ai' => 'data-platforms',
            'mobile' => 'product-engineering',
            'logiciel' => 'backend-engineering',
        ];

        foreach ($categoryMapping as $oldSlug => $newSlug) {
            $oldCategoryId = DB::table('categories')->where('slug', $oldSlug)->value('id');

            if ($oldCategoryId !== null) {
                DB::table('categorizables')
                    ->where('category_id', $oldCategoryId)
                    ->update(['category_id' => $categoryIds[$newSlug]]);
            }
        }

        DB::table('categories')->whereNotIn('slug', array_column($curatedCategories, 1))->delete();

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('stack_id');
            $table->dropConstrainedForeignId('infra_id');
            $table->dropColumn(['version', 'price', 'complexity']);
        });

        Schema::table('project_skill', function (Blueprint $table): void {
            $table->dropColumn('proficiency');
        });

        Schema::table('skills', function (Blueprint $table): void {
            $table->dropColumn('level');
        });

        Schema::dropIfExists('stack_items');
        Schema::dropIfExists('stacks');
        Schema::dropIfExists('infras');

        DB::table('categorizables')->where('categorizable_type', 'App\\Models\\Skill')->delete();

        DB::table('cvs')->where('template', '!=', 'engineering')->update(['template' => 'engineering']);
        Schema::table('cvs', function (Blueprint $table): void {
            $table->dropIndex(['template']);
            $table->dropColumn(['template', 'accent_color']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('This migration changes the portfolio taxonomy and removes obsolete stack and infrastructure records; restore from a pre-migration backup to roll it back.');
    }
};
