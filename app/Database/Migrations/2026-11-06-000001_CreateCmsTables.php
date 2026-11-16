<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCmsTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'email' => ['type' => 'VARCHAR', 'constraint' => 191],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'editor'],
            'last_login_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true)->addUniqueKey('email')->createTable('users');

        foreach (['pages', 'content_items'] as $table) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'title' => ['type' => 'VARCHAR', 'constraint' => 191],
                'slug' => ['type' => 'VARCHAR', 'constraint' => 191],
                'excerpt' => ['type' => 'TEXT', 'null' => true],
                'body' => ['type' => 'LONGTEXT', 'null' => true],
                'cover_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'hero_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'seo_title' => ['type' => 'VARCHAR', 'constraint' => 191, 'null' => true],
                'seo_description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
                'is_featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'published_at' => ['type' => 'DATETIME', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true)->addUniqueKey('slug')->addKey('status')->createTable($table);
        }
        // Content items have a type; add it separately to keep the shared fields readable.
        $this->forge->addColumn('content_items', ['type' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'post', 'after' => 'id']]);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'filename' => ['type' => 'VARCHAR', 'constraint' => 255],
            'path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'mime_type' => ['type' => 'VARCHAR', 'constraint' => 100],
            'alt_text' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'size' => ['type' => 'INT', 'unsigned' => true],
            'uploaded_by' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true)->createTable('media');
    }

    public function down()
    {
        foreach (['media', 'content_items', 'pages', 'users'] as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}
