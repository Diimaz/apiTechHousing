<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $modelClientes = [
            "hola"=>'hola'
        ];
        return json_encode($modelClientes,true);
    }
}