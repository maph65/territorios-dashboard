<?php

Doo::loadController('SecurityController');

class VideosController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('presentaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        $categoria = new CtCategoriaDescarga();
        $categoria->slug = 'videos';
        //Checamos si es una subseccion
        if(isset($this->params['subseccion'])){
            $subseccion = filter_var($this->params['subseccion'],FILTER_SANITIZE_STRING);
            $categoria->slug = 'videos-'.$subseccion;
        }
        $categoria = $categoria->getOne();
        Doo::loadClass('vimeo-1.2.5/autoload');
        $lib = new \Vimeo\Vimeo(Doo::conf()->VIMEO_CLIENT_ID,Doo::conf()->VIMEO_CLIENT_SECRET);
        $lib->setToken(Doo::conf()->VIMEO_TOKEN);
        $redirect = Doo::conf()->APP_URL.'videos/informacion';
        if(isset($subseccion) && !empty($subseccion)){
            $redirect = Doo::conf()->APP_URL.'videos/'.$subseccion.'/informacion';
        }
        $request = $lib->request('/me/videos',array('type'=>'POST','redirect_url'=> $redirect),'POST');
        $linkSecure = $request['body']['upload_link_secure'];
        if (!empty($categoria) && !empty($linkSecure)) {
            $descargas = new CtDescarga();
            $descargas->id_categoria = $categoria->id_categoria;
            $descargas->habilitado = 1;
            $descargas = $descargas->find(array('desc' => 'fecha_alta', 'limit' => 40));
            $this->data['descargas'] = $descargas;
            $this->data['location'] = 'videos';
            if(isset($subseccion)){
                $this->data['location'] = $subseccion;
                $this->data['sublocation'] = 'videos';
                $this->data['categoria'] = 'videos-'.$this->data['location'];
            }
            $this->data['link'] = $linkSecure;
            $this->renderc('admin/videos', $this->data);
        } else {
            header('location:' . Doo::conf()->APP_URL . 'home?error=1');
        }
    }
    
    public function informacionVideo() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('presentaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        $categoria = new CtCategoriaDescarga();
        $categoria->slug = 'videos';
        //Checamos si es una subseccion
        $subseccion = '';
        if(isset($this->params['subseccion'])){
            $subseccion = filter_var($this->params['subseccion'],FILTER_SANITIZE_STRING);
            $categoria->slug = 'videos-'.$subseccion;
        }
        $categoria = $categoria->getOne();
        Doo::loadClass('vimeo-1.2.5/autoload');
        $lib = new \Vimeo\Vimeo(Doo::conf()->VIMEO_CLIENT_ID,Doo::conf()->VIMEO_CLIENT_SECRET);
        $lib->setToken(Doo::conf()->VIMEO_TOKEN);
        
        $videoValido = FALSE;
        $videoUrl = NULL;
        if(isset($_GET['video_uri']) && !empty($_GET['video_uri'])){
            $request = $lib->request('/me'.$_GET['video_uri'],array(),'GET');
            if(!empty($request) && !isset($request['body']['error'])  && isset($request['body']['files']) && is_array($request['body']['files']) ){
                $video = NULL;
                foreach ($request['body']['files'] as $file){
                    if($file['quality']=='sd' || $file['quality']=='hd'){
                        if(!empty($video)){
                            if(intval($file['width']) > intval($video['width']) ){
                                $video = $file;
                            }
                        }else{
                            $video = $file;
                        }
                    }
                }
                $videoUrl = $video['link'];
                $videoValido = TRUE;
            }
        }        
        if (!empty($categoria) && $videoValido) {
            $this->data['location'] = 'videos';
            if(isset($subseccion) && !empty($subseccion)){
                $this->data['location'] = $subseccion;
                $this->data['sublocation'] = 'videos';
            }
            $this->data['video_uri'] = $videoUrl;
            $this->data['video_uri_https'] = str_replace('http://','//',$videoUrl);
            $this->data['vimeo_uri'] = $_GET['video_uri'];
            $this->renderc('admin/video-informacion', $this->data);
        } else {
            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?error=1');
        }
    }

    public function publicarVideo() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('presentaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        Doo::loadHelper('DooGdImage');
        Doo::loadHelper('DooFile');
        Doo::autoload('DooDbExpression');
        Doo::loadClass('SlugifyClass');
        $subseccion = '';
        if(isset($this->params['subseccion'])){
            $subseccion = filter_var($this->params['subseccion'],FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['vimeo_uri']) && !empty($_POST['vimeo_uri']) 
                && isset($_POST['titulo']) && !empty($_POST['titulo']) 
                && isset($_POST['descripcion']) && !empty($_POST['descripcion']) 
                && isset($_POST['viewport-x']) && !empty($_POST['viewport-x']) 
                && isset($_POST['viewport-y']) && !empty($_POST['viewport-y']) 
                && isset($_FILES['imagen']) && !empty($_FILES['imagen']) 
                && isset($_POST['archivo']) && !empty($_POST['archivo'])
        ) {
            $categoria = new CtCategoriaDescarga();
            $categoria->slug = 'videos';
            if(!empty($subseccion)){
                $categoria->slug = 'videos-'. $subseccion;
            }
            $categoria = $categoria->getOne();
            $uriVideo  = isset($_POST['vimeo_uri']) ? $_POST['vimeo_uri'] : '';
            if (!empty($categoria)) {
                $titulo = self::aUtf8(filter_var($_POST['titulo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW));
                $descripcion = self::aUtf8(strip_tags($_POST['descripcion']));
                
                $archivos = new DooFile(755);
                $gd = new DooGdImage(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/', Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/');
                $gd->generatedQuality = 100;
                if ($gd->checkImageExtension('imagen')) {
                    $nombreArchivo = $categoria->slug . '_' . SlugifyClass::slugify($_FILES['imagen']['name']);
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
                    if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $nombreArchivo . '.' . $archivos->getFileExtensionFromPath($_FILES['imagen']['name']))) {
                        unlink(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $nombreArchivo . '.' . $archivos->getFileExtensionFromPath($_FILES['imagen']['name']));
                    }
                    if (is_file(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType)) {
                        unlink(Doo::conf()->GLOBAL_PATH . 'uploads/' . $categoria->slug . '/' . $thumbName . '.' . $gd->generatedType);
                    }
                    
                    //Guardamos el video
                    if(filter_var($_POST['archivo'],FILTER_VALIDATE_URL)!==FALSE){
                        $urlFinalArchivo = $_POST['archivo'];
                    }else{
                        $urlFinalArchivo =  '';
                    }
                    //Insertamos la info de la descarga
                    Doo::loadClass('vimeo-1.2.5/autoload');
                    $lib = new \Vimeo\Vimeo(Doo::conf()->VIMEO_CLIENT_ID,Doo::conf()->VIMEO_CLIENT_SECRET);
                    $lib->setToken(Doo::conf()->VIMEO_TOKEN);
                    
                    $request = $lib->request($_POST['video_uri'],array('name'=>$titulo,'description'=>$descripcion,'privacy.view'=>'disable'),'PATCH');
                    
                    $descarga = new CtDescarga();
                    $descarga->id_categoria = $categoria->id_categoria;
                    $descarga->titulo = $titulo;
                    $descarga->descripcion = $descripcion;
                    $descarga->url = $urlFinalArchivo;
                    $descarga->imagen = $urlFinalFoto;
                    $descarga->habilitado = 1;
                    $val = $descarga->validate();
                    if (empty($val)) {
                        $result = $descarga->insert();
                        if ($result) {
                            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?success=1');
                        } else {
                            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'/informacion?error=6&video_uri='.$uriVideo);
                        }
                    } else {
                        header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'/informacion?error=5&video_uri='.$uriVideo);
                    }
                } else {
                    header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'/informacion?error=4&video_uri='.$uriVideo);
                }
            } else {
                header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'/informacion?error=2&video_uri='.$uriVideo);
            }
        } else if(isset($_POST['vimeo_uri']) && !empty($_POST['vimeo_uri'])) {
            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'/informacion?error=1&video_uri='.$_POST['vimeo_uri']);
        }else{
            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?error=1');
        }
    }

    public function eliminarVideo() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        if (!self::validarPermisos('presentaciones')) {
            header('location:' . Doo::conf()->APP_URL . 'home');
        }
        $subseccion = '';
        if(isset($this->params['subseccion'])){
            $subseccion = filter_var($this->params['subseccion'],FILTER_SANITIZE_STRING);
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadModel('CtDescarga');
        $idDescarga = isset($this->params['iddescarga']) ? intval($this->params['iddescarga']) : 0;
        if ($idDescarga) {
            $d = new CtDescarga();
            $d->id_descarga = $idDescarga;
            $d = $d->getOne();
            if (!empty($d)) {
                if (is_file(Doo::conf()->GLOBAL_PATH . $d->imagen)) {
                    unlink(Doo::conf()->GLOBAL_PATH . $d->imagen);
                }
                $d->delete();
                header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?success=2');
            } else {
                header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?error=5');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'videos/'.$subseccion.'?error=5');
        }
    }

    public function obtenerVideo() {
        session_start();
        $resultado = array();
        if (self::validarSesion() && self::validarPermisos('presentaciones')) {
            Doo::loadModel('CtCategoriaDescarga');
            Doo::loadModel('CtDescarga');
            if (isset($this->params['iddescarga'])) {
                $idDescarga = intval($this->params['iddescarga']);
                $descarga = new CtDescarga();
                $descarga->id_descarga = $idDescarga;
                //$descarga = $descarga->getOne();
                $descarga = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "videos"', 'limit' => 1));
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
            } else {
                $resultado['status'] = 'error';
                $resultado['msg'] = 'No se encontró el archivo solicitado.';
            }
        } else {
            $resultado['status'] = 'error';
            $resultado['msg'] = 'No tiene permisos para ver la información solicitada.';
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function obtenerVideos() {
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        //ultimas 10 notificaciones
        $descarga = new CtDescarga();
        $descargas = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "videos"  AND habilitado=1', 'desc' => 'fecha_alta', 'limit' => 40));

        $resultado = array();
        if (!empty($descargas)) {
            foreach ($descargas as $d) {
                $desc = array();
                $desc['id'] = $d->id_descarga;
                $desc['titulo'] = utf8_encode($d->titulo);
                $desc['descripcion'] = utf8_encode($d->descripcion);
                $desc['url'] = $d->url;
                $desc['categoria'] = utf8_encode($d->CtCategoriaDescarga->nombre);
                $desc['imagen'] = Doo::conf()->GLOBAL_URL . $d->imagen;
                $desc['fecha'] = $d->fecha_alta;
                array_push($resultado, $desc);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
    
    public function obtenerVideosNetworks() {
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        //ultimas 10 notificaciones
        $descarga = new CtDescarga();
        $descargas = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "videos-networks"  AND habilitado=1', 'desc' => 'fecha_alta', 'limit' => 40));

        $resultado = array();
        if (!empty($descargas)) {
            foreach ($descargas as $d) {
                $desc = array();
                $desc['id'] = $d->id_descarga;
                $desc['titulo'] = utf8_encode($d->titulo);
                $desc['descripcion'] = utf8_encode($d->descripcion);
                $desc['url'] = $d->url;
                $desc['categoria'] = utf8_encode($d->CtCategoriaDescarga->nombre);
                $desc['imagen'] = Doo::conf()->GLOBAL_URL . $d->imagen;
                $desc['fecha'] = $d->fecha_alta;
                array_push($resultado, $desc);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
    
    public function obtenerVideosRegional() {
        Doo::loadModel('CtCategoriaDescarga');
        Doo::loadModel('CtDescarga');
        //ultimas 10 notificaciones
        $descarga = new CtDescarga();
        $descargas = $descarga->relate('CtCategoriaDescarga', array('where' => 'ct_categoria_descarga.slug = "videos-regional"  AND habilitado=1', 'desc' => 'fecha_alta', 'limit' => 40));

        $resultado = array();
        if (!empty($descargas)) {
            foreach ($descargas as $d) {
                $desc = array();
                $desc['id'] = $d->id_descarga;
                $desc['titulo'] = utf8_encode($d->titulo);
                $desc['descripcion'] = utf8_encode($d->descripcion);
                $desc['url'] = $d->url;
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
