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




//Locaciones
$route['*']['/locaciones'] = array('LocacionesController', 'index');



//Notificaciones
$route['*']['/notificaciones'] = array('NotificacionesController', 'index');
$route['*']['/notificaciones/editar/:idnotificacion'] = array('NotificacionesController', 'editarNotificacion');
$route['post']['/notifcaciones/completa/enviar'] = array('NotificacionesController', 'enviarNotificacionCompleta');
$route['post']['/notificaciones/actualizar/:idnotificacion'] = array('NotificacionesController', 'actualizarNotificacion');
$route['*']['/notificaciones/eliminar/:idnotificacion'] = array('NotificacionesController', 'eliminarNotificacion');

$route['*']['/api/v1/notificacion/obtener/:idnotificacion'] = array('NotificacionesController', 'obtenerNotificacion');

//Herramientas
//catalogos
$route['*']['/catalogos'] = array('CatalogosController', 'index');
$route['post']['/catalogos/agregar'] = array('CatalogosController', 'publicarCatalogos');
$route['*']['/catalogos/eliminar/:iddescarga'] = array('CatalogosController', 'eliminarCatalogo');
$route['*']['/catalogos/editar/:iddescarga'] = array('CatalogosController', 'editarCatalogo');
$route['*']['/catalogos/actualizar/:iddescarga'] = array('CatalogosController', 'actualizarCatalogo');

$route['*']['/api/v1/catalogo/obtener/:iddescarga'] = array('CatalogosController', 'obtenerCatalogo');

//Circulares
$route['*']['/circulares'] = array('CircularesController', 'index');
$route['post']['/circular/agregar'] = array('CircularesController', 'publicarCircular');
$route['*']['/circular/eliminar/:iddescarga'] = array('CircularesController', 'eliminarCircular');
$route['*']['/circular/editar/:iddescarga'] = array('CircularesController', 'editarCircular');
$route['post']['/circular/actualizar/:iddescarga'] = array('CircularesController', 'actualizarCircular');

$route['*']['/api/v1/circulares/obtener/:iddescarga'] = array('CircularesController', 'obtenerCircular');

//HotResults
$route['*']['/hot-results'] = array('HotResultsController', 'index');
$route['post']['/hot-results/agregar'] = array('HotResultsController', 'publicarHotResult');
$route['*']['/hot-results/eliminar/:iddescarga'] = array('HotResultsController', 'eliminarHotResult');
$route['*']['/hot-results/editar/:iddescarga'] = array('HotResultsController', 'editarHotResult');
$route['post']['/hot-results/actualizar/:iddescarga'] = array('HotResultsController', 'actualizarHotResult');

$route['*']['/api/v1/hot-results/obtener/:iddescarga'] = array('CircularesController', 'obtenerHotResult');

//ibooks
$route['*']['/ibooks'] = array('IBooksController', 'index');
$route['post']['/ibook/agregar'] = array('IBooksController', 'publicarIBook');
$route['*']['/ibooks/eliminar/:iddescarga'] = array('IBooksController', 'eliminarIBook');
$route['*']['/ibooks/editar/:iddescarga'] = array('IBooksController', 'editarIBook');
$route['post']['/ibooks/actualizar/:iddescarga'] = array('IBooksController', 'actualizarIBook');
$route['*']['/api/v1/ibooks/obtener/:iddescarga'] = array('IBooksController', 'obtenerIBook');

//ibooks subseccion
$route['*']['/ibooks/:subseccion'] = array('IBooksController', 'index');
$route['post']['/ibook/:subseccion/agregar'] = array('IBooksController', 'publicarIBook');
$route['*']['/ibooks/:subseccion/eliminar/:iddescarga'] = array('IBooksController', 'eliminarIBook');
$route['*']['/ibooks/:subseccion/editar/:iddescarga'] = array('IBooksController', 'editarIBook');
$route['post']['/ibooks/:subseccion/actualizar/:iddescarga'] = array('IBooksController', 'actualizarIBook');


//News
$route['*']['/news-mensual'] = array('NewslettersController', 'newsMensual');
$route['*']['/news-semanal'] = array('NewslettersController', 'newsSemanal');
$route['*']['/news-cliente'] = array('NewslettersController', 'newsClientes');
$route['*']['/news-clientes'] = array('NewslettersController', 'newsClientes');
$route['*']['/news-metacontenidos'] = array('NewslettersController', 'newsMetacontenidos');
$route['post']['/newsletter/agregar'] = array('NewslettersController', 'publicarNewsletter');
$route['*']['/newsletter/eliminar/:iddescarga/:slug'] = array('NewslettersController', 'eliminarNewsletter');
$route['*']['/newsletter/editar/:iddescarga/:slug'] = array('NewslettersController', 'editarNewsletter');
$route['post']['/newsletter/actualizar/:iddescarga/:slug'] = array('NewslettersController', 'actualizarNewsletter');

$route['*']['/api/v1/newsletter/obtener/:iddescarga'] = array('NewslettersController', 'obtenerNewsletter');

//Presentaciones
$route['*']['/presentaciones'] = array('PresentacionesController', 'index');
$route['post']['/presentacion/agregar'] = array('PresentacionesController', 'publicarPresentacion');
$route['*']['/presentacion/eliminar/:iddescarga'] = array('PresentacionesController', 'eliminarPresentacion');
$route['*']['/presentacion/editar/:iddescarga'] = array('PresentacionesController', 'editarPresentacion');
$route['*']['/presentacion/actualizar/:iddescarga'] = array('PresentacionesController', 'actualizarPresentacion');
$route['*']['/api/v1/presentacion/obtener/:iddescarga'] = array('PresentacionesController', 'obtenerPresentacion');

