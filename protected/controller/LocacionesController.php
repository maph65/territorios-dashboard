<?php

Doo::loadController('SecurityController');

class LocacionesController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $locationsCountQuery
            = 'SELECT e.id_estado, e.nombre, COUNT(l.id_locacion) as cantidad '.
            'FROM ct_estado e LEFT JOIN ct_locacion l ON l.id_estado = e.id_estado'.
            ' GROUP BY e.id_estado';
        $this->data['estados']  = Doo::db()->fetchAll($locationsCountQuery);
        $this->data['location'] = 'locaciones';
        $this->renderc('admin/locaciones', $this->data);
    }

    public function locacionesPorEstado(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');
        Doo::loadModel('CtUsuario');
        $idEstado = (int)$this->params['idestado'];
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        //print_r($this->data['usr']); die();
        $locaciones = new CtLocacion();
        $locaciones->id_estado = $idEstado;
        $this->data['locaciones'] = $locaciones->find();
        $estado = new CtEstado();
        $estado->id_estado = $idEstado;
        $this->data['estado'] = $estado->getOne();
        $this->data['location'] = 'locaciones';
        if($this->data['estado']){
            $this->renderc('admin/locaciones/estado',$this->data);
        }else{
            header('location:' . Doo::conf()->APP_URL . '?admin/locaciones?error=1');
        }
    }

    public function nuevaLocacion(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');
        Doo::loadModel('CtAutor');
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $estado = new CtEstado();
        $this->data['estados'] = $estado->find();
        $autor = new CtAutor();
        $this->data['autores'] = $autor->find();
        $this->data['location'] = 'locaciones';
        $this->renderc('admin/locaciones/nuevo',$this->data);
    }

    public function guardarLocacion(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        $locacion = new CtLocacion();
        if ( isset($_POST['estado']) && !empty($_POST['estado'])
            && isset($_POST['nombre-locacion']) && !empty($_POST['nombre-locacion'])
            && isset($_POST['direccion']) && !empty($_POST['direccion'])
            && isset($_POST['contenido']) && !empty($_POST['contenido'])
            && isset($_POST['autor']) && !empty($_POST['autor'])
        ) {
            $locacion->nombre = $_POST['nombre-locacion'];
            $locacion->ubicacion = $_POST['direccion'];
            $locacion->html_cotenido = $_POST['contenido'];
            $locacion->id_autor = (int)$_POST['autor'];
            $locacion->id_estado = (int)$_POST['estado'];
            $locacion->habiltiado = (isset($_POST['visible']) && $_POST['visible']) ? 1 : 0;
            $val = $locacion->validate();
            if(empty($val)){
                $result = $locacion->insert();
                if($result){
                    header('location:' . Doo::conf()->APP_URL . 'locaciones/estado/'.$locacion->id_estado.'?success=1');
                }else{
                    header('location:' . Doo::conf()->APP_URL . 'locaciones/estado/'.$locacion->id_estado.'?error=4');
                }
            }else{
                header('location:' . Doo::conf()->APP_URL . 'locaciones?error=3');
            }
        }else{
            header('location:' . Doo::conf()->APP_URL . 'locaciones?error=2');
        }
    }

    public function eliminarLocacion(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('Ctlocacion');
        $idLocacion = isset($this->params['idlocacion']) ? intval($this->params['idlocacion']) : 0;
        if ($idLocacion) {
            $n = new CtLocacion();
            $n->id_locacion = $idLocacion;
            $n = $n->getOne();
            if (!empty($n)) {
                //Todo: Eliminar media antes de eliminar locacion
                $n->delete();
                header('location:' . Doo::conf()->APP_URL . 'locaciones/estado/'.$n->id_estado.'?success=2');
            } else {
                header('location:' . Doo::conf()->APP_URL . 'locaciones/estado/'.$n->id_estado.'?error=5');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'locaciones?error=5');
        }
    }


    public function administrarGaleria(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtMedia');
        Doo::loadModel('CtUsuario');
        $idLocacion = (int)$this->params['idlocacion'];
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        //print_r($this->data['usr']); die();
        $locacion = new CtLocacion();
        $locacion->id_locacion = $idLocacion;
        $locacion = $locacion->getOne();
        if($locacion &&  $locacion->id_locacion){
            $galeria = new CtMedia();
            $galeria->id_locacion = $idLocacion;
            $this->data['locacion'] = $locacion;
            $this->data['galeria'] = $galeria->find();
            $this->data['location'] = 'locaciones';
            $this->renderc('admin/locaciones/galeria',$this->data);
        }else{
            header('location:' . Doo::conf()->APP_URL . 'locaciones?error=5');
        }
    }

    public function subirImagenes(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtMedia');
        Doo::loadHelper('DooGdImage');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('SlugifyClass');
        $imageKey = 'bfuploadimg';
        $arrayFileKeys = array();
        $newFiles = array();
        if(is_array($_FILES[$imageKey]) && !empty($_FILES[$imageKey])){
            if(is_array($_FILES['bfuploadimg']['name'])){
                $qty = count($_FILES['bfuploadimg']['name']);
                for($_c = 0; $_c < $qty;$_c++){
                    $newKey = $imageKey.'_'.$_c;
                    $newFiles[$newKey] = [];
                    foreach ($_FILES[$imageKey] as $k => $v){
                        $newFiles[$newKey][$k] = $v[$_c];
                        $arrayFileKeys[$newKey] = $newKey;
                    }
                }
                $_FILES = $newFiles;
            }else{
                $arrayFileKeys[$imageKey] = $imageKey;
            }
            $arrayFileKeys = array_keys($arrayFileKeys);
            foreach ($arrayFileKeys as $imgProcessKey){
                $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/locacion/', Doo::conf()->GLOBAL_PATH . 'uploads/locacion/');
                $gd->generatedQuality = 100;
                $gd->generatedType = "jpg";
                $rndText = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $nombreArchivo = 'locacion_' . SlugifyClass::slugify($_FILES[$imgProcessKey]['name']);
                $originalFileExtension = substr(strrchr($_FILES[$imgProcessKey]['name'], '.'), 1);
                $uploadImage = $gd->uploadImage($imgProcessKey, $nombreArchivo);
                $resizeName =  $nombreArchivo.'_resized_'.$rndText;
                $gd->ratioResize($uploadImage,'1200','1200',$resizeName);
                unlink(Doo::conf()->GLOBAL_PATH . 'uploads/locacion/'.$nombreArchivo.'.'.$originalFileExtension);
                if(is_file(Doo::conf()->GLOBAL_PATH . 'uploads/locacion/'.$resizeName.'.jpg')){
                    $media = new CtMedia();
                    $media->ruta = 'uploads/locacion/'.$resizeName.'.jpg';
                    $media->tipo = 'imagen';
                    $media->id_locacion = (int)$this->params['idlocacion'];
                    $media->insert();
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array('result','success'));
    }

    public function eliminarImagen(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtMedia');
        $idMedia = $this->params['idmedia'];
        $media = new CtMedia();
        $media->id_media = $idMedia;
        $m = $media->getOne();
        if($m){
            $idLocacion = $m->id_locacion;
            if(is_file(Doo::conf()->GLOBAL_PATH.$m->ruta)){
                unlink(Doo::conf()->GLOBAL_PATH.$m->ruta);
            }
            $m->delete();
            header('location:'.Doo::conf()->APP_URL.'locaciones/galeria/'.$idLocacion.'?success=1');
        }else{
            header('location:'.Doo::conf()->APP_URL.'locaciones/?error=1');
        }

    }

}

?>
