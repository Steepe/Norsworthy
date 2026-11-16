<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInquiriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'email' => ['type' => 'VARCHAR', 'constraint' => 191],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'company' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 191],
            'message' => ['type' => 'TEXT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'new'],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true)->addKey('status')->addKey('created_at')->createTable('inquiries');
    }

    public function down()
    {
        $this->forge->dropTable('inquiries', true);
    }
}
