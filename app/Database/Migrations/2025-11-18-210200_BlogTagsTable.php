<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BlogTagsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'blog_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey(['blog_id', 'tag_id'], true);
        $this->forge->addKey('tag_id');

        // Create without FKs first for portability across drivers
        $this->forge->createTable('blog_tags');
    }

    public function down()
    {
        $this->forge->dropTable('blog_tags');
    }
}
