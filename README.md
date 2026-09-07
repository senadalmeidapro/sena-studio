<div align="center">

# 🎨 Sena Studio

### Freelance Command Center & Public Portfolio Platform

> Custom-built freelance management backoffice + elegant public site, built on **Laravel 13**, **Filament v5**, **Livewire 4** and **Flux 2** — to manage projects, tech stacks, skills, infrastructure, resumes and contact requests from a single interface.

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Filament](https://img.shields.io/badge/Filament-v5-FCB66D?logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSIzMiI+PHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iMTAiIGZpbGw9IiMwNDExMjciLz48Y2lyY2xlIGN4PSIxMSIgY3k9IjExIiByPSI2IiBmaWxsPSIjZmM2NmJkIi8+PGNpcmNsZSBjeD0iMjEiIGN5PSIyMSIgcj0iNiIgZmlsbD0iI2ZjNjZiZCIvPjwvc3ZnPg==)](https://filamentphp.com)
[![Livewire](https://img.shields.io/badge/Livewire-v4-EB4B4B?logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Flux](https://img.shields.io/badge/Flux-v2-0A3EAE)](https://fluxui.dev)
[![Tailwind](https://img.shields.io/badge/Tailwind-v4-38BDF8?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-4cc61e.svg)](LICENSE)

**Author:** Sena Gedeon D'ALMEIDA — [email](mailto:senadalmeidapro@gmail.com)

</div>

---

## 📖 Overview

**Sena Studio** brings together two complementary experiences on a single codebase:

- **A complete Filament backoffice** (a "command center") to manage — in just a few clicks — projects, tech stacks, skills, infrastructure, resumes and contact requests.
- **A modern, accessible public site** (Livewire + Flux) that automatically publishes the content managed in the admin: homepage, filterable portfolio, skills, tech stack, contact form and a downloadable PDF resume.

The whole thing is wrapped in a **premium blue design system** (Tailwind CSS v4) with a layered dark mode and polished micro-interactions.

---

## ✨ Features

### 🗂️ Project management
- Rich metadata: **status** (`development` / `testing` / `production` / `cancelled`), **type** (`web` / `app` / `software`), **complexity** and **visibility** (`public` / `protected` / `private`)
- Links to a **stack**, an **infrastructure** and **skills** (with proficiency level `primary` / `secondary` / `research` in the pivot)
- Classification into polymorphic **categories**, pricing, version, dates, URL and repository
- **Image gallery** (`ProjectImage`) with sort order, managed from a Filament repeater
- Soft deletes (`SoftDeletes`) and advanced filtering

### 🧩 Tech stacks
- Named, reusable stacks broken down into categorized **StackItems**: `frontend`, `backend`, `database`, `cache`, `queue`, `orm`, `storage`, `cloud`, `monitoring`, `analytics`, `devops`, `design`, `testing`, `documentation`, `others`
- Each item: value, version and **icon** (SimpleIcons / site icon)
- Inline editing + enable/disable per stack

### 🛠️ Skills
- Proficiency levels: `beginner` → `intermediate` → `advanced` → `expert`
- Visual icons, activation toggles and shared polymorphic categorization
- Public page grouped by level

### ☁️ Infrastructure as data
- Docker, Kubernetes and Helm recorded per infra profile
- Allocations: **CPU (cores)**, **memory (MB)**, **storage (GB)**
- Environment: `development` / `staging` / `production`

### 📄 Versioned resume
- Rendering templates: **Classic**, **Modern**, **Minimal** — each version has its own accent color
- **Draft** / **Published** statuses, featured **primary** version
- Structured content (experience, education, skills, languages, certifications, interests) via repeaters
- **PDF export** (dompdf) from the admin, dedicated public page and draft preview
- Auto-generated slug on save

### ✉️ Contact messages
- Public form (Livewire) with validation, preset budgets and email sending
- Admin inbox: raw read/unread message, automatic `markAsRead` on view
- "Unread messages" widget on the dashboard

### 📊 Filament dashboard
- **6 overview stats** (users, projects, production, unread messages, skills, stacks/infra)
- **Charts**: projects by status (donut), projects by stack (bars), skills by category (bars)
- Operational widgets: recent projects, **unread messages**, **projects with no media**, quick actions
- **Infrastructure** health view (active/inactive infras, production, provisioned CPU/RAM/storage)

### 🔐 Authentication & security
- **Fortify**: registration, password reset, **email verification** and **2FA** (with confirmation)
- Custom auth views in **Livewire/Flux**
- Flux `appearance` and `profile` pages, "Account security" page in Filament
- **Spatie RBAC**: `permissions` / `roles` tables and provided `Roles` & `Permissions` Filament resources
- `User` implements `FilamentUser` (admin access)

### 🎨 Design system (premium blue)
- **Blue `#2563eb`** accent palette, slate neutrals, semantic green (success/availability)
- **Surface tokens** (`canvas`, `surface`, `card`, `elevated`, `soft`, `line`) as CSS variables — Light & Dark (4 surface levels in dark mode)
- Shadows (`soft` / `card` / `lifted` / `panel`), consistent radii, **Instrument Sans + Space Grotesk + JetBrains Mono** typography
- Dedicated `filament.css` to align the Filament admin with the public site

---

## 🛠️ Tech stack

| Layer | Technology |
|---|---|
| **Runtime** | PHP ^8.4 |
| **Framework** | Laravel ^13.0 |
| **Admin Panel** | Filament ^5.6 |
| **Frontend** | Livewire ^4.1 · Flux ^2.13 · Alpine.js · Tailwind CSS ^4 · Vite ^8 |
| **Database** | PostgreSQL (default & Railway) · SQLite for quick dev |
| **Auth** | Fortify · Sanctum |
| **Billing** | Cashier (Stripe) |
| **RBAC** | Spatie Permission |
| **Media** | Spatie MediaLibrary |
| **PDF** | barryvdh/laravel-dompdf |
| **Testing** | Pest ^4 |

---

## 🏗️ Project structure

```
sena-studio/
│
├── app/
│   ├── Actions/               # Fortify (CreateNewUser, ResetUserPassword)
│   ├── Concerns/              # Validation rules (Password & Profile)
│   ├── Enums/                 # 11 typed enums (Project, Skill, Stack, Infra, CV…)
│   ├── Filament/
│   │   ├── Pages/             # Dashboard (9 widgets) + Account security
│   │   ├── Resources/         # 10 resources (Schemas/ + Tables/ + Pages/)
│   │   │   └── Projects/RelationManagers/
│   │   └── Widgets/           # 9 widgets (stats, charts, operational)
│   ├── Livewire/
│   │   ├── Site/              # 7 public pages (Home, Projects, Stack…)
│   │   ├── Filament/          # AccountSecurity (2FA)
│   │   └── Actions/           # Logout
│   ├── Models/                # 22 models (domain + system tables)
│   ├── Providers/             # App, Fortify + Filament\AdminPanel
│   └── Http/                  # Controllers
│
├── config/                    # fortify, permission, auth, services…
├── database/
│   ├── factories/             # 7 factories
│   ├── migrations/            # 16 migrations
│   └── seeders/               # DatabaseSeeder + PortfolioSeeder
│
├── resources/
│   ├── css/                   # app.css (design system) + filament.css (admin)
│   ├── views/                 # Public/admin/auth layouts + Livewire pages
│   │   ├── pages/public/      # home, projects, skills, stack, contact, cv-show
│   │   └── filament/          # widgets + security page
│   └── js/
│
├── routes/
│   ├── web.php                # Public routes + PDF export
│   ├── settings.php           # Profile & Appearance
│   └── console.php
│
├── tests/                     # Pest: public, admin, auth, domain tests
│
├── Dockerfile                 # Multi-stage image (Vite build + PHP 8.4 runtime)
├── docker/entrypoint.sh       # Migrations, storage:link, caches, serve on $PORT
├── .dockerignore
└── vite.config.js             # Vite + Tailwind (app.css/filament.css inputs)
```

---

## 🗃️ Data model

| Entity | Role |
|---|---|
| `Project` | Central unit — stack, infra, skills, categories, images |
| `Stack` → `StackItem` | Named technical collection, broken down into categorized items |
| `Skill` | Catalog of expertise with levels & icons |
| `Infra` | Infrastructure profiles (Docker, K8s, Helm, resources) |
| `Category` | Polymorphic classification (Projects & Skills) |
| `Cv` | Resume versions (draft / published, 3 templates, JSON content) |
| `ContactMessage` | Contact requests (read / unread, budget) |
| `User` | Account with 2FA, implements `FilamentUser` |

### Key relationships

```mermaid
erDiagram
    USER ||--o{ PROJECT : owns
    STACK ||--o{ STACK_ITEM : contains
    STACK ||--o{ PROJECT : deployed_via
    INFRA ||--o{ PROJECT : runs_on
    PROJECT ||--o{ PROJECT_SKILL : has
    PROJECT ||--o{ SKILL : has_many_through(project_skill)
    PROJECT ||--o{ PROJECT_IMAGE : has
    CATEGORY ||--o{ CATEGORIZABLE : polymorphic
    PROJECT ||--o{ CATEGORIZABLE : categorized_as
    SKILL ||--o{ CATEGORIZABLE : categorized_as
```

---

## 🚀 Installation

### Prerequisites
- **PHP** ^8.4
- **Composer** 2.x
- **Node.js** 18+ & npm
- **PostgreSQL** 14+ (or SQLite for a server-free dev setup)

### Quick start

```bash
git clone https://github.com/sena/sena-studio.git
cd sena-studio
composer setup
```

`composer setup` chains together: `composer install`, `.env` creation, `key:generate`, migrations, `npm install` and `npm run build`.

### Manually

```bash
composer install
```

> **Windows:** `copy .env.example .env` (instead of `cp`).

```bash
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
```

### Database

The project is configured for **PostgreSQL** by default (`.env.example` ready for Railway).
Create a `sena_studio` database and adjust your `.env`:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sena_studio
DB_USERNAME=sena
DB_PASSWORD=secret
```

> **Local SQLite alternative**: `DB_CONNECTION=sqlite` works out of the box
> (no server required).

---

## ▶️ Development

The project ships with a concurrent dev server (color-coded per process):

```bash
composer dev
```

| Process | Command |
|---|---|
| **HTTP server** | `php artisan serve` |
| **Queue** | `php artisan queue:listen --tries=1` |
| **Logs (Pail)** | `php artisan pail` |
| **Assets** | `npm run dev` |

Or individually:

```bash
php artisan serve        # http://localhost:8000
npm run dev              # Vite hot reload
php artisan queue:listen # Background jobs
php artisan pail         # Real-time logs
```

---

## 🔑 Access & credentials

The seeder creates an **admin** account:

| Role | Email | Password |
|---|---|---|
| **Admin** | `senadalmeidapro@gmail.com` | `Sena-Studio@2026` (⚠️ to be changed) |

### Entry points

| Route | Description |
|---|---|
| `/` | Public homepage (Livewire) |
| `/projets` · `/projets/{slug}` | Public portfolio + detail filtered by type |
| `/competences` | Active skills grouped by level |
| `/stack` | Active stacks by category |
| `/contact` | Public contact form |
| `/cv/{cv:slug}` | Public resume (rendered per template) |
| `/admin` | **Filament admin** (login protected) |
| `/admin/cvs/{cv}/pdf` | Resume PDF export (auth + verified) |
| `/settings/profile` · `/settings/appearance` | Flux settings (post-login) |

---

## ☁️ Deployment — Railway

The repo ships with a **multi-stage Dockerfile**: the image builds Vite assets at build time,
then starts `php artisan serve` on port `$PORT` with automatic migrations,
storage links and application caches.

### 1. Create the project on Railway

```bash
railway init
railway link
```

### 2. Provision PostgreSQL

In the Railway dashboard: **Create → Database → PostgreSQL**. Then reference its
`DATABASE_URL` (auto-generated) in the service variables.

### 3. Environment variables

| Variable | Recommended value | Role |
|---|---|---|
| `APP_KEY` | `base64:…` *(recommended: `php artisan key:generate --show`)* | Encryption key; otherwise generated ephemerally at startup (sessions invalidated on every restart) |
| `APP_ENV` | `production` | Environment |
| `APP_DEBUG` | `false` | Never in production |
| `APP_URL` | `https://<your-app>.up.railway.app` | Canonical URL (HTTPS via trusted proxies) |
| `DB_URL` | `${DATABASE_URL}` | PostgreSQL connection string injected by Railway |
| `DB_CONNECTION` | `pgsql` | PostgreSQL driver |
| `DB_SSLMODE` | `require` | Railway requires SSL |
| `LOG_CHANNEL` | `stderr` | Logs visible in Railway |
| `SESSION_SECURE_COOKIE` | `true` | Secure cookies over HTTPS |
| `DB_SEED` | `true` *(1st deployment)* | Seeds admin user + portfolio |
| `APP_MIGRATE` | `true` *(default)* | Automatic migrations on startup |

> The server waits for the database (up to `DB_RETRIES=30` attempts) before applying migrations.
> The `/up` health route is exposed for health checks.

### 4. Push and deploy

```bash
git add . && git commit -m "deploy: railway + postgres"
git push
```

Railway detects the `Dockerfile` and rebuilds on every push.

### File storage

Project images shipped in `public/` are included in the container. Backoffice **uploads**
go into `storage/app/public` (ephemeral volume by default) — remember to attach a
**persistent volume** at `/app/storage` to keep uploaded images.

---

## 🧬 Filament architecture

- **10 resources**: `Projects`, `Stacks`, `Skills`, `Categories`, `Infras`, `Cvs`, `Messages › ContactMessages`, `Users`, `Roles`, `Permissions`
- **Resource → Form/Schema → Table → Pages (Create/Edit/List)** breakdown for maximum maintainability
- `SkillsRelationManager` relation manager on projects (proficiency in pivot)
- `Security` page (2FA) in the "Account" group, custom 12-column `Dashboard` widget

---

## 🎨 Design system

- **Colors** — blue accent (`#2563eb`), `ink` (slate) neutrals, `emerald` reserved for success states (availability, `production` status, submission confirmation)
- **Surfaces** — `canvas / surface / card / elevated / soft / line` tokens defined as CSS vars, exposed to Tailwind via `@theme inline`, with a 4-level dark mode
- **Typography** — `Instrument Sans` (text), `Space Grotesk` (headings), `JetBrains Mono` (technical labels)
- **Semantic badges** — project statuses colored by state (production → green, testing → amber, development → blue, cancelled → gray)
- **`filament.css`** — injected into the admin panel via `FilamentView::registerRenderHook` (HEAD_START)

---

## ✔️ Quality & tests

**Pest** test suite (SQLite `:memory:`, `RefreshDatabase`) — covers public pages, admin (smoke), auth (login, 2FA, email, passwords, registration), settings, domain (projects, stacks) and PDF export.

```bash
composer lint        # Fix style (Pint)
composer lint:check  # Check style only
composer test        # config:clear + lint:check + tests
composer ci:check     # Full CI pipeline
```

Targeted pipelines:
```bash
php artisan test
php artisan test --filter=PublicSiteTest
```

---

## 🌍 Production hardening

- **Strict password policy** in production: `min 12`, mixed case, letters, digits, symbols, `uncompromised`
- **Destructive commands blocked** (`DB::prohibitDestructiveCommands`) in production
- Global **CarbonImmutable**
- **Fortify rate limiting**: 5 requests/minute on login and 2FA
- **2FA** available for accounts
- Chained services: Pail + queue worker under `composer dev`

---

## 🤝 Contributing

1. *Fork* the repository
2. Create your branch (`git checkout -b feature/amazing-feature`)
3. Commit (`git commit -m 'feat: add amazing feature'`)
4. Push (`git push origin feature/amazing-feature`)
5. Run `composer lint` and `composer test` before opening a PR
6. Open a Pull Request

---

## 📄 License

Released under the [MIT license](LICENSE).

---

<div align="center">

**Designed with ❤️ by [Sena Gedeon D'ALMEIDA](mailto:senadalmeidapro@gmail.com)**

</div>
