# AGENTS.md

## Project overview

`wonder-image/new-site` is a **consumer project** built on the `wonder-image/app` framework
(installed under `vendor/wonder-image/app`) and the `wonder-image` JS/CSS library
(installed under `node_modules/wonder-image`, copied to `assets/lib/wonder-image/dist/`
by the `postinstall` script).

This is **not** a framework or a library: it is the actual site. Most of the work
happens under `custom/`, `app/`, and `assets/`.

## Directory structure

- `custom/` — everything project-specific (the only folder a designer/dev should normally edit)
  - `custom/config/` — site config (`config.php`, `lang.php`, `permissions.php`)
  - `custom/build/table/` — one PHP file per DB table; loaded by glob from the framework
  - `custom/build/page/`, `custom/build/row/` — additional page/row schemas
  - `custom/function/function.php` — project-level helpers (currently empty)
  - `custom/routes/` — custom Symfony routes
  - `custom/view/components/` — project component overrides under `frontend/` and `backend/`
  - `custom/view/pages/` — project pages rendered through `View::layout(...)`
- `app/` — PSR-4 `App\\` classes (`Models/`, `Resources/`, services/support classes)
- `assets/` — public web assets
  - `assets/0.0/css/set-up/` — `root.css` (design tokens) + `color.css` (color utility classes, **generated**, gitignored)
  - `assets/0.0/{images,js,icons}/` — site assets
  - `assets/lib/wonder-image/dist/` — copied from npm by `npm install` postinstall (gitignored)
  - `assets/upload/` — runtime upload destination (gitignored except `.gitkeep`)
- `api/` — public API endpoints (`frontend/`, `backend/`, `task/`)
- `backend/` — backend admin pages (`form/`, `notices/popup/`, `notices/announcements/`)
- `lang/` — i18n JSON: `it/{pages,components,emails}.json`, `en/{...}`
- `legal/` — privacy/cookie/terms PHP entry points
- `contact/` — contact page entry point
- `handler/` — generated runtime entry; gitignored
- `shared/sitemap/` — generated runtime sitemap; gitignored

Top-level entry points: `index.php` (under-construction stub), `demo.php` (homepage).

## Setup commands

```bash
composer install         # also runs `php forge config` via post-install-cmd
npm install              # copies wonder-image dist into assets/lib/
php forge update --local # runs DB updates and regenerates configuration files
php forge start          # local server (defaults: 127.0.0.1:8088)
```

If `.env` values are missing, `forge start` fills `APP_URL`, `APP_KEY`, `DB_*`, `USER_PASSWORD` automatically.

## Coding conventions

- New PHP classes go under `app/` with namespace `App\\` (PSR-4).
- Project helpers go in `custom/function/function.php` (or new files alongside it).
- Renderable layout overrides go in `custom/view/components/frontend/layout/` and `custom/view/components/backend/layout/`.
- Prefer `\Wonder\View\View::component(...)` over manual `include` for components.
- DB table schemas: **one file per table** under `custom/build/table/`. Files are loaded by glob — do not centralize them in a single megafile.
- For backend forms / pages built on top of the framework, follow the framework conventions:
  - `Model::tableSchema()` = SQL structure
  - `Model::dataSchema()` = data treatment / prepare / upload
  - `Resource::formSchema()` = backend inputs
  - `FormInput::repeater()` for repeatable rows
- i18n: every user-facing string goes in `lang/{locale}/{pages,components,emails}.json` and is read via `__t("path.to.key")`. Never hardcode user-facing text in PHP.
- URLs: build with `__u('contact')` (locale-aware), never hardcode language prefixes.

## CSS / design system

