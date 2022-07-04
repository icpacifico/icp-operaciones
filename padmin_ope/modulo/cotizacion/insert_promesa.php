<?php
session_start();
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: "._ADMIN."index.php");
    exit();
}
// if(!isset($_SESSION["modulo_cotizacion_panel"])){
//     header("Location: "._ADMIN."panel.php");
//     exit();
// }
if(!isset($_POST["id"])){
	header("Location: "._ADMIN."index.php");
	exit();
}

include("../class/cotizacion_clase.php");
$cotizacion = new cotizacion();

$id = isset($_POST["id"]) ? utf8_encode($_POST["id"]) : 0;
$fecha = isset($_POST["fecha"]) ? utf8_decode($_POST["fecha"]) : "0000-00-00 00:00:00";
$hora = date(" H:i:s");
$fecha = date("Y-m-d  H:i:s",strtotime($fecha." ".$hora));
$id_vivienda = $_POST["id_vivienda"];
$id_condominio = $_POST["id_condominio"];
$monto_vivienda = $_POST["monto_vivienda"];
$precio_descuento = $_POST["precio_descuento"];
$porcentaje_descuento = $_POST["porcentaje_descuento"];
$forma_pago = $_POST["forma_pago"];
$pie = $_POST["pie"];
$premio = $_POST["premio"];
$aplica_pie = $_POST["aplica_pie"]; 
$id_pro = $_POST["id_pro"]; 
$monto_reserva = $_POST["monto_reserva"]; 
$valor_viv = $_POST["valor_viv"];
$estado_venta = 4;
$id_ban = 0;
$id_tip_pag = 0;
$descuento = 0;
$descuento_adicional = 0;
$descuento_manual = $valor_viv - $monto_vivienda;
$descuento_precio = 0;
$monto_estacionamiento = 0;
$cantidad_estacionamiento = 0;
$monto_bodega = 0;
$cantidad_bodega = 0;
$tiene_promesa = $cotizacion->valida_venta_unica($id_vivienda);

if($tiene_promesa>0){
	$jsondata['envio'] = 5;
	echo json_encode($jsondata);
	exit();
}

if (empty($premio)) $premio = 0;
// DESCUENTOS

if($precio_descuento == 1) $descuento_precio = ($valor_viv * $porcentaje_descuento) / 100;

if ($descuento_manual>0) { //cuando usa manual no usa el otro
	$descuento_ven = $descuento_manual;
} else {
	$descuento_ven = $descuento_precio + $descuento_adicional;
}

if($aplica_pie == 2){
    $monto_vivienda_descuento = $valor_viv - $descuento_ven;
}
else{
	$monto_vivienda_descuento = $valor_viv;
}


if(isset($_POST["estacionamiento"])) $cantidad_estacionamiento = count($_POST["estacionamiento"]);
if(isset($_POST["bodega"])) $cantidad_bodega = count($_POST["bodega"]);
if($cantidad_estacionamiento > 0) $monto_estacionamiento = $cotizacion->cotizacion_estacionamiento($_POST["estacionamiento"]);
if($cantidad_bodega > 0) $monto_bodega = $cotizacion->cotizacion_bodega($_POST["bodega"]);
// este es el valor total, con los adcionales
$monto_vivienda_descuento_total = $monto_vivienda_descuento + $monto_estacionamiento + $monto_bodega;
//----- PIE
$valor_pie = $cotizacion->cotizacion_pie($pie);
$monto_pie = $monto_vivienda_descuento_total * ($valor_pie / 100);
$monto_pie_sin_reserva = $monto_pie - $monto_reserva;

if($aplica_pie == 2){ //no aplica
	$pie_cancelado = $monto_pie_sin_reserva;
	$pie_cobrar = 0;
}
else{
	$monto_pie_con_descuento = $monto_pie_sin_reserva - $descuento_ven; //le resta el descuento que traiga
	$pie_cancelado = $monto_pie_con_descuento;
	$pie_cobrar = 0;
}

$cotizacion->cotizacion_insert_venta($id_vivienda,$id_pro,$id_ban,$pie,$forma_pago,$descuento,$premio,$aplica_pie,$id_tip_pag,$estado_venta,$fecha,$fecha,$monto_reserva,$descuento_manual,$descuento_precio,$descuento_adicional,$descuento_ven,$pie_cancelado,$pie_cobrar,$monto_estacionamiento,$monto_bodega,$valor_viv,$monto_vivienda,$monto_vivienda_descuento_total,$id,$precio_descuento);
$id_venta = $cotizacion->recupera_venta_id();
if($cantidad_estacionamiento > 0) $cotizacion->cotizacion_insert_estacionamiento($id_vivienda,$id_venta,$_POST["estacionamiento"]);
if($cantidad_bodega > 0) $cotizacion->cotizacion_insert_bodega($id_vivienda,$id_venta,$_POST["bodega"]);


$jsondata['envio'] = 1;
echo json_encode($jsondata);
exit();
?>