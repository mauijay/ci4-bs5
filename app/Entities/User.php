<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected $casts = [
        'full_name' => 'string',
        'phone'     => 'string',
        'theme'     => 'string',
    ];
}
