<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategoriesSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(BlogsSeeder::class);
    }
}
