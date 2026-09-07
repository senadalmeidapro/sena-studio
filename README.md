<div align="center">

# 🎨 Sena Studio

### Freelance Command Center & Public Portfolio Platform

> Backoffice de gestion freelance sur mesure + site public élégant, construits sur **Laravel 13**, **Filament v5**, **Livewire 4** et **Flux 2** — pour piloter projets, stacks techniques, compétences, infrastructure, CV et demandes de contact depuis une seule interface.

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Filament](https://img.shields.io/badge/Filament-v5-FCB66D?logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMiIgaGVpZ2h0PSIzMiI+PHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iMTAiIGZpbGw9IiMwNDExMjciLz48Y2lyY2xlIGN4PSIxMSIgY3k9IjExIiByPSI2IiBmaWxsPSIjZmM2NmJkIi8+PGNpcmNsZSBjeD0iMjEiIGN5PSIyMSIgcj0iNiIgZmlsbD0iI2ZjNjZiZCIvPjwvc3ZnPg==)](https://filamentphp.com)
[![Livewire](https://img.shields.io/badge/Livewire-v4-EB4B4B?logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Flux](https://img.shields.io/badge/Flux-v2-0A3EAE)](https://fluxui.dev)
[![Tailwind](https://img.shields.io/badge/Tailwind-v4-38BDF8?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-4cc61e.svg)](LICENSE)

**Auteur :** Sena Gedeon D'ALMEIDA — [email](mailto:senadalmeidapro@gmail.com)

</div>

---

## 📖 Vue d'ensemble

**Sena Studio** réunit deux expériences complémentaires sur une seule base de code :

- **Un backoffice Filament complet** (« command center ») pour gérer — en quelques clics — les projets, les stacks techniques, les compétences, l'infrastructure, les CV et les demandes de contact.
- **Un site public moderne et accessible** (Livewire + Flux), qui diffuse automatiquement le contenu géré dans l'admin : accueil, portfolio filtrable, compétences, stack technique, formulaire de contact et CV téléchargeable en PDF.

Le tout est habillé d'un **design system bleu premium** (Tailwind CSS v4) avec mode sombre hiérarchisé et micro-interactions soignées.

---

## ✨ Fonctionnalités

### 🗂️ Gestion de projets
- Métadonnées riches : **statut** (`development` / `testing` / `production` / `cancelled`), **type** (`web` / `app` / `software`), **complexité** et **visibilité** (`public` / `protected` / `private`)
- Liens vers une **stack**, une **infrastructure** et des **compétences** (avec niveau de maîtrise `primary` / `secondary` / `research` en pivot)
- Classification dans des **catégories polymorphiques**, prix, version, dates, URL et dépôt
- **Galerie d'images** (`ProjectImage`) avec ordre de tri, triée depuis un repeater Filament
- Suppression douce (`SoftDeletes`) et filtrage avancé

### 🧩 Stacks techniques
- Stacks nommées et réutilisables, décomposées en **StackItems** catégorisés : `frontend`, `backend`, `database`, `cache`, `queue`, `orm`, `storage`, `cloud`, `monitoring`, `analytics`, `devops`, `design`, `testing`, `documentation`, `others`
- Chaque item : valeur, version et **icône** (SimpleIcons / icône de site)
- Édition inline + activation/désactivation d'une stack

### 🛠️ Compétences
- Niveaux de maîtrise : `beginner` → `intermediate` → `advanced` → `expert`
- Icônes visuelles, toggles d'activation et catégorisation polymorphique partagée
- Page publique groupée par niveau

### ☁️ Infrastructure comme donnée
- Docker, Kubernetes et Helm enregistrés par profil infra
- Allocations : **CPU (cœurs)**, **mémoire (Mo)**, **stockage (Go)**
- Environnement : `development` / `staging` / `production`

### 📄 CV versionné
- Modèles de rendu : **Classique**, **Moderne**, **Minimal** — chaque version a sa couleur d'accent
- Statuts **Brouillon** / **Publié**, version **principale** mise en avant
- Contenu structuré (expériences, formations, compétences, langues, certifications, centres d'intérêt) via repeaters
- **Export PDF** (dompdf) depuis l'admin, page publique dédiée et aperçu du brouillon
- Slug auto-généré lors de l'enregistrement

### ✉️ Messages de contact
- Formulaire public (Livewire) avec validation, budgets prédéfinis et envoi d'email
- Inbox admin : message brut lu/non lu, `markAsRead` automatique à la consultation
- Widget « Messages non lus » sur le tableau de bord

### 📊 Tableau de bord Filament
- **6 stats** de vue d'ensemble (utilisateurs, projets, production, messages non lus, compétences, stacks/infra)
- **Graphiques** : projets par statut (donut), projets par stack (barres), compétences par catégorie (barres)
- Widgets opérationnels : projets récents, **messages non lus**, **projets sans média**, actions rapides
- Vue santé **Infrastructure** (infras actives/inactives, production, CPU/RAM/Stockage provisionnés)

### 🔐 Authentification & sécurité
- **Fortify** : inscription, réinitialisation de mot de passe, **vérification d'email** et **2FA** (avec confirmation)
- Vues d'authentification personnalisées en **Livewire/Flux**
- Pages `appearance` et `profile` Flux, page « Sécurité du compte » dans Filament
- **RBAC Spatie** : tables `permissions` / `roles` et ressources Filament `Roles` & `Permissions` fournies
- `User` implémente `FilamentUser` (accès admin)

### 🎨 Design system (bleu premium)
- Palette accent **bleu `#2563eb`**, neutres slate, vert sémantique (succès/disponibilité)
- **Tokens de surface** (`canvas`, `surface`, `card`, `elevated`, `soft`, `line`) en CSS variables — Light & Dark (4 niveaux de surfaces en sombre)
- Ombres (`soft` / `card` / `lifted` / `panel`), rayons cohérents, typographie **Instrument Sans + Space Grotesk + JetBrains Mono**
- `filament.css` dédié pour harmoniser l'admin Filament avec le site public

---

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| **Runtime** | PHP ^8.4 |
| **Framework** | Laravel ^13.0 |
| **Admin Panel** | Filament ^5.6 |
| **Frontend** | Livewire ^4.1 · Flux ^2.13 · Alpine.js · Tailwind CSS ^4 · Vite ^8 |
| **Base de données** | PostgreSQL (défaut & Railway) · SQLite en dev rapide |
| **Auth** | Fortify · Sanctum |
| **Billing** | Cashier (Stripe) |
| **RBAC** | Spatie Permission |
| **Médias** | Spatie MediaLibrary |
| **PDF** | barryvdh/laravel-dompdf |
| **Testing** | Pest ^4 |

---

## 🏗️ Structure du projet

```
sena-studio/
│
├── app/
│   ├── Actions/               # Fortify (CreateNewUser, ResetUserPassword)
│   ├── Concerns/              # Règles de validation (Password & Profile)
│   ├── Enums/                 # 11 enums typés (Projet, Skill, Stack, Infra, CV…)
│   ├── Filament/
│   │   ├── Pages/             # Dashboard (9 widgets) + Sécurité du compte
│   │   ├── Resources/         # 10 ressources (Schemas/ + Tables/ + Pages/)
│   │   │   └── Projects/RelationManagers/
│   │   └── Widgets/           # 9 widgets (stats, chartes, opérationnels)
│   ├── Livewire/
│   │   ├── Site/              # 7 pages publiques (Home, Projects, Stack…)
│   │   ├── Filament/          # AccountSecurity (2FA)
│   │   └── Actions/           # Logout
│   ├── Models/                # 22 modèles (domaine + tables système)
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
│   ├── views/                 # Layouts public/admin/auth + pages Livewire
│   │   ├── pages/public/      # home, projects, skills, stack, contact, cv-show
│   │   └── filament/          # widgets + page security
│   └── js/
│
├── routes/
│   ├── web.php                # Routes publiques + export PDF
│   ├── settings.php           # Profile & Appearance
│   └── console.php
│
├── tests/                     # Pest : tests publics, admin, auth, domaine
│
├── Dockerfile                 # Image multi-stage (build Vite + runtime PHP 8.4)
├── docker/entrypoint.sh       # Migrations, storage:link, caches, serve sur $PORT
├── .dockerignore
└── vite.config.js             # Vite + Tailwind (inputs app.css/filament.css)
```

---

## 🗃️ Modèle de données

| Entité | Rôle |
|---|---|
| `Project` | Unité centrale — stack, infra, compétences, catégories, images |
| `Stack` → `StackItem` | Collection technique nommée, décomposée en items catégorisés |
| `Skill` | Catalogue d'expertises avec niveaux & icônes |
| `Infra` | Profils d'infrastructure (Docker, K8s, Helm, ressources) |
| `Category` | Classification polymorphique (Projets & Compétences) |
| `Cv` | Versions de CV (brouillon / publié, 3 templates, contenus JSON) |
| `ContactMessage` | Demandes de contact (lu / non lu, budget) |
| `User` | Compte avec 2FA, implémente `FilamentUser` |

### Relations clés

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

### Prérequis
- **PHP** ^8.4
- **Composer** 2.x
- **Node.js** 18+ & npm
- **PostgreSQL** 14+ (ou SQLite pour un dev sans serveur)

### Démarrage rapide

```bash
git clone https://github.com/sena/sena-studio.git
cd sena-studio
composer setup
```

`composer setup` enchaîne : `composer install`, création de `.env`, `key:generate`, migrations, `npm install` et `npm run build`.

### Manuellement

```bash
composer install
```

> **Windows :** `copy .env.example .env` (au lieu de `cp`).

```bash
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
```

### Base de données

Le projet est configuré pour **PostgreSQL** par défaut (`.env.example` prêt pour Railway).
Créez une base `sena_studio` et ajustez votre `.env` :

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sena_studio
DB_USERNAME=sena
DB_PASSWORD=secret
```

> **Alternative locale SQLite** : `DB_CONNECTION=sqlite` fonctionne tel quel
> (aucun serveur requis).

---

## ▶️ Développement

Le projet embarque un serveur dev concurrent (code couleur par process) :

```bash
composer dev
```

| Process | Commande |
|---|---|
| **Serveur HTTP** | `php artisan serve` |
| **Queue** | `php artisan queue:listen --tries=1` |
| **Logs (Pail)** | `php artisan pail` |
| **Assets** | `npm run dev` |

Ou individuellement :

```bash
php artisan serve        # http://localhost:8000
npm run dev              # Hot reload Vite
php artisan queue:listen # Jobs en arrière-plan
php artisan pail         # Logs en temps réel
```

---

## 🔑 Accès & identifiants

Le seeder crée un **administrateur** :

| Rôle | Email | Mot de passe |
|---|---|---|
| **Admin** | `senadalmeidapro@gmail.com` | `Sena-Studio@2026` (⚠️ à changer) |

### Points d'entrée

| Route | Description |
|---|---|
| `/` | Page d'accueil publique (Livewire) |
| `/projets` · `/projets/{slug}` | Portfolio public + détail filtré par type |
| `/competences` | Compétences actives groupées par niveau |
| `/stack` | Stacks actives par catégorie |
| `/contact` | Formulaire de contact public |
| `/cv/{cv:slug}` | CV public (rendu selon le template) |
| `/admin` | **Filament admin** (login protégé) |
| `/admin/cvs/{cv}/pdf` | Export PDF du CV (auth + vérifié) |
| `/settings/profile` · `/settings/appearance` | Réglages Flux (post-connexion) |

---

## ☁️ Déploiement — Railway

Le repo embarque un **Dockerfile multi-stage** : l'image construit les assets Vite au build,
puis démarre `php artisan serve` sur le port `$PORT` avec migrations automatiques,
liens de stockage et caches applicatifs.

### 1. Créer le projet sur Railway

```bash
railway init
railway link
```

### 2. Provisionner PostgreSQL

Dans le dashboard Railway : **Create → Database → PostgreSQL**. Puis référencer sa
`DATABASE_URL` (générée automatiquement) dans les variables du service.

### 3. Variables d'environnement

| Variable | Valeur conseillée | Rôle |
|---|---|---|
| `APP_KEY` | *(auto-générée au démarrage si absente)* | Clé de chiffrement Laravel |
| `APP_ENV` | `production` | Environnement |
| `APP_DEBUG` | `false` | Jamais en production |
| `APP_URL` | `https://<votre-app>.up.railway.app` | URL canonique (HTTPS via proxies approuvés) |
| `DB_URL` | `${DATABASE_URL}` | Chaîne de connexion PostgreSQL injectée par Railway |
| `DB_CONNECTION` | `pgsql` | Driver PostgreSQL |
| `DB_SSLMODE` | `require` | Railway exige SSL |
| `LOG_CHANNEL` | `stderr` | Logs visibles dans Railway |
| `SESSION_SECURE_COOKIE` | `true` | Cookies sécurisés sur HTTPs |
| `DB_SEED` | `true` *(1er déploiement)* | Seede utilisateur admin + portfolio |
| `APP_MIGRATE` | `true` *(défaut)* | Migrations automatiques au démarrage |

> Le serveur attend la base (jusqu'à `DB_RETRIES=30` tentatives) avant d'appliquer les migrations.
> La route de santé `/up` est exposée pour les health-checks.

### 4. Pousser et déployer

```bash
git add . && git commit -m "deploy: railway + postgres"
git push
```

Railway détecte le `Dockerfile` et reconstruit à chaque push.

### Stockage de fichiers

Les images projet shipées dans `public/` sont incluses dans le conteneur. Les **uploads**
du backoffice partent dans `storage/app/public` (volume éphémère par défaut) — pensez à
brancher un **volume persistant** sur `/app/storage` pour conserver les images téléversées.

---

## 🧬 Architecture Filament

- **10 ressources** : `Projects`, `Stacks`, `Skills`, `Categories`, `Infras`, `Cvs`, `Messages › ContactMessages`, `Users`, `Roles`, `Permissions`
- Décomposition **Resource → Form/Schema → Table → Pages (Create/Edit/List)** pour une maintenabilité maximale
- Relation manager `SkillsRelationManager` sur les projets (proficiency en pivot)
- Page `Security` (2FA) dans le groupe « Compte », widget `Dashboard` sur mesure à 12 colonnes

---

## 🎨 Design system

- **Couleurs** — accent bleu (`#2563eb`), neutres `ink` (slate), `emerald` réservé aux états de succès (disponibilité, statut `production`, confirmation d'envoi)
- **Surfaces** — tokens `canvas / surface / card / elevated / soft / line` définis en CSS vars, exposés à Tailwind via `@theme inline`, avec mode sombre en 4 niveaux
- **Typographie** — `Instrument Sans` (texte), `Space Grotesk` (titres), `JetBrains Mono` (labels techniques)
- **Badges sémantiques** — statuts de projet colorés par état (production → vert, test → ambre, développement → bleu, annulé → gris)
- **`filament.css`** — injecté dans le panneau admin via `FilamentView::registerRenderHook` (HEAD_START)

---

## ✔️ Qualité & tests

Suite **Pest** (SQLite `:memory:`, `RefreshDatabase`) — couvre les pages publiques, l'admin (smoke), l'auth (connexion, 2FA, email, mots de passe, inscription), les réglages, le domaine (projets, stacks) et l'export PDF.

```bash
composer lint        # Corrige le style (Pint)
composer lint:check  # Vérifie le style uniquement
composer test        # config:clear + lint:check + tests
composer ci:check    # Pipeline CI complet
```

Pipelines ciblés :
```bash
php artisan test
php artisan test --filter=PublicSiteTest
```

---

## 🌍 Durcissement production

- **Politique de mot de passe stricte** en production : `min 12`, casse mixte, lettres, chiffres, symboles, `uncompromised`
- **Commandes destructrices bloquées** (`DB::prohibitDestructiveCommands`) en production
- **CarbonImmutable** global
- **Rate limiting Fortify** : 5 requêtes/minute sur login et 2FA
- **2FA** disponible pour les comptes
- Les services chaînés : Pail + queue worker sous `composer dev`

---

## 🤝 Contribuer

1. *Fork* le dépôt
2. Créez votre branche (`git checkout -b feature/amazing-feature`)
3. Committez (`git commit -m 'feat: add amazing feature'`)
4. Poussez (`git push origin feature/amazing-feature`)
5. Passez `composer lint` et `composer test` avant d'ouvrir une PR
6. Ouvrez une Pull Request

---

## 📄 Licence

Publié sous la [licence MIT](LICENSE).

---

<div align="center">

**Conçu avec ❤️ par [Sena Gedeon D'ALMEIDA](mailto:senadalmeidapro@gmail.com)**

</div>