- Design tokens (colors, fonts, spacing) live in `assets/0.0/css/set-up/root.css`.
- Color utility classes (`tx-primary`, `bg-secondary-50`, ...) live in `assets/0.0/css/set-up/color.css` — **generated, gitignored**. Do not hand-edit; regenerate from tokens.
- The CSS/JS framework (utility classes `.f-end`, `.col-3`, `.mh-10`, `.tx-upper`, ...) comes from `wonder-image` lib — see [lib/MANIFEST.json](../lib/MANIFEST.json) (in the lib repo) for the registry.
- Custom site styles: `assets/0.0/css/` (excluding `set-up/`), one file per concern.

## Component structure

Follow the framework component split:

- `custom/view/components/frontend/layout/`
- `custom/view/components/frontend/ui/`
- `custom/view/components/frontend/sections/`
- `custom/view/components/frontend/overlay/`
- `custom/view/components/backend/layout/`

Do not reintroduce `custom/utility/*`.

Target structure (when refactor lands):

```
custom/
├── view/
│   ├── components/
│   │   ├── frontend/
│   │   │   ├── layout/
│   │   │   ├── sections/
│   │   │   ├── ui/
│   │   │   └── overlay/
│   │   └── backend/
│   │       └── layout/
│   └── pages/           # one ~10-line file per page, via View::layout()
├── features/          # contact-form (handler), popup (data)
├── lib/page.php       # page factory
├── config/            # site, navigation, pages, lang, permissions
├── build/{tables,pages,rows}/
app/                   # App\\ classes
```

## AI skills (Claude Code / Cursor / Codex)

The repo uses **AI skills** managed via `npx skills` — prompt-driven
helpers invoked at *development time* by AI assistants (Claude Code,
Cursor, Codex, etc.) while you chat with them — for example to audit
UI, suggest copy, or refactor components.

Installed under `.agents/skills/<slug>/` (universal folder, symlinked
into `.claude/skills/` etc.). Both are gitignored: skills are managed
by their CLI and auto-updated.

Install / manage:

```bash
npx skills add pbakaus/impeccable     # UI design audit/craft skill
npx skills list
npx skills update                     # update all
npx skills remove <slug>
```

Each dev runs `npx skills add` once on their own laptop. The skill is
not versioned in this repo (intentional): updates flow through the
CLI, not through git.

## Validation before commit

```bash
php -l path/to/file.php
composer dump-autoload    # if classes added/moved
```

For runtime/integration changes (framework or DB schemas):
```bash
php forge update --local
php forge start
```

## Files / areas not to edit

- `vendor/` — Composer deps
- `node_modules/`, `assets/lib/wonder-image/` — npm artifacts, regenerated by `npm install`
- `assets/0.0/css/set-up/color.css`, `assets/0.0/css/set-up/root.css` — listed in `.gitignore`, generated by `php forge update`
- `assets/upload/**` — runtime user uploads
- `shared/sitemap/*` — generated by `vendor/wonder-image/app/vendor-static/xml-sitemaps/`
- `handler/index.php`, `.htaccess`, `robots.txt` — generated by Forge
- `INFO.md` — gitignored; see `INFO.example.md` template

## Repo-specific gotchas

- `composer.json` requires `wonder-image/app` as `dev-main` — the framework is consumed from a sibling repo, not from a tagged release.
- `npm install` runs a `postinstall` that copies `node_modules/wonder-image/dist` into `assets/lib/wonder-image/dist`. If you upgrade the lib, re-run `npm install`.
- Forge commands run from this repo, not from the framework repo.
- The `0.0/` versioning in `assets/` is intentional for cache-busting; do not rename without coordinating with the framework's path resolver.
- Two `composer.json` exist (this one + framework's); make sure you're editing the right one.
- Most legacy globals (`$ROOT`, `$ROOT_APP`, `$PATH`, `$SEO`, `$SOCIETY`, `$DB`, `$DEFAULT`) are made available by the framework's bootstrap (`vendor/wonder-image/app/wonder-image.php`) via `extract()`. They are not visible in static analysis. To know what's in scope on a given page, read `vendor/wonder-image/app/wonder-image.php` and the current frontend/backend layout components under `vendor/wonder-image/app/app/view/components/`.
