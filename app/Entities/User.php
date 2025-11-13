<?php
/**
 * User entity (extends Shield User)
 *
 * @package    App
 * @category   Entities
 * @license    MIT
 * @link       https://github.com/mauijay/ci4-bs5
 */

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
