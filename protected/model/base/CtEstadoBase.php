<?php
Doo::loadCore('db/DooModel');

class CtEstadoBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_estado;

    /**
     * @var varchar Max length is 120.
     */
    public $nombre;

    /**
     * @var varchar Max length is 3.
     */
    public $codigo;

    public $_table = 'ct_estado';
    public $_primarykey = 'id_estado';
    public $_fields = array('id_estado','nombre','codigo');

    public function getVRules() {
        return array(
                'id_estado' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'nombre' => array(
                        array( 'maxlength', 120 ),
                        array( 'notnull' ),
                ),

                'codigo' => array(
                        array( 'maxlength', 3 ),
                        array( 'optional' ),
                )
            );
    }

}