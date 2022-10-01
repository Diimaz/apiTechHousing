<?php

namespace App\Controllers;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Misiones extends BaseController
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

        $misionModel = model('MisionesModel');
        $fechasMisionModel = model('FechasMisionesModel');
        $fotosMisionModel = model('FotosMisionesModel');
        $usuarioModel = model('UserModel');

        $mostrarMision['datos'] = $misionModel->findAll();
        $mostrarMision['fechas'] = $fechasMisionModel->findAll();
        $mostrarMision['fotos'] = $fotosMisionModel->findAll();
        
        return $this->getResponse([
            'message' => 'Todas las misiones',
            'misiones' => $mostrarMision
        ]);
    }

    public function create(){

        $rules = service('validation');
        $rules->setRules([
            'nombreEvento'=>'required|alpha_space',
            'institucionOrganizadora'=>'required',
            'motivoEvento'=>'required',
            'empleadoYRolesEnParticipacion'=>'required',
            'audienciaEstimada'=>'required',
            'comentarios'=>'required',
        ],[
            'nombreEvento' => [
                    'required' => 'Digite una institucion',
                    'alpha_space' => 'Caracteres no permitidos'
            ],
            'institucionOrganizadora' => [
                'required' => 'Digite las horas duracion',
            ],
            'motivoEvento' => [
                'required' => 'Digite una descripcion',
            ],
            'empleadoYRolesEnParticipacion' => [
                'required' => 'Digite una descripcion',
            ],
            'audienciaEstimada' => [
                'required' => 'Digite una descripcion',
            ],
            'comentarios' => [
                'required' => 'Digite una descripcion',
            ],
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $input = $this->getRequestInput($this->request);

        /*return $this->getResponse([
            'message' => 'fallo',
            'input' => $input
        ]);*/

        $misionModel = model('MisionesModel');

        if(!$misionModel->save($input)){
            return $this->getResponse([
                'message' => 'fallo',
            ]);
        }

        $id = $misionModel->getInsertID();

        $fotosMisionModel = model('FotosMisionesModel');
        
        $tamanoFotos = count($_FILES['imagenes']['name']);
        
        $estructura = 'C:/laragon/www/apitechhousing/public/img/misionesGaleria/'.$id;
        
        if(!file_exists($estructura)){
            mkdir($estructura, 0777, true);
        }
        
        for($i=0 ; $i < $tamanoFotos; $i++){
            $imagen = \Config\Services::image()->withFile($_FILES['imagenes']['tmp_name'][$i])->fit(500,500)->save($_FILES['imagenes']['tmp_name'][$i]);

            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $path = $_FILES['imagenes']['name'][$i];
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;

            $direccion = 'C:/laragon/www/apitechhousing/public/img/misionesGaleria/'.$id.'/'.$newName;
            move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$direccion);

            $direccionGuardado = 'apitechhousing.test/img/misionesGaleria/'.$id.'/'.$newName;

            $guardar = [
                'url' => $direccionGuardado,
                'idMisionInstitucional' => $id
            ];
            $fotosMisionModel->save($guardar);
        }

        $tamanoFechas = count($input['fechaInicio']);
        $tamanoFechaFinal = count($input['fechaFinal']);

        $fechasMisionModel = model('FechasMisionesModel');
        $fechaInicio = $input['fechaInicio'];
        $fechaFinal = $input['fechaFinal'];

        for($i=0 ; $i < $tamanoFechas; $i++){
            $guardar = [
                'fechaInicio' => $fechaInicio[$i],
                'fechaFinal' => $fechaFinal[$i],
                'idMisionInstitucional' => $id
            ];
            $fechasMisionModel->save($guardar);
        }

        $mision = $misionModel->buscarMision($id);

        return $this->getResponse([
            'message' => 'agregado',
            'capacitacion' => $mision,
        ]);
    }

    public function update($id){
        $rules = service('validation');
        $rules->setRules([
            'nombreEvento'=>'required|alpha_space',
            'institucionOrganizadora'=>'required',
            'motivoEvento'=>'required',
            'empleadoYRolesEnParticipacion'=>'required',
            'audienciaEstimada'=>'required',
            'comentarios'=>'required',
        ],[
            'nombreEvento' => [
                    'required' => 'Digite una institucion',
                    'alpha_space' => 'Caracteres no permitidos'
            ],
            'institucionOrganizadora' => [
                'required' => 'Digite las horas duracion',
            ],
            'motivoEvento' => [
                'required' => 'Digite una descripcion',
            ],
            'empleadoYRolesEnParticipacion' => [
                'required' => 'Digite una descripcion',
            ],
            'audienciaEstimada' => [
                'required' => 'Digite una descripcion',
            ],
            'comentarios' => [
                'required' => 'Digite una descripcion',
            ],
        ]);

        if(!$rules->withRequest($this->request)->run()){
            return $this->getResponse($rules->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $input = $this->getRequestInput($this->request);


        $misionModel = model('MisionesModel');

        if(!$misionModel->update($id, $input)){
            return $this->getResponse([
                'message' => 'fallo',
            ]);
        }

        $fotosMisionModel = model('FotosMisionesModel');

        if(iseet($_POST['imagenes'])){

            $arrayFotos = $fotosMisionModel->where('idMisionInstitucional',$id)->findColumn('idFotoMision');
            $tamanoFotos = count($_FILES['imagenes']['name']);

            for($i=0 ; $i < $tamanoFotos; $i++){
                $imagen = \Config\Services::image()->withFile($_FILES['imagenes']['tmp_name'][$i])->fit(500,500)->save($_FILES['imagenes']['tmp_name'][$i]);
    
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $path = $_FILES['imagenes']['name'][$i];
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $newName = substr(str_shuffle($permitted_chars), 0, 16).'.'.$extension;
    
                $direccion = 'C:/laragon/www/apitechhousing/public/img/misionesGaleria/'.$id.'/'.$newName;
                move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$direccion);
    
                $direccionGuardado = 'apitechhousing.test/img/misionesGaleria/'.$id.'/'.$newName;
    
                $guardar = [
                    'idFotoMision' => $arrayFotos[$i],
                    'url' => $direccionGuardado,
                    'idMisionInstitucional' => $id
                ];
                $fotosMisionModel->save($guardar);
            }
        }

        if(isset($_POST['fechaInicio']) && isset($_POST['fechaFinal'])){
            $tamanoFechas = count($input['fechaInicio']);
            $tamanoFechaFinal = count($input['fechaFinal']);

            $fechasMisionModel = model('FechasMisionModel');
            $fechaInicio = $input['fechaInicio'];
            $fechaFinal = $input['fechaFinal'];

            $arrayFechas = $fechasMisionModel->where('idMisionInstitucional',$id)->findColumn('idFechaMision');

            for($i=0 ; $i < $tamanoFechas; $i++){
                $guardar = [
                    'idFechaMision' => $arrayFechas[$i],
                    'fechaInicio' => $fechaInicio[$i],
                    'fechaFinal' => $fechaFinal[$i],
                    'idMisionInstitucional' => $id
                ];
                $fechasMisionModel->save($guardar);
            }
        }

        $mision = $misionModel->buscarCapacitacion($id);

        return $this->getResponse([
            'message' => 'Mision Actualizada',
            'capacitacion' => $mision,
        ]);
    }

    public function show($id){
        $misionModel = model('MisionesModel');
        $fechasMisionModel = model('FechasMisionesModel');
        $fotosMisionModel = model('FotosMisionesModel');

        $mostrarMision['datos'] = $misionModel->where('idMisionInstitucional',$id)->findAll();
        $mostrarMision['fechas'] = $fechasMisionModel->where('idMisionInstitucional',$id)->findAll();
        $mostrarMision['fotos'] = $fotosMisionModel->where('idMisionInstitucional',$id)->findAll();

        return $this->getResponse([
            'message' => 'Busqueda de mision',
            'mision' => $mostrarMision
        ]);
    }

    public function delete($id){
        $misionModel = model('MisionesModel');
        $fechasMisionModel = model('FechasMisionesModel');
        $fotosMisionModel = model('FotosMisionesModel');

        $arrayFechas = $fechasMisionModel->where('idMisionInstitucional',$id)->findColumn('idFechaMision');
        $arrayFotos = $fotosMisionModel->where('idMisionInstitucional',$id)->findColumn('idFotoMision');
        
        if($arrayFechas != null){
            for($i=0 ; $i < count($arrayFechas); $i++){
                if(!$fechasMisionModel->delete($arrayFechas[$i])){
                    return $this->getResponse([
                        'message' => 'Falló',
                    ]);
                }
            }
        }

        if($arrayFotos != null){
            for($i=0 ; $i < count($arrayFotos); $i++){
                if(!$fotosMisionModel->delete($arrayFotos[$i])){
                    return $this->getResponse([
                        'message' => 'Falló',
                    ]);
                }
            }
        }
            
        if(!$misionModel->delete($id)){
            return $this->getResponse([
                'message' => 'Falló',
            ]);
        }

        return $this->getResponse([
            'message' => 'Mision eliminada',
        ]);
    }
}