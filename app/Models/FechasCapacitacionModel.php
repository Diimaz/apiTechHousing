<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FechasCapacitacionModel extends Model
{

    protected $table = 'tbl_fechas_capacitacion';
    protected $primaryKey = 'idFechaCapacitacion';
    protected $allowedFields = ['fechaInicio','fechaFinal','idCapacitacion'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}