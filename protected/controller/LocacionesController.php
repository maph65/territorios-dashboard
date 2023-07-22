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
        Doo::loadModel('CtLocacion');
        Doo::loadModel('CtUsuario');
        $this->data['usr'] = unserialize($_SESSION['usuario']);
        $locationsCountQuery = 'SELECT e.id_estado, e.nombre, COUNT(l.id_locacion) as cantidad FROM ct_estado e LEFT JOIN ct_locacion l ON l.id_estado = e.id_estado GROUP BY e.id_estado';
        $this->data['estados']  = Doo::db()->fetchAll($locationsCountQuery);
        $this->data['categorias'] =  array();
        $this->data['notificaciones'] =  array();
        $this->data['location'] = 'locaciones';
        $this->renderc('admin/locaciones', $this->data);
    }


}

?>
