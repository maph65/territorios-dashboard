<?php
Doo::loadCore('db/DooModel');

class CtComentarioBase extends DooModel{

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_comentario;

    /**
     * @var text
     */
    public $comentaro;

    /**
     * @var varchar Max length is 45.
     */
    public $usuario;

    /**
     * @var int Max length is 1.
     */
    public $calificacion;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $id_locacion;

    /**
     * @var varchar Max length is 45.
     */
    public $fecha;

    public $_table = 'ct_comentario';
    public $_primarykey = 'id_comentario';
    public $_fields = array('id_comentario','comentaro','usuario','calificacion','id_locacion','fecha');

    public function getVRules() {
        return array(
                'id_comentario' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'optional' ),
                ),

                'comentaro' => array(
                        array( 'notnull' ),
                ),

                'usuario' => array(
                        array( 'maxlength', 45 ),
                        array( 'notnull' ),
                ),

                'calificacion' => array(
                        array( 'integer' ),
                        array( 'maxlength', 1 ),
                        array( 'optional' ),
                ),

                'id_locacion' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                ),

                'fecha' => array(
                        array( 'maxlength', 45 ),
                        array( 'notnull' ),
                )
            );
    }

}