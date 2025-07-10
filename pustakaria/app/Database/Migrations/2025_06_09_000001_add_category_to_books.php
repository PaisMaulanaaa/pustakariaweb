<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryToBooks extends Migration
{
    public function up()
    {
        $this->forge->addColumn('books', [
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'after' => 'isbn'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('books', 'category');
    }
}
