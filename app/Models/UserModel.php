<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{

    protected $table = 'tbl_usuarios';
    protected $allowedFields = ['username','password','nombre', 'apellido','telefono','email','idRol','idDepartamento'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_create';
    protected $updatedField  = 'date_update';
    protected $deletedField  = 'date_delete';

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = password_hash($plaintextPassword, PASSWORD_BCRYPT);
        }

        return $data;
    }

    public function findUserByEmailAddress(string $emailAddress) {
        $user = $this->asArray()->where(['email' => $emailAddress])->first();

        if (!$user) {
            throw new Exception('User does not exist for specified email address');
        }
        return $user;
    }

    public function findClientById($id)
    {
        $client = $this->asArray()->where(['idUsuario' => $id])->first();

        if (!$client) {
            throw new \Exception('Could not find client for specified ID');
        }

        return $client;
    }
}