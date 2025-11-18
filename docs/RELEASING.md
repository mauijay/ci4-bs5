# Releasing & Labels

This repository uses `.github/release.yml` to auto-generate release notes grouped by labels.

## Labels

Recommended labels (also listed in `.github/labels.yml`):

- breaking-change, ui, ux, layout
- routes, auth, security, filters
- admin, settings, blog
- build, tooling, tests, test
- docs, documentation, dependencies, deps
- chore, maintenance, ci, wip, skip-changelog

Guidance:

- Prefer merging changes via PRs with one or more of the above labels.
- Use `breaking-change` for anything requiring user action.
- Use `skip-changelog` for internal or noisy changes that shouldn’t appear in release notes.

## Sync labels with GitHub CLI

From the repo root, create/update labels defined in `.github/labels.yml`:

```bash
# Authenticate once if needed
gh auth status

# Create or update labels from .github/labels.yml
jq -r '.labels[] | "\(.name)\t\(.color)\t\(.description)"' .github/labels.yml \
| while IFS=$'\t' read -r name color desc; do \
  gh label create "$name" --color "$color" --description "$desc" 2>/dev/null || \
  gh label edit "$name" --color "$color" --description "$desc"; \
  echo "Synced label: $name"; \
 done
```

## Draft a release

1. Push a tag (e.g., `vYYYY.MM.DD`).
2. In GitHub → Releases → Draft a new release → Select tag → Generate release notes.
3. Review categories and publish.
