<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblMisionesInstitucionales extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idMisionInstitucional'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'nombreEvento'       => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'institucionOrganizadora'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'motivoEvento'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'empleadoYRolesEnParticipacion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
                'null' => false,
            ],
            'audienciaEstimada'       => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => false,
            ],
            'comentarios'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
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
            'date_delete' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'idModalidad'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idMisionInstitucional', true);
        //$this->forge->addForeignKey('idModalidad','tbl_modalidades','idModalidad','CASCADE','SET NULL');
        $this->forge->createTable('tbl_misiones_institucionales');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_misiones_institucionales');
    }

}