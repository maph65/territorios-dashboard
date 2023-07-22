<?php

/**
 * Description of DispositivoController
 *
 * @author miguelperez
 */
class DispositivoController extends DooController {

    public function registrarDispositivo() {
        $devicetkn = NULL;
        $result = array();
        $_DATA = json_decode(file_get_contents("php://input"), TRUE);
        if (isset($_POST['devicetoken']) && !empty($_POST['devicetoken'])) {
            $devicetkn = strip_tags(addslashes($_POST['devicetoken']));
        }else if(isset($_GET['devicetoken']) && !empty($_GET['devicetoken']) ){
            $devicetkn = strip_tags(addslashes($_GET['devicetoken']));
        }else if(isset($_DATA['devicetoken']) && !empty($_DATA['devicetoken']) ){
            $devicetkn = strip_tags(addslashes($_DATA['devicetoken']));
        }
        if(!is_null($devicetkn)){
            Doo::loadModel('CtDispositivo');
            $dispositivo = new CtDispositivo();
            $dispositivo->token = $devicetkn;
            $fDispositivo = $dispositivo->getOne();
            if(empty($fDispositivo)){
                $dispositivo->activo = 1;
                $dispositivo->insert();
            }else{
                Doo::loadCore('db/DooDbExpression');
                $fDispositivo->activo = 1;
                $fDispositivo->ultimo_update = new DooDbExpression('NOW()');
                $fDispositivo->update();
            }
            $result = array('status'=>'ok','mensaje'=>'Se registro exitosamente el token.');
        }else{
            $result = array('status'=>'error','mensaje'=>'No se recibio el token.');
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

}
