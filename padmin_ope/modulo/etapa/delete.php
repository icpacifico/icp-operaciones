<?
session_start();
require "../../config.php"; 
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: "._ADMIN."index.php");
    exit();
}
if (!isset($_SESSION["modulo_etapa_panel"])) {
    header("Location: "._ADMIN."panel.php");
    exit();
}
if(!isset($_POST["valor"])){
	header("Location: "._ADMIN."index.php");
	exit();
}
include("../class/etapa_clase.php");
$etapa = new etapa();
$id = $_POST["valor"];
$etapa->etapa_delete($id);
$jsondata['envio'] = 1;
echo json_encode($jsondata);
exit();
?>