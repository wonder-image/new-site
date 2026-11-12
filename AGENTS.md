# AGENTS.md

<!-- Single source of truth for every AI agent (Claude Code, Codex, Cursor, ...).
     Identical in wonder-image/new-site and in the boilerplates derived from it
     (ecommerce-site, immobili-site, rsvp-site): change it in new-site first,
     then copy it. Site-specific context goes in docs/ai/PRODUCT.md, not here. -->

## Project overview

This repo is a **Wonder site**: the scaffold `wonder-image/new-site` or a
boilerplate/project derived from it. It is not the framework and not the lib.

- **framework** — `wonder-image/app`, installed by Composer under `vendor/wonder-image/app`.
- **lib** — `wonder-image` JS/CSS design system, installed by npm and copied to
  `assets/lib/wonder-image/dist/` by the `postinstall` script.
- **modules** — optional Composer packages `wonder-image/<slug>` (ecommerce,
  customer-account, gestionale, ...) enabled in `custom/config/modules.php`.

Brand, `site_type`, target users and voice of this specific site:
[`docs/ai/PRODUCT.md`](docs/ai/PRODUCT.md). Read it before any task that
touches copy, pages or UI.

## Before you start: preflight

Before writing code, answer in 3–5 lines:

1. **Understood** — what will change, which files and which area
   (`custom/`, `app/`, `lang/`, `assets/`, CI).
2. **Missing** — what the request does not say. Ask only if the answer changes
   the implementation; otherwise state the assumption and continue.
3. **Needed?** — say so when the change is unnecessary or already exists:
   a framework component, a module, a lib class, a backend setting the client
   can change without code. Prefer configuration over code.
4. **Better prompt** — when the request was ambiguous, propose a rewritten
   version the user can reuse next time.

For a small, unambiguous request, one line is enough and you proceed
without waiting.

## Stop and ask before

- editing anything under `vendor/`, `node_modules/`, `assets/lib/` (upstream:
  the change belongs in `wonder-image/app` or `wonder-image/lib`);
- touching `.github/workflows/`, `.htaccess`, `custom/config/permissions.php`,
  `custom/config/access.php`, `custom/config/modules.php`, `composer.json`;
- adding a Composer/npm dependency or upgrading one (`composer update`,
  `npm install <pkg>`);
- deleting files, DB tables or columns, or rewriting git history;
- running anything that writes secrets, provisions infrastructure or reaches
  production (see Forbidden commands).

## Forbidden commands

Never run these: they write secrets, create remote resources or deploy.
They are for the developer, by hand.

- `php forge provision`, `php forge credentials`, `php forge db:init`,
  `php forge build`, `php forge config`, `php forge cloudflare:*`
- `git push` to `main` (deploys to production via `.github/workflows/deploy.yml`),
  `git push --force`
- reading or printing `.env`

`composer install` / `composer update` run `php forge config` through the
Composer scripts: in an agent session use `composer install --no-scripts`.

## Directory structure

- `custom/` — everything project-specific
  - `custom/config/` — `config.php`, `lang.php` (active languages),
    `navigation.php`, `permissions.php`, optional `access.php`, `modules.php`
  - `custom/routes/` — `route.frontend.php`, `route.api.php`
  - `custom/view/pages/{frontend,backend}/` — one file per page, rendered with
    `\Wonder\View\View::layout(...)` (see `custom/view/pages/frontend/home.php`)
  - `custom/view/layout/frontend/` — page layouts (`main`, `minimal`, `auth`)
  - `custom/view/components/{frontend,backend}/{layout,ui,sections,overlay}/`
    — component overrides, called with `\Wonder\View\View::component(...)`
  - `custom/function/function.php` — project helpers
