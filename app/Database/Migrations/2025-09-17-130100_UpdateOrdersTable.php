<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        // Add customer_id to orders table
        $this->forge->addColumn('orders', [
            'customer_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id',
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
                'after' => 'customer_id',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'],
                'default' => 'pending',
                'after' => 'order_number',
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'refunded'],
                'default' => 'pending',
                'after' => 'status',
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'payment_status',
            ],
            'shipping_address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'payment_method',
            ],
            'billing_address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'shipping_address',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'billing_address',
            ],
            'coupon_code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'notes',
            ],
            'discount_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
                'after' => 'coupon_code',
            ],
            'shipping_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
                'after' => 'discount_amount',
            ],
            'tax_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
                'after' => 'shipping_cost',
            ],
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        $this->forge->dropForeignKey('orders', 'orders_customer_id_foreign');
        $this->forge->dropColumn('orders', [
            'customer_id', 'order_number', 'status', 'payment_status', 
            'payment_method', 'shipping_address', 'billing_address', 
            'notes', 'coupon_code', 'discount_amount', 'shipping_cost', 'tax_amount'
        ]);
    }
}
