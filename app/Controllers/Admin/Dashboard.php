<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
      //$user = auth()->user();
      //$user->addPermission('app.viewOffline');
      //$user->addGroup('superadmin');

      return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
        ]);
    }
}
