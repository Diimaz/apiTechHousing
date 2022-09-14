<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblUsuarios extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idUsuario'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'username'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'password'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'nombre'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'apellido'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'telefono'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
                'unique' => true,
            ],
            'date_create' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'date_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'date_delete' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'idRol'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
            'idDepartamento'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idUsuario', true);
        //$this->forge->addForeignKey('idRol','tbl_roles','idRol','CASCADE','SET NULL');
        //$this->forge->addForeignKey('idDepartamento','tbl_departamentos','idDepartamento','CASCADE','SET NULL');
        $this->forge->createTable('tbl_usuarios');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_usuarios');
    }
}