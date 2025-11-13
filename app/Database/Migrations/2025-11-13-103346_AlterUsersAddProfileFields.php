<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersAddProfileFields extends Migration
{
    public function up(): void
    {
        $fields = [
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'last_active',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'full_name',
            ],
            'theme' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'phone',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down(): void
    {
        $this->forge->dropColumn('users', ['full_name', 'phone', 'theme']);
    }
}
