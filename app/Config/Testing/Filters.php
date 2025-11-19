<?php

namespace Config;

class Filters extends \Config\Filters
{
    /**
     * Override HTTP method filters for testing to disable CSRF.
     * Keep other method filters intact/minimal.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [
        'POST' => ['invalidchars'],
        'GET'  => ['cors'],
    ];
}
