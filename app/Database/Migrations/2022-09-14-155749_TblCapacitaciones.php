<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblCapacitaciones extends Migration
{
    public function up()
    {
        //$this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'idCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'institucion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
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
            'horasDuracion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'descripcion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => true,
            ],
            'estatus'       => [
                'type'       => 'BIT',
                'null' => false,
            ],
            'imagenInscripcion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'imagenFinaizacion'       => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'imagenVarias'       => [
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
            'idUsuario'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
            'idModalidad'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
            'idFuenteFinanciamiento'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
            'idTipoCapacitacion'          => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idCapacitacion', true);
        //$this->forge->addForeignKey('idUsuario','tbl_usuarios','idUsuario','CASCADE','SET NULL');
        //$this->forge->addForeignKey('idModalidad','tbl_modalidades','idModalidad','CASCADE','SET NULL');
        //$this->forge->addForeignKey('idFuenteFinanciamiento','tbl_fuentesFinanciamientos','idfuenteFinanciamiento','CASCADE','SET NULL');
        //$this->forge->addForeignKey('idTipoCapacitacion','tbl_tiposCapacitaciones','idTipoCapacitacion','CASCADE','SET NULL');
        $this->forge->createTable('tbl_capacitaciones');
        //$this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('tbl_capacitaciones');
    }
}