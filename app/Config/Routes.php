<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Use all default routes EXCEPT login/register
service('auth')->routes($routes, ['except' => ['login', 'register']]);

// Your custom auth controllers
$routes->get('register', '\App\Controllers\Auth\RegisterController::registerView');
$routes->post('register', '\App\Controllers\Auth\RegisterController::registerAction');

$routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');

// Admin group – protected with Shield session filter
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'group:admin'], static function ($routes): void {
    $routes->get('/', 'Dashboard::index');
    $routes->get('users', 'Users::index');
    $routes->get('settings', 'Settings::index');
    $routes->post('settings', 'Settings::update');
});

$routes->group('account', ['namespace' => 'App\Controllers\Account', 'filter' => 'session'], static function ($routes): void {
    $routes->get('settings', 'Settings::index');
    $routes->post('settings', 'Settings::update');
});
