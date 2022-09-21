<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Capacitaciones extends BaseController
{
    public function index(){
        $modelcapacitaciones = model('CapacitacionesModel');
        return $this->getResponse([
            'message' => 'Clients retrieved successfully',
            'clients' => $modelcapacitaciones->findAll()
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
        }

        $capacitacion = $capacitacionModel->buscarCapacitacion($id);

        return $this->getResponse([
            'message' => 'agregado',
            'capacitacion' => $capacitacion,
        ]);
    }

}