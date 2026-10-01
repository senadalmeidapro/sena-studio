# Sena Studio

Sena Studio is a single-admin portfolio for generating qualified leads, with a small tracker for clients, engagements, deliverables, and invoices. It is not a multi-user service.

The public site is available in French and English. It presents projects and case studies, skills, services, a CV, and a structured contact scoping form. The Filament admin manages that content and the lead/client workflow.

## Current application

- **14 Eloquent models**, including projects, skills, testimonials, leads, clients, engagements, deliverables, invoices, and CVs.
- **11 Filament resources** and **4 dashboard widgets** for new leads, contact pipeline, projects missing media, and active engagements/overdue invoices.
- A single `is_admin` flag controls access to the admin panel. Public registration is disabled.
- Contact submissions store project type, goal, timeline, budget range, and optional context. A lead can be converted into a client and proposal engagement from the inbox.
- Engagement and invoice amounts are integers: EUR values use cents; XOF values use whole units.
- Public projects can include case-study details, a headline result metric, and one linked testimonial.
- Protected projects use non-expiring signed share links generated in the admin. Regenerating a link revokes previously generated links.
- Analytics script injection is optional and configured with `ANALYTICS_SCRIPT`.

## Stack

| Area | Technology |
| --- | --- |
| Runtime | PHP ^8.3 |
| Application | Laravel ^13.0 |
| Admin | Filament ^5.6 |
| UI | Livewire ^4.1, Flux ^2.13, Tailwind CSS ^4, Vite ^8 |
| Database | PostgreSQL; SQLite is used by the test suite |
| Authentication | Laravel Fortify, one admin account |
| Media | Cloudinary PHP client and Laravel Flysystem adapter |
| CV export | `barryvdh/laravel-dompdf` |
| Tests and style | Pest ^4 and Laravel Pint |

## Setup

Requirements: PHP 8.3+, Composer 2, Node.js compatible with Vite 8, and PostgreSQL (or SQLite for local development).

```bash
git clone <repository-url>
cd sena-studio
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Set the database connection and credentials in `.env`. To create the initial admin account, set `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD`, then run:

```bash
php artisan db:seed
```

In production, the seeder stops with an error if `ADMIN_EMAIL` or `ADMIN_PASSWORD` is missing. Never commit `.env` or place credentials in source control.

Start local development with `composer dev`, or run `php artisan serve` and `npm run dev` separately.

## Routes

Localized public pages use `/fr/...` and `/en/...`; the bare root redirects to the default locale. Route slugs are shared across locales. Examples:

- `/fr` and `/en` — portfolio home
- `/fr/projets` and `/en/projets` — projects and case studies
- `/fr/competences` and `/en/competences` — skills
- `/fr/services` and `/en/services` — service offer
- `/fr/contact` and `/en/contact` — lead scoping form
- `/fr/cv/{slug}` and `/en/cv/{slug}` — published CV
- `/stack` — permanent redirect to the localized skills page
- `/admin` — authenticated Filament panel

The admin also provides a protected CV PDF export route. Public route aliases and legacy redirects are defined in `routes/web.php`.

## Configuration

See `.env.example` for database, mail, Cloudinary, queue, and optional analytics settings. Availability and the optional booking URL are edited from **Admin → Settings → Site availability**.

The seeded portfolio content is sample content. Review it before publishing. The services page currently positions the studio around backend and product engineering for fintech and ed-tech, including EU regulatory context; validate that positioning before launch.

## Quality checks

```bash
composer lint
composer test
composer ci:check
```

The test suite uses Pest with an in-memory SQLite database and `RefreshDatabase`.
