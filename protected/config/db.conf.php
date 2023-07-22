<?php
$dbmap = array();

//CtEstado
$dbmap['CtEstado']['has_many']['CtLocacion'] = array('foreign_key'=>'id_estado');

//CtLocacion
$dbmap['CtLocacion']['belongs_to']['CtEstado'] = array('foreign_key'=>'id_estado');
$dbmap['CtLocacion']['has_many']['CtComentario'] = array('foreign_key'=>'id_locacion');
$dbmap['CtLocacion']['has_many']['CtMedia'] = array('foreign_key'=>'id_locacion');

//CtLocacion
$dbmap['CtLocacion']['belongs_to']['CtEstado'] = array('foreign_key'=>'id_estado');

//CtComentario
$dbmap['CtComentario']['belongs_to']['CtLocacion'] = array('foreign_key'=>'id_locacion');

//CtMedia
$dbmap['CtMedia']['belongs_to']['CtLocacion'] = array('foreign_key'=>'id_locacion');

//$dbconfig[ Environment or connection name] = array(Host, Database, User, Password, DB Driver, Make Persistent Connection?);

$dbconfig['dev'] = array('localhost', 'territorios_saber', 'root', 'root', 'mysql', true);
$dbconfig['prod'] = array('localhost', 'territorios_saber', 'root', 'root', 'mysql', true);
?>