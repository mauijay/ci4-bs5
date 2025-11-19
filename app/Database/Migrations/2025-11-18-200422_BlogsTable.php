<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BlogsTable extends Migration
{
    public function up()
    {
        $fields = [
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title'       => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'summary'     => [
                'type' => 'TEXT',
            ],
            'content'     => [
                'type' => 'TEXT',
            ],
            'blockquote'  => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'final_thoughts' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'author_id'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'image_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'image_alt'   => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'image'       => [ //legacy, will remove when introduce image service
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tags'        => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published', 'archived'],
                'default'    => 'draft',
            ],
            'created_at'  => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at'  => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'published_at'=> [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('blogs');
    }

    public function down()
    {
        $this->forge->dropTable('blogs');
    }
}
