<?php

Doo::loadController('SecurityController');
class MainController extends SecurityController {

    public function login() {
        session_start();
        if(self::validarSesion()){
            header('location:'.Doo::conf()->APP_URL.'home');
        }else{
            session_destroy();
            $this->renderc('login');
        }
    }
    
    
    public function home() {
        session_start();
        if(!self::validarSesion()){
            header('location:'.Doo::conf()->APP_URL.'?error=2');
            session_destroy();
            die();
        }
        Doo::loadModel('CtUsuario'); 
        $usuario = unserialize($_SESSION['usuario']);
        $permisos = isset($usuario->permisos) ? unserialize($usuario->permisos) : array();
        //print_r($permisos);
        $home = 'locaciones';
        if(!is_null($home)){
            header('location:'.Doo::conf()->APP_URL.$home);
        }else{
            header('location:'.Doo::conf()->APP_URL.'logout');
        }
    }
    
    
    public function connectAppInstall() {
        //$this->renderc('apps/appConnect');
        header('location:'.Doo::conf()->APP_URL.'appstore/');
    }
    
    public function cotizadorAppInstall() {
        //$this->renderc('apps/appCotizador');
        header('location:'.Doo::conf()->APP_URL.'appstore/');
    }

    public function gen_model() {
        Doo::loadCore('db/DooModelGen');
        DooModelGen::genMySQL();
    }
    
    

}

?>