<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateProductsDescriptionToLongText extends Migration
{
    public function up()
    {
        // Update description field to LONGTEXT
        $this->forge->modifyColumn('products', [
            'description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'short_description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        // Revert back to TEXT
        $this->forge->modifyColumn('products', [
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'short_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);
    }
}
