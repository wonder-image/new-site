# CLAUDE.md

@AGENTS.md

<!-- AGENTS.md is the single source of truth for every agent (Codex and Cursor
     read it directly). Keep here only what is specific to Claude Code. -->

## Claude Code

- Project permissions and hooks are in `.claude/settings.json` (committed):
  writes to `vendor/`, `node_modules/`, `assets/lib/` and generated files are
  denied, the Forge provisioning commands and the explicit forms of a push to
  `main` are denied, and every edited PHP file is checked with `php -l`
  automatically. These rules are a guard-rail, not a security boundary (other
  spellings of a command are not matched): the real gate is branch protection
  on `main` plus the CI checks. Follow `AGENTS.md` even where no rule stops
  you, and never work around a denied action: tell the user what you needed
  and why.
- Personal overrides go in `.claude/settings.local.json` (gitignored).
- Use the `wi-site` skill for work in this repo (`npx skills add wonder-image/skills --skill '*'`).
