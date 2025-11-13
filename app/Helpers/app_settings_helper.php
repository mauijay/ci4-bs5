<?php

use App\Libraries\AppSettingsService;

function app_settings(): Config\AppSettings
{
    return AppSettingsService::get();
}
