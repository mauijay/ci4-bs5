<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $usersModel = new UserModel();

        // Eager load all identities so meta doesn't cause N queries
        $users = $usersModel->withIdentities()->findAll();

        return view('admin/users/index', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }
}
