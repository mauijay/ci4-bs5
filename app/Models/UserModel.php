<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $returnType = \App\Entities\User::class;

    protected $allowedFields = [
        'username', 'status', 'status_message', 'active', 'last_active',
        // custom attributes
        'full_name', 'phone', 'theme', 'email', 'password',
    ];
}
