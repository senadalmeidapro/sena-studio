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
use App\Models\Post;
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
            [StackItemCategory::Cloud, 'Railway', null, $buildIcon('railway')],
            [StackItemCategory::Storage, 'Cloudinary', null, $buildIcon('cloudinary')],
            [StackItemCategory::Devops, 'Docker', null, $buildIcon('docker')],
            [StackItemCategory::Devops, 'GitHub Actions', null, $buildIcon('githubactions')],
            [StackItemCategory::Testing, 'Pest', '4.x', '🧪'],
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

        Infra::where('name', 'Production Cloud')->delete();

        $infra = Infra::updateOrCreate(['name' => 'Railway Production'], [
            'description' => 'Déploiement Railway documenté pour l’application Laravel, avec image Docker multi-stage et base PostgreSQL managée.',
            'docker_image' => 'Dockerfile multi-stage',
            'kubernetes_config' => null,
            'helm_chart' => null,
            'cpu_cores' => 1,
            'memory_mb' => 512,
            'storage_gb' => 10,
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

        // Remove the legacy infrastructure claim that is no longer part of the verified profile.
        Skill::where('name', 'Kubernetes')->delete();

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
            'Node.js' => ['backend', 'application', 'web'],
            'NestJS' => ['backend', 'application', 'architecture'],
            'React' => ['frontend', 'web', 'architecture', 'application'],
            'Vue.js' => ['frontend', 'web', 'architecture', 'application'],
            'PHP' => ['backend', 'programming', 'web'],
            'Laravel' => ['backend', 'web', 'application'],
            'Livewire' => ['frontend', 'architecture', 'web'],
            'Filament' => ['backend', 'architecture', 'tools'],
            'Blade' => ['frontend', 'architecture', 'web'],
            'Tailwind CSS' => ['frontend', 'architecture', 'web', 'ui-ux'],
            'Alpine.js' => ['frontend', 'architecture', 'web', 'ui-ux'],
            'MySQL' => ['database'],
            'PostgreSQL' => ['database'],
            'Redis' => ['database', 'infrastructure'],
            'Docker' => ['devops', 'infrastructure', 'tools'],
            'Pest' => ['testing', 'programming'],
            'Git' => ['tools', 'open-source', 'devops'],
            'Figma' => ['ui-ux', 'architecture', 'web'],
            'TypeScript' => ['programming', 'backend', 'frontend', 'web'],
            'JavaScript' => ['programming', 'backend', 'frontend', 'web'],
            'Express.js' => ['backend', 'web'],
            'Prisma' => ['database', 'backend', 'programming'],
            'TypeORM' => ['database', 'backend', 'programming'],
            'REST API' => ['backend', 'api', 'architecture'],
            'WebSockets' => ['backend', 'api', 'application'],
            'Postman' => ['tools', 'api', 'testing'],
            'Swagger / OpenAPI' => ['api', 'tools'],
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
                'description' => 'REST API for an e-commerce platform built with NestJS and TypeORM. The repository covers authentication, users, addresses, products, categories, carts, orders, payments and reviews with JWT authentication and request validation.',
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
                'description' => 'Backend of a career-guidance platform for young people in Benin. The repository implements the RIASEC model, two-phase testing, multi-dimensional scoring, career recommendations, adaptive behavior, gamification, administration and security layers.',
                'status' => ProjectStatus::Development,
                'type' => ProjectType::App,
                'complexity' => ProjectComplexity::Complex,
                'visibility' => ProjectVisibility::Public,
                'url' => 'https://orientation-bj-production.up.railway.app',
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
                'description' => 'A TypeScript Express.js repository focused on structuring an onboarding API and its REST endpoints.',
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
                'url' => env('SITE_URL', url('/')),
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

        $caseStudies = [
            'mini-shop-api' => [
                'role' => 'Conception backend et architecture API',
                'problem' => 'Construire un socle e-commerce capable de couvrir le catalogue, le panier, les commandes et les paiements sans mélanger les responsabilités.',
                'architecture' => 'API REST modulaire avec NestJS, TypeORM et PostgreSQL, organisée autour de domaines métier explicites.',
                'technical_decisions' => 'Validation stricte des entrées, authentification JWT, gestion du stock au niveau du parcours de commande et documentation OpenAPI.',
                'result' => 'Un backend indépendant du frontend, plus simple à tester, documenter et faire évoluer.',
                'featured' => true,
                'sort_order' => 1,
            ],
            'api-orientation' => [
                'role' => 'Backend, modélisation métier et moteur de recommandation',
                'problem' => 'Transformer un questionnaire d’orientation en recommandations cohérentes, traçables et compréhensibles pour l’utilisateur.',
                'architecture' => 'API NestJS avec modèle de données PostgreSQL, cache Redis, authentification par rôles et services dédiés au calcul des résultats.',
                'technical_decisions' => 'Séparer le calcul psychométrique, la recommandation et la génération de conseils afin de garder chaque étape testable.',
                'result' => 'Une base applicative structurée autour du domaine plutôt qu’autour des seuls écrans de l’application.',
                'featured' => true,
                'sort_order' => 2,
            ],
            'itdesk' => [
                'role' => 'Conception full-stack et modélisation des workflows',
                'problem' => 'Centraliser les demandes IT, les incidents, les changements et les actifs dans un outil interne compréhensible par plusieurs profils.',
                'architecture' => 'Application Laravel avec Livewire, Filament, politiques d’accès et modèles métier séparés pour les tickets et les actifs.',
                'technical_decisions' => 'Utiliser des transitions d’état et des permissions explicites pour rendre les workflows prévisibles et auditables.',
                'result' => 'Un outil interne construit autour des processus réels plutôt qu’une simple liste de tickets.',
                'sort_order' => 3,
            ],
            'mini-shop' => [
                'role' => 'Développement frontend et intégration API',
                'problem' => 'Proposer une expérience storefront légère au-dessus d’un backend e-commerce indépendant.',
                'architecture' => 'Frontend Vue 3 et Vite consommant une API REST, avec une séparation claire entre interface, état du panier et appels réseau.',
                'technical_decisions' => 'Privilégier des composants simples et une interface responsive afin de garder le produit rapide et maintenable.',
                'result' => 'Une interface prête à évoluer sans coupler le frontend aux détails internes du backend.',
                'sort_order' => 4,
            ],
            'express-js-onboarding-api' => [
                'role' => 'Conception d’API et implémentation TypeScript',
                'problem' => 'Structurer un parcours d’inscription en plusieurs étapes sans perdre la cohérence des données utilisateur.',
                'architecture' => 'API Express.js typée avec des endpoints REST dédiés au parcours d’onboarding et à la validation des requêtes.',
                'technical_decisions' => 'Conserver une architecture volontairement simple pour rendre le flux lisible et facile à brancher sur différents clients.',
                'result' => 'Une base claire pour les produits qui doivent accompagner un utilisateur pendant son inscription.',
                'sort_order' => 5,
            ],
            'portfolio-sena-studio' => [
                'role' => 'Architecture, développement et déploiement',
                'problem' => 'Gérer le contenu d’un portfolio technique tout en gardant une expérience publique rapide et éditoriale.',
                'architecture' => 'Application Laravel avec frontend Livewire, administration Filament, PostgreSQL, Redis, Cloudinary et déploiement Railway.',
                'technical_decisions' => 'Séparer le backoffice de la présentation publique, utiliser des composants réutilisables et centraliser le stockage des médias.',
                'result' => 'Une base de portfolio conçue comme un produit maintenable, et non comme une page statique difficile à faire évoluer.',
                'sort_order' => 0,
            ],
        ];

        $verifiedProjectUpdates = [
            'mini-shop-api' => [
                'description' => 'API REST e-commerce NestJS et TypeORM couvrant l’authentification, les utilisateurs, les adresses, les produits, les catégories, les paniers, les commandes, les paiements, les avis, les notifications et la facturation.',
                'role' => 'Conception backend et architecture API',
                'problem' => 'Construire un socle e-commerce capable de gérer le catalogue, le panier, les commandes et les paiements avec des règles métier explicites.',
                'architecture' => 'API REST modulaire avec NestJS, TypeORM et PostgreSQL, organisée autour de modules métier et d’événements de paiement.',
                'technical_decisions' => 'Validation stricte des entrées, authentification JWT, vérification du stock dans une transaction, pagination, rate limiting et génération de factures.',
                'result' => 'Un backend indépendant du frontend avec des parcours métier structurés et des évolutions récentes vérifiables dans l’historique GitHub.',
            ],
            'api-orientation' => [
                'description' => 'Backend NestJS d’une plateforme d’orientation professionnelle destinée principalement aux jeunes béninois, avec parcours RIASEC, scoring multidimensionnel et recommandations de métiers.',
                'role' => 'Backend, modélisation métier et moteur de recommandation',
                'problem' => 'Transformer un questionnaire d’orientation en résultats cohérents, traçables et compréhensibles, adaptés au contexte local.',
                'architecture' => 'Application NestJS, TypeScript, Prisma et PostgreSQL, avec Redis pour le cache adaptatif, des guards globaux et des modules métier séparés.',
                'technical_decisions' => 'Validation globale stricte, JWT, RBAC, rate limiting, audit trail, scoring séparé des recommandations, export PDF et intégrations optionnelles.',
                'result' => 'Une base backend documentée autour du domaine : sessions, réponses, scoring, résultats, recommandations, métiers, établissements et ressources.',
            ],
            'itdesk' => [
                'description' => 'Plateforme Laravel de gestion des services IT avec catalogue public, formulaires par service, back-office Filament, tickets, approbations, incidents, problèmes, changements et suivi des actifs.',
                'role' => 'Conception full-stack et modélisation des workflows',
                'problem' => 'Relier les demandes publiques, les opérations IT et le support interne dans un même flux compréhensible par chaque rôle.',
                'architecture' => 'Monolithe Laravel avec Blade, Livewire, Filament, politiques d’accès et modèles métier séparés pour les leads, tickets, actifs et licences.',
                'technical_decisions' => 'Limiter les champs de formulaire au schéma déclaré, convertir les leads en tickets de manière idempotente et imposer les transitions d’état au niveau du modèle.',
                'result' => 'Un workflow vérifiable de capture lead → ticket, complété par un back-office, une CMDB et des suites de tests dédiées.',
            ],
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
                    ...($caseStudies[$projectData['slug']] ?? []),
                    ...($verifiedProjectUpdates[$projectData['slug']] ?? []),
                    'version' => '1.0.0',
                    'started_at' => $projectData['started_at'] ?? null,
                    'ended_at' => $projectData['ended_at'] ?? null,
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

        // Remove the three placeholder leads created by the former demo seeder.
        ContactMessage::whereIn('email', [
            'claire@atelier-fontaine.fr',
            'marc@indepmarc.fr',
            'sonia@meunier-studio.com',
        ])->delete();

        /* Demo leads removed: seed only verified portfolio data.
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

        */

        $this->seedPosts();
        $this->seedCvs();
    }

    private function seedPosts(): void
    {
        $posts = [
            [
                'key' => 'riasec-scoring-engine',
                'category' => 'architecture',
                'fr' => [
                    'title' => 'Concevoir un moteur de scoring RIASEC traçable',
                    'excerpt' => 'Retour sur la séparation entre réponses, scoring, cohérence du profil et recommandations dans Orientation-BJ.',
                    'content' => '<h2>Le problème</h2><p>Un questionnaire d’orientation ne se résume pas à additionner des réponses. Le système doit conserver le parcours de la session, calculer plusieurs dimensions et produire un résultat que l’on peut expliquer.</p><h2>Séparer les responsabilités</h2><p>Dans Orientation-BJ, les réponses, les sessions, le calcul des scores, les résultats et les recommandations correspondent à des modules distincts. Cette séparation évite de mélanger la collecte avec la décision métier et rend chaque étape plus facile à tester.</p><h2>Du score à la recommandation</h2><p>Le profil RIASEC est calculé à partir des réponses, puis les codes dominants et les indicateurs de cohérence sont persistés avec le résultat. Les recommandations peuvent ensuite s’appuyer sur ce résultat sans recalculer tout le parcours.</p><h2>Ce que cela change</h2><p>Cette structure rend le système plus lisible : une règle de scoring peut évoluer sans réécrire les contrôleurs de session, et une recommandation peut être expliquée à partir de données conservées.</p>',
                    'seo' => 'Concevoir un moteur de scoring RIASEC traçable avec NestJS, Prisma et PostgreSQL.',
                ],
                'en' => [
                    'title' => 'Designing a traceable RIASEC scoring engine',
                    'excerpt' => 'How Orientation-BJ separates answers, scoring, profile consistency and recommendations.',
                    'content' => '<h2>The problem</h2><p>A career questionnaire is not just a sum of answers. The system must preserve the session journey, calculate several dimensions and produce an explainable result.</p><h2>Separate responsibilities</h2><p>In Orientation-BJ, answers, sessions, scoring, results and recommendations are represented by separate modules. This keeps data collection apart from business decisions and makes each stage easier to test.</p><h2>From score to recommendation</h2><p>The RIASEC profile is calculated from the answers, then dominant codes and consistency indicators are persisted with the result. Recommendations can use that result without recalculating the entire journey.</p><h2>Why it matters</h2><p>This structure keeps the system readable: a scoring rule can evolve without rewriting session controllers, and a recommendation can be explained from stored data.</p>',
                    'seo' => 'Designing a traceable RIASEC scoring engine with NestJS, Prisma and PostgreSQL.',
                ],
            ],
            [
                'key' => 'itdesk-lead-to-ticket',
                'category' => 'application',
                'fr' => [
                    'title' => 'De la demande publique au ticket IT : concevoir un workflow fiable',
                    'excerpt' => 'Comment ITDesk transforme une demande de service en ticket tout en gardant les règles métier dans le domaine.',
                    'content' => '<h2>Un formulaire n’est que le début</h2><p>Dans ITDesk, une demande envoyée depuis le site public est un lead. Elle doit ensuite être qualifiée, éventuellement convertie en ticket et reliée à un agent sans perdre son contexte.</p><h2>Une conversion idempotente</h2><p>La conversion lead vers ticket est conçue pour être idempotente : une seconde action ne crée pas un doublon. Le lead conserve son statut et la relation vers le ticket créé.</p><h2>Les états appartiennent au domaine</h2><p>Les transitions de ticket sont définies par le modèle métier. Les chemins invalides sont refusés, et le statut fermé reste terminal sauf règle explicite de réouverture.</p><h2>Pourquoi le back-office compte</h2><p>Filament sert ici à rendre les opérations visibles : statuts, permissions, clients, agents et historique sont réunis dans un espace de travail adapté aux rôles.</p>',
                    'seo' => 'Concevoir un workflow lead vers ticket fiable avec Laravel, Livewire et Filament.',
                ],
                'en' => [
                    'title' => 'From public request to IT ticket: designing a reliable workflow',
                    'excerpt' => 'How ITDesk turns a service request into a ticket while keeping business rules in the domain.',
                    'content' => '<h2>A form is only the beginning</h2><p>In ITDesk, a request submitted through the public site is a lead. It must be qualified, potentially converted into a ticket and assigned without losing its context.</p><h2>An idempotent conversion</h2><p>The lead-to-ticket conversion is designed to be idempotent: repeating the action does not create a duplicate. The lead keeps its status and its relation to the created ticket.</p><h2>States belong to the domain</h2><p>Ticket transitions are defined by the domain model. Invalid paths are rejected, and a closed ticket remains terminal unless an explicit reopen rule applies.</p><h2>Why the back office matters</h2><p>Filament makes operations visible: statuses, permissions, clients, agents and history are brought together in a role-aware workspace.</p>',
                    'seo' => 'Designing a reliable lead-to-ticket workflow with Laravel, Livewire and Filament.',
                ],
            ],
            [
                'key' => 'stock-transactions-ecommerce-api',
                'category' => 'api',
                'fr' => [
                    'title' => 'Stock et transactions dans une API e-commerce',
                    'excerpt' => 'Les décisions récentes de Mini Shop API pour éviter les commandes incohérentes et faire évoluer les parcours métier.',
                    'content' => '<h2>Le stock est une règle métier</h2><p>Ajouter un article au panier et créer une commande ne sont pas de simples opérations CRUD. La quantité demandée doit être validée, et l’état du stock doit rester cohérent pendant le parcours.</p><h2>Valider au bon endroit</h2><p>Mini Shop API combine la validation des DTO avec une vérification métier du stock. La création de commande s’appuie sur une transaction afin de regrouper les écritures liées au panier, aux lignes de commande et à l’inventaire.</p><h2>Faire évoluer sans tout coupler</h2><p>Les commits récents ajoutent la pagination, le rate limiting, les événements de paiement, les factures et les notifications par modules séparés. Ces évolutions gardent les contrôleurs minces et déplacent les décisions dans les services.</p><h2>Une base utile pour le frontend</h2><p>Le frontend n’a pas besoin de connaître les détails internes de la persistance. Il consomme des contrats HTTP et reçoit des erreurs explicites lorsque la règle métier n’est pas respectée.</p>',
                    'seo' => 'Gérer le stock et les transactions dans une API e-commerce NestJS.',
                ],
                'en' => [
                    'title' => 'Stock and transactions in an e-commerce API',
                    'excerpt' => 'Recent Mini Shop API decisions for preventing inconsistent orders and evolving business workflows.',
                    'content' => '<h2>Stock is a business rule</h2><p>Adding an item to a cart and creating an order are not simple CRUD operations. The requested quantity must be validated and stock must remain consistent throughout the flow.</p><h2>Validate at the right boundary</h2><p>Mini Shop API combines DTO validation with a business-level stock check. Order creation uses a transaction to group writes related to the cart, order lines and inventory.</p><h2>Evolve without tight coupling</h2><p>Recent commits add pagination, rate limiting, payment events, invoices and notifications as separate modules. This keeps controllers thin and moves decisions into services.</p><h2>A useful frontend contract</h2><p>The frontend does not need to know persistence details. It consumes HTTP contracts and receives explicit errors when a business rule is not satisfied.</p>',
                    'seo' => 'Managing stock and transactions in a NestJS e-commerce API.',
                ],
            ],
        ];

        foreach ($posts as $index => $postData) {
            $category = Category::where('slug', $postData['category'])->first();

            foreach (['fr', 'en'] as $locale) {
                $content = $postData[$locale];
                $post = Post::updateOrCreate(
                    ['slug' => $postData['key'].'-'.$locale],
                    [
                        'locale' => $locale,
                        'title' => $content['title'],
                        'excerpt' => $content['excerpt'],
                        'content' => $content['content'],
                        'status' => Post::STATUS_PUBLISHED,
                        'published_at' => now()->subDays(10 - ($index * 3)),
                        'seo_title' => $content['title'],
                        'seo_description' => $content['seo'],
                    ],
                );

                if ($category && ! $post->categories()->whereKey($category->id)->exists()) {
                    $post->categories()->attach($category->id);
                }
            }
        }
    }

    private function seedCvs(): void
    {
        /* Legacy CV fixture replaced by the verified profile below.
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
        ]; */

        $base = [
            'title' => 'Curriculum vitae - Sèna Gédéon D\'ALMEIDA',
            'headline' => 'Sèna Gédéon D\'ALMEIDA - Backend Engineer',
            'email' => 'senadalmeidapro@gmail.com',
            'phone' => '(+229) 01 45 74 08 16',
            'location' => 'Cotonou, Benin',
            'website' => 'https://senadalmeidapro.github.io/CV/',
            'summary' => 'Backend Engineer focused on building secure, reliable, and maintainable APIs and business applications across the full development lifecycle, from architecture and database design to implementation, testing and deployment. Based in Cotonou, Benin, and open to remote international collaborations.',
            'links' => [
                ['label' => 'GitHub', 'url' => 'https://github.com/senadalmeidapro'],
                ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/senadalmeida'],
                ['label' => 'Portfolio', 'url' => 'https://senadalmeidapro.github.io/CV/'],
            ],
            'experience' => [
                [
                    'title' => 'Full-Stack Developer and DevOps (Freelance)',
                    'subtitle' => 'Fintech and ed-tech web applications',
                    'period_start' => '2023-01',
                    'period_end' => null,
                    'description' => 'Built and deployed REST APIs with NestJS, Prisma, PostgreSQL and Docker; modeled relational data, integrated transactional services, automated operations with self-hosted n8n, and owned the workflow from requirements to delivery.',
                ],
            ],
            'projects' => [
                [
                    'title' => 'Orientation-BJ API',
                    'subtitle' => 'Career guidance platform | Backend and domain architecture',
                    'stack' => 'NestJS - Prisma - PostgreSQL - Redis - Docker',
                    'url' => 'https://github.com/senadalmeidapro/api-orientation',
                    'description' => 'Implemented the RIASEC assessment flow, multi-dimensional scoring, career recommendations, adaptive behavior, administration and security layers for a platform focused on young people in Benin.',
                ],
                [
                    'title' => 'ITDesk / TAKTIC',
                    'subtitle' => 'IT service management platform | Full-stack architecture',
                    'stack' => 'Laravel - Livewire - Filament - Tailwind CSS - Pest',
                    'url' => 'https://github.com/senadalmeidapro/itdesk',
                    'description' => 'Designed ticket workflows, approvals, incident/problem/change management, asset tracking and a lead-to-ticket pipeline with permission-based policies and a Filament back office.',
                ],
                [
                    'title' => 'Mini Shop API',
                    'subtitle' => 'E-commerce backend | REST API design',
                    'stack' => 'NestJS - TypeORM - PostgreSQL - JWT',
                    'url' => 'https://github.com/senadalmeidapro/mini-shop-api',
                    'description' => 'Built the core commerce domains: users, addresses, cart, products, categories, orders, payments and reviews, with authentication, validation and stock-aware order flows.',
                ],
                [
                    'title' => 'Sena Studio',
                    'subtitle' => 'Engineering portfolio and freelance command center',
                    'stack' => 'Laravel - Filament - Livewire - PostgreSQL - Redis - Cloudinary',
                    'url' => 'https://github.com/senadalmeidapro/sena-studio',
                    'description' => 'Built a maintainable public portfolio and administration system for projects, case studies, media, CV versions, editorial content and freelance leads.',
                ],
            ],
            'education' => [
                [
                    'title' => "Bachelor's Degree - Computer Science and Software Engineering",
                    'subtitle' => 'ENEAM',
                    'period_start' => '2023-01',
                    'period_end' => '2026-12',
                    'description' => null,
                ],
                [
                    'title' => 'High School Diploma - Science Track',
                    'subtitle' => 'Collège Catholique Père Planque',
                    'period_start' => '2022-01',
                    'period_end' => '2023-01',
                    'description' => null,
                ],
            ],
            'skills' => [
                ['name' => 'TypeScript', 'group' => 'Languages', 'level' => 'avance'],
                ['name' => 'JavaScript', 'group' => 'Languages', 'level' => 'avance'],
                ['name' => 'Python', 'group' => 'Languages', 'level' => 'intermediaire'],
                ['name' => 'SQL', 'group' => 'Languages', 'level' => 'avance'],
                ['name' => 'NestJS', 'group' => 'Backend', 'level' => 'avance'],
                ['name' => 'Node.js', 'group' => 'Backend', 'level' => 'avance'],
                ['name' => 'Laravel', 'group' => 'Backend', 'level' => 'intermediaire'],
                ['name' => 'REST API', 'group' => 'Backend', 'level' => 'avance'],
                ['name' => 'JWT / OAuth2', 'group' => 'Backend', 'level' => 'intermediaire'],
                ['name' => 'React', 'group' => 'Frontend', 'level' => 'intermediaire'],
                ['name' => 'Responsive UI', 'group' => 'Frontend', 'level' => 'intermediaire'],
                ['name' => 'PostgreSQL', 'group' => 'Database', 'level' => 'avance'],
                ['name' => 'Prisma', 'group' => 'Database', 'level' => 'avance'],
                ['name' => 'MySQL', 'group' => 'Database', 'level' => 'avance'],
                ['name' => 'Linux', 'group' => 'DevOps', 'level' => 'intermediaire'],
                ['name' => 'Docker', 'group' => 'DevOps', 'level' => 'avance'],
                ['name' => 'CI/CD', 'group' => 'DevOps', 'level' => 'intermediaire'],
                ['name' => 'GitHub Actions', 'group' => 'DevOps', 'level' => 'intermediaire'],
            ],
            'languages' => [
                ['name' => 'Fon', 'level' => 'Native'],
                ['name' => 'French', 'level' => 'C1'],
                ['name' => 'English', 'level' => 'B1'],
            ],
            'certifications' => [],
            'hobbies' => [
                ['name' => 'Self-hosting'],
                ['name' => 'Problem solving'],
                ['name' => 'Developer tooling'],
            ],
        ];

        $published = [
            'version_label' => 'V1 - Engineering',
            'slug' => 'senastudio-cv',
            'template' => CvTemplate::Engineering,
            'status' => CvStatus::Published,
            'accent_color' => '#059669',
            'is_primary' => true,
        ];

        $draft = [
            'version_label' => 'V2 - Minimal',
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
