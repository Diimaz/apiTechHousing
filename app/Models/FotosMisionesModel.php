<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class FotosMisionesModel extends Model
{

    protected $table = 'tbl_fotos_mision';
    protected $primaryKey = 'idFotoMision';
    protected $allowedFields = ['url','idMisionInstitucional'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
}