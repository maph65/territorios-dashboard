<?php

/**
 * Se definene los permisos de los usuarios
 *
 * @author Miguel Pérez
 */
class PermisosClass {

    protected static $secciones = array(
        'usuarios' => 'Administrar usuarios',
    );
    protected static $permisosDefinidos = array(
        'usuarios',
    );
    
    static function getArraySecciones(){
        return self::$secciones;
    }

    static function getPermisos($array) {
        $permisos = array();
        if(is_array($array) && !empty($array)){
            foreach (self::$permisosDefinidos as $p) {
                if (in_array($p, $array)) {
                    $permisos[$p] = TRUE;
                }else{
                    $permisos[$p] = FALSE;
                }
            }
        }
        return $permisos;
    }

}

?>
