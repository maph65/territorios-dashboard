<?php

class ApiController extends DooController {

    public function getLocaciones(){
        $result = ['success'=>true];
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');

        $locationsCountQuery
            = 'SELECT e.id_estado, e.nombre, e.codigo, COUNT(l.id_locacion) as cantidad '.
            'FROM ct_estado e LEFT JOIN ct_locacion l ON l.id_estado = e.id_estado AND l.habiltiado = 1'.
            ' GROUP BY e.id_estado';
        $estados  = Doo::db()->fetchAll($locationsCountQuery);
        $maxQty = 0;
        if(!empty($estados)) {
            foreach ($estados as $_edo) {
                $maxQty = ($_edo['cantidad'] > $maxQty) ? $_edo['cantidad'] : $maxQty;
            }
        }
        $baseColor = array('r'=>34,'g'=>95,'b'=>96);
        $invertedBaseColor = array('r'=>(255 - $baseColor['r']),'g'=>(255 - $baseColor['g']),'b'=>(255 - $baseColor['b']));
        $dataContent = array();
        if(!empty($estados)){
            foreach ($estados as $_edo){
                $data['codigo'] = $_edo['codigo'];
                $data['nombre'] = $_edo['nombre'];
                $data['locaciones'] = $_edo['cantidad'];
                if($_edo['cantidad'] > 0){
                    $red = 255 - (int)($invertedBaseColor['r'] / ( $maxQty / $_edo['cantidad']));
                    $green = 255 - (int)($invertedBaseColor['g'] / ( $maxQty / $_edo['cantidad']));
                    $blue = 255 - (int)($invertedBaseColor['b'] / ( $maxQty / $_edo['cantidad']));
                }else{
                    $red = 255;
                    $green = 255;
                    $blue = 255;
                }
                $color = sprintf("#%02x%02x%02x", $red, $green, $blue);
                $data['color']['hex'] = $color;
                $data['color']['rgba'] = array($red,$green,$blue);
                $dataContent[] = $data;
            }
        }
        $result['data'] = $dataContent;
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function getLocacionesByEstado(){
        $result = ['success'=>true];
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');
        $codigo = $this->params['codigo'];
        $estado = new CtEstado();
        $estado->codigo = $codigo;
        $estado = $estado->getOne();
        if(!empty($estado)){
            $locacion = new CtLocacion();
            $locacion->id_estado = $estado->id_estado;
            $locacion->habiltiado = 1;
            $locaciones = $locacion->relateMany(array('CtAutor','CtMedia'));
            if($locaciones){
                $result['data'] = $locaciones;
            }else{
                $result['data'] = array();
            }
        }else{
            $result['data'] = array();
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function getLocacionesByString(){
        $result = ['success'=>true];
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');
        $query = '';
        if(isset($_GET['query'])){
            $query = stripslashes(strip_tags($_GET['query']));
        }else if(isset($_POST['query'])){
            $query = stripslashes(strip_tags($_POST['query']));
        }
        if($query){
            $locacion = new CtLocacion();
            $locacion->habiltiado = 1;
            $locaciones = $locacion->relateMany(array('CtAutor','CtMedia','CtEstado'),
                ['CtAutor'=>['where'=>'ct_locacion.nombre LIKE \'%'.$query.'%\'']]);
            if($locaciones){
                $result['data'] = $locaciones;
            }else{
                $result['data'] = array();
            }
        }else{
            $result['data'] = array();
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

}

?>