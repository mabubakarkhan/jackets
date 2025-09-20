<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCanonicalUrlToTables extends Migration
{
    public function up()
    {
        // Add canonical_url to categories table
        $this->forge->addColumn('categories', [
            'canonical_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'meta_keywords'
            ]
        ]);

        // Add canonical_url to products table
        $this->forge->addColumn('products', [
            'canonical_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'meta_keywords'
            ]
        ]);

        // Add canonical_url to pages table
        $this->forge->addColumn('pages', [
            'canonical_url' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'meta_keywords'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'canonical_url');
        $this->forge->dropColumn('products', 'canonical_url');
        $this->forge->dropColumn('pages', 'canonical_url');
    }
}
