# Changelog

All notable changes to this project will be documented in this file.

## v2025.11.19 — 2025-11-19

### 2025.11.19 Highlights

- Blog: Added SEO-friendly blog images with `images` table and `ImageService`.
- Blog: Implemented responsive `<picture>` sets and WebP via `optimize-images.sh`.
- SEO: Per-post meta, OpenGraph/Twitter cards, and JSON-LD for posts and index.

### 2025.11.19 Admin UX

- Admin: Blog CRUD now supports image upload, preview, and alt text.
- Admin: Added basic image manager for listing and editing image metadata.

### 2025.11.19 Developer Experience

- Images: Slug-based filenames under `public/uploads/images` with optimized variants.
- Config: `AppSettings` powers blog/index SEO titles, descriptions, and publisher logo.

### 2025.11.19 Upgrade Notes

- Run `./scripts/optimize-images.sh public/uploads/images` after adding new originals.
- Replace demo images/content as needed; blog now prefers `images` table over legacy fields.

## v2025.11.17 — 2025-11-17

### Highlights

- UI: Gate navbar "Site Online" switch behind `admin.access`.
- Layout: Restored full head meta; simplified conditionals; cached auth state.
- Auth: Named GET `/login` route as `login` for Shield redirects.
- Blog: Added blog index/show routes and views.
- Build: ESBuild JS bundle wired in layout.

### Security/Access

- Admin area protected via `permission:admin.access`.
- Offline mode: global online filter with safe exceptions; admin-only quick toggle.

### Admin UX

- Admin Profile page with groups and permissions.
- Admin Settings: "Site Online" toggle (settings page) + navbar quick toggle.
- Navbar: primary group badge next to avatar.

### Developer Experience

- Tests: Added CSRF token headers to login POSTs; suite green (11 tests, 18 assertions).
- Shield: Rely on Registrar-managed filter aliases (no manual alias clutter).
- Intelephense: Helper stubs/include paths added earlier in cycle.

### Changes Summary

- Routes: `login` route name (GET), `blog.index` / `blog.show` named routes.
- Views: `app/Views/layouts/main.php` restored meta; simplified conditionals; permission-gated switch.
- Tests: `tests/feature/AccessControlTest.php` includes `X-CSRF-TOKEN` header on POST `/login`.
- Build: ESBuild for JS; bundle included in layout.

### Upgrade Notes

- If you referenced the old `auth.login.new` for GET `/login`, switch to `route_to('login')`.
- Only users with `admin.access` will see the navbar “Site Online” switch.

### Verification

- Tests: 11 tests, 18 assertions — OK.
- Lint: clean (only unrelated doc warnings).
