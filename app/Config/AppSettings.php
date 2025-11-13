<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppSettings extends BaseConfig
{
    // General
    public string $siteName = 'My CI4 App';
    public bool $maintenanceMode = false;

    // Themes
    public string $theme = 'light';
    public array $availableThemes = ['light', 'dark'];

    // Auth controls
    public bool $adminRegistrationOnly = false;

    // User preferences
    public bool $allowUserThemePreference = true;
}
