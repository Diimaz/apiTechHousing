<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblFechas extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idFechaCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'fechaInicio'       => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'fechaFinal'       => [
                'type' => 'DATETIME',
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
            'idCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idFechaCapacitacion', true);
        //$this->forge->addForeignKey('idCapacitacion','tbl_capacitaciones','idCapacitacion','CASCADE','SET NULL');
        $this->forge->createTable('tbl_fechas_capacitacion');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fechas_capacitacion');
    }

}