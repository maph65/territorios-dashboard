<?php

Doo::loadController('SecurityController');

class HotResultsController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('hot-results')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        $categoria = new CtCategoriaDescarga();
        $categoria->slug = 'hot-results';
        $categoria = $categoria->getOne();
        if (!empty($categoria)) {
            $descargas = new CtDescarga();
            $descargas->id_categoria = $categoria->id_categoria;
            $descargas->habilitado = 1;
            $descargas = $descargas->find(array('desc' => 'fecha_alta', 'limit' => 30));
            $this->data['descargas'] = $descargas;
            $this->data['location'] = 'hot-results';
            $this->renderc('admin/hotresults', $this->data);
        } else {
            header('location:' . Doo::conf()->APP_URL . 'home?error=1');
        }
    }

    public function publicarHotResult() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('hot-results')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        Doo::loadHelper('DooGdImage');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('SlugifyClass');
        if (isset($_POST['titulo']) && !empty($_POST['titulo']) &&
                isset($_POST['viewport-x']) && !empty($_POST['viewport-x']) &&
                isset($_POST['viewport-y']) && !empty($_POST['viewport-y']) &&
                isset($_FILES['imagen']) && !empty($_FILES['imagen'])
        ) {
            $categoria = new CtCategoriaDescarga();
            $categoria->slug = 'hot-results';
            $categoria = $categoria->getOne();
            if (!empty($categoria)) {
                $titulo = self::aUtf8(filter_var($_POST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW));

                $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/', Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/');
                $gd->generatedQuality = 100;
                if ($gd->checkImageExtension('imagen')) {
                    $nombreArchivo = 'catalogos_' . SlugifyClass::slugify($_FILES['imagen']['name']);
                    $uploadImage = $gd->uploadImage('imagen', $nombreArchivo);
                    $gd->generatedType = "jpg";
                    //Resize de la iamgen y thumb
                    $viewportX = intval($_POST['viewport-x']);
                    $viewportY = intval($_POST['viewport-y']);
                    $origx = (isset($_POST['imagen-orig-x']) && !empty($_POST['imagen-orig-x'])) ? intval($_POST['imagen-orig-x']) : 1;
                    $origy = (isset($_POST['imagen-orig-y']) && !empty($_POST['imagen-orig-y'])) ? intval($_POST['imagen-orig-y']) : 1;
                    $zoom = (isset($_POST['imagen-orig-zoom']) && !empty($_POST['imagen-orig-zoom'])) ? floatval($_POST['imagen-orig-zoom']) : 1;
                    $finx = intval((($origx * $zoom) + $viewportX) / $zoom);
                    $finy = intval((($origy * $zoom) + $viewportY) / $zoom);
                    $dimensionX = $finx - $origx;
                    $dimensionY = $finy - $origy;
                    $thumbName = $nombreArchivo . '_thumb_' . $dimensionX . 'x' . $dimensionY;
                    $gd->crop($uploadImage, $dimensionX, $dimensionY, $origx, $origy, $thumbName);
                    $resizeName = $nombreArchivo . '_thumb_400x720';
                    $gd->adaptiveResizeCropExcess($thumbName . '.' . $gd->generatedType, 720, 400, $resizeName);
                    $urlFinalFoto = 'uploads/' . $categoria->slug . '/' . $resizeName . '.' . $gd->generatedType;
                    //Eliminamos las iamgenes que ya no usaremos
                    if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType)) {
                        unlink(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType);
                    }

                    //Insertamos la info de la descarga
                    $descarga = new CtDescarga();
                    $descarga->id_categoria = $categoria->id_categoria;
                    $descarga->titulo = $titulo;
                    $descarga->url = 'uploads/' . $categoria->slug . '/' . $uploadImage;
                    $descarga->imagen = $urlFinalFoto;
                    $descarga->habilitado = 1;
                    $val = $descarga->validate();
                    if (empty($val)) {
                        $result = $descarga->insert();
                        if ($result) {
                            header('location:' . Doo::conf()->APP_URL . 'hot-results?success=1');
                        } else {
                            header('location:' . Doo::conf()->APP_URL . 'hot-results?error=6');
                        }
                    } else {
                        //print_r($notificacion->validate());
                        header('location:' . Doo::conf()->APP_URL . 'hot-results?error=5');
                    }
                } else {
                    header('location:' . Doo::conf()->APP_URL . 'hot-results?error=4');
                }
            } else {
                header('location:' . Doo::conf()->APP_URL . 'hot-results?error=2');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'hot-results?error=1');
        }
    }

    public function editarHotResult() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('hot-results')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        $categoria = new CtCategoriaDescarga();
        $categoria->slug = 'hot-results';
        $categoria = $categoria->getOne();
        $idDescarga = isset($this->params['iddescarga']) ? intval($this->params['iddescarga']) : 0;
        if (!empty($categoria) && !empty($idDescarga)) {
            $descarga = new CtDescarga();
            $descarga->id_descarga = $idDescarga;
            $descarga->id_categoria = $categoria->id_categoria;
            $descarga->habilitado = 1;
            $descarga = $descarga->getOne();
            if (!empty($descarga)) {
                $this->data['descarga'] = $descarga;
                $this->data['location'] = 'hot-results';
                $this->renderc('admin/editar/hotresults', $this->data);
            } else {
                
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'home?error=1');
        }
    }

    public function actualizarHotResult() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('hot-results')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        Doo::loadHelper('DooGdImage');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('SlugifyClass');
        $categoria = new CtCategoriaDescarga();
        $categoria->slug = 'hot-results';
        $categoria = $categoria->getOne();
        $idDescarga = isset($this->params['iddescarga']) ? intval($this->params['iddescarga']) : 0;
        if (!empty($categoria) && !empty($idDescarga)) {
            $descarga = new CtDescarga();
            $descarga->id_descarga = $idDescarga;
            $descarga->id_categoria = $categoria->id_categoria;
            $descarga->habilitado = 1;
            $descarga = $descarga->getOne();
            if (!empty($descarga)) {
                $titulo = (isset($_POST['titulo']) && !empty($_POST['titulo'])) ? self::aUtf8(filter_var($_POST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW)) : $descarga->titulo;

                if (isset($_FILES) && !empty($_FILES) && isset($_FILES['imagen'])) {
                    $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/', Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/');
                    $gd->generatedQuality = 100;
                    if ($gd->checkImageExtension('imagen')) {
                        $nombreArchivo = 'catalogos_' . SlugifyClass::slugify($_FILES['imagen']['name']);
                        $uploadImage = $gd->uploadImage('imagen', $nombreArchivo);
                        $gd->generatedType = "jpg";
                        //Resize de la iamgen y thumb
                        $viewportX = intval($_POST['viewport-x']);
                        $viewportY = intval($_POST['viewport-y']);
                        $origx = (isset($_POST['imagen-orig-x']) && !empty($_POST['imagen-orig-x'])) ? intval($_POST['imagen-orig-x']) : 1;
                        $origy = (isset($_POST['imagen-orig-y']) && !empty($_POST['imagen-orig-y'])) ? intval($_POST['imagen-orig-y']) : 1;
                        $zoom = (isset($_POST['imagen-orig-zoom']) && !empty($_POST['imagen-orig-zoom'])) ? floatval($_POST['imagen-orig-zoom']) : 1;
                        $finx = intval((($origx * $zoom) + $viewportX) / $zoom);
                        $finy = intval((($origy * $zoom) + $viewportY) / $zoom);
                        $dimensionX = $finx - $origx;
                        $dimensionY = $finy - $origy;
                        $thumbName = $nombreArchivo . '_thumb_' . $dimensionX . 'x' . $dimensionY;
                        $gd->crop($uploadImage, $dimensionX, $dimensionY, $origx, $origy, $thumbName);
                        $resizeName = $nombreArchivo . '_thumb_400x720';
                        $gd->adaptiveResizeCropExcess($thumbName . '.' . $gd->generatedType, 720, 400, $resizeName);
                        $urlFinalFoto = 'uploads/' . $categoria->slug . '/' . $resizeName . '.' . $gd->generatedType;
                        $url = 'uploads/' . $categoria->slug . '/' . $uploadImage;
                        //Eliminamos las iamgenes que ya no usaremos
                        if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType)) {
                            unlink(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType);
                        }
                    } else {
                        $urlFinalFoto = $descarga->imagen;
                        $url = $descarga->url;
                    }
                }else{
                    $urlFinalFoto = $descarga->imagen;
                    $url = $descarga->url;
                }
                //Actualizamos la info de la descarga
                $descarga->titulo = $titulo;
                $descarga->url = $url;
                $descarga->imagen = $urlFinalFoto;
                $descarga->habilitado = 1;
                $val = $descarga->validate();
                if (empty($val)) {
                    $result = $descarga->update();
                    if ($result) {
                        header('location:' . Doo::conf()->APP_URL . 'hot-results?success=3');
                    } else {
                        header('location:' . Doo::conf()->APP_URL . 'hot-results?error=6');
                    }
                } else {
                    header('location:' . Doo::conf()->APP_URL . 'hot-results?error=6');
                }
            } else {
                header('location:' . Doo::conf()->APP_URL . 'hot-results?error=6');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'home?error=1');
        }
    }

    public function eliminarHotResult() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('hot-results')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtDescarga');
        $idDescarga = isset($this->params['iddescarga']) ? intval($this->params['iddescarga']) : 0;
        //$slug = isset($this->params['slug']) ? $this->params['slug'] : '';
        if ($idDescarga) {
            $d = new CtDescarga();
            $d->id_descarga = $idDescarga;
            $d = $d->getOne();
            if (!empty($d)) {
                if (is_file(Doo::conf()->GLOBAL_PATH . $d->imagen)) {
                    unlink(Doo::conf()->GLOBAL_PATH . $d->imagen);
                }
                if (is_file(Doo::conf()->GLOBAL_PATH . $d->url)) {
                    unlink(Doo::conf()->GLOBAL_PATH . $d->url);
                }
                $d->delete();
                header('location:' . Doo::conf()->APP_URL . 'hot-results?success=2');
            } else {
                header('location:' . Doo::conf()->APP_URL . 'hot-results?error=5');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'hot-results?error=5');
        }
    }

    public function obtenerHotResult() {
        session_start();
        $resultado = array();
        if (self::validarSesion() && self::validarPermisos('hot-results')) {
            Doo::loadModel('CtCategoriaDescarga');
            Doo::loadModel('CtDescarga');
            if (isset($this->params['iddescarga'])) {
                $idDescarga = intval($this->params['iddescarga']);

                $descarga = new CtDescarga();
                $descarga->id_descarga = $idDescarga;
                //$descarga = $descarga->getOne();
                $descarga = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "hot-results"', 'limit' => 1));
                if (!empty($descarga)) {
                    $resultado['status'] = 'ok';
                    $arrayDescarga = array();
                    $arrayDescarga['id_descarga'] = intval($descarga->id_descarga);
                    $arrayDescarga['titulo'] = utf8_encode($descarga->titulo);
                    $arrayDescarga['descripcion'] = utf8_encode($descarga->descripcion);
                    $arrayDescarga['imagen'] = Doo::conf()->GLOBAL_URL . $descarga->imagen;
                    $arrayDescarga['url'] = $descarga->url;
                    $resultado['descarga'] = $arrayDescarga;
                } else {
                    $resultado['status'] = 'error';
                    $resultado['msg'] = 'No se encontró el archivo solicitado.';
                }
            }
        } else {
            $resultado['status'] = 'error';
            $resultado['msg'] = 'No tiene permisos para ver la información solicitada.';
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function obtenerHotResults() {
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        //ultimas 10 notificaciones
        $descarga = new CtDescarga();
        $descargas = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "hot-results"', 'desc' => 'fecha_alta', 'limit' => 30));

        $resultado = array();
        if (!empty($descargas)) {
            foreach ($descargas as $d) {
                $desc = array();
                $desc['titulo'] = utf8_encode($d->titulo);
                //$desc['descripcion'] = utf8_encode($d->descripcion);
                $desc['url'] = Doo::conf()->GLOBAL_URL . $d->url;
                $desc['categoria'] = utf8_encode($d->CtCategoriaDescarga->nombre);
                $desc['imagen'] = Doo::conf()->GLOBAL_URL . $d->imagen;
                $desc['fecha'] = $d->fecha_alta;
                array_push($resultado, $desc);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}

?>
