<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Models\UserModel;

class PromoteFirstUserToAdmin extends Seeder
{
    public function run(): void
    {
        $users = new UserModel();
        $user  = $users->orderBy('id', 'asc')->first();

        if ($user === null) {
            echo "No users found. Register a user first.\n";
            return;
        }

        if (! $user->inGroup('admin')) {
            $user->addGroup('admin');
            echo "User ID {$user->id} promoted to 'admin'.\n";
        } else {
            echo "User ID {$user->id} is already in 'admin' group.\n";
        }
    }
}
