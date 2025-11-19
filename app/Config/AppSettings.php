<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppSettings extends BaseConfig
{
    // General
    public string $siteName = 'My CI4 BS5 App';
    public bool $maintenanceMode = false;
    /**
   * --------------------------------------------------------------------------
   * Site Online?
   * --------------------------------------------------------------------------
   *
   * When false, only superadmins and user groups with permission will be
   * able to view the site. All others will see the "System Offline" page.
   */
    public bool $siteOnline = true;  //or false
  /**
   * --------------------------------------------------------------------------
   * Site Offline View
   * --------------------------------------------------------------------------
   *
   * The view file that is displayed when the site is offline.
   */
    public $siteOfflineView = 'Views/errors/html/offline.php';

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
