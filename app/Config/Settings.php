<?php

namespace Config;

use CodeIgniter\Settings\Config\Settings as BaseSettings;
use Config\AppSettings;

class Settings extends BaseSettings
{
    public $registered = [
        AppSettings::class,
    ];
}
