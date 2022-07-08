<?php 
session_start(); 
require "../../config.php"; 
include _INCLUDE."class/conexion.php";
$conexion = new conexion(); 

$id_cot = $_POST["id"];
$id_vivienda = $_POST["id_vivienda"];
$id_condominio = $_POST["id_condominio"];
$valor_viv = $_POST["valor_viv"];
$monto_vivienda = $_POST["monto_vivienda"];
$fecha = $_POST["fecha"];
$precio_descuento = $_POST["precio_descuento"];
$forma_pago = $_POST["forma_pago"];
$pie = $_POST["pie"];
$premio = $_POST["premio"];
$aplica_pie = $_POST["aplica_pie"];
$abonoInmobiliario = $_POST["abonoInmobiliario"]; 
/*
$aplica_pie = 1 es abono inmobiliario, osea descuento al pie
$aplica_pie = 2 es descuento al precio total

*/
?>
<div class="row mt-2 proceso">
	<div class="col-md-12">
		<hr>
	</div>
<?php
if (empty($monto_vivienda) || $monto_vivienda > $valor_viv || empty($fecha) || empty($precio_descuento) || empty($forma_pago) || empty($pie) || empty($aplica_pie)) {
    ?>
    <div class="col-sm-12" style="margin-top: 20px;">
        <span class="label label-danger" style="font-size: 16px;">* Falta Información por Completar</span>
        <?php
        if (empty($monto_vivienda)) {
            ?>
            <h6>- Precio Departamento</h6>
            <?php
        }
        if ($monto_vivienda>$valor_viv) {
            ?>
            <h6>- El valor ingresado a la Vivienda no puede ser mayor al de lista.</h6>
            <?php
        }
        if (empty($fecha)) {
            ?>
            <h6>- Fecha</h6>
            <?php
        }
        if (empty($precio_descuento)) {
            ?>
            <h6>- Precio con Descuento</h6>
            <?php
        }
        if (empty($forma_pago)) {
            ?>
            <h6>- Forma de Pago</h6>
            <?php
        }
        if (empty($pie)) {
            ?>
            <h6>- PIE (%)</h6>
            <?php
        }
        if (empty($aplica_pie)) {
            ?>
            <h6>- Descuento Aplica PIE</h6>
            <?php
        }
        ?>
    </div>
    
    <?php
    exit();
}

$monto_estacionamiento = 0;
$monto_bodega = 0;
$total_descuento = 0;
$monto_reserva = 0;
$monto_descuento = 0;

$consulta = "SELECT valor_par FROM parametro_parametro WHERE valor2_par = ? AND id_con = ?";
$conexion->consulta_form($consulta,array(12,$id_condominio));
$fila = $conexion->extraer_registro_unico();
$monto_reserva = utf8_encode($fila['valor_par']);
$fecha_uf = date("Y-m-d",strtotime($fecha));
$consulta = "SELECT valor_uf FROM uf_uf WHERE fecha_uf = ?";
$conexion->consulta_form($consulta,array($fecha_uf));
$cantidad_uf = $conexion->total();
    if($cantidad_uf == 0){
        ?>
        <div class="col-sm-12" style="margin-top: 20px;">
            <span class="label label-info" style="font-size: 16px;">* No existe Uf cargada para la fecha seleccionada. Debe cargar UF para ver el resumen de promesa.</span>
        </div>
        <?php
        exit();
    }
$fila = $conexion->extraer_registro_unico();
$valor_uf = utf8_encode($fila['valor_uf']);
$cantidad_estacionamiento = 0;
$cantidad_bodega = 0;
if( isset($_POST["estacionamiento"])){
	$cantidad_estacionamiento = count($_POST["estacionamiento"]);
}
if( isset($_POST["bodega"])){
	$cantidad_bodega = count($_POST["bodega"]);
}
if($cantidad_estacionamiento > 0){
    $consulta = "SELECT IFNULL(SUM(valor_esta),0) AS suma FROM estacionamiento_estacionamiento WHERE id_esta IN (".implode(',',$_POST["estacionamiento"]).") ";
    $conexion->consulta($consulta);
    $fila = $conexion->extraer_registro_unico();
    $monto_estacionamiento = $fila["suma"];
}
if($cantidad_bodega > 0){
    $consulta = "SELECT IFNULL(SUM(valor_bod),0) AS suma FROM bodega_bodega WHERE id_bod IN (".implode(',',$_POST["bodega"]).") ";
    $conexion->consulta($consulta);
    $fila = $conexion->extraer_registro_unico();
    $monto_bodega = $fila["suma"];
}
if($precio_descuento == 1){//descuento al valor lista parámetro
    $consulta = "SELECT valor_par FROM parametro_parametro WHERE valor2_par = ? AND id_con = ? ";
    $conexion->consulta_form($consulta,array(4,$id_condominio));
    $fila = $conexion->extraer_registro_unico();
    $porcentaje_descuento = $fila['valor_par'];
    $total_precio_descuento = ($valor_viv * $porcentaje_descuento) / 100; //aca usa el valor viv, el original
}
$consulta = "SELECT nombre_for_pag FROM pago_forma_pago WHERE id_for_pag = ? ";
$conexion->consulta_form($consulta,array($forma_pago));
$fila = $conexion->extraer_registro_unico();
$forma_pago = utf8_encode($fila['nombre_for_pag']);

