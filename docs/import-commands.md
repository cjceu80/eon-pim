# Import commands

Run these from the project root. Paths below use the container path `/var/www/html/…` (works with the default Docker Compose setup in this repo).

```bash
docker compose exec php bin/console <command> <arguments> [options]
```

- **Dry-run** (default for most commands): omit `--apply` to validate only.
- **Persist**: add `--apply` when you are ready to write to Pimcore.

---

## Data imports (YAML / JSON)

| Command | Purpose | Typical plan file |
| --- | --- | --- |
| `app:race:import` | Race categories and race templates for a rule set | `docs/plans/import-races-v1.yaml` |
| `app:skill:import` | Skill groups and skills | `docs/plans/import-skills-v1.yaml` |
| `app:profession:import` | Professions (`raceRestriction` / `raceIds`, sub-professions, brick fields; `professionSkills` / `otherSkills` resolve **Skill** or **SkillGroup** by `externalId`) | `docs/plans/import-professions-v1.yaml` |
| `app:rule:import` | Rule templates (single envelope or array of envelopes) | `docs/plans/import-rules-v1.yaml` |
| `app:roll-table:import` | Roll table templates | Your roll-table YAML under `docs/plans/` (e.g. background tables) |

**Examples**

```bash
docker compose exec php bin/console app:race:import /var/www/html/docs/plans/import-races-v1.yaml
docker compose exec php bin/console app:skill:import /var/www/html/docs/plans/import-skills-v1.yaml --apply
docker compose exec php bin/console app:profession:import /var/www/html/docs/plans/import-professions-v1.yaml --apply
docker compose exec php bin/console app:rule:import /var/www/html/docs/plans/import-rules-v1.yaml --apply
docker compose exec php bin/console app:roll-table:import /var/www/html/docs/plans/<your-roll-table>.yaml --apply
```

---

## Rule set helpers (not full document imports)

| Command | Purpose |
| --- | --- |
| `app:ruleset:import` | Import RuleSetTemplate baseline from YAML/JSON. Options: `--apply`, `--resolve-table-refs`. |
| `app:ruleset:init` | Create or update a RuleSetTemplate root by `externalId` (many optional `--` flags for baseline metadata). |
| `app:ruleset:resolve-table-refs` | Resolve deferred baseline table references to object relations. Optional `externalId` argument; use `--apply` to persist. |

**Examples**

```bash
docker compose exec php bin/console app:ruleset:import /var/www/html/docs/plans/<ruleset-file>.yaml
docker compose exec php bin/console app:ruleset:import /var/www/html/docs/plans/<ruleset-file>.yaml --apply --resolve-table-refs
docker compose exec php bin/console app:ruleset:init EON --apply
docker compose exec php bin/console app:ruleset:resolve-table-refs EON --apply
```

---

## Discover commands locally

```bash
docker compose exec php bin/console list app:
```

Lists every command whose name starts with `app:` (including imports and other utilities).
