<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Capacitaciones extends BaseController
{
    public function index(){
        $capacitacionModel = model('CapacitacionesModel');
        $fechasCapacitacionModel = model('FechasCapacitacionModel');
        $fotosCapacitacionModel = model('FotosCapacitacionModel');

        $mostrarCapacitacion['datos'] = $capacitacionModel->findAll();
        $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->findAll();
        $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->findAll();
        
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
        $imagenI = $_FILES['imagenInscripcion']['name'];
        $imagenF = $_FILES['imagenFinalizacion']['name'];

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

            $guardar = [
                'url' => $direccion,
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
       // $imagenI = $_FILES['imagenInscripcion']['name'];
        //$imagenF = $_FILES['imagenFinalizacion']['name'];

        //$capacitacionModel->agregarla($imagenI,$imagenF);

        if(!$capacitacionModel->save($dataActualizar)){
            return $this->getResponse([
                'message' => 'fallo',
            ]);
        }

       // $idC = $capacitacionModel->getInsertID();

        /*$fotosCapacitacionModel = model('FotosCapacitacionModel');
        
        $tamanoFotos = count($_FILES['imagenes']['name']);

        for($i=0 ; $i < $tamanoFotos; $i++){
            $guardar = [
                'url' => $_FILES['imagenes']['name'][$i],
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
        }*/

        $capacitacion = $capacitacionModel->buscarCapacitacion($id);

        return $this->getResponse([
            'message' => 'Actualizado',
            'capacitacion' => $capacitacion,
        ]);
    }

    public function show($id){
        $capacitacionModel = model('CapacitacionesModel');
        $fechasCapacitacionModel = model('FechasCapacitacionModel');
        $fotosCapacitacionModel = model('FotosCapacitacionModel');

        $mostrarCapacitacion['datos'] = $capacitacionModel->where('idCapacitacion',$id)->findAll();
        $mostrarCapacitacion['fechas'] = $fechasCapacitacionModel->where('idCapacitacion',$id)->findAll();
        $mostrarCapacitacion['fotos'] = $fotosCapacitacionModel->where('idCapacitacion',$id)->findAll();
        
        return $this->getResponse([
            'message' => 'Busqueda de capacitacion',
            'capacitacion' => $mostrarCapacitacion
        ]);
    }

    public function delete($id){
        $capacitacionModel = model('CapacitacionesModel');
        
        if(!$capacitacionModel->delete($id)){
            return $this->getResponse([
                'message' => 'Falló',
            ]);
        }

        return $this->getResponse([
            'message' => 'Capacitacion eliminada',
        ]);
    }
}