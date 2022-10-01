<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FechasMisionesModel extends Model
{

    protected $table = 'tbl_fechas_mision';
    protected $primaryKey = 'idFechaMision';
    protected $allowedFields = ['fechaInicio','fechaFinal','idMisionInstitucional'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}