<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FotosCapacitacionModel extends Model
{

    protected $table = 'tbl_fotos_capacitacion';
    protected $primaryKey = 'idFotoCapacitacion';
    protected $allowedFields = ['url','idCapacitacion'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}