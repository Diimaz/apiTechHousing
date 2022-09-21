<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblFechasMision extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idFechaMision'          => [
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
            'idMisionInstitucional'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idFechaMision', true);
        //$this->forge->addForeignKey('idMisionInstitucional','tbl_misiones_institucionales','idMisionInstitucional','CASCADE','SET NULL');
        $this->forge->createTable('tbl_fechas_mision');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fechas_mision');
    }
}