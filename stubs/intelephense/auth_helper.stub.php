<?php
// Dev-only stub for Intelephense to recognize the Shield auth() helper.
// Not autoloaded by the app; safe to keep in repo.

use CodeIgniter\Shield\Authentication\Authentication;
use CodeIgniter\Shield\Config\Services;

if (!function_exists('auth')) {
    /**
     * Returns the Shield Authentication service.
     *
     * @return Authentication
     */
    function auth(): Authentication
    {
        return Services::auth();
    }
}
