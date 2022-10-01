<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class EstatusModel extends Model
{

    protected $table = 'tbl_estatus';
    protected $primaryKey = 'idEstatus';
    protected $allowedFields = ['estatus'];

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}