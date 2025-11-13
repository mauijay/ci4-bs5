Admin Roles, Permissions & Access Control (CI4 + Shield)
Full RBAC Implementation for Your Admin Panel

Save as:
docs/doc_admin_permissions.md

🔐 Admin Roles, Permissions & Access Control (CI4 + Shield 1.2.0)

This document explains how to implement real role-based access control (RBAC) for an admin panel using:

CodeIgniter 4.6.3

Shield 1.2.0

Settings v2.2.0

Shield provides extremely flexible permissions.
This guide organizes them cleanly for production use.

🎯 1. Overview

You will implement:

Roles
Role	Purpose
superadmin	Full system control
admin	Manages site settings & users
editor	Can view admin panel but limited actions
user	Standard member
Permissions

We define custom abilities such as:

admin.access
admin.users.manage
admin.settings.manage
admin.content.edit


Shield ships with ability support built-in — you just define & apply.

🧱 2. Creating Roles (Seeder)

Create seeder:

php spark make:seeder RolesSeeder


app/Database/Seeds/RolesSeeder.php

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $auth = auth();

        // Roles
        $auth->createRole('superadmin', 'Full system access');
        $auth->createRole('admin', 'Admin panel access');
        $auth->createRole('editor', 'Limited admin access');
        $auth->createRole('user', 'Regular user');

        // Permissions (Abilities)
        $permissions = [
            'admin.access',
            'admin.users.manage',
            'admin.settings.manage',
            'admin.content.edit',
        ];

        foreach ($permissions as $perm) {
            $auth->createPermission($perm);
        }

        // Assign permissions to roles
        $auth->addPermissionToRole('superadmin', '*'); // wildcard: full access
        $auth->addPermissionToRole('admin', [
            'admin.access',
            'admin.users.manage',
            'admin.settings.manage',
        ]);
        $auth->addPermissionToRole('editor', [
            'admin.access',
            'admin.content.edit',
        ]);
    }
}


Run it:

php spark db:seed RolesSeeder

🧍 3. Adding Users to Roles

Assign role:

$user->addRole('admin')->save();


Assign multiple:

$user->addRole(['editor', 'admin'])->save();


Remove role:

$user->removeRole('editor')->save();


Check:

if ($user->inGroup('admin')) { ... }

🛂 4. Checking Permissions in Controllers
Require admin access:
if (! auth()->user()->can('admin.access')) {
    return redirect()->to('/')->with('error', 'Unauthorized');
}

Require settings permission:
if (! auth()->user()->can('admin.settings.manage')) {
    return redirect()->back()->with('error', 'Unauthorized');
}

Require user management permission:
if (! auth()->user()->can('admin.users.manage')) {
    return redirect()->back()->with('error', 'Unauthorized');
}

🧰 5. Adding Permissions to Routes
In app/Config/Filters.php:

Add this alias:

'can' => \CodeIgniter\Shield\Filters\PermissionFilter::class,

In app/Config/Routes.php:
$routes->group('admin', ['filter' => 'can:admin.access'], function ($routes) {

    $routes->get('/', 'Admin\Dashboard::index');

    $routes->group('users', ['filter' => 'can:admin.users.manage'], function ($routes) {
        $routes->get('/', 'Admin\Users::index');
    });

    $routes->group('settings', ['filter' => 'can:admin.settings.manage'], function ($routes) {
        $routes->get('/', 'Admin\Settings::index');
        $routes->post('/', 'Admin\Settings::update');
    });
});


This keeps RBAC clean, centralized, and automatic.

🧰 6. Adding Admin Middleware (Optional Alternative)

Create a simple helper:

app/Filters/AdminFilter.php

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! auth()->loggedIn() || ! auth()->user()->can('admin.access')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}


Then register:

app/Config/Filters.php

public $aliases = [
    'admin' => \App\Filters\AdminFilter::class,
];


Use:

$routes->group('admin', ['filter' => 'admin'], function () {
    // admin routes...
});

📑 7. Admin Menu Visibility

Use permission checks in views:

<?php if (auth()->user()->can('admin.users.manage')): ?>
<li><a href="/admin/users">Users</a></li>
<?php endif; ?>


For settings:

<?php if (auth()->user()->can('admin.settings.manage')): ?>
<li><a href="/admin/settings">Settings</a></li>
<?php endif; ?>

🚫 8. Prevent Non-Admin Login to Admin Panel

Inside your admin Dashboard controller:

public function index()
{
    if (! auth()->user()->can('admin.access')) {
        return redirect()->to('/');
    }

    return view('admin/dashboard');
}

🦺 9. Superadmin Lockout Protection

Highly recommended:
Add a protection rule in AdminFilter:

if (auth()->user()->id === 1) {
    return; // full access for founder
}


Or enforce superadmin role:

if ($user->inGroup('superadmin')) {
    return;
}

🧩 10. Summary of Your RBAC System

With this system you now have:

✔ Full roles system (superadmin, admin, editor, user)
✔ Custom abilities
✔ Route-level protection
✔ Controller-level protection
✔ View-level protection
✔ Seeder for all roles & permissions
✔ Expandable security structure
✔ Future-proof authorization

This is a production-ready RBAC architecture for serious CI4 apps.