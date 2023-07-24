<?php
Doo::loadCore('db/DooModel');

class CtAutorBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_autor;

    /**
     * @var varchar Max length is 250.
     */
    public $nombre;

    /**
     * @var text
     */
    public $bilografia;

    /**
     * @var varchar Max length is 250.
     */
    public $url_foto;

    public $_table = 'ct_autor';
    public $_primarykey = 'id_autor';
    public $_fields = array('id_autor','nombre','bilografia','url_foto');

    public function getVRules() {
        return array(
                'id_autor' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'nombre' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'bilografia' => array(
                        array( 'optional' ),
                ),

                'url_foto' => array(
                        array( 'maxlength', 250 ),
                        array( 'optional' ),
                )
            );
    }

}