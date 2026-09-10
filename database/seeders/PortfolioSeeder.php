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
            'description' => 'Sena Studio is a personal freelance business command center. It unifies project tracking, technology cataloging, skill management, and infrastructure provisioning into a single, beautifully crafted admin interface — backed by a robust and extendable architecture.',
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
            [StackItemCategory::Analytics, 'Plausible', null, $buildIcon('plausible')],
            [StackItemCategory::Documentation, 'Markdown', null, $buildIcon('markdown')],
            [StackItemCategory::Design, 'Tailwind UI', null, null],
        ];

        $stackItemValues = collect($stackItems)->map(fn (array $item): string => $item[1]);

        StackItem::where('stack_id', $portfolioStack->id)
            ->whereNotIn('value', $stackItemValues)
            ->delete();

        foreach ($stackItems as [$category, $value, $version, $icon]) {
            StackItem::updateOrCreate(
                ['stack_id' => $portfolioStack->id, 'category' => $category, 'value' => $value],
                ['version' => $version, 'icon' => $icon],
            );
        }

        $categories = [
            ['name' => 'Backend', 'slug' => 'backend', 'description' => 'Technologies and practices used to build server-side applications, business logic, and backend services.', 'sort_order' => 1],
            ['name' => 'Programming', 'slug' => 'programming', 'description' => 'Programming languages, concepts, paradigms, and techniques used to develop software.', 'sort_order' => 2],
            ['name' => 'Web', 'slug' => 'web', 'description' => 'Technologies and practices for building modern websites and web-based solutions.', 'sort_order' => 3],
            ['name' => 'API', 'slug' => 'api', 'description' => 'Technologies and practices for designing, developing, integrating, documenting, and securing application programming interfaces.', 'sort_order' => 4],
            ['name' => 'Database', 'slug' => 'database', 'description' => 'Database technologies, data modeling, querying, optimization, and data management systems.', 'sort_order' => 5],
            ['name' => 'Architecture', 'slug' => 'architecture', 'description' => 'Software architecture patterns, system design principles, scalability, modularity, and maintainability.', 'sort_order' => 6],
            ['name' => 'Frontend', 'slug' => 'frontend', 'description' => 'Technologies and tools used to build interactive, responsive, and user-friendly interfaces.', 'sort_order' => 7],
            ['name' => 'DevOps', 'slug' => 'devops', 'description' => 'Practices and tools for automating development, testing, deployment, monitoring, and software operations.', 'sort_order' => 8],
            ['name' => 'Security', 'slug' => 'security', 'description' => 'Technologies and practices for protecting applications, APIs, systems, data, and infrastructure.', 'sort_order' => 9],
            ['name' => 'Testing', 'slug' => 'testing', 'description' => 'Tools, methodologies, and practices for verifying software quality, reliability, and correctness.', 'sort_order' => 10],
            ['name' => 'Cloud', 'slug' => 'cloud', 'description' => 'Cloud platforms, services, and technologies used to deploy, scale, and manage applications.', 'sort_order' => 11],
            ['name' => 'Infrastructure', 'slug' => 'infrastructure', 'description' => 'Technologies and practices for managing servers, networks, containers, storage, and computing environments.', 'sort_order' => 12],
            ['name' => 'Tools', 'slug' => 'tools', 'description' => 'Development tools and utilities used to improve coding, collaboration, productivity, and workflows.', 'sort_order' => 13],
            ['name' => 'Open Source', 'slug' => 'open-source', 'description' => 'Open-source technologies, projects, contributions, and development practices.', 'sort_order' => 14],
            ['name' => 'Application', 'slug' => 'application', 'description' => 'Technologies and practices used to design and develop functional software applications.', 'sort_order' => 15],
            ['name' => 'Automation', 'slug' => 'automation', 'description' => 'Technologies and practices for automating repetitive tasks, workflows, integrations, and development processes.', 'sort_order' => 16],
            ['name' => 'UI/UX', 'slug' => 'ui-ux', 'description' => 'Principles and tools for designing intuitive, accessible, attractive, and effective user experiences.', 'sort_order' => 17],
            ['name' => 'AI', 'slug' => 'ai', 'description' => 'Technologies and techniques for artificial intelligence, machine learning, intelligent applications, and data-driven systems.', 'sort_order' => 18],
            ['name' => 'Mobile', 'slug' => 'mobile', 'description' => 'Technologies and frameworks used to develop applications and experiences for mobile devices.', 'sort_order' => 19],
            ['name' => 'Logiciel', 'slug' => 'logiciel', 'description' => 'Software development technologies, methodologies, and tools used to build complete software solutions.', 'sort_order' => 20],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        $infra = Infra::firstOrCreate(['name' => 'Production Cloud'], [
            'description' => 'Infrastructure cloud containerisée pour la mise en production des projets web.',
            'docker_image' => 'php:8.3-fpm-alpine',
            'kubernetes_config' => 'deployment + service + ingress',
            'helm_chart' => 'stable/laravel',
            'cpu_cores' => 2,
            'memory_mb' => 1024,
            'storage_gb' => 100,
            'environment' => InfraEnvironment::Production,
            'is_active' => true,
        ]);

        $skillsData = [
            ['TypeScript', SkillLevel::Advanced, 'Typed superset of JavaScript used to build scalable and maintainable web applications and backend services.', $buildIcon('typescript')],
            ['JavaScript', SkillLevel::Advanced, 'Core programming language for building interactive web applications and modern backend services.', $buildIcon('javascript')],
            ['Node.js', SkillLevel::Advanced, 'JavaScript runtime used to build scalable server-side applications, APIs, and backend services.', $buildIcon('nodedotjs')],
            ['NestJS', SkillLevel::Advanced, 'Progressive Node.js framework for building scalable, modular, and maintainable server-side applications with TypeScript.', $buildIcon('nestjs')],
            ['Express.js', SkillLevel::Intermediate, 'Lightweight Node.js web framework for building REST APIs, middleware, and server-side applications.', $buildIcon('express')],
            ['Prisma', SkillLevel::Advanced, 'Modern TypeScript ORM for type-safe database access, schema management, migrations, and query building.', $buildIcon('prisma')],
            ['React', SkillLevel::Intermediate, 'JavaScript library for building component-based user interfaces and modern frontend applications.', $buildIcon('react')],
            ['Vue.js', SkillLevel::Intermediate, 'Progressive JavaScript framework for building reactive and component-based web interfaces.', $buildIcon('vuedotjs')],
            ['REST API', SkillLevel::Advanced, 'Design and development of RESTful APIs using HTTP methods, resources, status codes, validation, and structured responses.', $buildIcon('openapiinitiative')],
            ['WebSockets', SkillLevel::Intermediate, 'Real-time bidirectional communication technology for applications requiring persistent client-server connections.', $buildIcon('socketdotio')],
            ['GitHub', SkillLevel::Advanced, 'Development platform for source control, collaboration, pull requests, code review, repositories, and project management.', $buildIcon('github')],
            ['Linux', SkillLevel::Intermediate, 'Unix-like operating system ecosystem used for development, server administration, automation, and deployment.', $buildIcon('linux')],
            ['GitHub Actions', SkillLevel::Intermediate, 'CI/CD automation platform for building, testing, deploying, and automating software development workflows.', $buildIcon('githubactions')],
            ['Git', SkillLevel::Advanced, 'Managing source code, branching strategies, version history, merges, and collaborative development workflows.', $buildIcon('git')],
            ['Kubernetes', SkillLevel::Intermediate, 'Orchestrating containerized applications, managing deployments and services, scaling workloads, and maintaining resilient application environments.', $buildIcon('kubernetes')],
            ['MySQL', SkillLevel::Advanced, 'Designing and managing relational databases, writing complex SQL queries, and optimizing database performance.', $buildIcon('mysql')],
            ['TypeORM', SkillLevel::Advanced, 'TypeScript ORM for working with relational databases through entities, repositories, relations, and migrations.', $buildIcon('typeorm')],
            ['Blade', SkillLevel::Advanced, 'Template engine et composants Laravel.', $buildIcon('laravel')],
            ['Alpine.js', SkillLevel::Intermediate, 'Building lightweight and reactive user interfaces by adding client-side interactions and dynamic behavior without the complexity of a full frontend framework.', $buildIcon('alpine.js')],
            ['Figma', SkillLevel::Intermediate, 'Designing user interfaces, creating interactive prototypes, organizing design systems, and translating product ideas into structured visual interfaces.', $buildIcon('figma')],
            ['Pest', SkillLevel::Intermediate, 'Writing expressive automated tests for PHP applications, covering application behavior, business logic, and regression scenarios to improve software reliability.', '🧪'],
            ['Postman', SkillLevel::Advanced, 'API development and testing platform used to design, test, document, and debug HTTP APIs.', $buildIcon('postman')],
            ['Swagger / OpenAPI', SkillLevel::Advanced, 'API specification and documentation tooling for designing, documenting, and testing HTTP APIs.', $buildIcon('swagger')],
            ['PHP', SkillLevel::Intermediate, 'A server-side programming language used to build dynamic web applications, APIs, and backend services.', $buildIcon('php')],
            ['Laravel', SkillLevel::Intermediate, 'A modern PHP framework for building robust web applications, APIs, and backend systems with an expressive development workflow.', $buildIcon('laravel')],
            ['Filament', SkillLevel::Advanced, 'A Laravel-based framework for building modern admin panels, dashboards, forms, tables, and internal applications.', $buildIcon('filament')],
            ['Livewire', SkillLevel::Intermediate, 'A Laravel framework for building dynamic and interactive web interfaces using server-driven components and minimal JavaScript.', $buildIcon('livewire')],
            ['Redis', SkillLevel::Advanced, 'Implementing high-performance caching, session management, temporary data storage, and background job queues.', $buildIcon('redis')],
            ['Docker', SkillLevel::Advanced, 'Containerizing applications and services to create consistent, isolated, and reproducible development and production environments.', $buildIcon('docker')],
            ['PostgreSQL', SkillLevel::Advanced, 'Designing relational databases, developing complex SQL queries, managing data integrity, and optimizing database performance.', $buildIcon('postgresql')],
            ['Tailwind CSS', SkillLevel::Intermediate, 'Building responsive and maintainable user interfaces using a utility-first approach with reusable styling patterns and responsive design principles.', $buildIcon('tailwindcss')],
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

        $skillCategories = [
            'Node.js' => ['application', 'frontend', 'web'],
            'NestJS' => ['application', 'frontend', 'ai', 'architecture'],
            'React' => ['web', 'architecture', 'application'],
            'Vue.js' => ['web', 'architecture', 'application'],
            'PHP' => ['programming', 'frontend', 'web'],
            'Laravel' => ['frontend', 'web', 'application'],
            'Livewire' => ['architecture', 'frontend', 'web'],
            'Filament' => ['architecture', 'frontend', 'web', 'tools'],
            'Blade' => ['architecture', 'web'],
            'Tailwind CSS' => ['architecture', 'web', 'ui-ux'],
            'Alpine.js' => ['architecture', 'web', 'ui-ux'],
            'MySQL' => ['database', 'frontend'],
            'PostgreSQL' => ['database', 'frontend'],
            'Redis' => ['database', 'frontend', 'infrastructure'],
            'Docker' => ['devops', 'infrastructure', 'tools'],
            'Kubernetes' => ['devops', 'infrastructure', 'cloud'],
            'Pest' => ['testing', 'programming'],
            'Git' => ['tools', 'open-source', 'devops'],
            'Figma' => ['ui-ux', 'architecture', 'web'],
            'TypeScript' => ['programming', 'architecture', 'frontend', 'web'],
            'JavaScript' => ['programming', 'architecture', 'frontend', 'web'],
            'Express.js' => ['frontend', 'ai', 'web'],
            'Prisma' => ['database', 'frontend', 'programming'],
            'TypeORM' => ['database', 'frontend', 'programming'],
            'REST API' => ['api', 'frontend', 'architecture'],
            'WebSockets' => ['api', 'frontend', 'application'],
            'Postman' => ['tools', 'api', 'testing'],
            'Swagger / OpenAPI' => ['api', 'frontend', 'tools'],
            'GitHub' => ['tools', 'open-source', 'devops'],
            'GitHub Actions' => ['devops', 'automation', 'tools'],
            'Linux' => ['infrastructure', 'devops', 'tools'],
        ];

        $categoryIdsBySlug = Category::pluck('id', 'slug');

        foreach ($skillCategories as $skillName => $categorySlugs) {
            $skill = $skills->firstWhere('name', $skillName);
            if (! $skill) {
                continue;
            }

            $categoryIds = collect($categorySlugs)
                ->map(fn (string $slug): ?int => $categoryIdsBySlug[$slug] ?? null)
                ->filter()
                ->values()
                ->all();

            $skill->categories()->detach();
            $skill->categories()->attach($categoryIds);
        }

        $projectsData = [
            [
                'name' => 'Mini Shop API',
                'slug' => 'mini-shop-api',
                'description' => 'A production-grade REST API powering a complete e-commerce platform. It covers the full sales lifecycle — products and categories, cart management, orders with stock validation, payments and product reviews — secured with JWT authentication and strict request validation. Clean modular architecture (NestJS, TypeORM, PostgreSQL) designed to feed any storefront frontend.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::Software,
                'complexity' => ProjectComplexity::Complex,
                'visibility' => ProjectVisibility::Public,
                'url' => null,
                'repository_url' => 'https://github.com/senadalmeidapro/mini-shop-api',
                'image' => 'images/screenshots/project-2.svg',
                'skills' => ['TypeScript', 'Node.js', 'NestJS', 'TypeORM', 'PostgreSQL', 'REST API', 'Swagger / OpenAPI', 'Docker', 'Git'],
            ],
            [
                'name' => 'Orientation-BJ API',
                'slug' => 'api-orientation',
                'description' => 'Backend of a career-guidance platform helping young people in Benin find their professional path. Implements the RIASEC psychometric model with two-phase testing, multi-dimensional scoring, an adaptive recommendation engine, gamification, and an AI layer (GPT-4o) that turns results into actionable advice. JWT auth, role-based access, rate limiting, audit trail and full Swagger documentation make it ready for production.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::App,
                'complexity' => ProjectComplexity::Complex,
                'visibility' => ProjectVisibility::Public,
                'url' => null,
                'repository_url' => 'https://github.com/senadalmeidapro/api-orientation',
                'image' => 'images/screenshots/project-5.svg',
                'skills' => ['TypeScript', 'Node.js', 'NestJS', 'Prisma', 'PostgreSQL', 'Redis', 'REST API', 'Swagger / OpenAPI', 'Docker', 'GitHub Actions', 'Linux'],
            ],
            [
                'name' => 'ITDesk',
                'slug' => 'itdesk',
                'description' => 'IT service management platform built to run an entire internal IT department: ticket lifecycle with a strict state machine, approval workflows, incident, problem and change management, asset and software-license tracking (CMDB), plus a lead-to-ticket pipeline fed by the public contact form. Built the Laravel way — Livewire, Filament and permission-based policies — so access rights can be fine-tuned for every user.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::App,
                'complexity' => ProjectComplexity::Medium,
                'visibility' => ProjectVisibility::Public,
                'url' => null,
                'repository_url' => 'https://github.com/senadalmeidapro/itdesk',
                'image' => 'images/screenshots/project-4.svg',
                'skills' => ['PHP', 'Laravel', 'Livewire', 'Filament', 'Blade', 'Tailwind CSS', 'Alpine.js', 'MySQL', 'Pest'],
            ],
            [
                'name' => 'Mini Shop',
                'slug' => 'mini-shop',
                'description' => 'Modern, responsive storefront for the Mini Shop API, built with Vue 3 and Vite. It delivers a fast product catalog, live cart and smooth checkout flows sitting on the REST backend. Utility-first Tailwind CSS keeps the interface clean, lightweight and easy to extend — a solid base for any storefront design.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::Web,
                'complexity' => ProjectComplexity::Medium,
                'visibility' => ProjectVisibility::Public,
                'url' => null,
                'repository_url' => 'https://github.com/senadalmeidapro/mini-shop',
                'image' => 'images/screenshots/project-3.svg',
                'skills' => ['Vue.js', 'TypeScript', 'JavaScript', 'Tailwind CSS', 'REST API', 'Figma'],
            ],
            [
                'name' => 'Express Onboarding API',
                'slug' => 'express-js-onboarding-api',
                'description' => 'A focused onboarding API built with Express.js and TypeScript. It guides new users through a step-by-step signup and onboarding flow behind clean REST endpoints, strong typing and straightforward request validation — a great starting point for any product that needs structured user onboarding.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::Software,
                'complexity' => ProjectComplexity::Simple,
                'visibility' => ProjectVisibility::Public,
                'url' => null,
                'repository_url' => 'https://github.com/senadalmeidapro/express-js-onboarding-api',
                'image' => 'images/screenshots/project-1.svg',
                'skills' => ['TypeScript', 'Node.js', 'Express.js', 'REST API', 'Git'],
            ],
            [
                'name' => 'Portfolio Sena Studio',
                'slug' => 'portfolio-sena-studio',
                'description' => 'This very site: a personal freelance command center. A Filament back office to manage projects, skills, tech stack and infrastructure, backed by a polished, fast public front end in Livewire. The stack — Laravel, Redis, PostgreSQL and Docker — is deployed in the cloud and built to be extended, not replaced.',
                'status' => ProjectStatus::Production,
                'type' => ProjectType::Web,
                'complexity' => ProjectComplexity::Medium,
                'visibility' => ProjectVisibility::Public,
                'url' => url('/'),
                'repository_url' => 'https://github.com/senadalmeidapro/sena-studio',
                'image' => 'images/screenshots/project-6.svg',
                'stack' => $portfolioStack,
                'infra' => $infra,
                'skills' => ['PHP', 'Laravel', 'Filament', 'Livewire', 'Blade', 'Tailwind CSS', 'Alpine.js', 'Redis', 'PostgreSQL', 'Docker', 'Pest', 'Git'],
            ],
        ];

        $projectGalleries = [
            'mini-shop-api' => ['images/screenshots/project-2.svg', 'images/screenshots/project-3.svg'],
            'api-orientation' => ['images/screenshots/project-5.svg', 'images/screenshots/project-1.svg'],
            'itdesk' => ['images/screenshots/project-4.svg'],
            'mini-shop' => ['images/screenshots/project-2.svg'],
            'express-js-onboarding-api' => ['images/screenshots/project-1.svg'],
            'portfolio-sena-studio' => ['images/screenshots/project-2.svg', 'images/screenshots/project-5.svg', 'images/screenshots/project-3.svg'],
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
