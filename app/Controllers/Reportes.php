<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Reportes extends BaseController
{
    public function Reporte(){

        $input = $this->getRequestInput($this->request);

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
            $capacitacionModel = model('CapacitacionesModel');
            $estatusModel = model('EstatusModel');
            $usuarioModel = model('UserModel');
            $departamentoModel = model('DepartamentosModel');
            
            if (!isset($_POST['tipoReporte'])){
                return $this->getResponse([
                    'message' => 'No existe'
                ]);
            }

            if($input['tipoReporte'] == 'departamento'){

                if (!isset($_POST['idDepartamento'])){
                    $arrayDepartamento = $departamentoModel->findColumn('idDepartamento');
                    
                }else{
                    $buscarDepartamento = $departamentoModel->where('idDepartamento',$input['idDepartamento'])->findColumn('idDepartamento');
        
                    if($buscarDepartamento == null){
                        return $this->getResponse([
                            'message' => 'Departamento no valido'
                        ]);
                    }
        
                    $arrayDepartamento[] = $input['idDepartamento'];
                }

                $arrayUsuarios = $usuarioModel->whereIn('idDepartamento',$arrayDepartamento)->findColumn('idUsuario');

                if($arrayUsuarios == null){
                    return $this->getResponse([
                        'message' => 'No hay usuarios en este departamento'
                    ]);
                }

                if(isset($_POST['tipoFecha'])){
                    if($input['tipoFecha'] == 'mes'){
                        $resta = date('Y-M-d');
                        $fechaFinal = date('Y-m-d');
                        $fechaInicio = date("Y-m-d",strtotime($resta."- 1 month"));
                        
                    }elseif($input['tipoFecha'] == 'year'){
                        $resta = date('Y-M-d');
                        $fechaFinal = date('Y-m-d');
                        $fechaInicio = date("Y-m-d",strtotime($resta."- 1 year"));
                    } 
                }

                if(isset($_POST['fechaInicio']) && isset($_POST['fechaFinal']) && !isset($_POST['tipoFecha'])){
                    $fechaInicio = $input['fechaInicio'];
                    $fechaFinal = $input['fechaFinal'];
                }

                if (!isset($_POST['idEstatus'])){
                    $arrayEstatus= $estatusModel->findColumn('idEstatus');
                    
                }else{
                    $buscarEstatus = $estatusModel->where('idEstatus',$input['idEstatus'])->findColumn('idEstatus');
        
                    if($buscarEstatus == null){
                        return $this->getResponse([
                            'message' => 'Estatus no valido'
                        ]);
                    }
        
                    $arrayEstatus[] = $input['idEstatus'];
                }
                
                if(!isset($_POST['tipoFecha']) && !isset($_POST['fechaInicio']) && !isset($_POST['fechaFfina'])){
                    $mostrarCapacitacion = $capacitacionModel->whereIn('idUsuario',$arrayUsuarios)->whereIn('idEstatus',$arrayEstatus)->findAll();
                }else{
                    $mostrarCapacitacion = $capacitacionModel->where('date_create >', $fechaInicio.'00:00:00')->where('date_create <', $fechaFinal.'23:59:59')->whereIn('idUsuario',$arrayUsuarios)->whereIn('idEstatus',$arrayEstatus)->findAll();
                }


            }elseif($input['tipoReporte'] == 'usuario'){
                if (!isset($_POST['idUsuario'])){
                    $arrayUsuario = $usuarioModel->findColumn('idUsuario');
                    
                }else{
                    $buscarUsuario = $usuarioModel->where('idUsuario',$input['idUsuario'])->findColumn('idUsuario');
        
                    if($buscarUsuario == null){
                        return $this->getResponse([
                            'message' => 'Usuario no valido'
                        ]);
                    }
        
                    $arrayUsuario[] = $input['idUsuario'];
                }
        
                if (!isset($_POST['idEstatus'])){
                    $arrayEstatus= $estatusModel->findColumn('idEstatus');
                    
                }else{
                    $buscarEstatus = $estatusModel->where('idEstatus',$input['idEstatus'])->findColumn('idEstatus');
        
                    if($buscarEstatus == null){
                        return $this->getResponse([
                            'message' => 'Estatus no valido'
                        ]);
                    }
        
                    $arrayEstatus[] = $input['idEstatus'];
                }
        
                $mostrarCapacitacion = $capacitacionModel->whereIn('idUsuario',$arrayUsuario)->whereIn('idEstatus',$arrayEstatus)->findAll();    
                
            }else{
                return $this->getResponse([
                    'message' => 'No valido'
                ]);
            }

            return $this->getResponse([
                'message' => 'Clients retrieved successfully',
                'clients' => $mostrarCapacitacion,
            ]);
        }else{
            return $this->getResponse([
                'message' => 'No tiene privilegios',
            ]);
        }
    }
}