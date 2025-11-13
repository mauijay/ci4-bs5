<?php

namespace App\Libraries;

use Config\AppSettings;

class AppSettingsService
{
    protected static ?AppSettings $cache = null;

    public static function get(): AppSettings
    {
        if (self::$cache === null) {
            // Start with defaults from config
            $config = config('AppSettings');

            // Overlay persisted values per property using dot syntax
            try {
                $settingsService = setting(); // returns Settings manager
                foreach (array_keys(get_object_vars($config)) as $prop) {
                    $value = $settingsService->get('AppSettings.' . $prop);
                    if ($value !== null) {
                        $config->{$prop} = $value;
                    }
                }
            } catch (\Throwable $e) {
                // In testing or early bootstrap when settings tables may not exist,
                // silently fall back to config defaults.
            }

            self::$cache = $config;
        }

        return self::$cache;
    }

    public static function refresh(): void
    {
        self::$cache = null;
    }

    public static function value(string $key, $default = null)
    {
        try {
            $settingsService = setting();
            $value = $settingsService->get('AppSettings.' . $key);
            if ($value !== null) {
                return $value;
            }
        } catch (\Throwable $e) {
            // If settings backend is unavailable (e.g., during tests), fall back to config
        }

        $config = config('AppSettings');
        return $config->{$key} ?? $default;
    }
}