//Presentaciones subseccion
$route['*']['/presentaciones/:subseccion'] = array('PresentacionesController', 'index');
$route['post']['/presentacion/:subseccion/agregar'] = array('PresentacionesController', 'publicarPresentacion');
$route['*']['/presentacion/:subseccion/eliminar/:iddescarga'] = array('PresentacionesController', 'eliminarPresentacion');
$route['*']['/presentacion/:subseccion/editar/:iddescarga'] = array('PresentacionesController', 'editarPresentacion');
$route['*']['/presentacion/:subseccion/actualizar/:iddescarga'] = array('PresentacionesController', 'actualizarPresentacion');


//Videos
$route['*']['/videos'] = array('VideosController', 'index');
$route['*']['/videos/informacion'] = array('VideosController', 'informacionVideo');
$route['post']['/videos/agregar'] = array('VideosController', 'publicarVideo');
$route['*']['/video/eliminar/:iddescarga'] = array('VideosController', 'eliminarVideo');
$route['*']['/api/v1/video/obtener/:iddescarga'] = array('VideosController', 'obtenerVideo');

//Videos subseccion
$route['*']['/videos/:subseccion'] = array('VideosController', 'index');
$route['*']['/videos/:subseccion/informacion'] = array('VideosController', 'informacionVideo');
$route['post']['/videos/:subseccion/agregar'] = array('VideosController', 'publicarVideo');
$route['*']['/video/:subseccion/eliminar/:iddescarga'] = array('VideosController', 'eliminarVideo');

//Parilla
$route['*']['/parrilla'] = array('ParillaController', 'index');
$route['*']['/parrillaAction'] = array('ParillaController', 'uploadParrilla');

//ParillaSubseccion
$route['*']['/parrilla/:subseccion'] = array('ParillaController', 'index');
$route['*']['/parrillaAction/:subseccion'] = array('ParillaController', 'uploadParrilla');

//usuarios
$route['*']['/usuarios'] = array('UsuarioController', 'index');
$route['post']['/usuario/crear'] = array('UsuarioController', 'actionCrearUsuario');
$route['*']['/usuario/eliminar/:idusuario'] = array('UsuarioController', 'eliminarUsuario');

//API
$route['*']['/api/v1/dispositivo/registrar'] = array('DispositivoController', 'registrarDispositivo');
$route['*']['/api/v1/notificaciones/obtener'] = array('NotificacionesController', 'obtenerNotificaciones');
$route['*']['/api/v1/hot-results/obtener'] = array('HotResultsController', 'obtenerHotResults');
$route['*']['/api/v1/newsletters/semanal/obtener'] = array('NewslettersController', 'obtenerNewsSemanal');
$route['*']['/api/v1/newsletters/mensual/obtener'] = array('NewslettersController', 'obtenerNewsMensual');
$route['*']['/api/v1/newsletters/clientes/obtener'] = array('NewslettersController', 'obtenerNewsClientes');
$route['*']['/api/v1/newsletters/metacontenidos/obtener'] = array('NewslettersController', 'obtenerNewsMetacontenidos');
$route['*']['/api/v1/ibooks/obtener'] = array('IBooksController', 'obtenerIBooks');
$route['*']['/api/v1/catalogos/obtener'] = array('CatalogosController', 'obtenerCatalogos');
$route['*']['/api/v1/circulares/obtener'] = array('CircularesController', 'obtenerCirculares');
$route['*']['/api/v1/presentaciones/obtener'] = array('PresentacionesController', 'obtenerPresentaciones');
$route['*']['/api/v1/videos/obtener'] = array('VideosController', 'obtenerVideos');
$route['*']['/api/v1/parilla/obtener'] = array('ParillaController', 'obtenerParilla');

//Networks API
$route['*']['/api/v1/presentaciones/networks/obtener'] = array('PresentacionesController', 'obtenerPresentacionesNetworks');
$route['*']['/api/v1/videos/networks/obtener'] = array('VideosController', 'obtenerVideosNetworks');
$route['*']['/api/v1/parrilla/networks/obtener'] = array('ParillaController', 'obtenerParillaNetworks');
$route['*']['/api/v1/mapa/networks/obtener'] = array('ParillaController', 'obtenerMapaNetworks');

//Parrillas
$route['*']['/api/v1/parrilla/abierta/obtener'] = array('ParillaController', 'obtenerParillaAbierta');
$route['*']['/api/v1/parrilla/paga/obtener'] = array('ParillaController', 'obtenerParillaPaga');

//Regional API
$route['*']['/api/v1/ibooks/regional/obtener'] = array('IBooksController', 'obtenerIBooksRegional');
$route['*']['/api/v1/videos/regional/obtener'] = array('VideosController', 'obtenerVideosRegional');
$route['*']['/api/v1/parrilla/regional/obtener'] = array('ParillaController', 'obtenerParillaRegional');

//APP
$route['*']['/connect/app/install'] = array('MainController', 'connectAppInstall');
$route['*']['/cotizador/app/install'] = array('MainController', 'cotizadorAppInstall');




//generate Models automatically
//$route['*']['/gen_model'] = array('MainController', 'gen_model', 'authName'=>'Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');


?>