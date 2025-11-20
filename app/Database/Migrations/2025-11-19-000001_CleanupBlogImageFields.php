<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupBlogImageFields extends Migration
{
    public function up()
    {
        // Move alt text responsibility to images table; remove legacy columns from blogs
        $this->forge->dropColumn('blogs', ['image_alt', 'image', 'tags']);
    }

    public function down()
    {
        // Restore legacy columns if needed (minimal definitions)
        $fields = [
            'image_alt' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tags' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
        ];

        $this->forge->addColumn('blogs', $fields);
    }
}
