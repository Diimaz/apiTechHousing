<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class MisionesModel extends Model
{

    protected $table = 'tbl_misiones_institucionales';
    protected $primaryKey = 'idMisionInstitucional';
    
    protected $allowedFields = ['nombreEvento','institucionOrganizadora','motivoEvento','empleadoYRolesEnParticipacion','audienciaEstimada','comentarios','idModalidad'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $deletedField  = 'date_delete';

   /* protected $beforeInsert = ['agregarImagenes'];

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
    }*/


   /* protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array{
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array{
        return $this->getUpdatedDataWithHashedPassword($data);
    }*/

    public function buscarMision($id) {
        $mision = $this->asArray()->where(['idMisionInstitucional' => $id])->first();

        if (!$mision) {
            throw new Exception('La mision no existe');
        }
        return $mision;
    }
}