<?php
date_default_timezone_set('America/Santiago');
// Rutas para referencias
/*
	$MOD : sera el toquen que cambiara según el ambiente
	1) .- es para el ambiente de produccion
	2) .- es para el ambiente de pruebas
	3) .- es para el ambiente de desarrollo 
*/
$MOD = 1; 


$rutausada = substr($_SERVER['HTTP_HOST'], 0, 3);
if ($rutausada=="www") {
	$inicioruta = "www.";
} else {
	$inicioruta = "";
}

require "parametros.php"; 

// Definición de rutas globales
if (!defined('_RUTA')) {

	switch ($MOD) {
		case 1:
			// Produccion.
			define('_RUTA', "https://".$inicioruta."00ppsav.cl/");
			break;
		case 2:
			// Pruebas.
			define('_RUTA', "http://".$inicioruta."test.00ppsav.cl/");
			break;
		case 3:
			// Desarrollo.
			define('_RUTA', "http://localhost/icp-operaciones/");
			break;
		default:
			die();
			break;
	}	   
}
// Obtención del nombre de dominio
if(!defined('_DOMINIO')){
	$protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', _RUTA));
	if($MOD){
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

// token de sendgrid
if (!defined('_ACCESS_TOKEN')) {
	define('_ACCESS_TOKEN','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');
}

// PARAMETROS DE BASE DE DATOS
switch ($MOD) {
	case 1:
		// Produccion.
		if(!defined('_SERVER')) define('_SERVER','localhost');
		if(!defined('_USER')) define('_USER','root');
		if(!defined('_PASS')) define('_PASS','Proyectarse2022!!');
		if(!defined('_DB')) define('_DB','ppsavcl_ssoopp_digital');
		break;
	case 2:
		// Pruebas.
		if(!defined('_SERVER')) define('_SERVER','localhost');
		if(!defined('_USER')) define('_USER','root');
		if(!defined('_PASS')) define('_PASS','Proyectarse2022!!');	
		if(!defined('_DB')) define('_DB','ppsavcl_ssoopp_digital_test');
		break;
	case 3:
		// Desarrollo.
		if(!defined('_SERVER')) define('_SERVER','localhost');
		if(!defined('_USER')) define('_USER','root');
		if(!defined('_PASS')) define('_PASS','');	
		if(!defined('_DB')) define('_DB','ppsavcl_ssoopp_digital');
		break;
	default:
		die();
		break;
}


// $_SESSION["sesion_perfil_panel"]
// 	1:administrador
//  2:Jefe Ventas
// 	3:Operaciones
// 	4:propietario -> vendedor
// 	6:contabilidad
// 	7:Operaciones


?>