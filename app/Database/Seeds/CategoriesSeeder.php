<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        helper('text');

        $names = [
            'Announcements',
            'Tutorials',
            'Releases',
            'Guides',
            'Opinions',
        ];

        $builder = $this->db->table('categories');

        foreach ($names as $name) {
            $builder->ignore(true)->insert([
                'name' => $name,
                'slug' => url_title($name, '-', true),
                'description' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
