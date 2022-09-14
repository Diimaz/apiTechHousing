<?php

namespace App\Controllers;
use CodeIgniter\Config\Services;

class Login extends BaseController
{
    public function login(){
        if(!$this->validate([
            'usuario'=>'required',
            'password'=>'required'
        ],[
            'usuario' => [
                'required' => 'Digite un usuario'
            ],
            'password' => [
                'required' => 'Digite una contraseña'
            ],
        ])){
            return json_encode($this->validator->getErrors(),true);
        }
         $user = trim($this->request->getVar('usuario'));
         $password = trim($this->request->getVar('password'));
 
         $modelUsuarios = model('UsuariosModel');
 
         if(!$usuario = $modelUsuarios->buscarUsuario('email', $user)){
            $data = [
                'code'=> '001',
                'mensaje' => 'Usuario no encontrado.'
            ];
                
            return json_encode($data,true);
         }
         
         if(!password_verify($password,$usuario->password)){
            $data = [
                'code'=> '001',
                'mensaje' => 'Credenciales invalidas.'
            ];
                
            return json_encode($data,true);
         }
 
        if($usuario->idRol != null){
        }else{
            $data = [
                'code'=> '001',
                'mensaje' => 'Error.'
            ];
            return json_encode($data,true);
        }
        
        $data = [
            'code'=> '002',
            'mensaje' => 'Inicio sesion.'
        ];

        return json_encode($data,true);
    }
}