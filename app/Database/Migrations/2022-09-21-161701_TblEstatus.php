<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblEstatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idEstatus'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'estatus'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'date_create' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'date_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idEstatus', true);
        $this->forge->createTable('tbl_estatus');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_estatus');
    }
}