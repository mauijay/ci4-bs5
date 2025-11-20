<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBlogsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('blogs', [
            'seo_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'slug',
            ],
            'seo_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'seo_title',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', ['seo_title', 'seo_description']);
    }
}
