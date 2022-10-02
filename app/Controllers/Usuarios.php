<?php

namespace App\Controllers;

use Exception;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Usuarios extends BaseController
{
    public function index(){
        $modelUsuario = model('UserModel');
        $usuarios = $modelUsuario->findAll();

        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'clients' => $usuarios
        ]);
    }

    public function create(){
        if(!isset($_COOKIE['idRol'])){
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        if(!isset($_COOKIE['idUsuario'])){
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        if(!isset($_COOKIE['idDepartamento'])){
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        if($_COOKIE['idRol'] == null){
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        
        if($_COOKIE['idRol'] == '1'){
            $rules = service('validation');
            $rules->setRules([
                'nombre'=>'required|alpha_space',
                'apellido'=>'required|alpha_space',
                'telefono'=>'required|numeric|is_unique[tbl_usuarios.telefono]',
                'email'=>'required|valid_email|is_unique[tbl_usuarios.email]',
                'password'=>'matches[c-password]',
            ],[
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

            if(!$rules->withRequest($this->request)->run()){
                return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }

            $input = $this->getRequestInput($this->request);

            $userModel = new UserModel();
            $userModel->save($input);

            return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_CREATED);
        }else{
            return $this->getResponse([
                'message' => 'No tiene privilegios',
            ]);
        }
    }

    private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK){
        try {
            $modelUsuario = model('UserModel');
            $user = $modelUsuario->findUserByEmailAddress($email);
            unset($user['password']);

            helper('jwt');

            return $this->getResponse([
                'message' => 'User authenticated successfully',
                'user' => $user,
                'access_token' => getSignedJWTForUser($email)
            ]);
        } catch (\Exception $e) {
            return $this->getResponse([
                'error' => $e->getMessage()
            ], $responseCode);
        }
    }
}