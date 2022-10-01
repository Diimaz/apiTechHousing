<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class CapacitacionesModel extends Model
{

    protected $table = 'tbl_capacitaciones';
    protected $primaryKey = 'idCapacitacion';
    
    protected $allowedFields = ['institucion','horasDuracion','descripcion','imagenInscripcion','imagenFinalizacion','idUsuario','idModalidad','idFuenteFinanciamiento','idTipoCapacitacion','idEstatus'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $deletedField  = 'date_delete';

    protected $beforeInsert = ['agregarImagenes'];

    protected $agregarImagenInscripcion;
    protected $agregarImagenFinalizacion;

    protected function agregarImagenes($data){
        $data['data']['imagenInscripcion'] = $this->agregarImagenInscripcion;
        $data['data']['imagenFinalizacion'] = $this->agregarImagenFinalizacion;
        return $data;
    }

    public function agregarla(string $imagenI, string $imagenF){
        $this->agregarImagenInscripcion = $imagenI;
        $this->agregarImagenFinalizacion = $imagenF;
    }


   /* protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array{
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array{
        return $this->getUpdatedDataWithHashedPassword($data);
    }*/

    private function getUpdatedDataWithHashedPassword(array $data): array{
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = password_hash($plaintextPassword, PASSWORD_BCRYPT);
        }

        return $data;
    }

    public function findUserByEmailAddress(string $emailAddress) {
        $user = $this->asArray()->where(['email' => $emailAddress])->first();

        if (!$user) {
            throw new Exception('User does not exist for specified email address');
        }
        return $user;
    }

    public function buscarCapacitacion($id) {
        $capacitacion = $this->asArray()->where(['idCapacitacion' => $id])->first();

        if (!$capacitacion) {
            throw new Exception('La capacitacion no existe');
        }
        return $capacitacion;
    }

    public function findClientById($id){
        $client = $this->asArray()->where(['idUsuario' => $id])->first();

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }
}