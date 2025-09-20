<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
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
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'customer_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'customer_address' => [
                'type' => 'TEXT',
            ],
            'customer_city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'customer_state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'customer_zip' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'customer_country' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'Pakistan',
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'shipping_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'payment_method' => [
                'type' => 'ENUM',
                'constraint' => ['cash_on_delivery', 'bank_transfer', 'inquiry'],
                'default' => 'cash_on_delivery',
            ],
            'order_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'],
                'default' => 'pending',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('order_number');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
