<?php

/**
 * Controlador con métodos estáticos privados que proveen validación y seguridad de la sesión
 *
 * @author miguelperez
 */
class SecurityController extends DooController {

    protected static function validarSesion() {
        Doo::loadClass('EncriptadoClass');
        Doo::loadModel('CtUsuario');
        if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario']) /*&& isset($_SESSION['tkn']) && EncriptadoClass::tokenEsValido($_SESSION['tkn'])*/) {
            //$_SESSION['tkn'] = EncriptadoClass::tokenizarSesion();
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    protected static function validarPermisos($seccion){
        Doo::loadModel('CtUsuario');
        $usr = unserialize($_SESSION['usuario']);
        $permisos = isset($usr->permisos) ?  unserialize($usr->permisos) : array();
        if(isset($permisos[$seccion])){
            return $permisos[$seccion];
        }else{
            return FALSE;
        }
    }
    
    protected static function aUtf8($string){
        $string = strip_tags($string);
        if (class_exists('Normalizer') && !Normalizer::isNormalized($string,Normalizer::FORM_C)) {
            $string = Normalizer::normalize($string,  Normalizer::FORM_C);
        }
        return utf8_decode($string);
    }

}
