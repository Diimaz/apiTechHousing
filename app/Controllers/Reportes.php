<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Reportes extends BaseController
{
    public function reporte(){
        return $this->getResponse([
            'message' => 'Reportes'
        ]);
    }
}