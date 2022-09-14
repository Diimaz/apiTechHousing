<?php

namespace App\Controllers;
use CodeIgniter\Config\Services;

class Usuarios extends BaseController
{
    public function index(){
        $modelUsuarios = model('UsuariosModel');
        return json_encode($modelUsuarios->findAll(),true);
    }

    public function create(){
        $modelUsuarios = model('UsuariosModel');
        $request = \Config\Services::request();
        $validar = service('validation');


        $validar->setRules([
            'nombre'=>'required|alpha_space',
            'apellido'=>'required|alpha_space',
            'telefono'=>'required|numeric|is_unique[tbl_usuarios.telefono]',
            'email'=>'required|valid_email|is_unique[tbl_usuarios.email]',
            'password'=>'matches[c-password]',
        ],
        [
            'nombre' => [
                    'required' => 'Digite un nombre',
                    'alpha_space' => 'Caracteres no permitidos'
            ],
            'apellido' => [
                'required' => 'Digite un apellido',
                'alpha_space' => 'Caracteres no permitidos'
            ],
            'telefono' => [
                'required' => 'Digite un número de telefono',
                'numeric' => 'Solo digite numeros',
                'is_unique' => 'Este número de telefono ya existe'
            ],
            'email' => [
                'required' => 'Digite un correo',
                'valid_email' => 'Correo no valido',
                'is_unique' => 'Este correo ya existe'
            ],
            'password' => [
                'matches' => 'Las contraseñas no coinciden',
            ],
        ]);
        
        if(!$validar->withRequest($this->request)->run()){
            return json_encode($validar->getErrors(),true);
        }
        
        $dataGuardado = [
            'username' => 'usuario',
            'nombre' => $request->getVar('nombre'),
            'apellido' => $request->getVar('apellido'),
            'telefono' => $request->getVar('telefono'),
            'email' => $request->getVar('email'),
            'password' => password_hash($request->getVar('password'),PASSWORD_DEFAULT),
            'idRol' => 1,
            'idDepartamento' => 5
        ];

        

        if(!$modelUsuarios->save($dataGuardado)){
            $data = [
                'code'=> '001',
                'mensaje' => 'Error al insertar datos.',
            ];

            return json_encode($data,true);
        }   

        $data = [
            'code'=> '002',
            'mensaje' => 'Datos insertados.'
        ];

        return json_encode($data,true);
    }
}