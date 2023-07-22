<?php
Doo::loadCore('db/DooModel');

class CtLocacionBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_locacion;

    /**
     * @var varchar Max length is 250.
     */
    public $nombre;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_estado;

    /**
     * @var text
     */
    public $html_cotenido;

    /**
     * @var tinyint Max length is 1.
     */
    public $habiltiado;

    public $_table = 'ct_locacion';
    public $_primarykey = 'id_locacion';
    public $_fields = array('id_locacion','nombre','id_estado','html_cotenido','habiltiado');

    public function getVRules() {
        return array(
                'id_locacion' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'nombre' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'id_estado' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                ),

                'html_cotenido' => array(
                        array( 'optional' ),
                ),

                'habiltiado' => array(
                        array( 'integer' ),
                        array( 'maxlength', 1 ),
                        array( 'optional' ),
                )
            );
    }

}