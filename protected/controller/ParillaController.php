<?php

Doo::loadController('SecurityController');

class ParillaController extends SecurityController {

    public function index() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $this->data['location'] = 'parillas';
        $subseccion = '';
        if (isset($this->params['subseccion'])) {
            $subseccion = filter_var($this->params['subseccion'], FILTER_SANITIZE_STRING);
            $this->data['location'] = 'parrillas';
            $this->data['sublocation'] = $subseccion;
        }
        $extension = '.xlsx';
        if ($subseccion == 'regional' || $subseccion == 'abierta') {
            $extension = '.pdf';
        }
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrilla' . $subseccion . $extension)) {
            $this->data['excel'] = Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrilla' . $subseccion . $extension;
        }
        $this->renderc('admin/parrilla', $this->data);
    }

    public function uploadParrilla() {
        session_start();
        if (!self::validarSesion()) {
            header('location:' . Doo::conf()->APP_URL . '?error=2');
            session_destroy();
            die();
        }
        $subseccion = '';
        if (isset($this->params['subseccion'])) {
            $subseccion = filter_var($this->params['subseccion'], FILTER_SANITIZE_STRING);
        }
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadHelper('DooFile');
        Doo::loadClass('SlugifyClass');
        if (isset($_FILES['archivo']) && !empty($_FILES['archivo'])) {
            $nombreArchivo = 'parrilla' . $subseccion;
            $archivo = new DooFile(755);
            $extension = 'xlsx';
            if ($subseccion == 'regional' || $subseccion == 'abierta') {
                $extension = 'pdf';
            }
            if ($archivo->checkFileExtension('archivo', array($extension))) {
                $extension = '.' . $extension;
                //Guardamos el archivo
                if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/' . $nombreArchivo . $extension)) {
                    unlink(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/' . $nombreArchivo . $extension);
                }
                $result = $archivo->upload(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/', 'archivo', $nombreArchivo);
                //print_r($result);
                if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/' . $nombreArchivo . $extension)) {
                    header('location:' . Doo::conf()->APP_URL . 'parrilla/' . $subseccion . '?success=1');
                } else {
                    header('location:' . Doo::conf()->APP_URL . 'parrilla/' . $subseccion . '?error=3');
                }
            } else {
                header('location:' . Doo::conf()->APP_URL . 'parrilla/' . $subseccion . '?error=2');
            }
        } else {
            header('location:' . Doo::conf()->APP_URL . 'parrilla/' . $subseccion . '?error=1');
        }
    }

    public function obtenerParilla() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrilla.xlsx')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrilla.xlsx');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

    public function obtenerParillaNetworks() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrillanetworks.xlsx')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrillanetworks.xlsx');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

    public function obtenerMapaNetworks() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/mapa/mapanetworks.jpg')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/mapa/mapanetworks.jpg');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

    public function obtenerParillaRegional() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrillaregional.pdf')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrillaregional.pdf');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

    public function obtenerParillaPaga() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrillapaga.xlsx')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrillapaga.xlsx');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

    public function obtenerParillaAbierta() {
        if (file_exists(Doo::conf()->GLOBAL_PATH . 'uploads/parrilla/parrillaabierta.pdf')) {
            header('Location:' . Doo::conf()->GLOBAL_URL . 'uploads/parrilla/parrillaabierta.pdf');
        } else {
            echo 'No se encontr&oacute; el archivo solicitado.';
        }
    }

}

?>
