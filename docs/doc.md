CodeIgniter 4.6.3 + Shield 1.2 + Settings 2.2.0
Global App Settings + User Preferences + Admin UI Module

You can paste this directly into a docs/doc.md file in your project.

📘 Application Settings Architecture (CI4.6.3 + Shield + Settings v2.2.0)

This document describes how to implement:

Global site settings stored in the database

A settings UI in the admin panel

Cached settings service

Per-user preferences using Shield meta

Theme override logic

Proper Settings v2.2.0 setup (modern CI4 approach)

🚀 1. Requirements

This guide assumes:

CodeIgniter Framework: 4.6.3

CodeIgniter Shield: 1.2.0

CodeIgniter Settings: 2.2.0

Working admin panel under /admin

Bootstrap 5 layout (optional but recommended)

🛠 2. Install & Enable Settings v2.2.0

If not installed:

```bash
composer require codeigniter4/settings
```


Then run:

```bash
php spark publish
php spark migrate
```


This creates the settings database table and publishes vendor assets.

🧩 3. Define Global Application Settings

Settings are stored in a config class, but their values are stored in the database.

app/Config/AppSettings.php

```php
<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class AppSettings extends BaseConfig
{
    public string $siteName = 'My CI4 App';
    public bool   $maintenanceMode = false;

    public string $theme = 'light';
    public array  $availableThemes = ['light', 'dark'];

    public bool $adminRegistrationOnly = false;

    public bool $allowUserThemePreference = true;
}
```

📝 4. Register Settings with CI4 Settings

Settings 2.x requires registration via:

app/Config/Settings.php

```php
<?php

namespace Config;

use CodeIgniter\Settings\Settings as BaseSettings;
use App\Config\AppSettings;

class Settings extends BaseSettings
{
    public $registered = [
        AppSettings::class,
    ];
}
```


This tells CI Settings that AppSettings can persist into the database.

## ⚡ 5. Cached Settings Service

To avoid constant database lookups, use a simple service layer.

app/Libraries/AppSettingsService.php

```php
<?php

namespace App\Libraries;

use App\Config\AppSettings;

class AppSettingsService
{
    protected static ?AppSettings $cache = null;

    public static function get(): AppSettings
    {
        if (self::$cache === null) {
            $settings = setting('AppSettings') ?? config('AppSettings');
            self::$cache = $settings;
        }

        return self::$cache;
    }

    public static function refresh(): void
    {
        self::$cache = null;
    }

    public static function value(string $key, $default = null)
    {
        $settings = self::get();
        return $settings->{$key} ?? $default;
    }
}
```

## 🧰 6. Helper (Optional)

app/Helpers/app_settings_helper.php

```php
<?php

use App\Libraries\AppSettingsService;

function app_settings(): App\Config\AppSettings
{
    return AppSettingsService::get();
}
```


Enable in:

app/Config/Autoload.php

```php

public $helpers = ['app_settings'];
```

## 🛠 7. Admin Settings Module

7.1 Routes

Add inside your admin group:

```php

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('settings', 'Settings::index');
    $routes->post('settings', 'Settings::update');
});
```

### 7.2 Controller

app/Controllers/Admin/Settings.php

```php

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\AppSettingsService;

class Settings extends BaseController
{
    public function index()
    {
        return view('admin/settings/index', [
            'settings' => app_settings(),
        ]);
    }

    public function update()
    {
        $data = $this->request->getPost([
            'siteName',
            'theme',
        ]);

        $newSettings = [
            'siteName'  => $data['siteName'] ?? 'My CI4 App',
            'theme'     => $data['theme'] ?? 'light',
            'maintenanceMode'         => $this->request->getPost('maintenanceMode') !== null,
            'adminRegistrationOnly'   => $this->request->getPost('adminRegistrationOnly') !== null,
            'allowUserThemePreference'=> $this->request->getPost('allowUserThemePreference') !== null,
        ];

        setting()->set('AppSettings', $newSettings)->save();

        AppSettingsService::refresh();

        return redirect()->back()->with('message', 'Settings updated.');
    }
}
```

### 7.3 Settings View (Bootstrap 5)

app/Views/admin/settings/index.php

```php
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Site Settings</h1>

<?php if (session('message')): ?>
    <div class="alert alert-success"><?= esc(session('message')) ?></div>
<?php endif; ?>

<form action="<?= site_url('admin/settings') ?>" method="post" class="row g-3">
    <?= csrf_field() ?>

    <div class="col-md-6">
        <label class="form-label">Site Name</label>
        <input type="text" name="siteName"
               value="<?= esc($settings->siteName) ?>"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Default Theme</label>
        <select name="theme" class="form-select">
            <?php foreach ($settings->availableThemes as $theme): ?>
                <option value="<?= $theme ?>" <?= $settings->theme === $theme ? 'selected' : '' ?>>
                    <?= ucfirst($theme) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input" type="checkbox"
               name="allowUserThemePreference"
               <?= $settings->allowUserThemePreference ? 'checked' : '' ?>>
        <label class="form-check-label">Allow User Theme Preference</label>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input" type="checkbox"
               name="maintenanceMode"
               <?= $settings->maintenanceMode ? 'checked' : '' ?>>
        <label class="form-check-label">Maintenance Mode</label>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input" type="checkbox"
               name="adminRegistrationOnly"
               <?= $settings->adminRegistrationOnly ? 'checked' : '' ?>>
        <label class="form-check-label">Admin Registration Only</label>
    </div>

    <div class="col-12 mt-3">
        <button class="btn btn-primary">Save</button>
    </div>
</form>

<?= $this->endSection() ?>

```

## 👤 8. Per-User Preferences using Shield Meta

Store user setting:

```php

auth()->user()->setMeta('theme', 'dark')->save();
```

Read user setting:

```php

$theme = auth()->user()->getMeta('theme');
```

## 🌗 9. Theme Resolution Priority

Final theme selection logic:

1. Admin disables user override → use global theme

2. User override allowed → use user theme

3. Fallback → global theme

Example:

```php

$s = app_settings();

if (!$s->allowUserThemePreference) {
    return $s->theme;
}

$user = auth()->user();

return $user
    ? ($user->getMeta('theme') ?? $s->theme)
    : $s->theme;

```

## 🎉 10. Result

With this system you now have:

✔ Global app settings stored in DB

✔ Editable admin UI

✔ Cached settings service

✔ User-specific theme preferences

✔ Proper modern Settings v2.2.0 usage

✔ Fully compatible with CI4.6.3 + Shield 1.2