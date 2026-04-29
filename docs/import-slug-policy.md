# Import Slug Policy

Use this policy for every import-managed object class.

## Goals

- Keep paths deterministic and stable across repeated imports.
- Avoid accidental object renames when display names change.
- Resolve collisions predictably.

## Rules

1. Use `externalId` as the canonical import identity.
2. Build object `key` from `externalId`, not from `name`.
3. Set `key` only on create. Do not rename on update unless explicitly requested.
4. If the generated key already exists in the same parent, append suffixes: `-2`, `-3`, ...
5. Keep user-facing text in `name` (or localized fields), not in `key`.

## Recommended field pattern

- `externalId` (string, required, unique per class or per source+class)
- `name` (string, display label)
- `source` (optional string when IDs can overlap across providers)

## Upsert flow

1. Look up by `externalId` (and `source` when used).
2. If found, update mutable fields and keep existing key.
3. If missing, create object with slug key derived from `externalId`.
4. Save and log summary counts (created, updated, skipped, failed).

## Implementation note

`App\Service\ImportSlugPolicy` provides reusable helpers:

- `createKeyFromLabel()`
- `createStableKeyFromExternalId()`
- `ensureUniqueKeyInParent()`
