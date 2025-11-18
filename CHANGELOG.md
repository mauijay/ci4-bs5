# Changelog

All notable changes to this project will be documented in this file.

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
