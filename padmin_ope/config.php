<?php
date_default_timezone_set('America/Santiago');
// Rutas para referencias

$PROD = true; // si es falso, entrara en modo de desarrollo

$rutausada = substr($_SERVER['HTTP_HOST'], 0, 3);
if ($rutausada=="www") {
	$inicioruta = "www.";
} else {
	$inicioruta = "";
}

require "parametros.php"; 

// Definición de rutas globales
if (!defined('_RUTA')) {
	// PRODUCCIÓN
	if($PROD){
	  define('_RUTA', "https://".$inicioruta."00ppsav.cl/");
	}else{
	  //DESARROLLO
	  define('_RUTA', "http://localhost/icp-operaciones/");
	}   
}
// Obtención del nombre de dominio
if(!defined('_DOMINIO')){
	$protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', _RUTA));
	if($PROD){
		define('_DOMINIO', $url[0]);
	}else{
		define('_DOMINIO', $url[0].'/'.$url[1]);
	}
}
if (!defined('_ADMIN')) {
	define('_ADMIN', _RUTA."padmin_ope/");
}
if (!defined('_ASSETS')) {
	define('_ASSETS', _ADMIN."assets/");
}
if (!defined('_MODULO')) {
	define('_MODULO', _ADMIN."modulo/"); 
}
// esta es para los include o require
if (!defined('_INCLUDE')) {
	define('_INCLUDE',dirname(__FILE__) . '/');
}

// PARAMETROS DE BASE DE DATOS
if($PROD){
	if(!defined('_SERVER')) define('_SERVER','localhost');
	if(!defined('_USER')) define('_USER','root');
	if(!defined('_PASS')) define('_PASS','Proyectarse2022!!');
	if(!defined('_DB')) define('_DB','ppsavcl_ssoopp_digital');
}else{
	
	// if(!defined('_SERVER')) define('_SERVER','144.202.84.205');
	if(!defined('_SERVER')) define('_SERVER','localhost');
	if(!defined('_USER')) define('_USER','root');
	if(!defined('_PASS')) define('_PASS','');
	// if(!defined('_PASS')) define('_PASS','Proyectarse2022!!');
	if(!defined('_DB')) define('_DB','ppsavcl_ssoopp_digital');
}



?>