- `app/` — PSR-4 `App\` classes: `Models/`, `Resources/`, support classes
- `lang/{locale}/*.json` — translations; the file name is the first key segment
  (`lang/it/pages.json` → `__t('pages....')`)
- `assets/{ASSETS_VERSION}/` — site CSS/JS/images (`ASSETS_VERSION` from `.env`,
  default `0.0`: do not assume it, read it)
- `tests/` — plain PHP tests, `php tests/<Name>Test.php` (see Validation)
- `docs/ai/` — AI context: `PRODUCT.md` (committed), `DESIGN.md` (generated,
  gitignored), `reports/` (gitignored). Never deployed.

## Coding conventions

- **Tables**: a site Model in `app/Models/` with `Model::tableSchema()` (SQL) and
  `Model::dataSchema()` (data treatment). `custom/build/table/` is a legacy
  path still loaded by the framework: do not add new files there.
- **Backend forms**: a Resource in `app/Resources/` with `formSchema()`,
  `permissionSchema()`, `navigationSchema()`. Repeatable rows:
  `FormField::...->repeater([...])` with `RepeaterColumn`.
- **Text**: every user-facing string goes through `__t('file.path.key')` with
  the entry in `lang/{default locale}/*.json`. Never hardcode copy in PHP.
- **Languages**: the active languages are those declared in
  `custom/config/lang.php`. With one language (`setLang('it')`) only
  `lang/it/` must be complete; other folders in `lang/` are seeds. With
  several (`addLanguage(...)`), every active language must have the same keys.
- **URLs**: `__r('route.name', [...])` (named route, preferred); `__u('path')`
  only when no named route exists. Never hardcode language prefixes.
- **Escaping**: visitor data is escaped with `e()` in hand-written HTML and
  in emails; hand-written POST forms carry the CSRF token.
- **Legal pages** render `LegalDocument::make(...)`: the DB is the source,
  `lang/*/legal.json` is only the seed.

## CSS / design system

- **Use the lib, do not extend it.** Look for an existing lib class or
  component before writing CSS; no new prefix-based naming (`.wi-*` or
  similar), no parallel CSS system, no hardcoded colors.
- **Design tokens** (colors, fonts, inputs, modals, ...) live in the database
  and are edited in the backend (Set-up → CSS). `php forge update --local`
  regenerates `assets/{ASSETS_VERSION}/css/set-up/root.css`, `color.css` and
  `docs/ai/DESIGN.md` from them. Those three files are generated and
  gitignored: read them, never edit them.
- Custom site CSS/JS: `assets/{ASSETS_VERSION}/css/` and `js/`, one file per
  concern, never inside `set-up/`.

## AI skills

Install the Wonder skills once per machine (not versioned in this repo):

```bash
npx skills add wonder-image/skills --skill '*'
```

`wi-site` covers work in this repo, `wi-app` the framework API it points to,
`wi-review` the review before a pull request, `wi-testing` the tests in
`tests/`. `wi-sync` (run by hand) realigns a boilerplate or site with
`wonder-image/new-site`. External design skills are installed on demand by
`wi-site` with `--global`.

## Validation (definition of done)

A task is done only when all of these pass locally:

```bash
composer install --no-scripts        # only if vendor/ is missing
php -l <every touched PHP file>
composer dump-autoload               # if classes were added, moved or renamed
for t in tests/*Test.php; do php "$t" || break; done   # if tests/ exists
php .github/scripts/check-lang.php   # translations (needs vendor/)
```

The same checks run in CI (`.github/workflows/ci.yml`) on every pull request
and before every deploy. A behavior that must not break gets a test in
`tests/`: plain PHP files `tests/<Name>Test.php` that exit non-zero on
failure. If the repo has no `tests/` yet, start from the `tests/bootstrap.php`
of `wonder-image/ecommerce-site` (Composer autoload and pure helpers, no DB).

For runtime changes (DB schema, routes, Forge-generated files) the developer
runs `php forge update --local` and `php forge start`: say so in the report.

## Final report

End every task with:

- files changed (paths) and why;
- checks run and their result — never claim a check you did not run;
- what the developer still has to do (Forge commands, backend settings,
  translations for other active languages);
- anything that belongs upstream (`wonder-image/app`, `wonder-image/lib`).

## Generated files — do not edit

- `vendor/`, `node_modules/`, `assets/lib/wonder-image/`
- `assets/{ASSETS_VERSION}/css/set-up/root.css`, `color.css`, `docs/ai/DESIGN.md`
- `handler/index.php`, `.htaccess`, `robots.txt`, `bin/scheduler.php`
- `shared/sitemap/*`, `assets/upload/**`, `assets/temp/*`

## New project startup (developer only)

Use the complete domain with dots replaced by hyphens as the project folder:
`wonderimage.it` becomes `wonderimage-it`.

```bash
NOME_PROGETTO="wonderimage-it"
composer create-project wonder-image/new-site:dev-main "$NOME_PROGETTO"
cd "$NOME_PROGETTO"
composer update
git init
git remote add origin "https://github.com/wonder-image/${NOME_PROGETTO}.git"
php forge provision
php forge db:init
php forge update --local
php forge start
```

Then `git add . && git commit -m "Initial commit" && git push -u origin HEAD`
and GitHub Desktop → Add → Add existing repository. Set `origin` before
`provision` so it creates the repo under the `wonder-image` organization.
`APP_DOMAIN=wonderimage.it` is distinct from the local `APP_URL`
(e.g. `https://wonderimage.test` with Herd). Full guide in `README.md`.
This section documents the human workflow: it does not authorize an agent to
run these commands.

## Repo-specific gotchas

- `composer.json` requires `wonder-image/app` as `dev-main`: the framework
  changes without a tag. If something breaks after `composer update`, check
  the framework commit log before patching the site.
- The legacy globals (`$ROOT`, `$ROOT_APP`, `$PATH`, `$SEO`, `$SOCIETY`, `$DB`,
  `$DEFAULT`) come from `vendor/wonder-image/app/wonder-image.php` via
  `extract()`: they are invisible to static analysis.
- `assets/0.0/` is the cache-busting version folder: do not rename it.
- Deploy: push to `main` → CI → FTP. `docs/**`, `*.md`, `tests/**`,
  `.claude/**` are excluded from the upload.
