<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblFotosCapacitacion extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idFotoCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'url'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
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
        $this->forge->addKey('idFotoCapacitacion', true);
        //$this->forge->addForeignKey('idCapacitacion','tbl_capacitaciones','idCapacitacion','CASCADE','SET NULL');
        $this->forge->createTable('tbl_fotos_capacitacion');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fotos_capacitacion');
    }
}