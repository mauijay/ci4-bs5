<?php

namespace Config;

class Security extends \Config\Security
{
    /**
     * Disable CSRF in testing environment.
     */
    public bool $csrfProtection = false;
}
