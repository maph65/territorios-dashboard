<?php
Doo::loadCore('db/DooModel');

class CtMediaBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_media;

    /**
     * @var varchar Max length is 250.
     */
    public $ruta;

    /**
     * @var varchar Max length is 50.
     */
    public $tipo;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_locacion;

    public $_table = 'ct_media';
    public $_primarykey = 'id_media';
    public $_fields = array('id_media','ruta','tipo','id_locacion');

    public function getVRules() {
        return array(
                'id_media' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'ruta' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'tipo' => array(
                        array( 'maxlength', 50 ),
                        array( 'notnull' ),
                ),

                'id_locacion' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                )
            );
    }

}