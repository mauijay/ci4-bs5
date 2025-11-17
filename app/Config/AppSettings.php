<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppSettings extends BaseConfig
{
    // General
    public string $siteName = 'My CI4 BS5 App';
    public bool $maintenanceMode = false;

    // Contact
    public string $supportEmail = 'support@example.com';

    // Themes
    public string $theme = 'light';
    public array $availableThemes = ['light', 'dark'];

    // Auth controls
    public bool $adminRegistrationOnly = false;

    // Localization
    public string $defaultLocale = 'en';
    public array $availableLocales = ['en', 'es'];

    // User preferences
    public bool $allowUserThemePreference = true;
}
