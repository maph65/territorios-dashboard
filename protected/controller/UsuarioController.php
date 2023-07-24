<?php

/**
 * En este controlador se maneja el alta, baja y modificacion de los usuario del sistema
 *
 * @author miguelperez
 */
Doo::loadController('SecurityController');

class UsuarioController extends SecurityController {

    public function index() {
        session_start(); 
        if(!self::validarSesion()){
            header('location:'.Doo::conf()->APP_URL.'?error=2');
            session_destroy();
            die();
        }
        if(!self::validarPermisos('usuarios')){
            header('location:'.Doo::conf()->APP_URL.'home');
        }
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        Doo::loadClass('PermisosClass');
        Doo::loadModel('CtUsuario');
        $usuarios = new CtUsuario();
        $this->data['usuarios'] = $usuarios->find();
        $this->data['permisos'] = PermisosClass::getArraySecciones();
        $this->data['location'] = 'usuarios';
        $this->renderc('admin/usuarios', $this->data);
    }

    public function actionCrearUsuario() {
        session_start();
        if(!self::validarSesion()){
            header('location:'.Doo::conf()->APP_URL.'?error=2');
            session_destroy();
            die();
        }
        if(!self::validarPermisos('usuarios')){
            header('location:'.Doo::conf()->APP_URL.'home');
        }
        if (isset($_POST) && 
                isset($_POST['email']) && !empty($_POST['email']) &&
                isset($_POST['passwd']) && !empty($_POST['passwd']) &&
                isset($_POST['passwdconf']) && !empty($_POST['passwdconf']) &&
                isset($_POST['nombre']) && !empty($_POST['nombre'])  &&
                isset($_POST['permisos']) && !is_null($_POST['permisos']) && is_array($_POST['permisos']) ) {
            Doo::loadModel('CtUsuario');
            Doo::loadClass('EncriptadoClass');
            $usr = new CtUsuario();
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $usr->correo = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                $findUsr = $usr->getOne();
                if (empty($findUsr)) {
                    if(strcmp($_POST['passwdconf'], $_POST['passwd'])===0){
                        Doo::loadClass('PermisosClass');
                        $usr->passwd = EncriptadoClass::encriptar($_POST['passwd']);
                        $usr->nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
                        $usr->permisos = serialize(PermisosClass::getPermisos($_POST['permisos']));
                        $usr->insert();
                        header('location:'.Doo::conf()->APP_URL.'usuarios?success=1');
                    }else{
                        header('location:'.Doo::conf()->APP_URL.'usuarios?error=4');
                    }
                } else {
                    header('location:'.Doo::conf()->APP_URL.'usuarios?error=3');
                }
            } else {
                header('location:'.Doo::conf()->APP_URL.'usuarios?error=2');
            }
        } else {
            header('location:'.Doo::conf()->APP_URL.'usuarios?error=1');
        }
    }
    
    public function eliminarUsuario(){
        session_start(); 
        if(!self::validarSesion()){
            header('location:'.Doo::conf()->APP_URL.'?error=2');
            session_destroy();
            die();
        }        
        if(!self::validarPermisos('usuarios')){
            header('location:'.Doo::conf()->APP_URL.'home');
        }Doo::loadModel('CtUsuario');
        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = intval($this->params['idusuario']);
        if($usuario->id_usuario != $idUsuario ){
            $u = new CtUsuario();
            $u->id_usuario = $idUsuario;
            $u->delete();
            header('location:'.Doo::conf()->APP_URL.'usuarios?delete=success');
        }else{
            header('location:'.Doo::conf()->APP_URL.'usuarios?delete=error');
        }
    }


    public function loginAction() {
        session_start();
        if (isset($_POST) && isset($_POST['email']) && isset($_POST['passwd'])) {
            Doo::loadModel('CtUsuario');
            Doo::loadClass('EncriptadoClass');
            $usr = new CtUsuario();
            $usr->correo = strip_tags(addslashes($_POST['email']));
            $findUsr = $usr->getOne();
            if (!empty($findUsr)) {
                $pwd = $findUsr->passwd;
                $salId = EncriptadoClass::obtenerSalId($findUsr->passwd);
                $pwdIngresado = EncriptadoClass::encriptar($_POST['passwd'], $salId);
                if ($pwdIngresado == $pwd) {
                    $_SESSION['usuario'] = serialize($findUsr);
                    //$_SESSION['tkn'] = EncriptadoClass::tokenizarSesion();
                    header('location:' . Doo::conf()->APP_URL . 'locaciones');
                } else {
                    session_destroy();
                    header('location:' . Doo::conf()->APP_URL . '?error=1');
                }
            } else {
                session_destroy();
                header('location:' . Doo::conf()->APP_URL . '?error=1');
            }
        } else {
            session_destroy();
            header('location:' . Doo::conf()->APP_URL . '?error=1');
        }
    }

    public function logoutAction() {
        session_start();
        session_destroy();
        header('location:' . Doo::conf()->APP_URL . '?logout=success');
    }

}
