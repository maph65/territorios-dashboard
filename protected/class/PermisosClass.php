<?php

/**
 * Se definene los permisos de los usuarios
 *
 * @author Miguel Pérez
 */
class PermisosClass {

    protected static $secciones = array(
        /*'notificaciones' => 'Enviar notificaciones',
        'news-semanal' => 'Newsletter semanales',
        'news-mensual' => 'Newsletter Mensual',
        'news-metacontenidos' => 'Metacontenidos',
        'news-clientes' => 'Newsletter a clientes',
        'ibooks' => 'iBooks',
        'presentaciones' => 'Presentaciones',
        'circulares' => 'Circulares',
        'catalogos' => 'Catálogos',
        'hot-results' => 'Hot+Results',*/
        'usuarios' => 'Administrar usuarios',
    );
    protected static $permisosDefinidos = array(
        /*'notificaciones',
        'news-semanal',
        'news-mensual',
        'news-metacontenidos',
        'news-clientes',
        'ibooks',
        'presentaciones',
        'circulares',
        'catalogos',
        'hot-results',*/
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
