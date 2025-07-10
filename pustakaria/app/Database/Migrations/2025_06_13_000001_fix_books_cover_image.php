<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixBooksCoverImage extends Migration
{
    public function up()
    {
        // Ensure cover_image field exists and has proper default
        if ($this->db->fieldExists('cover_image', 'books')) {
            // Update existing NULL values to empty string or default
            $this->db->query("UPDATE books SET cover_image = '' WHERE cover_image IS NULL");
        } else {
            // Add cover_image field if it doesn't exist
            $this->forge->addColumn('books', [
                'cover_image' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'default'    => '',
                    'after'      => 'stock'
                ]
            ]);
        }
    }

    public function down()
    {
        // Don't remove the field in down migration to prevent data loss
        // Just log that this migration was rolled back
        log_message('info', 'FixBooksCoverImage migration rolled back');
    }
}
