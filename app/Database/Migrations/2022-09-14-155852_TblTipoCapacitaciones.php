<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblTipoCapacitaciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idTipoCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'tipoCapacitacion'       => [
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
        $this->forge->addKey('idTipoCapacitacion', true);
        $this->forge->createTable('tbl_tiposCapacitaciones');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_tiposCapacitaciones');
    }
}