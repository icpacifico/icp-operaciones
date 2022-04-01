<?php
session_start();
date_default_timezone_set('America/Santiago');
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: "._ADMIN."index.php");
    exit();
}
// if(!isset($_SESSION["modulo_evento_panel"])){
//     header("Location: "._ADMIN."panel.php");
//     exit();
// }
if(!isset($_POST["valor"])){
	header("Location: "._ADMIN."index.php");
	exit();
}

include("../class/evento_clase.php");
$evento = new evento();
$id = isset($_POST["valor"]) ? htmlentities(utf8_decode($_POST["valor"])) : 0;
$evento->evento_update_estado($id);
$jsondata['envio'] = 1;
echo json_encode($jsondata);
exit();
?>