// $consulta = "SELECT valor_pie_ven FROM venta_pie_venta WHERE id_pie_ven = ?";
// $conexion->consulta_form($consulta,array($pie));
// $fila = $conexion->extraer_registro_unico();

$monto_vivienda_total = $valor_viv + $monto_bodega + $monto_estacionamiento;
// $porc_pie = $fila['valor_pie_ven'];
$porc_pie = ($pie * 100) / $monto_vivienda_total;
?>
<div class="col-md-4">
	<?php 
	if ($aplica_pie==1) {
	?>
	<div class="info"><b>Precio Depto:</b> <?php echo number_format($valor_viv, 2, ',', '.'); ?></div>
	<?php
	} else if($aplica_pie==2 && ($precio_descuento == 1)) {
	 ?>
	<div class="info">--</div>
	<?php } else {
	?>
	<div class="info"><b>Precio Depto:</b> <?php echo number_format($monto_vivienda, 2, ',', '.'); ?></div>	
	<?php } ?>	
	<div class="info"><b>Fecha Promesa:</b> <?php echo date("d/m/Y",strtotime($fecha)); ?></div>
	<div class="info"><b>Valor UF:</b> <?php echo number_format($valor_uf, 2, ',', '.'); ?></div>
	<div class="info"><b>% Pie:</b> <?php echo round($porc_pie); ?></div>
<?php

if(!empty($premio)){
    $consulta = "SELECT nombre_pre FROM premio_premio WHERE id_pre = ? ";
    $conexion->consulta_form($consulta,array($premio));
    $fila = $conexion->extraer_registro_unico();
    ?>
    <div class="info">Premio: <?php echo utf8_encode($fila['nombre_pre']);?></div>
	<?php    
}

?>
</div>
<div class="col-md-4">

<?php

if($cantidad_estacionamiento > 0){
	?>
	<h5 class="mb-0">Estacionamientos Adicionales</h5>

	<?php
    // echo "Estacionamientos Adicionales <br>";
    $consulta ="SELECT nombre_esta, valor_esta FROM estacionamiento_estacionamiento WHERE id_esta IN (".implode(',',$_POST["estacionamiento"]).") ";
    $conexion->consulta($consulta);
    $fila_consulta = $conexion->extraer_registro();
    if(is_array($fila_consulta)){
        foreach ($fila_consulta as $fila) {
            $valor_esta = $fila["valor_esta"];
            ?>
			<div class="info"><?php echo utf8_encode($fila['nombre_esta']);?> - <?php echo number_format($valor_esta, 2, ',', '.');?> UF</div>
            <?php           
        }
    }
}
if($cantidad_bodega > 0){
	?>
	<h5 class="mb-0">Bodegas Adicionales</h5>
	<?php
    // echo "Bodegas Adicionales <br>";
    $consulta = "SELECT nombre_bod, valor_bod FROM bodega_bodega WHERE id_bod IN (".implode(',',$_POST["bodega"]).") ";
    $conexion->consulta($consulta);
    $fila_consulta = $conexion->extraer_registro();
    if(is_array($fila_consulta)){
        foreach ($fila_consulta as $fila) {
            $valor_bod = $fila["valor_bod"];
            ?>
			<div class="info"><?php echo utf8_encode($fila['nombre_bod']);?> - <?php echo number_format($valor_bod, 2, ',', '.');?> UF</div>
            <?php            
        }
    }
}

?>

<!-- /////////////////////////////////////////////////    DESCUENTOS Y PIE       /////////////////////////////////////////////////////////////////////////////////////// -->


