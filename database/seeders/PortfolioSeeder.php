<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            throw new \RuntimeException('PortfolioSeeder contains sample content and cannot run in production.');
        }

        $buildIcon = fn (string $slug): string => 'https://cdn.simpleicons.org/'.$slug;

        $categories = [
            [
                'name' => 'Backend engineering',
                'slug' => 'backend-engineering',
                'description' => 'Robust server-side systems, business logic, data processing, and reliable application services.',
                'sort_order' => 1,
            ],
            [
                'name' => 'APIs & integrations',
                'slug' => 'apis-integrations',
                'description' => 'Well-designed APIs, webhooks, and seamless integrations connecting applications, services, and external platforms.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Software architecture',
                'slug' => 'software-architecture',
                'description' => 'Thoughtful system design, clear architectural boundaries, modular components, and maintainable software built to evolve.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Full-stack applications',
                'slug' => 'full-stack-applications',
                'description' => 'Complete web applications combining intuitive user interfaces, robust backend services, data management, and cohesive user experiences.',
                'sort_order' => 4,
            ],
            [
                'name' => 'DevOps & infrastructure',
                'slug' => 'devops-infrastructure',
                'description' => 'Containerization, deployment automation, environment configuration, and infrastructure practices that improve reliability and delivery.',
                'sort_order' => 5,
            ],
            [
                'name' => 'SaaS & internal tools',
                'slug' => 'saas-internal-tools',
                'description' => 'Business-oriented software products, SaaS platforms, administrative interfaces, and internal tools that streamline workflows and operations.',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }

        $skillsData = [
            ['TypeScript', 'Typed superset of JavaScript that adds static types to catch errors early and make code easier to maintain.', $buildIcon('typescript')],
            ['JavaScript', 'High-level, dynamic programming language used to create interactive and dynamic web experiences.', $buildIcon('javascript')],
            ['Python', 'High-level, general-purpose programming language known for its readable syntax and broad applications in automation, backend development, data processing, and scripting.', $buildIcon('python')],
            ['Rust', 'Systems programming language focused on memory safety, concurrency, and performance without requiring a garbage collector.', $buildIcon('rust')],
            ['Node.js', 'Cross-platform JavaScript runtime environment that allows JavaScript to run outside the browser.', $buildIcon('nodedotjs')],
            ['NestJS', 'Progressive Node.js framework for building efficient, reliable, and scalable server-side applications with TypeScript.', $buildIcon('nestjs')],
            ['Express.js', 'A fast, unopinionated, minimalist web framework for Node.js.', $buildIcon('express')],
            ['Prisma', 'ORM (Object-Relational Mapping) for Node.js and TypeScript that simplifies database access with type-safe queries.', $buildIcon('prisma')],
            ['React', 'JavaScript library for building user interfaces, especially interactive web applications.', $buildIcon('react')],
            ['Vue.js', 'Progressive JavaScript framework for building user interfaces and single-page applications.', $buildIcon('vuedotjs')],
            ['REST API', 'REST API (Representational State Transfer API) is an application programming interface that follows REST architectural principles to enable communication between systems over HTTP.', $buildIcon('openapiinitiative')],
            ['WebSockets', 'Communication protocol that enables persistent, bidirectional communication between a client and a server over a single connection.', $buildIcon('socketdotio')],
            ['GitHub', 'Cloud-based platform for version control and collaborative software development, built around Git.', $buildIcon('github')],
            ['Linux', 'Unix-like operating system kernel that serves as the foundation for Linux-based operating systems (distributions).', $buildIcon('linux')],
            ['GitHub Actions', 'CI/CD automation platform for building, testing, deploying, and automating software development workflows.', $buildIcon('githubactions')],
            ['Git', 'Distributed version control system designed to track changes in source code and support collaboration among developers.', $buildIcon('git')],
            ['MySQL', 'Relational database management system (RDBMS) that uses SQL (Structured Query Language) to store, organize, and retrieve data.', $buildIcon('mysql')],
            ['TypeORM', 'ORM (Object-Relational Mapping) for TypeScript and JavaScript that simplifies database interactions.', $buildIcon('typeorm')],
            ['Eloquent', 'ORM for interacting with databases through expressive PHP models, simplifying data retrieval, persistence, relationships, and query building.', $buildIcon('databricks')],
            ['Postman', 'API platform for building, testing, documenting, and managing APIs throughout their lifecycle.', $buildIcon('postman')],
            ['Swagger', 'Suite of tools for designing, documenting, testing, and interacting with APIs described using the OpenAPI Specification.', $buildIcon('swagger')],
            ['OpenAPI', 'Open standard specification for describing HTTP APIs in a language-agnostic, machine-readable format.', $buildIcon('openapiinitiative')],
            ['Laravel', 'PHP web application framework designed for building modern, robust, and scalable web applications.', $buildIcon('laravel')],
            ['Filament', 'UI framework for building admin panels, dashboards, and forms in Laravel applications using PHP.', $buildIcon('filament')],
            ['Livewire', 'Full-stack framework for Laravel that enables to build dynamic, reactive interfaces using PHP without requiring extensive JavaScript.', $buildIcon('livewire')],
            ['Redis', 'In-memory data store used as a database, cache, message broker, and streaming engine.', $buildIcon('redis')],
            ['Docker', 'Containerizing applications and services to create consistent, isolated, and reproducible development and production environments.', $buildIcon('docker')],
            ['PostgreSQL', 'Object-relational database management system (ORDBMS) known for its reliability, extensibility, and SQL compliance.', $buildIcon('postgresql')],
            ['SQLite', 'Self-contained, serverless, zero-configuration, transactional SQL database engine.', $buildIcon('sqlite')],
            ['Redis Queue', 'Python library for queueing jobs and processing them in the background using Redis.', $buildIcon('redis')],
            ['Markdown', 'Lightweight markup language that lets you format plain text using simple, readable syntax and convert it into HTML or other document formats.', $buildIcon('markdown')],
        ];

        $skillCategories = [
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

        $skills = collect();
        foreach ($skillsData as [$name, $description, $icon]) {
            $skills->push(Skill::updateOrCreate(['name' => $name], [
                'description' => $description,
                'category' => $skillCategories[$name] ?? 'tools',
                'is_active' => true,
                'icon' => $icon,
            ]));
        }
    }
}
