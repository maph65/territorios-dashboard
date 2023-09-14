<?php
/**
 * Define your URI routes here.
 *
 * $route[Request Method][Uri] = array( Controller class, action method, other options, etc. )
 *
 * RESTful api support, *=any request method, GET PUT POST DELETE
 * POST 	Create
 * GET      Read
 * PUT      Update, Create
 * DELETE 	Delete
 *
 */
 //---------- Delete if not needed ------------
$admin = array('admin'=>'crexr3crexr3');

$route['*']['/'] = array('MainController', 'login');
$route['*']['/loginAction'] = array('UsuarioController', 'loginAction');
$route['*']['/logout'] = array('UsuarioController', 'logoutAction');

$route['*']['/home'] = array('MainController', 'home');

$route['*']['/error'] = array('ErrorController', 'index');

//$route['*']['/test'] = array('MainController', 'test');
//$route['*']['/test2'] = array('MainController', 'test2');
$route['*']['/genmodel'] = array('MainController', 'gen_model');

//autores
$route['*']['/autores'] = array('AutoresController', 'index');
$route['*']['/autores/:idautor'] = array('AutoresController', 'editarAutor');
$route['*']['/autores/nuevo'] = array('AutoresController', 'nuevoAutor');
$route['post']['/autores/nuevo/crear'] = array('AutoresController', 'guardarAutor');
$route['*']['/autores/editar/:idautor'] = array('AutoresController', 'editarAutor');
$route['get']['/autores/eliminar/:idautor'] = array('AutoresController', 'eliminarAutor');

//Locaciones
$route['*']['/locaciones'] = array('LocacionesController', 'index');
$route['*']['/locaciones/estado/:idestado'] = array('LocacionesController', 'locacionesPorEstado');
$route['*']['/locaciones/galeria/:idlocacion'] = array('LocacionesController', 'administrarGaleria');
$route['*']['/locaciones/agregar'] = array('LocacionesController', 'nuevaLocacion');
$route['post']['/locaciones/guardar'] = array('LocacionesController', 'guardarLocacion');
$route['get']['/locaciones/editar/:idlocacion'] = array('LocacionesController', 'editarLocacion');
$route['get']['/locaciones/eliminar/:idlocacion'] = array('LocacionesController', 'eliminarLocacion');
$route['post']['/galeria/publicar/:idlocacion'] = array('LocacionesController', 'subirImagenes');
$route['get']['/galeria/eliminar/:idmedia'] = array('LocacionesController', 'eliminarImagen');

//API
$route['get']['/api/v1/get-locaciones'] = array('ApiController', 'getLocaciones');
$route['get']['/api/v1/get-locaciones/:codigo'] = array('ApiController', 'getLocacionesByEstado');
$route['*']['/api/v1/search/locaciones'] = array('ApiController', 'getLocacionesByString');

//usuarios
$route['*']['/usuarios'] = array('UsuarioController', 'index');
$route['post']['/usuario/crear'] = array('UsuarioController', 'actionCrearUsuario');
$route['*']['/usuario/eliminar/:idusuario'] = array('UsuarioController', 'eliminarUsuario');


?>