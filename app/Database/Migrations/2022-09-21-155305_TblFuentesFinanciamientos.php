<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblFuentesFinanciamientos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idFuenteFinanciamiento'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'fuenteFinanciamiento'       => [
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
        $this->forge->addKey('idFuenteFinanciamiento', true);
        $this->forge->createTable('tbl_fuentes_financiamientos');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fuentes_financiamientos');
    }

}