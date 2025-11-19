<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Admin\Dashboard;
use App\Controllers\Admin\Users;
use App\Controllers\Admin\Profile as AdminProfile;
use App\Controllers\Admin\Settings as AdminSettings;
use App\Controllers\Account\Settings as AccountSettings;
use App\Controllers\Api\V1\Health;
use App\Controllers\Admin\BlogController;
use App\Controllers\BlogsController;
use App\Controllers\CategoriesController;
use App\Controllers\TagsController;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', [Home::class, 'index'], ['as' => 'home.index']);

// Blog, categories and tags
$routes->get('blogs',                     [BlogsController::class, 'index'], ['as' => 'blog.index']);
$routes->get('blogs/(:segment)',          [BlogsController::class, 'show'], ['as' => 'blog.show']);
$routes->get('blog/categories',           [CategoriesController::class, 'index'], ['as' => 'blog.categories.index']);
$routes->get('blog/category/(:segment)',  [CategoriesController::class, 'show'], ['as' => 'blog.categories.show']);
$routes->get('blog/tags',                 [TagsController::class, 'index'], ['as' => 'blog.tags.index']);
$routes->get('blog/tag/(:segment)',       [TagsController::class, 'show'], ['as' => 'blog.tags.show']);

// Site offline route (used by OnlineCheckFilter exceptions)
$routes->get('site-offline', static function (): string {
    return view('errors/html/offline');
}, ['as' => 'site.offline']);

// Use all default routes EXCEPT login/register (standard CI4 helper)
service('auth')->routes($routes, ['except' => ['login', 'register']]);

// Custom auth routes (class-based + named)
$routes->get('register',  [RegisterController::class, 'registerView'], ['as' => 'auth.register.new']);
$routes->post('register', [RegisterController::class, 'registerAction'], ['as' => 'auth.register.store']);

$routes->get('login',   [LoginController::class, 'loginView'], ['as' => 'login']);
$routes->post('login',  [LoginController::class, 'loginAction'], ['as' => 'auth.login.submit']);

// Admin group – protected with Shield admin group filter
$routes->group('admin', ['filter' => 'permission:admin.access'], static function ($routes): void {
    $routes->get('/',                     [Dashboard::class, 'index'], ['as' => 'admin.dashboard.index']);
    $routes->get('users',                 [Users::class, 'index'], ['as' => 'admin.users.index']);
    $routes->get('profile',               [AdminProfile::class, 'index'], ['as' => 'admin.profile.index']);
    $routes->get('settings',              [AdminSettings::class, 'index'], ['as' => 'admin.settings.index']);
    $routes->post('settings',             [AdminSettings::class, 'update'], ['as' => 'admin.settings.update']);
    $routes->post('settings/site-online', [AdminSettings::class, 'siteOnline'], ['as' => 'admin.settings.siteOnline']);

    // Blog Admin
    $routes->get('blogs',                 [BlogController::class, 'index'],  ['as' => 'admin.blogs.index']);
    $routes->get('blogs/new',             [BlogController::class, 'create'], ['as' => 'admin.blogs.create']);
    $routes->post('blogs',                [BlogController::class, 'store'],  ['as' => 'admin.blogs.store']);
    $routes->get('blogs/(:num)',          [BlogController::class, 'edit'],   ['as' => 'admin.blogs.edit']);
    $routes->post('blogs/(:num)',         [BlogController::class, 'update'], ['as' => 'admin.blogs.update']);
    $routes->post('blogs/(:num)/delete',  [BlogController::class, 'delete'], ['as' => 'admin.blogs.delete']);
});

// Account group – session-protected
$routes->group('account', ['filter' => 'session'], static function ($routes): void {
    $routes->get('settings',  [AccountSettings::class, 'index'], ['as' => 'account.settings.index']);
    $routes->post('settings', [AccountSettings::class, 'update'], ['as' => 'account.settings.update']);
});

// API v1 group – protected with Shield token filter (dot-named routes)
$routes->group('api/v1', ['filter' => 'token'], static function ($routes): void {
    $routes->get('health', [Health::class, 'index'], ['as' => 'api.v1.health.index']);
});