<h5>Descuentos Y Pié</h5>
<?php

$monto_vivienda_descuento = $monto_vivienda;
$monto_vivienda_descuento_final = $monto_vivienda_descuento + $monto_bodega + $monto_estacionamiento;
//-------- CALCULOS DE MONTOS
if($precio_descuento == 1){  //si aplica precio con descuento
    // echo "DESCUENTOS <br>";
    if($precio_descuento == 1 && $aplica_pie == 1){
        // $total_precio_descuento_peso = $total_precio_descuento * $valor_uf;
        ?>
		<div class="info"><b>Abono Inmobiliaria:</b> <?php echo number_format($abonoInmobiliario, 2, ',', '.');?> UF</div>
        <?php       
    }       
    if($aplica_pie == 2){
        $monto_vivienda_descuento = $valor_viv - $total_precio_descuento - $monto_descuento; //parte del valor real de la vivienda
        ?>
		<div class="info"><b>Monto Depto con Descuentos:</b> <?php echo number_format($monto_vivienda_descuento, 2, ',', '.');?> UF</div>
        <?php
        // echo "Monto Depto con Descuentos ".number_format($monto_vivienda_descuento, 2, ',', '.')." UF <br>";
    }

    $descuentos_pie = $total_precio_descuento + $monto_descuento;

    
} 
//cuando hizo descuento manual
else { 
	if ($valor_viv>$monto_vivienda) {
		$descuento_manual = $valor_viv - $monto_vivienda;
		if($aplica_pie == 1){
		?>
		<div class="info"><b>Abono Inmobiliaria:</b> <?php echo number_format($abonoInmobiliario, 2, ',', '.');?> UF</div>
		<?php
		}
		if($aplica_pie == 2){
	        $monto_vivienda_descuento = $valor_viv - $descuento_manual;
	        ?>
			<div class="info"><b>Monto Depto con Descuento:</b> <?php echo number_format($monto_vivienda_descuento, 2, ',', '.');?> UF</div>
	        <?php	        
	    }

	}
}
if($cantidad_estacionamiento > 0){
	?>
	<div class="info"><b>Monto Total Est. Adicionales:</b> <?php echo number_format($monto_estacionamiento, 2, ',', '.');?> UF</div>
    <?php 
}

if($cantidad_bodega > 0){
	?>
	<div class="info"><b>Monto Total Bodegas Adicionales:</b> <?php echo number_format($monto_bodega, 2, ',', '.');?> UF</div>
    <?php
}



?>
<div class="info"><b>Monto Reserva:</b> <?php echo number_format($monto_reserva, 2, ',', '.');?> UF</div>
<?php
//----- PIE
if($aplica_pie == 1){ //descuenta al pie    
    $monto_pie = $monto_vivienda_total * ($porc_pie / 100);
    $monto_pie_sin_reserva = $monto_pie - $monto_reserva;
	if($precio_descuento == 1){ 
    	$monto_pie_con_descuento = $monto_pie - $descuentos_pie;
    } else {
    	$monto_pie_con_descuento = $monto_pie - $descuento_manual;
    }
	$monto_pie_con_descuento_sin_reserva = $monto_pie_con_descuento - $monto_reserva;
    ?>
    <!-- <div class="info"><b>Monto Pie (sin Reserva):</b> <?php echo number_format($monto_pie_sin_reserva, 2, ',', '.');?> UF</div> -->
	<div class="info"><b>Monto Pie Con Descuento:</b> <?php echo number_format($monto_pie_con_descuento_sin_reserva, 2, ',', '.');?> UF</div>
	<?php
} else { //el pie no tiene descuentos
	$monto_pie = $monto_vivienda_descuento_final * ($porc_pie / 100);
	$monto_pie_sin_reserva = $monto_pie - $monto_reserva;
	?>
	<div class="info"><b>Monto Pie (Sin Reserva):</b> <?php echo number_format($monto_pie_sin_reserva, 2, ',', '.');?> UF</div>
	<?php
}

if ($cantidad_estacionamiento > 0 || $cantidad_bodega > 0) {
	?>
	<div class="info"><b>Valor Venta Total:</b> <?php echo number_format($monto_vivienda_descuento_final, 2, ',', '.');?> UF</div>
	<?php
}
?>
</div>
</div>
<div id="contenedor_boton" class="box-footer">
    <button type="button" class="btn btn-primary pull-right" id="guardar">Pasar a Promesa</button>
</div>