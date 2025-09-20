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
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('customer_id', 'customers', 'id', 'CASCADE', 'SET NULL');

        // Add order status field
        $this->forge->addColumn('orders', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'],
                'default' => 'pending',
                'after' => 'total_amount',
            ],
        ]);

        // Add payment status field
        $this->forge->addColumn('orders', [
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'refunded'],
                'default' => 'pending',
                'after' => 'status',
            ],
        ]);

        // Add shipping information
        $this->forge->addColumn('orders', [
            'shipping_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'payment_status',
            ],
            'shipping_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'shipping_name',
            ],
            'shipping_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'shipping_email',
            ],
            'shipping_address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'shipping_phone',
            ],
            'shipping_city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'shipping_address',
            ],
            'shipping_state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'shipping_city',
            ],
            'shipping_country' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'shipping_state',
            ],
            'shipping_postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'shipping_country',
            ],
        ]);

        // Add order notes
        $this->forge->addColumn('orders', [
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'shipping_postal_code',
            ],
        ]);

        // Add tracking information
        $this->forge->addColumn('orders', [
            'tracking_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'notes',
            ],
            'shipped_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'tracking_number',
            ],
            'delivered_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'shipped_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropForeignKey('orders', 'orders_customer_id_foreign');
        $this->forge->dropColumn('orders', 'customer_id');
        $this->forge->dropColumn('orders', 'status');
        $this->forge->dropColumn('orders', 'payment_status');
        $this->forge->dropColumn('orders', 'shipping_name');
        $this->forge->dropColumn('orders', 'shipping_email');
        $this->forge->dropColumn('orders', 'shipping_phone');
        $this->forge->dropColumn('orders', 'shipping_address');
        $this->forge->dropColumn('orders', 'shipping_city');
        $this->forge->dropColumn('orders', 'shipping_state');
        $this->forge->dropColumn('orders', 'shipping_country');
        $this->forge->dropColumn('orders', 'shipping_postal_code');
        $this->forge->dropColumn('orders', 'notes');
        $this->forge->dropColumn('orders', 'tracking_number');
        $this->forge->dropColumn('orders', 'shipped_at');
        $this->forge->dropColumn('orders', 'delivered_at');
    }
}
