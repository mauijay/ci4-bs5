Theme System Integration (Global + Per-User)
CI4 + Shield + Settings v2.2.0 + Bootstrap 5 SCSS

Save as:
docs/doc_theme_integration.md

🎨 Theme System Integration for CI4 + Shield + Settings v2.2.0

This document describes a complete theme architecture that supports:

Global default theme (e.g., light / dark)

Per-user preference (stored in Shield meta)

Bootstrap 5 SCSS pipeline via npm

Dynamic layout loading

Automatic theme fallback

Theme switching via admin settings

This system is fully compatible with:

CodeIgniter 4.6.3

Shield 1.2.0

CI Settings 2.2.0

Bootstrap 5.x (via SCSS build)

🧩 1. Folder Structure

Recommended structure:

public/
themes/
light/
css/style.css
dark/
css/style.css

resources/
themes/
light/
scss/style.scss
dark/
scss/style.scss

Your SCSS compiles into public/themes/....

🔧 2. NPM + SCSS Build Setup

Inside your project root:

2.1 Install tooling
npm init -y
npm install bootstrap sass --save-dev

2.2 Add SCSS build script

In package.json:

"scripts": {
"build": "sass resources/themes:public/themes --no-source-map --style=compressed",
"watch": "sass resources/themes:public/themes --watch --style=expanded"
}

2.3 Example SCSS file

resources/themes/light/scss/style.scss

@import "node_modules/bootstrap/scss/bootstrap";

$body-bg: #ffffff;
$body-color: #212529;

body {
background-color: $body-bg;
color: $body-color;
}

resources/themes/dark/scss/style.scss

@import "node_modules/bootstrap/scss/bootstrap";

$body-bg: #111;
$body-color: #ddd;

body {
background-color: $body-bg;
color: $body-color;
}

Build the CSS:
npm run build

⚙ 3. Global Theme Setting (AppSettings)

Your existing AppSettings already includes:

public string $theme = 'light';
public array $availableThemes = ['light', 'dark'];
public bool $allowUserThemePreference = true;

Themes are now fully pluggable.

👤 4. Per-User Theme Preference (via Shield Meta)

In Shield, every user supports:

setMeta('key', 'value')

getMeta('key')

To store user theme preference:

4.1 Save preference
$user = auth()->user();
$user->setMeta('theme', 'dark')->save();

4.2 Retrieve preference
$theme = $user->getMeta('theme');

4.3 Clear preference (fallback to global)
$user->setMeta('theme', null)->save();

🧠 5. Theme Resolver Service

This service decides the final theme:

User preference (if allowed)

Otherwise global theme

Fallback to "light"

Create:

app/Libraries/ThemeService.php

<?php

namespace App\Libraries;

use App\Libraries\AppSettingsService;

class ThemeService
{
    public static function current(): string
    {
        $settings = AppSettingsService::get();

        $theme = $settings->theme; // global default

        // User preference?
        if ($settings->allowUserThemePreference && auth()->loggedIn()) {
            $userTheme = auth()->user()->getMeta('theme');

            if ($userTheme && in_array($userTheme, $settings->availableThemes)) {
                $theme = $userTheme;
            }
        }

        return $theme ?: 'light';
    }

    public static function path(string $file): string
    {
        $theme = self::current();
        return base_url("themes/{$theme}/{$file}");
    }
}

🔌 6. Helper Function (Optional)

app/Helpers/theme_helper.php

<?php

use App\Libraries\ThemeService;

if (! function_exists('theme_url')) {
    function theme_url(string $file): string
    {
        return ThemeService::path($file);
    }
}


Register helper in Config/Autoload.php if desired.

🖼 7. Layout Integration

In app/Views/layouts/main.php:

<link rel="stylesheet" href="<?= theme_url('css/style.css') ?>">

This line automatically switches CSS files depending on:

Global theme

Per-user theme preference

🧭 8. Theme Switcher UI
8.1 Admin: Global Theme Setting

(Already in your Admin Settings panel)

