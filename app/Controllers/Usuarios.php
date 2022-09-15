<?php

namespace App\Controllers;

use Exception;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Usuarios extends BaseController
{
    public function index(){
        $model = new UserModel();
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'clients' => $model->findAll()
        ]);
    }
}