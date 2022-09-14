<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idRol'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'rol'       => [
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
        $this->forge->addKey('idRol', true);
        $this->forge->createTable('tbl_roles');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_roles');
    }
}