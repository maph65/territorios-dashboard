<?php

Doo::loadController('SecurityController');

class NotificacionesController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('notificaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaNotificacion');
        Doo::loadModel('CtNotificacion');
        $categorias = CtCategoriaNotificacion::_find('CtCategoriaNotificacion');
        //ultimas 10 notificaciones
        $notificacion = new CtNotificacion();
        $notificaciones = $notificacion->relate('CtCategoriaNotificacion', array('desc' => 'fecha'));
        $this->data['categorias'] = (!empty($categorias)) ? $categorias : array();
        $this->data['notificaciones'] = (!empty($notificaciones)) ? $notificaciones : array();
        $this->data['location'] = 'notificaciones';
        $this->renderc('admin/notificaciones', $this->data);
    }

    public function editarNotificacion() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('notificaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaNotificacion');
        Doo::loadModel('CtNotificacion');
        $categorias = CtCategoriaNotificacion::_find('CtCategoriaNotificacion');

        $notificacion = new CtNotificacion();
        $notificacion->id_notificacion = intval($this->params['idnotificacion']);
        $notificacion = $notificacion->getOne();
        $this->data['categorias'] = (!empty($categorias)) ? $categorias : array();
        if (!empty($notificacion)) {
            $this->data['notificacion'] = $notificacion;
            $this->data['location'] = 'notificaciones';
            $this->renderc('admin/editar/notificaciones', $this->data);
        } else {
            header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=5');
        }
    }

    public function enviarNotificacionCompleta() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('notificaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtNotificacion');
        Doo::loadModel('CtDispositivo');
        Doo::loadHelper('DooGdImage');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('APNSClass');
        Doo::loadClass('SlugifyClass');
        if (isset($_POST['categoria']) && !empty($_POST['categoria']) && isset($_POST['mensaje']) && isset($_POST['titulo']) && !empty($_POST['titulo']) && isset($_POST['contenido']) && !empty($_POST['contenido']) && isset($_POST['viewport-x']) && !empty($_POST['viewport-x']) && isset($_POST['viewport-y']) && !empty($_POST['viewport-y']) && isset($_FILES['imagen']) && !empty($_FILES['imagen'])
        ) {
            $categoria = intval($_POST['categoria']);
            $mensajeSinCodificar = strip_tags($_POST['mensaje']);
            $mensaje = self::aUtf8(filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW));
            //$titutlo = self::aUtf8(filter_var($_POST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW));
            $titutlo = self::aUtf8(strip_tags($_POST['titulo']));
            $contenido = self::aUtf8(strip_tags($_POST['contenido']));

            $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/', Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/');
            $gd->generatedQuality = 100;
            if ($gd->checkImageExtension('imagen')) {
                $rndText = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $nombreArchivo = 'notificacion_' . SlugifyClass::slugify($_FILES['imagen']['name']);
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
                $resizeName = $nombreArchivo . '_thumb_400x720_'.$rndText;
                $gd->adaptiveResizeCropExcess($thumbName . '.' . $gd->generatedType, 720, 400, $resizeName);
                $urlFinalFoto = 'uploads/notificaciones/' . $resizeName . '.' . $gd->generatedType;
                //Eliminamos las iamgenes que ya no usaremos
                if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $nombreArchivo)) {
                    unlink(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $$nombreArchivo);
                }
                if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $thumbName . '.' . $gd->generatedType)) {
                    unlink(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $thumbName . '.' . $gd->generatedType);
                }
                $notificacion = new CtNotificacion();
                $notificacion->id_categoria = $categoria;
                $notificacion->titulo = $titutlo;
                $notificacion->mensaje = $mensaje;
                $notificacion->detalles = $contenido;
                $notificacion->imagen = $urlFinalFoto;
                $val = $notificacion->validate();
                if (empty($val)) {
                    $result = $notificacion->insert();
                    if ($result) {
                        if (isset($_POST['enviar']) && !empty($_POST['enviar']) && !empty($mensajeSinCodificar)) {
                            $dispositivos = new CtDispositivo();
                            $dispositivos->activo = 1;
                            $dispositivos = $dispositivos->find();
                            APNSClass::enviarMensaje($mensajeSinCodificar, $dispositivos);
                        }
                        header('location:' . Doo::conf()->APP_URL . 'notificaciones?success=1');
                    } else {
                        header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=4');
                    }
                } else {
                    header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=3');
                }
            } else {
                header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=2');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=1');
        }
    }

    public function actualizarNotificacion() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('notificaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        Doo::loadModel('CtNotificacion');
        $this->data['usr'] = unserialize($_SESSION['usuario']);

        $notificacion = new CtNotificacion();
        $notificacion->id_notificacion = intval($this->params['idnotificacion']);
        $notificacion = $notificacion->getOne();
        if (!empty($notificacion)) {
            Doo::loadHelper('DooGdImage');
            Doo::autoload('DooDbExpression');
            Doo::loadClass('SlugifyClass');
            $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria'])) ? intval($_POST['categoria']) : $notificacion->id_categoria;
            $mensaje = (isset($_POST['mensaje']) && !empty($_POST['mensaje'])) ? self::aUtf8(filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW)) : $notificacion->mensaje;
            $titutlo = (isset($_POST['titulo']) && !empty($_POST['titulo'])) ? self::aUtf8(strip_tags($_POST['titulo'])) : $notificacion->titulo;
            $contenido = (isset($_POST['contenido']) && !empty($_POST['contenido'])) ? self::aUtf8(strip_tags($_POST['contenido'])) : $notificacion->detalles;

            if (isset($_FILES) && !empty($_FILES['imagen'])) {
                $rndText = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/', Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/');
                $gd->generatedQuality = 100;
                if ($gd->checkImageExtension('imagen')) {
                    $nombreArchivo = 'notificacion_' . SlugifyClass::slugify($_FILES['imagen']['name']);
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
                    $resizeName = $nombreArchivo . '_thumb_400x720_'.$rndText;
                    $gd->adaptiveResizeCropExcess($thumbName . '.' . $gd->generatedType, 720, 400, $resizeName);
                    $urlFinalFoto = 'uploads/notificaciones/' . $resizeName . '.' . $gd->generatedType;
                    //Eliminamos las iamgenes que ya no usaremos
                    if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $nombreArchivo)) {
                        unlink(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $$nombreArchivo);
                    }
                    if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $thumbName . '.' . $gd->generatedType)) {
                        unlink(Doo::conf()->GLOBAL_PATH . 'uploads/notificaciones/' . $thumbName . '.' . $gd->generatedType);
                    }
                }else{
                    $urlFinalFoto = $notificacion->imagen;
                }
            }else{
                $urlFinalFoto = $notificacion->imagen;
            }
            $notificacion->id_categoria = $categoria;
            $notificacion->titulo = $titutlo;
            $notificacion->mensaje = $mensaje;
            $notificacion->detalles = $contenido;
            $notificacion->imagen = $urlFinalFoto;
            $val = $notificacion->validate();
            if (empty($val)) {
                $result = $notificacion->update();
                if ($result) {//actualización exitosa
                    header('location:' . Doo::conf()->APP_URL . 'notificaciones?success=3');
                } else {//No se actualizó ningún registro
                    header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=4');
                }
            } else {//No pasó la validación
                header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=3');
            }
        } else {//No se encontró la notificacion
            header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=5');
        }
    }

    public function eliminarNotificacion() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('notificaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtNotificacion');
        $idNotificacion = isset($this->params['idnotificacion']) ? intval($this->params['idnotificacion']) : 0;
        if ($idNotificacion) {
            $n = new CtNotificacion();
            $n->id_notificacion = $idNotificacion;
            $n = $n->getOne();
            if (!empty($n)) {
                if (is_file(Doo::conf()->GLOBAL_PATH . $n->imagen)) {
                    unlink(Doo::conf()->GLOBAL_PATH . $n->imagen);
                }
                $n->delete();
                header('location:' . Doo::conf()->APP_URL . 'notificaciones?success=2');
            } else {
                header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=5');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'notificaciones?error=5');
        }
    }

    public function obtenerNotificacion() {
        session_start();
        $resultado = array();
        if (self::validarSesion() && self::validarPermisos('notificaciones')) {
            Doo::loadModel('CtCategoriaNotificacion');
            Doo::loadModel('CtNotificacion');
            if (isset($this->params['idnotificacion'])) {
                $idNotificacion = intval($this->params['idnotificacion']);
                $notificacion = new CtNotificacion();
                $notificacion->id_notificacion = $idNotificacion;
                $notificacion = $notificacion->getOne();
                if (!empty($notificacion)) {
                    $resultado['status'] = 'ok';
                    //$resultado['notificacion'] = $notificacion;
                    $arrayNotificacion = array();
                    $arrayNotificacion['id_notificacion'] = intval($notificacion->id_notificacion);
                    $arrayNotificacion['titulo'] = utf8_encode($notificacion->titulo);
                    $arrayNotificacion['descripcion'] = utf8_encode($notificacion->detalles);
                    $arrayNotificacion['imagen'] = $notificacion->imagen;
                    $arrayNotificacion['id_categoria'] = $notificacion->id_categoria;
                    $resultado['descarga'] = $arrayNotificacion;
                } else {
                    $resultado['status'] = 'error';
                    $resultado['msg'] = 'No se encontró la notificación solicitada.';
                }
            }
        } else {
            $resultado['status'] = 'error';
            $resultado['msg'] = 'No tiene permisos para ver la información solciitada.';
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function obtenerNotificaciones() {
        Doo::loadModel('CtCategoriaNotificacion');
        Doo::loadModel('CtNotificacion');
        //ultimas 10 notificaciones
        $notificacion = new CtNotificacion();
        $notificaciones = $notificacion->relate('CtCategoriaNotificacion', array('desc' => 'fecha', 'limit' => 20));

        $resultado = array();
        if (!empty($notificaciones)) {
            foreach ($notificaciones as $n) {
                $notif = array();
                $notif['id'] = $n->id_notificacion;
                $notif['titulo'] = utf8_encode($n->titulo);
                $notif['contenido'] = utf8_encode($n->detalles);
                $notif['categoria'] = utf8_encode($n->CtCategoriaNotificacion->nombre);
                $notif['imagen'] = Doo::conf()->GLOBAL_URL . $n->imagen;
                $notif['fecha'] = $n->fecha;
                $notif['seccion'] = utf8_encode($n->CtCategoriaNotificacion->slug);
                array_push($resultado, $notif);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

}

?>
