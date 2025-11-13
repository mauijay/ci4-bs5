<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Users;
use App\Controllers\Admin\Settings as AdminSettings;
use App\Controllers\Account\Settings as AccountSettings;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', [Home::class, 'index'], ['as' => 'home.index']);

// Use all default routes EXCEPT login/register (static-analysis friendly)
$__authService = \call_user_func('service', 'auth');
if ($__authService) {
    $__authService->routes($routes, ['except' => ['login', 'register']]);
}

// Custom auth routes (class-based + named)
$routes->get('register', [RegisterController::class, 'registerView'], ['as' => 'auth.register.new']);
$routes->post('register', [RegisterController::class, 'registerAction'], ['as' => 'auth.register.store']);

$routes->get('login', [LoginController::class, 'loginView'], ['as' => 'auth.login.new']);
$routes->post('login', [LoginController::class, 'loginAction'], ['as' => 'auth.login.submit']);

// Admin group – protected with Shield admin group filter
$routes->group('admin', ['filter' => 'group:admin'], static function ($routes): void {
    $routes->get('/', [Dashboard::class, 'index'], ['as' => 'admin.dashboard.index']);
    $routes->get('users', [Users::class, 'index'], ['as' => 'admin.users.index']);
    $routes->get('settings', [AdminSettings::class, 'index'], ['as' => 'admin.settings.index']);
    $routes->post('settings', [AdminSettings::class, 'update'], ['as' => 'admin.settings.update']);
});

// Account group – session-protected
$routes->group('account', ['filter' => 'session'], static function ($routes): void {
    $routes->get('settings', [AccountSettings::class, 'index'], ['as' => 'account.settings.index']);
    $routes->post('settings', [AccountSettings::class, 'update'], ['as' => 'account.settings.update']);
});
