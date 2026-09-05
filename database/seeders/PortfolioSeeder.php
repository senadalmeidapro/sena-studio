<?php

namespace Database\Seeders;

use App\Enums\CvStatus;
use App\Enums\CvTemplate;
use App\Enums\InfraEnvironment;
use App\Enums\ProjectComplexity;
use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use App\Enums\SkillLevel;
use App\Enums\StackItemCategory;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Cv;
use App\Models\Infra;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Skill;
use App\Models\Stack;
use App\Models\StackItem;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $buildIcon = fn (string $slug): string => 'https://cdn.simpleicons.org/'.$slug;

        $portfolioStack = Stack::firstOrCreate([
            'name' => 'Portfolio Sena Studio',
        ], [
            'description' => 'La stack complète utilisée par Sena Studio pour concevoir, développer et déployer ses projets.',
            'is_active' => true,
        ]);

        $stackItems = [
            [StackItemCategory::Frontend, 'Blade', null, '🧩'],
            [StackItemCategory::Frontend, 'Tailwind CSS', '4.x', $buildIcon('tailwindcss')],
            [StackItemCategory::Frontend, 'Livewire', '4.x', $buildIcon('livewire')],
            [StackItemCategory::Frontend, 'Flux UI', '2.x', '🎛️'],
            [StackItemCategory::Frontend, 'Alpine.js', '3.x', $buildIcon('alpine.js')],
            [StackItemCategory::Backend, 'PHP', '8.3', $buildIcon('php')],
            [StackItemCategory::Backend, 'Laravel', '13.x', $buildIcon('laravel')],
            [StackItemCategory::Backend, 'Filament', '5.x', $buildIcon('filament')],
            [StackItemCategory::Database, 'SQLite', null, $buildIcon('sqlite')],
            [StackItemCategory::Database, 'MySQL', '8.x', $buildIcon('mysql')],
            [StackItemCategory::Database, 'PostgreSQL', '16.x', $buildIcon('postgresql')],
            [StackItemCategory::Cache, 'Redis', '7.x', $buildIcon('redis')],
            [StackItemCategory::Queue, 'Redis Queue', null, $buildIcon('redis')],
            [StackItemCategory::Orm, 'Eloquent', null, '🧙'],
            [StackItemCategory::Storage, 'Local Storage', null, '🗃️'],
            [StackItemCategory::Cloud, 'DigitalOcean', null, $buildIcon('digitalocean')],
            [StackItemCategory::Monitoring, 'Laravel Pulse', null, '📊'],
            [StackItemCategory::Devops, 'Docker', null, $buildIcon('docker')],
            [StackItemCategory::Devops, 'Kubernetes', null, $buildIcon('kubernetes')],
            [StackItemCategory::Devops, 'Helm', null, '⚓'],
            [StackItemCategory::Devops, 'GitHub Actions', null, $buildIcon('githubactions')],
            [StackItemCategory::Testing, 'Pest', '4.x', '🧪'],
            [StackItemCategory::Design, 'Figma', null, $buildIcon('figma')],
            [StackItemCategory::Design, 'Tailwind UI', null, '💠'],
            [StackItemCategory::Analytics, 'Plausible', null, $buildIcon('plausible')],
            [StackItemCategory::Documentation, 'Markdown', null, $buildIcon('markdown')],
        ];

        foreach ($stackItems as [$category, $value, $version, $icon]) {
            StackItem::updateOrCreate(
                ['stack_id' => $portfolioStack->id, 'category' => $category, 'value' => $value],
                ['version' => $version, 'icon' => $icon],
            );
        }

        $categories = [
            ['name' => 'Web', 'slug' => 'web', 'description' => 'Applications et sites web'],
            ['name' => 'Application', 'slug' => 'application', 'description' => 'Applications métier et SaaS'],
            ['name' => 'Logiciel', 'slug' => 'logiciel', 'description' => 'Outils et solutions logicielles'],
            ['name' => 'Open Source', 'slug' => 'open-source', 'description' => 'Projets open source'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        $infra = Infra::firstOrCreate(['name' => 'Production Cloud'], [
            'description' => 'Infrastructure cloud containerisée pour la mise en production des projets web.',
            'docker_image' => 'php:8.3-fpm-alpine',
            'kubernetes_config' => 'deployment + service + ingress',
            'helm_chart' => 'stable/laravel',
            'cpu_cores' => 4,
            'memory_mb' => 8192,
            'storage_gb' => 100,
            'environment' => InfraEnvironment::Production,
            'is_active' => true,
        ]);

        $skillsData = [
            ['PHP', SkillLevel::Expert, 'Développement backend robuste et sécurisé.', $buildIcon('php')],
            ['Laravel', SkillLevel::Expert, 'Architecture MVC, Eloquent, services, jobs, queues.', $buildIcon('laravel')],
            ['Livewire', SkillLevel::Advanced, 'Composants réactifs full-stack côté serveur.', $buildIcon('livewire')],
            ['Filament', SkillLevel::Advanced, 'Construction de backoffices et d’administrations sur mesure.', $buildIcon('filament')],
            ['Blade', SkillLevel::Expert, 'Template engine et composants Laravel.', '🧩'],
            ['Tailwind CSS', SkillLevel::Advanced, 'Design system et UI utilitaires.', $buildIcon('tailwindcss')],
            ['Alpine.js', SkillLevel::Advanced, 'Interactions front légères sans framework lourd.', $buildIcon('alpine.js')],
            ['MySQL', SkillLevel::Advanced, 'Modélisation relationnelle et optimisation.', $buildIcon('mysql')],
            ['PostgreSQL', SkillLevel::Intermediate, 'Bases relationnelles avancées.', $buildIcon('postgresql')],
            ['Redis', SkillLevel::Advanced, 'Cache, sessions et files de travail.', $buildIcon('redis')],
            ['Docker', SkillLevel::Advanced, 'Conteneurisation et environnements reproductibles.', $buildIcon('docker')],
            ['Kubernetes', SkillLevel::Intermediate, 'Orchestration et déploiement cloud natif.', $buildIcon('kubernetes')],
            ['Pest', SkillLevel::Advanced, 'Tests unitaires et fonctionnels.', '🧪'],
            ['Git', SkillLevel::Expert, 'Versionnement et workflow collaboratif.', $buildIcon('git')],
            ['Figma', SkillLevel::Intermediate, 'Prototypage et design UI/UX.', $buildIcon('figma')],
        ];

        $webCategory = Category::where('slug', 'web')->first();
        $appCategory = Category::where('slug', 'application')->first();

        $skills = collect();
        foreach ($skillsData as [$name, $level, $description, $icon]) {
            $skill = Skill::updateOrCreate(['name' => $name], [
                'description' => $description,
                'level' => $level,
                'is_active' => true,
                'icon' => $icon,
            ]);
            $skills->push($skill);
        }

        $projectsData = [
            [
                'name' => 'Portfolio Sena Studio',
                'slug' => 'portfolio-sena-studio',
                'description' => 'Ce portfolio : un backoffice Filament pour gérer projets, compétences, stack et infrastructure, avec un site public élégant en Livewire.',
                'status' => ProjectStatus::Production,
                'type' => ProjectType::Web,
                'complexity' => ProjectComplexity::Medium,
                'visibility' => ProjectVisibility::Public,
                'url' => url('/'),
                'image' => 'images/screenshots/project-1.svg',
                'stack' => $portfolioStack,
                'infra' => $infra,
                'skills' => ['Laravel', 'Livewire', 'Filament', 'Blade', 'Tailwind CSS'],
            ],
            [
                'name' => 'SaaS de Facturation',
                'slug' => 'saas-facturation',
                'description' => 'Plateforme SaaS de facturation et de suivi des devis pour indépendants, avec paiement Stripe, abonnements et tableaux de bord en temps réel.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::App,
                'complexity' => ProjectComplexity::Complex,
                'visibility' => ProjectVisibility::Public,
                'image' => 'images/screenshots/project-2.svg',
                'skills' => ['Laravel', 'Livewire', 'Blade', 'MySQL', 'Redis'],
            ],
            [
                'name' => 'API de Réservation',
                'slug' => 'api-reservation',
                'description' => 'API REST documentée pour la réservation de créneaux, avec authentification Sanctum, rate limiting et tests Pest complets.',
                'status' => ProjectStatus::Testing,
                'type' => ProjectType::Software,
                'complexity' => ProjectComplexity::Medium,
                'visibility' => ProjectVisibility::Public,
                'image' => 'images/screenshots/project-3.svg',
                'skills' => ['PHP', 'Laravel', 'MySQL', 'Pest'],
            ],
            [
                'name' => 'Dashboard IoT',
                'slug' => 'dashboard-iot',
                'description' => 'Tableau de bord temps réel pour capteurs IoT : queue Redis, WebSocket, visualisation des métriques et alertes.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::App,
                'complexity' => ProjectComplexity::Complex,
                'visibility' => ProjectVisibility::Public,
                'image' => 'images/screenshots/project-4.svg',
                'skills' => ['Laravel', 'Blade', 'Redis', 'Docker'],
            ],
            [
                'name' => 'Blog Headless',
                'slug' => 'blog-headless',
                'description' => 'Système de blog headless avec CMS Filament, déploiement sur Kubernetes et optimisation SEO complète.',
                'status' => ProjectStatus::Production,
                'type' => ProjectType::Web,
                'complexity' => ProjectComplexity::Simple,
                'visibility' => ProjectVisibility::Public,
                'image' => 'images/screenshots/project-5.svg',
                'skills' => ['Laravel', 'Filament', 'Blade', 'PostgreSQL', 'Kubernetes'],
            ],
        ];

        $projectGalleries = [
            'portfolio-sena-studio' => ['images/screenshots/project-2.svg', 'images/screenshots/project-5.svg', 'images/screenshots/project-3.svg'],
            'saas-facturation' => ['images/screenshots/project-1.svg', 'images/screenshots/project-4.svg'],
            'api-reservation' => ['images/screenshots/project-3.svg', 'images/screenshots/project-2.svg', 'images/screenshots/project-5.svg'],
            'dashboard-iot' => ['images/screenshots/project-4.svg', 'images/screenshots/project-1.svg'],
            'blog-headless' => ['images/screenshots/project-5.svg', 'images/screenshots/project-2.svg'],
        ];

        foreach ($projectsData as $projectData) {
            $skillsInProject = $projectData['skills'];
            $stackModel = $projectData['stack'] ?? null;
            $infraModel = $projectData['infra'] ?? null;

            unset($projectData['skills'], $projectData['stack'], $projectData['infra']);

            $project = Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                [
                    ...$projectData,
                    'version' => '1.0.0',
                    'started_at' => now()->subMonths(rand(1, 10)),
                    'ended_at' => $projectData['status'] === ProjectStatus::Production ? now()->subMonths(rand(0, 4)) : null,
                    'stack_id' => $stackModel?->id,
                    'infra_id' => $infraModel?->id,
                ],
            );

            foreach ($projectGalleries[$project->slug] ?? [] as $index => $path) {
                ProjectImage::updateOrCreate(
                    ['project_id' => $project->id, 'sort_order' => $index],
                    ['path' => $path],
                );
            }

            $skillModels = $skills->filter(fn (Skill $skill) => in_array($skill->name, $skillsInProject));

            foreach ($skillModels as $skill) {
                $proficiency = match (true) {
                    $project->complexity === ProjectComplexity::Complex => 'primary',
                    $project->complexity === ProjectComplexity::Medium => 'secondary',
                    default => 'research',
                };

                if (! $project->skills()->where('skill_id', $skill->id)->exists()) {
                    $project->skills()->attach($skill->id, ['proficiency' => $proficiency]);
                }
            }

            $projectCategories = match ($project->type) {
                ProjectType::Web => [$webCategory],
                ProjectType::App => [$appCategory, $webCategory],
                default => [$webCategory],
            };

            foreach (array_filter($projectCategories) as $category) {
                if (! $project->categories()->where('category_id', $category->id)->exists()) {
                    $project->categories()->attach($category->id);
                }
            }
        }

        $demoMessages = [
            [
                'name' => 'Claire Fontaine',
                'email' => 'claire@atelier-fontaine.fr',
                'phone' => '06 45 78 12 90',
                'company' => 'Atelier Fontaine',
                'subject' => 'Refonte de notre site vitrine',
                'budget' => '5k-15k',
                'message' => 'Bonjour, nous cherchons un développeur Laravel pour moderniser notre site vitrine et y ajouter un espace de réservation. Seriez-vous disponible pour un premier échange ?',
                'read_at' => null,
            ],
            [
                'name' => 'Marc Dubois',
                'email' => 'marc@indepmarc.fr',
                'phone' => null,
                'company' => null,
                'subject' => 'Question sur un dashboard SaaS',
                'budget' => '1k-5k',
                'message' => 'Salut, je développe une petite appli SaaS de gestion et je me demande si Livewire est adapté pour les tableaux de bord temps réel. Des retours concrets ?',
                'read_at' => now()->subDays(2),
            ],
            [
                'name' => 'Sonia Meunier',
                'email' => 'sonia@meunier-studio.com',
                'phone' => '07 12 34 56 78',
                'company' => 'Meunier Studio',
                'subject' => 'Maintenance et évolutions court terme',
                'budget' => 'a-definir',
                'message' => 'Nous utilisons une application Laravel en production et cherchons un profil pour des interventions ponctuelles et des évolutions. Pouvez-vous nous dire comment vous fonctionnez ?',
                'read_at' => null,
            ],
        ];

        foreach ($demoMessages as $message) {
            ContactMessage::updateOrCreate(
                [
                    'email' => $message['email'],
                    'subject' => $message['subject'],
                ],
                $message,
            );
        }

        $this->seedCvs();
    }

    private function seedCvs(): void
    {
        $base = [
            'title' => 'Curriculum vitae — Développeur Fullstack',
            'headline' => 'Développeur Fullstack Laravel & Vue.js',
            'email' => 'hello@senastudio.dev',
            'phone' => '+33 6 12 34 56 78',
            'location' => 'Lyon, France',
            'website' => env('SITE_URL', 'http://localhost'),
            'summary' => 'Développeur passionné, 8 ans d’expérience du prototypage à la mise en production : applications Laravel massives, interfaces Vue.js soignées et infrastructures cloud résilientes.',
            'links' => [
                ['label' => 'GitHub', 'url' => 'https://github.com/senastudio'],
                ['label' => 'LinkedIn', 'url' => 'https://linkedin.com/in/senastudio'],
            ],
            'experience' => [
                [
                    'title' => 'Développeur Fullstack Senior',
                    'subtitle' => 'Sena Studio',
                    'period_start' => '2019-01',
                    'period_end' => null,
                    'description' => 'Conception et maintenance d’applications Laravel en production, optimisation des performances et mentoring d’une équipe de 3 développeurs.',
                ],
                [
                    'title' => 'Développeur Backend',
                    'subtitle' => 'Agence Web Ouest',
                    'period_start' => '2015-06',
                    'period_end' => '2018-12',
                    'description' => 'Développement d’API REST, intégration de paiements en ligne et architecture de bases de données pour des clients e-commerce.',
                ],
            ],
            'education' => [
                [
                    'title' => 'Master Informatique — Génie Logiciel',
                    'subtitle' => 'Université de Lyon',
                    'period_start' => '2013-09',
                    'period_end' => '2015-06',
                    'description' => 'Spécialisation architecture logicielle et systèmes distribués.',
                ],
            ],
            'skills' => [
                ['name' => 'PHP / Laravel', 'level' => 'expert', 'experience' => '8 ans'],
                ['name' => 'Vue.js', 'level' => 'avance', 'experience' => '5 ans'],
                ['name' => 'Tailwind CSS', 'level' => 'avance', 'experience' => '5 ans'],
                ['name' => 'MySQL / PostgreSQL', 'level' => 'avance', 'experience' => '6 ans'],
                ['name' => 'Docker', 'level' => 'intermediaire', 'experience' => '4 ans'],
                ['name' => 'AWS', 'level' => 'intermediaire', 'experience' => '3 ans'],
            ],
            'languages' => [
                ['name' => 'Français', 'level' => 'natif'],
                ['name' => 'Anglais', 'level' => 'courant'],
                ['name' => 'Espagnol', 'level' => 'intermediaire'],
            ],
            'certifications' => [
                ['title' => 'AWS Certified Developer', 'subtitle' => 'Amazon Web Services', 'year' => '2023'],
                ['title' => 'Laravel Certification', 'subtitle' => 'Laravel', 'year' => '2021'],
            ],
            'hobbies' => [
                ['name' => 'Self-hosting'],
                ['name' => 'Cyclisme'],
                ['name' => 'Café de spécialité'],
            ],
        ];

        $published = [
            'version_label' => 'V1 · Fullstack',
            'slug' => 'senastudio-cv',
            'template' => CvTemplate::Moderne,
            'status' => CvStatus::Published,
            'accent_color' => '#059669',
            'is_primary' => true,
        ];

        $draft = [
            'version_label' => 'V2 · Minimal',
            'slug' => 'senastudio-cv-minimal',
            'template' => CvTemplate::Minimal,
            'status' => CvStatus::Draft,
            'accent_color' => '#2563eb',
            'is_primary' => false,
        ];

        Cv::updateOrCreate(['slug' => 'senastudio-cv'], array_merge($base, $published));
        Cv::updateOrCreate(['slug' => 'senastudio-cv-minimal'], array_merge($base, $draft));
    }
}
