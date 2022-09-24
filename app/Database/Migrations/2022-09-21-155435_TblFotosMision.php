<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblFotosMision extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idFotoMision'          => [
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
            'idMisionInstitucional'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idFotoMision', true);
        //$this->forge->addForeignKey('idMisionInstitucional','tbl_misiones_institucionales','idMisionInstitucional','CASCADE','SET NULL');
        $this->forge->createTable('tbl_fotos_mision');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fotos_mision');
    }
}