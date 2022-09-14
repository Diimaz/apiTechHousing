<?php
namespace App\Entities;

use CodeIgniter\Entity;

class Usuario extends Entity{
    /*Variables de tiempo en la entidad Usuario*/
    protected $dates = ['date_create','date_update','date_delete'];
    
/*--Funcion para hash una contraseña---------------------------------------------------------------------*/
    //protected function setPassword(string $password){
        /*En el atributo password recibe una variable password y esta le hace el respectivo hash*/
       // $this->attributes['password'] = password_hash($password,PASSWORD_DEFAULT);
    //}
/*-------------------------------------------------------------------------------------------------------*/

/*--Funcion para generar un username---------------------------------------------------------------------*/
   // public function generarUsername(){
        /*En el atributo username va recibir el primer nombre y el primer apellido y los va unir para generar el username*/
     //   $numberUser = rand(0, 1000);
       // $this->attributes['usuario'] = "DT".explode(" ",$this->nombre)[0] . "" . explode(" ",$this->apellido)[0].$numberUser;
    //}
/*-------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------*/
    //public function buscarRole(){
      //  $model = model('RolesModel');
        //return $model->where('idRol', $this->idRol)->first();
    //}
/*-------------------------------------------------------------------------------------------------------*/
}