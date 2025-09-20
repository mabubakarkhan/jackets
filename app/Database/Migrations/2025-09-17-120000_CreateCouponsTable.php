<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['percentage', 'fixed'],
                'default' => 'percentage',
            ],
            'value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'minimum_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'maximum_discount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'usage_limit' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'used_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'start_date' => [
                'type' => 'DATETIME',
            ],
            'end_date' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('code');
        $this->forge->addKey('status');
        $this->forge->createTable('coupons');
    }

    public function down()
    {
        $this->forge->dropTable('coupons');
    }
}
