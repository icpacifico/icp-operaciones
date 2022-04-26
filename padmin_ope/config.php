<?php
date_default_timezone_set('America/Santiago');
// Rutas para referencias
$rutausada = substr($_SERVER['HTTP_HOST'], 0, 3);
if ($rutausada=="www") {
	$inicioruta = "www.";
} else {
	$inicioruta = "";
}

require "parametros.php"; 
if (!defined('_RUTA')) {
	//define('_RUTA', "https://".$inicioruta."00ppsav.cl/");

    //DESARROLLO
	define('_RUTA', "http://localhost/icp-operaciones/");
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
?>
