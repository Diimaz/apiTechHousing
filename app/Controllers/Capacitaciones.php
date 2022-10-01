<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Capacitaciones extends BaseController
{
    public function index(){
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

        $capacitacionModel = model('CapacitacionesModel');
        $fechasCapacitacionModel = model('FechasCapacitacionModel');
        $fotosCapacitacionModel = model('FotosCapacitacionModel');
        $usuarioModel = model('UserModel');

        if($_COOKIE['idRol'] == '1'){
            $mostrarCapacitacion['datos'] = $capacitacionModel->findAll();
            $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->findAll();
            $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->findAll();
        }elseif($_COOKIE['idRol'] == '2'){
            $arrayUsuarios = $usuarioModel->where('idDepartamento',$_COOKIE['idDepartamento'])->findColumn('idUsuario');
            $arrayCapacitacion = $capacitacionModel->whereIn('idUsuario',$arrayUsuarios)->findColumn('idCapacitacion');
            $mostrarCapacitacion['datos'] = $capacitacionModel->whereIn('idUsuario',$arrayUsuarios)->findAll();
            $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->whereIn('idCapacitacion',$arrayCapacitacion)->findAll();
            $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->whereIn('idCapacitacion',$arrayCapacitacion)->findAll();
        }elseif($_COOKIE['idRol'] == '3'){
            $arrayCapacitacion[] = $capacitacionModel->where('idUsuario',$_COOKIE['idUsuario'])->findColumn('idCapacitacion');
            $mostrarCapacitacion['datos'] = $capacitacionModel->where('idUsuario',$_COOKIE['idUsuario'])->findAll();
            $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->whereIn('idCapacitacion',$arrayCapacitacion)->findAll();
            $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->whereIn('idCapacitacion',$arrayCapacitacion)->findAll();
        }else{
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        
        return $this->getResponse([
            'message' => 'Todas las capacitaciones',
            'capacitaciones' => $mostrarCapacitacion
        ]);
    }

    public function create(){

        $rules = service('validation');
        $rules->setRules([
            'institucion'=>'required|alpha_space',
            'horasDuracion'=>'required',
            'descripcion'=>'required',
            /*'imagenInscripcion'=>'required',
            'imagenFinalizacion'=>'required',*/
        ],[
            'institucion' => [
                    'required' => 'Digite una institucion',
                    'alpha_space' => 'Caracteres no permitidos'
            ],
            'horasDuracion' => [
                'required' => 'Digite las horas duracion',
            ],
            'descripcion' => [
                'required' => 'Digite una descripcion',
            ],
            /*'imagenInscripcion' => [
                'required' => 'Imagen no valida',
            ],
            'imagenFinalizacion' => [
                'required' => 'Imagen no valida',
            ],*/
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $input = $this->getRequestInput($this->request);

        $capacitacionModel = model('CapacitacionesModel');
        /*$imagenI = $_FILES['imagenInscripcion']['name'];
        $imagenF = $_FILES['imagenFinalizacion']['name'];*/

        /*$estructuraCapacitacion = 'C:/laragon/www/apitechhousing/public/img/capacitaciones/';
        
        if(!file_exists($estructuraCapacitacion)){
            mkdir($estructuraCapacitacion, 0777, true);
        }*/

        $imagen = \Config\Services::image()->withFile($_FILES['imagenInscripcion']['tmp_name'])->fit(500,500)->save($_FILES['imagenInscripcion']['tmp_name']);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $path = $_FILES['imagenInscripcion']['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;

        $direccion = 'C:/laragon/www/apitechhousing/public/img/capacitaciones/'.$newName;
        move_uploaded_file($_FILES['imagenInscripcion']['tmp_name'],$direccion);

        $imagenI = 'apitechhousing.test/img/capacitaciones/'.$newName;

        $imagen = \Config\Services::image()->withFile($_FILES['imagenFinalizacion']['tmp_name'])->fit(500,500)->save($_FILES['imagenFinalizacion']['tmp_name']);

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $path = $_FILES['imagenFinalizacion']['name'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;

        $direccion = 'C:/laragon/www/apitechhousing/public/img/capacitaciones/'.$newName;
        move_uploaded_file($_FILES['imagenFinalizacion']['tmp_name'],$direccion);

        $imagenF = 'apitechhousing.test/img/capacitaciones/'.$newName;

        $capacitacionModel->agregarla($imagenI,$imagenF);

        if(!$capacitacionModel->save($input)){
            return $this->getResponse([
                'message' => 'fallo',
            ]);
        }

        $id = $capacitacionModel->getInsertID();

        $fotosCapacitacionModel = model('FotosCapacitacionModel');
        
        $tamanoFotos = count($_FILES['imagenes']['name']);
        
        $estructura = 'C:/laragon/www/apitechhousing/public/img/capacitacionesGalerias/'.$id;
        
        if(!file_exists($estructura)){
            mkdir($estructura, 0777, true);
        }
        
        for($i=0 ; $i < $tamanoFotos; $i++){
            $imagen = \Config\Services::image()->withFile($_FILES['imagenes']['tmp_name'][$i])->fit(500,500)->save($_FILES['imagenes']['tmp_name'][$i]);

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $path = $_FILES['imagenes']['name'][$i];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;

            $direccion = 'C:/laragon/www/apitechhousing/public/img/capacitacionesGalerias/'.$id.'/'.$newName;
            move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$direccion);

            $direccionGuardado = 'apitechhousing.test/img/capacitacionesGalerias/'.$id.'/'.$newName;

            $guardar = [
                'url' => $direccionGuardado,
                'idCapacitacion' => $id
            ];
            $fotosCapacitacionModel->save($guardar);
        }

        $tamanoFechas = count($input['fechaInicio']);
        $tamanoFechaFinal = count($input['fechaFinal']);

        $fechasCapacitacionModel = model('FechasCapacitacionModel');
        $fechaInicio = $input['fechaInicio'];
        $fechaFinal = $input['fechaFinal'];

        for($i=0 ; $i < $tamanoFechas; $i++){
            $guardar = [
                'fechaInicio' => $fechaInicio[$i],
                'fechaFinal' => $fechaFinal[$i],
                'idCapacitacion' => $id
            ];
            $fechasCapacitacionModel->save($guardar);
        }

        $capacitacion = $capacitacionModel->buscarCapacitacion($id);

        return $this->getResponse([
            'message' => 'agregado',
            'capacitacion' => $capacitacion,
        ]);
    }

    public function update($id){
        /*$input = $this->getRequestInput($this->request);
        return $this->getResponse([
            'message' => 'fallo',
            'ver' => $input,
            'id' => $id
        ]);*/
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
                'institucion'=>'required|alpha_space',
                'horasDuracion'=>'required',
                'descripcion'=>'required',
            ],[
                'institucion' => [
                        'required' => 'Digite una institucion',
                        'alpha_space' => 'Caracteres no permitidos'
                ],
                'horasDuracion' => [
                    'required' => 'Digite las horas duracion',
                ],
                'descripcion' => [
                    'required' => 'Digite una descripcion',
                ],
            ]);

            if(!$rules->withRequest($this->request)->run()){
                return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
            }

            $input = $this->getRequestInput($this->request);

            $dataActualizar = [
                'idCapacitacion' => $id,
                'institucion' => $input['institucion'],
                'horasDuracion' => $input['horasDuracion'],
                'descripcion' => $input['descripcion'],
                //'imagenInscripcion' => $_FILES['imagenInscripcion']['name'],
                //'imagenFinalizacion' => $_FILES['imagenFinalizacion']['name'],
                //'idUsuario' => $input['idUsuario'],
                //'idModalidad'=> $input['idModalidad'],
                //'idFuenteFinanciamiento' => $input['idFuenteFinanciamiento'],
                //'idTipoCapacitacion' => $input['idTipoCapacitacion'],
                //'idEstatus' => $input['idEstatus'],
            ];

            $capacitacionModel = model('CapacitacionesModel');
            $fechasCapacitacionModel = model('FechasCapacitacionModel');
            $fotosCapacitacionModel = model('FotosCapacitacionModel');

            if(!$capacitacionModel->save($dataActualizar)){
                return $this->getResponse([
                    'message' => 'fallo',
                ]);
            }

            if(iseet($_POST['imagenes'])){
                $arrayFotos = $fotosCapacitacionModel->where('idCapacitacion',$id)->findColumn('idFotoCapacitacion');
                $tamanoFotos = count($_FILES['imagenes']['name']);
    
                for($i=0 ; $i < $tamanoFotos; $i++){
                    $imagen = \Config\Services::image()->withFile($_FILES['imagenes']['tmp_name'][$i])->fit(500,500)->save($_FILES['imagenes']['tmp_name'][$i]);
        
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $path = $_FILES['imagenes']['name'][$i];
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;
        
                    $direccion = 'C:/laragon/www/apitechhousing/public/img/capacitacionesGalerias/'.$id.'/'.$newName;
                    move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$direccion);
        
                    $direccionGuardado = 'apitechhousing.test/img/capacitacionesGalerias/'.$id.'/'.$newName;
        
                    $guardar = [
                        'idFotoCapacitacion' => $arrayFotos[$i],
                        'url' => $direccionGuardado,
                        'idCapacitacion' => $id
                    ];
                    $fotosCapacitacionModel->save($guardar);
                }
            }
    
            if(isset($_POST['fechaInicio']) && isset($_POST['fechaFinal'])){
                $tamanoFechas = count($input['fechaInicio']);
                $tamanoFechaFinal = count($input['fechaFinal']);
                
                $fechaInicio = $input['fechaInicio'];
                $fechaFinal = $input['fechaFinal'];
    
                $arrayFechas = $fechasCapacitacionModel->where('idCapacitacion',$id)->findColumn('idFechaCapacitacion');
    
                for($i=0 ; $i < $tamanoFechas; $i++){
                    $guardar = [
                        'idFechaCapacitacion' => $arrayFechas[$i],
                        'fechaInicio' => $fechaInicio[$i],
                        'fechaFinal' => $fechaFinal[$i],
                        'idCapacitacion' => $id
                    ];
                    $fechasCapacitacionModel->save($guardar);
                }
            }

            $capacitacion = $capacitacionModel->buscarCapacitacion($id);

            return $this->getResponse([
                'message' => 'Actualizado',
                'capacitacion' => $capacitacion,
            ]);
        }else{
            return $this->getResponse([
                'message' => 'No tiene privilegios'
            ]);
        }
    }

    public function show($id){

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
        
        $capacitacionModel = model('CapacitacionesModel');
        $fechasCapacitacionModel = model('FechasCapacitacionModel');
        $fotosCapacitacionModel = model('FotosCapacitacionModel');
        $usuarioModel = model('UserModel');

        if($_COOKIE['idRol'] == '1'){
            $mostrarCapacitacion['datos'] = $capacitacionModel->where('idCapacitacion',$id)->findAll();
            $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->where('idCapacitacion',$id)->findAll();
            $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->where('idCapacitacion',$id)->findAll();
        }elseif($_COOKIE['idRol'] == '2'){
            $usuario = $capacitacionModel->where('idCapacitacion',$id)->findColumn('idUsuario');
            if($usuario == null){
                return $this->getResponse([
                    'message' => 'No existe capacitacion'
                ]);
            }
            $departamento = $usuarioModel->where('idUsuario',$usuario[0])->findColumn('idDepartamento');
            if($departamento == null){
                return $this->getResponse([
                    'message' => 'No existe usuario'
                ]);
            }

            if($_COOKIE['idDepartamento'] == $departamento[0] || $usuario[0] == $_COOKIE['idUsuario']){
                $mostrarCapacitacion['datos'] = $capacitacionModel->where('idCapacitacion',$id)->findAll();
                $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->where('idCapacitacion',$id)->findAll();
                $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->where('idCapacitacion',$id)->findAll();
            }else{
                return $this->getResponse([
                    'message' => 'No tiene privilegios',
                ]);
            }
        }elseif($_COOKIE['idRol'] == '3'){
            $usuario = $capacitacionModel->where('idCapacitacion',$id)->findColumn('idUsuario');

            if($usuario == null){
                return $this->getResponse([
                    'message' => 'No existe capacitacion'
                ]);
            }

            if($usuario[0] == $_COOKIE['idUsuario']){
                $mostrarCapacitacion['datos'] = $capacitacionModel->where('idCapacitacion',$id)->findAll();
                $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->where('idCapacitacion',$id)->findAll();
                $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->where('idCapacitacion',$id)->findAll();
            }else{
                return $this->getResponse([
                    'message' => 'No tiene privilegios',
                ]);
            }
        }else{
            return $this->getResponse([
                'message' => 'Error'
            ]);
        }
        
        return $this->getResponse([
            'message' => 'Busqueda de capacitacion',
            'capacitacion' => $mostrarCapacitacion
        ]);
    }

    public function delete($id){

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
            $fechasCapacitacionModel = model('FechasCapacitacionModel');
            $fotosCapacitacionModel = model('FotosCapacitacionModel');

            $arrayFechas = $fechasCapacitacionModel->where('idCapacitacion',$id)->findColumn('idFechaCapacitacion');
            $arrayFotos = $fotosCapacitacionModel->where('idCapacitacion',$id)->findColumn('idFotoCapacitacion');
            
            if($arrayFechas != null){
                for($i=0 ; $i < count($arrayFechas); $i++){
                    if(!$fechasCapacitacionModel->delete($arrayFechas[$i])){
                        return $this->getResponse([
                            'message' => 'Falló',
                        ]);
                    }
                }
            }

            if($arrayFotos != null){
                for($i=0 ; $i < count($arrayFotos); $i++){
                    if(!$fotosCapacitacionModel->delete($arrayFotos[$i])){
                        return $this->getResponse([
                            'message' => 'Falló',
                        ]);
                    }
                }
            }

            
            if(!$capacitacionModel->delete($id)){
                return $this->getResponse([
                    'message' => 'Falló',
                ]);
            }

            return $this->getResponse([
                'message' => 'Capacitacion eliminada',
            ]);
        }else{
            return $this->getResponse([
                'message' => 'No tiene privilegios',
            ]);
        }
    }
}