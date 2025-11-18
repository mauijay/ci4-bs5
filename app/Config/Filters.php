<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\OnlineCheckFilter;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * The filter $aliases that Shield provides are automatically added for you by the Registrar class located at src/Config/Registrar.php. So you don't need to add in * your app/Config/Filters.php.
     *
     *  'session'     => SessionAuth::class,
     *  'tokens'      => TokenAuth::class,
     *  'hmac'        => HmacAuth::class,
     *  'chain'       => ChainAuth::class,
     *  'auth-rates'  => AuthRates::class,
     *  'group'       => GroupFilter::class,
     *  'permission'  => PermissionFilter::class,
     *  'force-reset' => ForcePasswordResetFilter::class,
     *  'jwt'         => JWTAuth::class,
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'onlinefilter'  => OnlineCheckFilter::class,
        // CodeIgniter Shield filters
        // 'session'       => \CodeIgniter\Shield\Filters\SessionAuth::class,
        // 'token'         => \CodeIgniter\Shield\Filters\TokenAuth::class,
        // 'chain'         => \CodeIgniter\Shield\Filters\ChainAuth::class,
        // 'group'         => \CodeIgniter\Shield\Filters\GroupFilter::class,
        // 'permission'    => \CodeIgniter\Shield\Filters\PermissionFilter::class,
    ];

    /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array{
     *     before: array<string, array{except: list<string>|string}>|list<string>,
     *     after: array<string, array{except: list<string>|string}>|list<string>
     * }
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
            // Allow access to auth, API, and assets while site is offline
            'onlinefilter' => [
                'except' => [
                    'site-offline',
                    'login*',
                    'register*',
                    'auth/*',
                    'assets/*',
                    'api/*',
                ],
            ],
            // Require login only on specific routes via route filters
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'POST' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     *
     * @var array<string, list<string>>
     */
    public array $methods = [
      'POST' => ['invalidchars', 'csrf'],
      'GET'  => ['cors'],
    ];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [
                // Rate limit auth endpoints
                'auth-rates' => ['before' => ['login*', 'register', 'auth/*']],
                // Rely on route-specific filters for admin (group:admin), account (session), and API (token)
        ];
}
