<?php

Doo::loadController('SecurityController');

class AutoresController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtUsuario');
        Doo::loadModel('CtAutor');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $this->data['autores'] = CtAutor::_find(new CtAutor());
        $this->data['location'] = 'autores';
        $this->renderc('admin/autores', $this->data);
    }

    public function nuevoAutor(){
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtEstado');
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $estado = new CtEstado();
        $this->data['estados'] = $estado->find();
        $this->data['location'] = 'autores';
        $this->renderc('admin/autores/nuevo',$this->data);
    }

    public function guardarAutor() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtAutor');
        Doo::loadHelper('DooGdImage');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('SlugifyClass');
        if ( isset($_POST['nombre'])
            && !empty($_POST['nombre'])
            && isset($_POST['contenido'])
            && !empty($_POST['contenido'])
        ) {

            $fotoAutor = '';
            $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/autores/', Doo::conf()->GLOBAL_PATH . 'uploads/autores/');
            $gd->generatedQuality = 100;
            if (isset($_FILES['imagen']) && $gd->checkImageExtension('imagen')) {
                $rndText = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $nombreArchivo = 'autor_' . SlugifyClass::slugify($_FILES['imagen']['name']);
                $uploadImage = $gd->uploadImage('imagen', $nombreArchivo);
                $gd->generatedType = "jpg";
                $viewportX = intval($_POST['viewport-x']);
                $viewportY = intval($_POST['viewport-y']);
                $origx = (isset($_POST['imagen-orig-x']) && !empty($_POST['imagen-orig-x'])) ? intval($_POST['imagen-orig-x']) : 1;
                $origy = (isset($_POST['imagen-orig-y']) && !empty($_POST['imagen-orig-y'])) ? intval($_POST['imagen-orig-y']) : 1;
                $zoom = (isset($_POST['imagen-orig-zoom']) && !empty($_POST['imagen-orig-zoom'])) ? floatval($_POST['imagen-orig-zoom']) : 1;
                $finx = intval((($origx * $zoom) + $viewportX) / $zoom);
                $finy = intval((($origy * $zoom) + $viewportY) / $zoom);
                $dimensionX = $finx - $origx;
                $dimensionY = $finy - $origy;
                $thumbName = $nombreArchivo . '_thumb_' . $dimensionX . 'x' . $dimensionY.'_'.$rndText;
                $gd->crop($uploadImage, $dimensionX, $dimensionY, $origx, $origy, $thumbName);
                $resizeName = $nombreArchivo . '_thumb_400x400_'.$rndText;
                $gd->adaptiveResizeCropExcess($thumbName . '.' . $gd->generatedType, 400, 400, $resizeName);
                $fotoAutor = 'uploads/autores/' . $resizeName . '.' . $gd->generatedType;
                //Eliminamos las iamgenes que ya no usaremos
                if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/autores/' . $nombreArchivo)) {
                    unlink(Doo::conf()->GLOBAL_PATH . 'uploads/autores/' . $nombreArchivo);
                }
                if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/autores/' . $thumbName . '.' . $gd->generatedType)) {
                    unlink(Doo::conf()->GLOBAL_PATH . 'uploads/autores/' . $thumbName . '.' . $gd->generatedType);
                }
            }

            $autor = new CtAutor();
            $autor->nombre = $_POST['nombre'];
            $autor->bilografia = $_POST['contenido'];
            $autor->url_foto = $fotoAutor;
            $val = $autor->validate();
            if(empty($val)){
                $result = $autor->insert();
                if($result){
                    header('location:' . Doo::conf()->APP_URL . 'autores?success=1');
                }else{
                    header('location:' . Doo::conf()->APP_URL . 'autores?error=4');
                }
            }else{
                header('location:' . Doo::conf()->APP_URL . 'autores?error=3');
            }

        } else {
            header('location:' . Doo::conf()->APP_URL . 'locaciones?error=1');
        }
    }

    public function eliminarAutor() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtAutor');
        $idAutor = isset($this->params['idautor']) ? intval($this->params['idautor']) : 0;
        if ($idAutor) {
            $n = new CtAutor();
            $n->id_autor = $idAutor;
            $n = $n->getOne();
            if (!empty($n)) {
                if (is_file(Doo::conf()->GLOBAL_PATH . $n->url_foto)) {
                    unlink(Doo::conf()->GLOBAL_PATH . $n->url_foto);
                }
                $n->delete();
                header('location:' . Doo::conf()->APP_URL . 'autores?success=2');
            } else {
                header('location:' . Doo::conf()->APP_URL . 'autores?error=5');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'autores?error=5');
        }
    }


}

?>
