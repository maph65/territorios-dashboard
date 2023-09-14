<?php
date_default_timezone_set('America/Mexico_City');

$config= array();

$config['APP_NAME'] = 'Territorios del Saber';

$config['APP_COOKIE_NAME'] = 'territoriosapp';

//PATHS FOR DEVELOPMENT
$config['DEV_SITE_PATH'] = realpath('..').'/territorios-dashboard/';
$config['DEV_BASE_PATH'] = realpath('..').'/territorios-dashboard/dooframework/';

//PATHS FOR PRODUCTION
$config['PROD_SITE_PATH'] = realpath('..').'/territorios-dashboard/';
$config['PROD_BASE_PATH'] = realpath('..').'/territorios-dashboard/dooframework/';


//for production mode use 'prod'
$config['APP_MODE'] = 'dev';

if($config['APP_MODE']== 'prod'){
    error_reporting(0);
    $config['SITE_PATH'] = $config['PROD_SITE_PATH'];
    $config['BASE_PATH'] = $config['PROD_BASE_PATH'];
    $config['SUBFOLDER'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/',$config['SITE_PATH']));
    if(strpos($config['SUBFOLDER'], '/')!==0){
            $config['SUBFOLDER'] = '/'.$config['SUBFOLDER'];
    }
    $config['APP_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$config['SUBFOLDER'];
    $config['AUTOROUTE'] = TRUE;
    $config['DEBUG_ENABLED'] = FALSE;
}else{
    error_reporting(E_ALL | E_STRICT);
    $config['SITE_PATH'] = $config['DEV_SITE_PATH'];
    $config['BASE_PATH'] = $config['DEV_BASE_PATH'];    
    $config['SUBFOLDER'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/',$config['SITE_PATH']));
    if(strpos($config['SUBFOLDER'], '/')!==0){
            $config['SUBFOLDER'] = '/'.$config['SUBFOLDER'];
    }
    $config['APP_URL'] = 'http://'.$_SERVER['HTTP_HOST'].$config['SUBFOLDER'];
    $config['AUTOROUTE'] = TRUE;
    $config['DEBUG_ENABLED'] = TRUE;
}


$config['LOG_PATH'] = $config['SITE_PATH'].'var/logs/';

$config['GLOBAL_PATH'] = $config['SITE_PATH'].'global/';
$config['VIEW_PATH'] = $config['SITE_PATH'].'protected/view/';
$config['VIEWC_PATH'] = $config['SITE_PATH'].'protected/viewc/';

$config['GLOBAL_URL'] = $config['APP_URL'].'global/';

//ERROR PAGES
$config['ERROR_404_ROUTE'] = '/error';


//FRAMEWORKS SETTINGS
//$config['TEMPLATE_COMPILE_ALWAYS'] = TRUE;

/**
 * for benchmark purpose, call Doo::benchmark() for time used.
 */
//$config['START_TIME'] = microtime(true);

//Session information
$lifetime = 60*60*24*365;
session_set_cookie_params($lifetime);
session_name($config['APP_COOKIE_NAME']);
//setcookie(session_name(),session_id(), time() + $lifetime);
