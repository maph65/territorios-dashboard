<?php
Doo::loadCore('db/DooModel');

class CtUsuarioBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_usuario;

    /**
     * @var varchar Max length is 60.
     */
    public $correo;

    /**
     * @var varchar Max length is 70.
     */
    public $nombre;

    /**
     * @var varchar Max length is 128.
     */
    public $passwd;

    /**
     * @var tinyint Max length is 4.
     */
    public $activo;

    /**
     * @var text
     */
    public $permisos;

    public $_table = 'ct_usuario';
    public $_primarykey = 'id_usuario';
    public $_fields = array('id_usuario','correo','nombre','passwd','activo','permisos');

    public function getVRules() {
        return array(
                'id_usuario' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'correo' => array(
                        array( 'maxlength', 60 ),
                        array( 'notnull' ),
                ),

                'nombre' => array(
                        array( 'maxlength', 70 ),
                        array( 'notnull' ),
                ),

                'passwd' => array(
                        array( 'maxlength', 128 ),
                        array( 'notnull' ),
                ),

                'activo' => array(
                        array( 'integer' ),
                        array( 'maxlength', 4 ),
                        array( 'notnull' ),
                ),

                'permisos' => array(
                        array( 'optional' ),
                )
            );
    }

}