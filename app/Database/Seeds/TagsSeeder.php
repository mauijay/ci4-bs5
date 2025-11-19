<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        helper('text');

        $names = [
            'codeigniter', 'php', 'shield', 'security', 'release', 'ci4',
            'bootstrap', 'ux', 'testing', 'performance', 'database', 'auth',
        ];

        $builder = $this->db->table('tags');

        foreach ($names as $name) {
            $builder->ignore(true)->insert([
                'name' => $name,
                'slug' => url_title($name, '-', true),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
