<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Config\Services as ShieldServices;

class Profile extends BaseController
{
    /**
     * Show current user's groups and permissions (admin-only route).
     */
    public function index(): string
    {
        $auth = ShieldServices::auth();
        $user = $auth->user();

        $groups = $user ? $user->getGroups() : [];
        $permissions = $user ? $user->getPermissions() : [];

        return view('admin/profile/index', [
            'title'       => 'My Admin Profile',
            'user'        => $user,
            'groups'      => $groups,
            'permissions' => $permissions,
        ]);
    }
}
