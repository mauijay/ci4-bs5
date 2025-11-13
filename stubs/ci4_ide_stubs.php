<?php
/**
 * IDE-only stubs for CodeIgniter 4 global helpers to satisfy static analyzers.
 * Not loaded by the app at runtime.
 */

if (!function_exists('view')) {
    /**
     * @param string $name
     * @param array<string,mixed> $data
     * @param array<string,mixed> $options
     */
    function view(string $name, array $data = [], array $options = []): string { return ''; }
}

if (!function_exists('service')) {
    /**
     * @param string $name
     * @return mixed
     */
    function service(string $name) {}
}

if (!function_exists('lang')) {
    /**
     * @param string $line
     * @param array<string,mixed> $args
     */
    function lang(string $line, array $args = []): string { return ''; }
}

if (!function_exists('config')) {
    /**
     * @param string $class
     * @return mixed
     */
    function config(string $class) {}
}

if (!function_exists('setting')) {
    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    function setting(string $key, $value = null) {}
}

if (!function_exists('redirect')) {
    /**
     * @return mixed
     */
    function redirect() {}
}
