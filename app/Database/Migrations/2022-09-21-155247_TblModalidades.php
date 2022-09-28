<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblModalidades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idModalidad'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'modalidadParticipacion'       => [
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
        $this->forge->addKey('idModalidad', true);
        $this->forge->createTable('tbl_modalidades');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_modalidades');
    }
}