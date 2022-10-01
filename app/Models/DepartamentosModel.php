<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class DepartamentosModel extends Model
{

    protected $table = 'tbl_departamentos';
    protected $primaryKey = 'idDepartamento';
    protected $allowedFields = ['departamento'];

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}