8.2 User Account: Change Theme Preference

Create:

app/Controllers/Profile.php

<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    public function theme()
    {
        $themes = config('AppSettings')->availableThemes;

        return view('profile/theme', [
            'themes' => $themes,
            'current' => auth()->user()->getMeta('theme'),
        ]);
    }

    public function saveTheme()
    {
        $theme = $this->request->getPost('theme');

        $settings = config('AppSettings');

        if (! in_array($theme, $settings->availableThemes)) {
            return redirect()->back()->with('error', 'Invalid theme.');
        }

        auth()->user()->setMeta('theme', $theme)->save();

        return redirect()->back()->with('message', 'Theme updated.');
    }
}

8.3 Routes

Add to app/Config/Routes.php:

$routes->group('profile', ['filter' => 'session'], function ($routes) {
    $routes->get('theme', 'Profile::theme');
    $routes->post('theme', 'Profile::saveTheme');
});

8.4 View

app/Views/profile/theme.php

<h1>Theme Preferences</h1>

<form method="post">
    <?= csrf_field() ?>

    <select name="theme" class="form-select">
        <?php foreach ($themes as $theme): ?>
        <option value="<?= $theme ?>" <?= $theme === $current ? 'selected' : '' ?>>
            <?= ucfirst($theme) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-primary mt-3">Save</button>

</form>

🎛 9. Dashboard Banner (Optional)

Show current theme in the admin dashboard:

<p>Current theme: <strong><?= ThemeService::current() ?></strong></p>

🧪 10. Testing

1. Admin changes global theme

→ All users switch theme unless they have a preference.

2. User changes theme

→ Only that user changes; admin settings remain unaffected.

3. Theme resources not found

→ Fallback to light.

4. SCSS changes
   npm run build

5. Live watching
   npm run watch

🏁 Final Result

You now have a production-grade theme system with:

✔ Global theme control
✔ Per-user theme preferences
✔ Shield meta storage
✔ Centralized theme resolver
✔ SCSS → CSS compilation
✔ Automatic theme URL routing
✔ Admin + user control panels
✔ Bootstrap 5 SCSS support

This is the cleanest and most scalable way to manage themes inside a long-term CI4 application.

---

Sass Modules Migration (Dart Sass 3 Ready)

We migrated the project SCSS to Sass modules to be compatible with Dart Sass 3.

- Project modules: Components and utilities import project tokens via `@use "../abstracts" as *;`.
- Bootstrap integration: Root entry uses `@use "bootstrap/scss/bootstrap" with (...)` to pass overrides.
- No global tokens: We removed global `@import` of Bootstrap `functions/variables/maps/mixins`.
- Custom mixins: A lightweight `btn-variant` mixin was added to avoid Bootstrap's internal mixins.

Key files

- `src/scss/abstracts/_theme.scss`: Canonical theme tokens; now uses `@use "sass:color"` and `color.mix(...)`.
- `src/scss/abstracts/_mixins.scss`: Project mixins, including `respond()` and `btn-variant(...)`.
- `src/scss/style.scss`: Root entry; loads `abstracts` via `@use`, Bootstrap via `@use ... with (...)`, and project partials via `@use ... as *`.

New button mixin (project)

Use the project `btn-variant` mixin to create variants without Bootstrap internals:

        // In a component file
        @use "../abstracts" as *;

        .btn-brand {
            @include btn-variant($primary, $primary);
        }

Adding new components

1. Create `src/scss/components/_your-comp.scss`:

   @use "../abstracts" as \*;

   .your-comp { color: inherit; }

1. Register in `src/scss/style.scss`:

   @use "components/your-comp" as \*;

Notes and warnings

- Bootstrap’s own SCSS still uses some deprecated APIs; warnings may appear until Bootstrap updates.
- Avoid cross-module `@extend` (e.g., `.text-reset`); prefer explicit declarations like `color: inherit;`.
- Prefer `sass:color` functions (`color.mix`, `color.adjust`) over deprecated global `mix()`/`fade-out()`.
