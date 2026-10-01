# Color migration audit and mapping

## Theme mechanism

The public site and Flux forms use Flux's existing `@fluxAppearance` integration. The navbar changes `window.Flux.appearance` among `light`, `system`, and `dark`; Flux applies/persists the `dark` class, while `system` follows the operating-system preference. Reuse the existing `.dark` selector and Flux appearance state. Filament's panel uses its built-in light/dark appearance control and the same `dark` class. No second theme mechanism is needed.

## Existing color sources (PDFs excluded)

- `resources/css/app.css`: Tailwind 4 `@theme` defines the old zinc, ink, blue, emerald, lime, and fuchsia palettes; it also defines canvas/surface/card/line aliases, dark overrides, focus styles, links, buttons, callouts, code/prose styles, and technical illustrations with literal colors.
- `resources/css/filament.css`: Filament gray variables style the panel canvas, sidebar labels, and widget section headings.
- Tailwind configuration is in `resources/css/app.css` (`@theme`, `@theme inline`); there is no separate Tailwind config file.
- `app/Providers/Filament/AdminPanelProvider.php`: Filament primary is `#2563eb`, with Rose, Sky, Emerald, Amber, and Slate semantic palettes.
- Public and shared browser views with color classes: `resources/views/errors/404.blade.php`; `resources/views/layouts/public.blade.php`; `resources/views/layouts/auth/simple.blade.php`; `resources/views/components/{app-logo,app-logo-icon,logo,project-media,site-footer,site-navbar}.blade.php`; `resources/views/components/front/{arrow-link,section-heading}.blade.php`; `resources/views/pages/auth/*.blade.php`; `resources/views/pages/public/{about,blog/index,blog/show,contact,cv-show,data-handling,home,process,project-detail,projects,services,skills}.blade.php`; and `resources/views/pages/public/cv-show/_engineering.blade.php`.
- App-owned Flux overrides: `resources/views/flux/navlist/group.blade.php` uses zinc and white variants. The Flux icon overrides use `currentColor`/`fill="none"` and contain no fixed color values.
- App-owned Filament view colors: `resources/views/filament/messages/reply-draft.blade.php`, `resources/views/filament/pages/reports.blade.php`, and `resources/views/filament/widgets/{active-engagements-and-overdue-invoices-widget,new-leads-widget,projects-missing-media-widget}.blade.php`. The widgets' inline styles use Filament gray variables; other inline styles in `resources/views/filament/tables/columns/site-icon.blade.php` are layout-only.
- No Livewire PHP component returns a hardcoded color class. The project filter's selected-state classes are in `resources/views/pages/public/projects.blade.php`.
- SVGs in browser views primarily use `currentColor`; logo SVG colors come from their surrounding text utilities. Preserve `fill="none"`, `stroke="currentColor"`, and other geometry/paint semantics while moving foreground colors to tokens.

## Shared web/PDF partials

No Blade partial is shared between a browser page and a PDF. `resources/views/pdf/cv.blade.php` includes only the PDF-specific `resources/views/pdf/cv-engineering.blade.php`. The public CV uses its separate `resources/views/pages/public/cv-show/_engineering.blade.php` partial. Keep the PDF templates, generation code, and styles untouched.

## Mapping

| Existing class/value | New token utility/value | Use |
| --- | --- | --- |
| `bg-canvas`, `--canvas` | `bg-bg`, `var(--bg)` | Browser page background |
| `bg-card`, `bg-white` on a card/form | `bg-surface` | Cards, fields, modal/panel surfaces |
| `bg-ink-100`, `bg-ink-200`, `bg-ink-50`, `bg-blue-50*` used as a section | `bg-surface-muted` | Alternate section or neutral muted fill |
| `border-ink-*`, `border-blue-*` on neutral structure | `border-border` | Dividers, inputs, cards |
| `text-ink-900/800/700`, `text-gray-*`, `text-zinc-*` primary text | `text-text` | Body and heading text |
| `text-ink-600/500/400`, `text-gray-*`, `text-zinc-*` secondary text | `text-text-muted` | Supporting and metadata text |
| `blue-*` primary action backgrounds | `bg-accent` | Primary actions and selected controls |
| `hover:bg-blue-700`, `hover:bg-blue-600` on primary actions | `hover:bg-accent-hover` | Primary action hover |
| `text-blue-*` links | `text-accent hover:text-accent-hover` | Links and interactive text |
| `blue-*` status/availability badge fill | `bg-accent-soft text-accent` | Availability and selected/filter badges only |
| `focus:ring-blue-*`, blue outlines | `focus-visible:ring-accent` / token-backed focus rule | Visible focus state |
| `emerald-*`, `green-*` success states | `text-success`, `bg-success` as appropriate | Success feedback |
| `amber-*`, `yellow-*` warning states | `text-warning`, `bg-warning` as appropriate | Warning feedback |
| `red-*`, `rose-*` validation/error states | `text-danger`, `bg-danger` as appropriate | Validation and error feedback |
| `white` text on an action | `text-on-accent` | Text on accent fills |
| `black`/white logo foreground | `text-on-accent` or `text-text` according to its existing container | Logo contrast, without fixed black/white |
| CSS `#hex`, named colors, or old semantic aliases | Corresponding `var(--...)` token | App CSS only; do not place token references in PDF views |
| `dark:*` color variants that duplicate a semantic token | Remove the color variant | Keep `dark:` only for a true non-color difference |

### Intentional exceptions

- Filament-owned neutral grays and its default success/info/warning/danger treatment remain owned by Filament. The requested panel primary color is set through Filament's color API; do not impose the public-site palette on unrelated Filament internals.
- `currentColor`, `fill="none"`, and `stroke="currentColor"` are SVG drawing instructions, not hardcoded palette colors.
- CSS hex literals that define the requested tokens themselves are intentional. No color literals or `var(--...)` token references are allowed in PDF files.
