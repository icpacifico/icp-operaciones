<?php 
session_start(); 
require "../../config.php"; 
include _INCLUDE."class/conexion.php";
$conexion = new conexion();

$fecha_desde = $_POST["fecha_desde"];
$fecha_hasta = $_POST["fecha_hasta"];
$mes = $_POST["mes"];
$anio = $_POST["anio"];
$condominio = $_POST["condominio"];

$_SESSION["sesion_fecha_desde_liquidacion_panel"] = $fecha_desde;
$_SESSION["sesion_fecha_hasta_liquidacion_panel"] = $fecha_hasta;
$_SESSION["sesion_mes_liquidacion_panel"] = $mes;
$_SESSION["sesion_anio_liquidacion_panel"] = $anio;
// $_SESSION["sesion_condominio_liquidacion_panel"] = $condominio;


$fecha_uf = date("Y-m-d",strtotime($fecha_hasta));

$mes_desde_liq = date("m",strtotime($fecha_desde));
$mes_hasta_liq = date("m",strtotime($fecha_hasta));

function get_uf_disistimiento($id_ven){

	$conexion = new conexion();

	// echo $id_ven;

	$consulta = 
	    "
	    SELECT
	        id_cie
	    FROM
	        cierre_venta_cierre
	    WHERE
	        id_ven = ?
	    ";
	$conexion->consulta_form($consulta,array($id_ven));
	$fila = $conexion->extraer_registro_unico();
	$id_cie = $fila["id_cie"];

	$consulta = 
	    "
	    SELECT
	        fecha_hasta_cie
	    FROM
	        cierre_cierre
	    WHERE
	        id_cie = ?
	    ";
	$conexion->consulta_form($consulta,array($id_cie));
	$fila = $conexion->extraer_registro_unico();
	$fecha_hasta_cie = $fila["fecha_hasta_cie"];

	$consulta = 
	    "
	    SELECT
	        valor_uf
	    FROM
	        uf_uf
	    WHERE
	        fecha_uf = ?
	    ";
	$conexion->consulta_form($consulta,array($fecha_hasta_cie));
	$fila = $conexion->extraer_registro_unico();
	$valor_uf_desistimiento = utf8_encode($fila['valor_uf']);

	return $valor_uf_desistimiento;

}

// echo $mes_desde_liq." ".$mes_hasta_liq;
// $consulta = 
//     "
//     SELECT
//         valor2_par,
//         valor_par
//     FROM
//         parametro_parametro
//     WHERE
//         id_con = ? AND
//         valor2_par IN (13,15)
//     ";
// $conexion->consulta_form($consulta,array($condominio));
// $fila_consulta = $conexion->extraer_registro();
// if(is_array($fila_consulta)){
//     foreach ($fila_consulta as $fila) {
//         if($fila['valor2_par'] == 13){
//             $porcentaje_bono_precio_jefe = $fila['valor_uf'];
//         }
//         else{
//             $porcentaje_bono_precio_supervisor = $fila['valor_uf'];
//         }
//     }
// }



// $consulta = 
//     "
//     SELECT
//         nombre_con
//     FROM
//         condominio_condominio
//     WHERE
//         id_con = ?
//     ";
// $conexion->consulta_form($consulta,array($condominio));
// $fila = $conexion->extraer_registro_unico();
// $nombre_con = utf8_encode($fila['nombre_con']);

$consulta = 
    "
    SELECT
        valor_uf
    FROM
        uf_uf
    WHERE
        fecha_uf = ?
    ";
$conexion->consulta_form($consulta,array($fecha_uf));
$cantidad_uf = $conexion->total();
$fila = $conexion->extraer_registro_unico();
$valor_uf = utf8_encode($fila['valor_uf']);
if($cantidad_uf == 0){
    ?>
    <div class="col-xs-12">
        <h4>
            UF no se encuentra cargada en la fecha de cierre seleccionada
        </h4>
    </div>
    <?php
    exit();
}

$UF_LIQUIDACION = $valor_uf;
?>
<div class="col-xs-12">
    <h2 class="page-header">
        <i class="fa fa-cog"></i> Liquidación Ventas
        <small class="pull-right">Período: <?php echo $mes;?>/<?php echo $anio;?> | Desde: <?php echo date("d-m-Y",strtotime($fecha_desde));?> Hasta: <?php echo date("d-m-Y",strtotime($fecha_hasta));?> | Valor UF: $<?php echo number_format($valor_uf, 2, ',', '.');?>.-</small>
    </h2>
</div>

<?php 
$consulta = 
    "
    SELECT
        id_cie
    FROM
        cierre_cierre
    WHERE
        id_mes = ? AND
        anio_cie = ? 
    ";
$conexion->consulta_form($consulta,array($mes,$anio));
$cantidad_cierre = $conexion->total();
if($cantidad_cierre > 0){
    ?>
    <div class="col-xs-12">
        <h4>
            Período se encuentra cerrado
        </h4>
    </div>
    <?php
    exit();
}
$arreglo_vendedor = array();
//--------- VENDEDOR ---------

$fecha_desde_ant = date('Y-m-d',strtotime ( '-1 day' , strtotime ($fecha_desde)));

$fecha_desde_consulta = date("Y-m-d 23:59:59",strtotime($fecha_desde_ant));
$fecha_hasta_consulta = date("Y-m-d 23:59:59",strtotime($fecha_hasta));


// $consulta = 
//     "
//     SELECT
//         vend.id_vend,
//         vend.nombre_vend,
//         vend.apellido_paterno_vend,
//         vend.apellido_materno_vend,
//         tor.id_con,
//         con.nombre_con,
//         cat_vend.id_cat_vend,
//         cat_vend.nombre_cat_vend
//     FROM
//         vendedor_vendedor AS vend
//         INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
//         INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
//         INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
//         INNER JOIN condominio_condominio AS con ON con.id_con = tor.id_con
//         INNER JOIN vendedor_categoria_vendedor AS cat_vend ON cat_vend.id_cat_vend = vend.id_cat_vend
//         INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
//     WHERE
//         ven.fecha_ven > '".$fecha_desde_consulta."' AND
//     	ven.fecha_ven <= '".$fecha_hasta_consulta."' AND
//         his.id_est_ven IN (4,6) AND NOT EXISTS
//         (
//         SELECT
//             b.id_ven
//         FROM
//             cierre_venta_cierre AS b
//         WHERE
//             b.id_ven = ven.id_ven AND
//             b.id_est_ven = his.id_est_ven
//         )
//     GROUP BY 
//         vend.id_vend,
//         vend.nombre_vend,
//         vend.apellido_paterno_vend,
//         vend.apellido_materno_vend,
//         con.nombre_con,
//         cat_vend.id_cat_vend,
//         tor.id_con
//     ";

// $condo = 6;

$arreglo_vendedores_operacion = array();

$consulta_vend_activos = 
    "
    SELECT
        id_vend
    FROM
        vendedor_vendedor
    WHERE
        id_est_vend = 1
    ";
$conexion->consulta($consulta_vend_activos);
$fila_consulta = $conexion->extraer_registro();
if(is_array($fila_consulta)){
    foreach ($fila_consulta as $fila) {
        if(!in_array($fila["id_vend"],$arreglo_vendedor)){
            $arreglo_vendedores_operacion[$fila["id_vend"]] = $fila["id_vend"];
        }
    }
}

$consulta_condominios = 
    "
    SELECT
        id_con,
        nombre_con
    FROM
        condominio_condominio
    WHERE
        id_est_con = 1 AND
        id_con > 3
    ";
$conexion->consulta($consulta_condominios);
$cantidad_cond = $conexion->total();

$cantidad_venta_totales = 0;

$fila_consulta = $conexion->extraer_registro();
if(is_array($fila_consulta)){
    foreach ($fila_consulta as $fila_cond) {

    	$condo = $fila_cond['id_con'];
    	$nombre_con = utf8_encode($fila_cond['nombre_con']);

    	$consulta = 
		    "
		    SELECT
		        vend.id_vend,
		        vend.nombre_vend,
		        vend.apellido_paterno_vend,
		        vend.apellido_materno_vend,
		        tor.id_con,
		        con.nombre_con,
		        cat_vend.id_cat_vend,
		        cat_vend.nombre_cat_vend
		    FROM
		        vendedor_vendedor AS vend
		        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		        INNER JOIN condominio_condominio AS con ON con.id_con = tor.id_con
		        INNER JOIN vendedor_categoria_vendedor AS cat_vend ON cat_vend.id_cat_vend = vend.id_cat_vend
		        INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		    WHERE
		    	ven.fecha_promesa_ven <= '".$fecha_hasta_consulta."' AND
		    	con.id_con = ".$condo." AND
		    	vend.id_est_vend = 1 AND 
		        his.id_est_ven IN (4,6) AND NOT EXISTS
		        (
		        SELECT
		            b.id_ven
		        FROM
		            cierre_venta_cierre AS b
		        WHERE
		            b.id_ven = ven.id_ven AND
		            b.id_est_ven = his.id_est_ven
		        )
		    GROUP BY 
		        vend.id_vend,
		        vend.nombre_vend,
		        vend.apellido_paterno_vend,
		        vend.apellido_materno_vend,
		        con.nombre_con,
		        cat_vend.id_cat_vend,
		        tor.id_con
		    ";
		$conexion->consulta($consulta);
		$cantidad_venta = $conexion->total();
		if($cantidad_venta > 0){
			$cantidad_venta_totales++;
		    ?>
		    <div class="col-sm-12">
		        <h4>Vendedores</h4>
		    </div>
		    <?php

		    $fila_consulta = $conexion->extraer_registro();
		    if(is_array($fila_consulta)){
		        foreach ($fila_consulta as $fila) {
		            if(!in_array($fila["id_vend"],$arreglo_vendedor)){
		                $arreglo_vendedor[$fila["id_vend"]] = $fila["id_vend"];
		            }


		            $consulta = 
		                "
		                SELECT
		                    valor2_par,
		                    valor_par
		                FROM
		                    parametro_parametro
		                WHERE
		                    id_con = ? AND
		                    valor2_par IN (1,2,3,8)
		                ";
		            $conexion->consulta_form($consulta,array($fila['id_con']));
		            $fila_consulta = $conexion->extraer_registro();
		            if(is_array($fila_consulta)){
		                foreach ($fila_consulta as $fila_par) {
		                    if($fila_par['valor2_par'] == 8){
		                        $porcentaje_comision_usuario = $fila_par['valor_par'];
		                    }
		                    else{
		                        if($fila_par['valor2_par'] == $fila['id_cat_vend']){
		                            $porcentaje_multiplo_categoria = $fila_par['valor_par'];
		                        }
		                    }
		                }
		            }
		            $porcentaje_comision_usuario = $porcentaje_comision_usuario * $porcentaje_multiplo_categoria;
		            ?>
		            <div class="col-sm-12 table-responsive">
		                <table class="table table-striped table-bordered">
		                    <tr>
		                        <td colspan="12"><?php echo $nombre_con; ?> - <?php echo utf8_encode($fila['nombre_vend']." ".$fila['apellido_paterno_vend']." ".$fila['apellido_materno_vend']);?> - <?php echo utf8_encode($fila['nombre_cat_vend']); ?> - <?php echo number_format($porcentaje_comision_usuario, 3, ',', '.');?></td>
		                    </tr>
		                    <tr class="font-weight-bold">
		                        <td colspan="3"></td>
		                        <td colspan="5" class="text-center">Comisiones</td>
		                        <td colspan="3" class="text-center">Bono al Precio</td>
		                        <td></td>
		                    </tr>
		                    <tr class="active font-weight-bold">
		                        <td>Unidad</td>
		                        <td>Cliente</td>
		                        <td>Valor Venta</td>
		                        <td>Comisión</td>
		                        <td>Comisión Promesa UF</td>
		                        <td>Comisión Promesa $</td>
		                        <td>Comisión Escritura UF</td>
		                        <td>Comisión Escritura $</td>
		                        <td>B. Precio</td>
		                        <td>B. Precio Promesa</td>
		                        <td>B. Precio Escritura</td>
		                        <td>Desistimiento</td>
		                    </tr>
		                    <?php 
		                    $arreglo_modelo = array(); 
		                    $monto_acumulado_a_pagar = 0;
		                    // PROMESAS
		                    $consulta = 
		                        "
		                        SELECT
		                            vend.id_vend,
		                            vend.nombre_vend,
		                            vend.apellido_paterno_vend,
		                            vend.apellido_materno_vend,
		                            his.id_est_ven,
		                            ven.monto_ven,
		                            CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                            ven.promesa_monto_comision_ven,
		                            ven.escritura_monto_comision_ven,
		                            ven.total_comision_ven,
		                            ven.promesa_bono_precio_ven,
		                            ven.escritura_bono_precio_ven,
		                            ven.total_bono_precio_ven,
		                            viv.id_mod,
		                            viv.nombre_viv,
		                            uf.valor_uf,
		                            ven.id_pie_abo_ven,
		                            ven.descuento_ven,
		                            ven.id_ven
		                        FROM
		                            vendedor_vendedor AS vend
		                            INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                            INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                            INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                            INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                            INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                            INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                        WHERE
		                            tor.id_con = ? AND
		                            vend.id_vend = ? AND
		                            ven.fecha_promesa_ven > '".$fecha_desde_consulta."' AND
		                            ven.fecha_promesa_ven <= '".$fecha_hasta_consulta."' AND
		                            his.id_est_ven IN (4) AND NOT EXISTS
		                            (
		                            SELECT
		                                b.id_ven
		                            FROM
		                                cierre_venta_cierre AS b
		                            WHERE
		                                b.id_ven = ven.id_ven AND
		                                b.id_est_ven = his.id_est_ven
		                            ) AND NOT EXISTS
		                            (
		                            SELECT
		                                des_ven.id_ven
		                            FROM
		                                venta_desestimiento_venta AS des_ven
		                            WHERE
		                                des_ven.id_ven = ven.id_ven
		                            )
		                            
		                        ";
		                    

		                    $conexion->consulta_form($consulta,array($fila['id_con'],$fila['id_vend']));
		                    $fila_consulta_detalle = $conexion->extraer_registro();
		                    $contador_promesa = 0;
		                    if(is_array($fila_consulta_detalle)){
		                        foreach ($fila_consulta_detalle as $fila_det) {
		                            // revisar valor de la venta
							        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
							        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
							        } else {
							        	$monto_ven_comision = $fila_det['monto_ven'];
							        }

							        $comision_promesa_red = floor($fila_det['promesa_monto_comision_ven'] * 1000) / 1000;
							        $comision_promesa_red = round($comision_promesa_red, 2);

							        $monto_comision_promesa = round($comision_promesa_red * $UF_LIQUIDACION);


		                            // $monto_comision_escritura = round($fila_det['escritura_monto_comision_ven'] * $fila_det['valor_uf']);
		                            $monto_bono_promesa = round($fila_det['promesa_bono_precio_ven'] * $UF_LIQUIDACION);
		                            // $monto_bono_escritura = round($fila_det['escritura_bono_precio_ven'] * $fila_det['valor_uf']);
							        ?>
		                            <tr>
		                                <td><?php echo utf8_encode($fila_det['nombre_viv']);?> <?php echo $fila_det['id_ven']; ?></td>
		                                <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                <td>UF <?php echo number_format($monto_ven_comision, 3, ',', '.');?></td>
		                                <td><?php echo number_format($fila_det['total_comision_ven'], 3, ',', '.');?></td>
		                                <?php  
		                                
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_promesa;
		                                $contador_promesa++;
		                                $arreglo_modelo[$fila_det['id_mod']] = $arreglo_modelo[$fila_det['id_mod']] + 1;

		                                ?>
		                                <td><?php echo $comision_promesa_red;?></td>
		                                <td><?php echo number_format($monto_comision_promesa, 0, ',', '.');?></td>
		                                <td>0,00</td>
		                                <td>0</td>
		                                    
		                                
		                                <td><?php echo number_format($fila_det['total_bono_precio_ven'], 3, ',', '.');?></td>
		                                <?php  
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_promesa;
		                                ?>
		                                <td><?php echo number_format($fila_det['promesa_bono_precio_ven'], 3, ',', '.');?> ($<?php echo number_format($monto_bono_promesa, 0, ',', '.');?>.-)</td>
		                                <td>0,00 ($0.-)</td>
		                                <td>---</td>
		                            </tr>
		                            <?php
		                        }
		                    }

		                    // ESCRITURAS
		                    $consulta = 
		                        "
		                        SELECT
		                            vend.id_vend,
		                            vend.nombre_vend,
		                            vend.apellido_paterno_vend,
		                            vend.apellido_materno_vend,
		                            his.id_est_ven,
		                            ven.monto_ven,
		                            CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                            ven.promesa_monto_comision_ven,
		                            ven.escritura_monto_comision_ven,
		                            ven.total_comision_ven,
		                            ven.promesa_bono_precio_ven,
		                            ven.escritura_bono_precio_ven,
		                            ven.total_bono_precio_ven,
		                            viv.id_mod,
		                            viv.nombre_viv,
		                            uf.valor_uf,
		                            ven.id_pie_abo_ven,
		                            ven.descuento_ven,
		                            ven.id_ven
		                        FROM
		                            vendedor_vendedor AS vend
		                            INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                            INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                            INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                            INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                            INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                            INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                        WHERE
		                            tor.id_con = ? AND
		                            vend.id_vend = ? AND
		                            ven.fecha_escritura_ven > '".$fecha_desde_consulta."' AND
		                            ven.fecha_escritura_ven <= '".$fecha_hasta_consulta."' AND
		                            his.id_est_ven IN (6) AND NOT EXISTS
		                            (
		                            SELECT
		                                b.id_ven
		                            FROM
		                                cierre_venta_cierre AS b
		                            WHERE
		                                b.id_ven = ven.id_ven AND
		                                b.id_est_ven = his.id_est_ven
		                            ) AND NOT EXISTS
		                            (
		                            SELECT
		                                des_ven.id_ven
		                            FROM
		                                venta_desestimiento_venta AS des_ven
		                            WHERE
		                                des_ven.id_ven = ven.id_ven
		                            )
		                        ";
		                    

		                    $conexion->consulta_form($consulta,array($fila['id_con'],$fila['id_vend']));
		                    $fila_consulta_detalle = $conexion->extraer_registro();
		                    
		                    if(is_array($fila_consulta_detalle)){
		                        foreach ($fila_consulta_detalle as $fila_det) {
		                            // revisar valor de la venta
							        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
							        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
							        } else {
							        	$monto_ven_comision = $fila_det['monto_ven'];
							        }
							        $comision_escritura_red = floor($fila_det['escritura_monto_comision_ven'] * 1000) / 1000;
							        $comision_escritura_red = round($comision_escritura_red, 2);

							        // $monto_comision_promesa = round($fila_det['promesa_monto_comision_ven'] * $fila_det['valor_uf']);
		                            $monto_comision_escritura = round($comision_escritura_red * $UF_LIQUIDACION);
		                            // $monto_bono_promesa = round($fila_det['promesa_bono_precio_ven'] * $fila_det['valor_uf']);
		                            $monto_bono_escritura = round($fila_det['escritura_bono_precio_ven'] * $UF_LIQUIDACION);
		                            ?>

		                            <tr>
		                                <td><?php echo utf8_encode($fila_det['nombre_viv']);?> <?php echo $fila_det['id_ven']; ?></td>
		                                <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                <td>UF <?php echo number_format($monto_ven_comision, 3, ',', '.');?></td>
		                                <td><?php echo number_format($fila_det['total_comision_ven'], 3, ',', '.');?></td>
		                                <?php  
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_escritura;
		                                ?>
		                                <td>0,00</td>
		                                <td>0</td>
		                                <td><?php echo $comision_escritura_red;?></td>
		                                <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>
		                                
		                                
		                                <td><?php echo number_format($fila_det['total_bono_precio_ven'], 3, ',', '.');?></td>
		                                <?php  
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_escritura;
		                                ?>
		                                <td>0,00 ($0.-)</td>
		                                <td><?php echo number_format($fila_det['escritura_bono_precio_ven'], 3, ',', '.');?> ($<?php echo number_format($monto_bono_escritura, 0, ',', '.');?>.-)</td>
		                                <td>---</td>
		                            </tr>
		                            <?php
		                        }
		                    }


		                    // DESISTIMIENTOS
		                    ?>
		                    
		                    
		                    <tr>
		                        <td class="active" colspan="12"><b>Desistimiento</b></td>
		                    </tr>
		                    <?php  
		                    $total_desistimiento_acumulado = 0;
		                    $consulta = 
		                        "
		                        SELECT
		                            vend.id_vend,
		                            vend.nombre_vend,
		                            vend.apellido_paterno_vend,
		                            vend.apellido_materno_vend,
		                            ven.id_ven,
		                            CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                            ven.id_est_ven,
		                            ven.monto_ven,
		                            ven.promesa_monto_comision_ven,
		                            ven.escritura_monto_comision_ven,
		                            ven.total_comision_ven,
		                            ven.promesa_bono_precio_ven,
		                            ven.escritura_bono_precio_ven,
		                            ven.total_bono_precio_ven,
		                            viv.nombre_viv,
		                            uf.valor_uf
		                        FROM
		                            vendedor_vendedor AS vend
		                            INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                            INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                            INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                            INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                            INNER JOIN venta_desestimiento_venta AS des_ven ON des_ven.id_ven = ven.id_ven
		                            -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
		                            INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                        WHERE
		                            tor.id_con = ? AND
		                            vend.id_vend = ? AND
		                            des_ven.fecha_des_ven > '".$fecha_desde_consulta."' AND
		                            des_ven.fecha_des_ven <= '".$fecha_hasta_consulta."' AND
		                            des_ven.id_tip_des = 1 AND
		                            ven.id_est_ven = 3 AND NOT 
		                            EXISTS(
		                                SELECT 
		                                    ven_cie.id_ven_cie
		                                FROM 
		                                    cierre_venta_cierre AS ven_cie
		                                WHERE
		                                    ven_cie.id_ven = ven.id_ven AND
		                                    ven_cie.id_est_ven = 3
		                            ) AND  
		                            EXISTS(
		                                SELECT 
		                                    ven_cie.id_ven_cie
		                                FROM 
		                                    cierre_venta_cierre AS ven_cie
		                                WHERE
		                                    ven_cie.id_ven = ven.id_ven AND
		                                    (ven_cie.id_est_ven = 4 OR ven_cie.id_est_ven = 6)
		                            )

		                            
		                        ";
		                    $conexion->consulta_form($consulta,array($fila['id_con'],$fila['id_vend']));
		                    $fila_consulta_detalle = $conexion->extraer_registro();
		                    // $contador_promesa = 0;
		                    if(is_array($fila_consulta_detalle)){
		                        foreach ($fila_consulta_detalle as $fila_det) {
		                        	$UF_DESISTIMIENTO_VENTA = 0;

		                        	$UF_DESISTIMIENTO_VENTA = get_uf_disistimiento($fila_det['id_ven']);

		                            $monto_comision_promesa = round(round($fila_det['promesa_monto_comision_ven'],2) * $UF_DESISTIMIENTO_VENTA);
		                            $monto_comision_escritura = round(round($fila_det['escritura_monto_comision_ven'],2) * $UF_DESISTIMIENTO_VENTA);
		                            $total_desistimiento = 0;

		                            // if ($fila_det['id_ven'] == 484) {

		                            // 	$promesa_monto_comision_ven_desistimiento = round($fila_det['promesa_monto_comision_ven'],1);
		                            	
		                            // 	$monto_comision_promesa = $promesa_monto_comision_ven_desistimiento * 29706.87;

	                             //    }

	                             //    if ($fila_det['id_ven'] == 509) {

		                            // 	$promesa_monto_comision_ven_desistimiento = round($fila_det['promesa_monto_comision_ven'],2);
		                            	
		                            // 	$monto_comision_promesa = $promesa_monto_comision_ven_desistimiento * 29753.8;

	                             //    }

		                            
		                            $consulta = 
		                                "
		                                SELECT
		                                    id_est_ven
		                                FROM
		                                    cierre_venta_cierre
		                                WHERE
		                                    id_ven = ? AND
		                                    id_est_ven = ?
		                                ";
		                            $conexion->consulta_form($consulta,array($fila_det['id_ven'],4));
		                            $cantidad_estado_promesa = $conexion->total();

		                            $consulta = 
		                                "
		                                SELECT
		                                    id_est_ven
		                                FROM
		                                    cierre_venta_cierre
		                                WHERE
		                                    id_ven = ? AND
		                                    id_est_ven = ?
		                                ";
		                            $conexion->consulta_form($consulta,array($fila_det['id_ven'],6));
		                            $cantidad_estado_escritura = $conexion->total();
		                            ?>
		                            <tr>
		                                <td><?php echo utf8_encode($fila_det['nombre_viv']);?> <?php echo $fila_det['id_ven']; ?></td>
		                                <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                <td></td>
		                                <td></td>
		                                <?php  
		                                if($cantidad_estado_promesa > 0){
		                                    $total_desistimiento = $total_desistimiento + $monto_comision_promesa;
		                                    ?>
		                                    <td><?php echo number_format($fila_det['promesa_monto_comision_ven'], 2, ',', '.');?></td>
		                                    <td><?php echo number_format($monto_comision_promesa, 0, ',', '.');?></td>
		                                    <?php
		                                }
		                                if($cantidad_estado_escritura > 0){
		                                    $total_desistimiento = $total_desistimiento + $monto_comision_escritura;
		                                    ?>
		                                    <td><?php echo number_format($fila_det['escritura_monto_comision_ven'], 2, ',', '.');?></td>
		                                    <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>

		                                    <?php
		                                }
		                                else{
		                                    ?>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    <?php
		                                }
		                                ?>
		                                <td></td>
		                                <td></td>
		                                <td></td>
		                                <td><?php echo number_format($total_desistimiento, 0, ',', '.');?>.-</td>
		                            </tr>
		                            <?php
		                            $total_desistimiento_acumulado = $total_desistimiento_acumulado + $total_desistimiento;
		                        }
		                    }
		                    ?>
		                    
		                    <?php  
		                    // bono rango 1
		                    $consulta = 
		                        "
		                        SELECT
		                            monto_bon,
		                            nombre_bon
		                        FROM
		                            bono_bono
		                        WHERE
		                            id_est_bon = 1 AND
		                            desde_bon <= ? AND
		                            hasta_bon >= ? AND
		                            id_tip_bon = 3 AND
		                            id_con = ? AND
		                            id_cat_bon = ?
		                        ";
		                    
		                    $conexion->consulta_form($consulta,array($contador_promesa,$contador_promesa,$fila['id_con'],1));
		                    $cantidad_bono = $conexion->total();
		                    // echo $cantidad_bono;
		                    if($cantidad_bono > 0){
			                    // $fila_bono = $conexion->extraer_registro_unico();
			                    $fila_consulta_detalle = $conexion->extraer_registro();
			                    if(is_array($fila_consulta_detalle)){
			                        foreach ($fila_consulta_detalle as $fila_bono) {
					                    $monto_bono_rango = 0;
					                    $monto_bono_rango_plata = 0;
			                    

				                        $nombre_bon = utf8_encode($fila_bono["nombre_bon"]);
				                        $monto_bono_rango = $fila_bono["monto_bon"];
				                        $monto_bono_rango_plata = $fila_bono["monto_bon"] * $valor_uf;
				                        $arreglo_vendedor_bono_uf[$fila["id_vend"]] = $monto_bono_rango;
				                        $arreglo_vendedor_bono_plata[$fila["id_vend"]] = $monto_bono_rango_plata;
				                        $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
			                    		?>
					                    <tr>
					                        <td class="active" colspan="9"><b><?php echo $nombre_bon ?></b></td>
					                        <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
					                        <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
					                        <td></td>
					                    </tr>
			                    	<?php 
			                    	}
			                    }
		                	}
		                    //---- BONO CATEGORIA FECHA SIN MODELO 
		                    $consulta = 
		                        "
		                        SELECT
		                            *
		                        FROM
		                            bono_bono
		                        WHERE
		                            id_est_bon = 1 AND
		                            id_tip_bon = 3 AND
		                            id_con = ? AND
		                            id_cat_bon = ? AND
		                            MONTH(fecha_hasta_bon) = '".$mes."' AND
		                            YEAR(fecha_hasta_bon) = '".$anio."'
		                        ";
		                    $conexion->consulta_form($consulta,array($fila['id_con'],2));
		                    $fila_consulta_detalle = $conexion->extraer_registro();
		                    if(is_array($fila_consulta_detalle)){
		                        foreach ($fila_consulta_detalle as $fila_det) {
		                            $consulta = 
		                                "
		                                SELECT
		                                    ven.id_ven 
		                                FROM
		                                    venta_venta AS ven 
		                                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                    
		                                WHERE
		                                    tor.id_con = ? AND
		                                    ven.fecha_promesa_ven >= ? AND
		                                    ven.fecha_promesa_ven <= ? AND
		                                    ven.id_vend = ? AND NOT
		                                    ven.id_est_ven = 3 AND NOT EXISTS
		                                    (
		                                    SELECT
		                                        b.id_ven_bon
		                                    FROM
		                                        bono_venta_bono AS b
		                                    WHERE
		                                        b.id_ven = ven.id_ven AND
		                                        b.id_bon = ?
		                                    )
		                                GROUP BY 
		                                    ven.id_ven 
		                                ";
		                            $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila['id_vend'],$fila_det["id_bon"]));
		                            $cantidad_bono = $conexion->total();
		                            if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                $monto_bono_rango = $fila_det["monto_bon"];
		                                $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                $arreglo_vendedor_bono_uf[$fila["id_vend"]] = $arreglo_vendedor_bono_uf[$fila["id_vend"]] + $monto_bono_rango;
		                                $arreglo_vendedor_bono_plata[$fila["id_vend"]] = $arreglo_vendedor_bono_plata[$fila["id_vend"]] + $monto_bono_rango_plata;
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                ?>
		                                <tr>
		                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                    <td></td>
		                                </tr>
		                                <?php

		                            }
		                        }
		                    }


		                    //---- BONO CATEGORIA FECHA CON MODELO 
		                    $consulta = 
		                        "
		                        SELECT
		                            *
		                        FROM
		                            bono_bono
		                        WHERE
		                            id_est_bon = 1 AND
		                            id_tip_bon = 3 AND
		                            id_con = ? AND
		                            id_cat_bon = ? AND
		                            MONTH(fecha_hasta_bon) = '".$mes."' AND
		                            YEAR(fecha_hasta_bon) = '".$anio."'
		                        ";
		                    $conexion->consulta_form($consulta,array($fila['id_con'],3));
		                    $fila_consulta_detalle = $conexion->extraer_registro();
		                    if(is_array($fila_consulta_detalle)){
		                        foreach ($fila_consulta_detalle as $fila_det) {
		                            $consulta = 
		                                "
		                                SELECT
		                                    ven.id_ven 
		                                FROM
		                                    venta_venta AS ven 
		                                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                    
		                                WHERE
		                                    tor.id_con = ? AND
		                                    ven.fecha_promesa_ven >= ? AND
		                                    ven.fecha_promesa_ven <= ? AND
		                                    viv.id_mod = ? AND
		                                    ven.id_vend = ? AND NOT
		                                    ven.id_est_ven = 3 AND NOT EXISTS
		                                    (
		                                    SELECT
		                                        b.id_ven_bon
		                                    FROM
		                                        bono_venta_bono AS b
		                                    WHERE
		                                        b.id_ven = ven.id_ven AND
		                                        b.id_bon = ?
		                                    )
		                                GROUP BY 
		                                    ven.id_ven 
		                                ";
		                            $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila_det["id_mod"],$fila['id_vend'],$fila_det["id_bon"]));
		                            $cantidad_bono = $conexion->total();
		                            if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                $monto_bono_rango = $fila_det["monto_bon"];
		                                $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                $arreglo_vendedor_bono_uf[$fila["id_vend"]] = $arreglo_vendedor_bono_uf[$fila["id_vend"]] + $monto_bono_rango;
		                                $arreglo_vendedor_bono_plata[$fila["id_vend"]] = $arreglo_vendedor_bono_plata[$fila["id_vend"]] + $monto_bono_rango_plata;
		                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                ?>
		                                <tr>
		                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                    <td></td>
		                                </tr>
		                                <?php

		                            }
		                        }
		                    }

		                    //---- BONO TÉRMINO VENTAS 
		                    $no_termino = 0;

							// preguntar si estoy en el mes de cierre venta
							$consulta_termino = 
		                        "
		                        SELECT
		                            valor_par
		                        FROM
		                            parametro_parametro
		                        WHERE
		                            valor2_par = ? AND
		                            id_con = ? 
		                        ";
		                    
		                    $conexion->consulta_form($consulta_termino,array(26,$fila['id_con']));
		                    $fila_term = $conexion->extraer_registro_unico();
		                    $fecha_termino = $fila_term['valor_par'];
		                    if ($fecha_termino<>'' & $fecha_termino<>null) {
		                    	$mes_termino = date("n",strtotime($fecha_termino));
		                    } else {
		                    	$no_termino = 1;
		                    }

		                    if ($mes_termino<>$mes) {
		                    	$no_termino = 1;
		                    }

							if ($no_termino==0) {
							// echo $mes_termino." - ".$mes;
							// para dejarlo perfecto, se podría separar ir a buscar los sin rango con la fecha
								// y los con rango sin la fecha
								$consulta = 
			                        "
			                        SELECT
			                            *
			                        FROM
			                            bono_bono
			                        WHERE
			                            id_est_bon = 1 AND
			                            id_tip_bon = 3 AND
			                            id_con = ? AND
			                            id_cat_bon = ? AND
			                            MONTH(fecha_hasta_bon) = '".$mes."' AND
			                            YEAR(fecha_hasta_bon) = '".$anio."'
			                        ";
			                    $conexion->consulta_form($consulta,array($fila['id_con'],4));

			                    $fila_consulta_detalle = $conexion->extraer_registro();
			                    if(is_array($fila_consulta_detalle)){
			                        foreach ($fila_consulta_detalle as $fila_det) {
			                        	// echo $mes_termino." - ".$mes;
										
										if ($fila_det["desde_bon"]==0 && $fila_det["hasta_bon"]==0) {
											// cuando no hay rango, se paga directo
											$monto_bono_rango = $fila_det["monto_bon"];
			                                $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
			                                $arreglo_vendedor_bono_uf[$fila["id_vend"]] = $arreglo_vendedor_bono_uf[$fila["id_vend"]] + $monto_bono_rango;
			                                $arreglo_vendedor_bono_plata[$fila["id_vend"]] = $arreglo_vendedor_bono_plata[$fila["id_vend"]] + $monto_bono_rango_plata;
			                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;

											?>
			                                <tr>
			                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
			                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
			                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
			                                    <td></td>
			                                </tr>
			                                <?php

										} else {
											$consulta = 
				                                "
				                                SELECT
				                                    ven.id_ven 
				                                FROM
				                                    venta_venta AS ven 
				                                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
				                                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
				                                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
				                                    
				                                WHERE
				                                    tor.id_con = ? AND
				                                    ven.fecha_promesa_ven >= ? AND
				                                    ven.fecha_promesa_ven <= ? AND
				                                    ven.id_vend = ? AND NOT
				                                    ven.id_est_ven = 3 AND NOT EXISTS
				                                    (
				                                    SELECT
				                                        b.id_ven_bon
				                                    FROM
				                                        bono_venta_bono AS b
				                                    WHERE
				                                        b.id_ven = ven.id_ven AND
				                                        b.id_bon = ?
				                                    )
				                                GROUP BY 
				                                    ven.id_ven 
				                                ";
				                            $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila['id_vend'],$fila_det["id_bon"]));
				                            $cantidad_bono = $conexion->total();
				                            if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
				                                $monto_bono_rango = $fila_det["monto_bon"];
				                                $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
				                                $arreglo_vendedor_bono_uf[$fila["id_vend"]] = $arreglo_vendedor_bono_uf[$fila["id_vend"]] + $monto_bono_rango;
				                                $arreglo_vendedor_bono_plata[$fila["id_vend"]] = $arreglo_vendedor_bono_plata[$fila["id_vend"]] + $monto_bono_rango_plata;
				                                $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
				                                ?>
				                                <tr>
				                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
				                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
				                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
				                                    <td></td>
				                                </tr>
				                                <?php

				                            }

										}
			                            
			                        }
			                    }
			                }
		                    


		                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar - $total_desistimiento_acumulado;
		                    ?>
		                    <tr class="success">
		                        <td colspan="2"><b>Total a Pagar</b></td>
		                        <td colspan="2"><?php echo number_format($monto_acumulado_a_pagar, 0, ',', '.');?>.-</td>
		                        <td colspan="8"></td>
		                    </tr>
		                </table>
		            </div>
		            <?php
		        }
		    }


		    //--------- SUPERVISOR ---------
		    $arreglo_vendedor_supervisor = array();
		    $monto_acumulado_a_pagar = 0;
		    $total_desistimiento = 0;
		    $total_desistimiento_acumulado = 0;

		    $consulta = 
		        "
		        SELECT
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.id_con,
		            con.nombre_con,
		            usu.id_cat_vend,
		            cat_vend.nombre_cat_vend
		        FROM
		            usuario_usuario AS usu
		            INNER JOIN vendedor_supervisor_vendedor AS sup_ven ON sup_ven.id_usu = usu.id_usu
		            INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		            INNER JOIN vendedor_categoria_vendedor AS cat_vend ON cat_vend.id_cat_vend = usu.id_cat_vend
		            INNER JOIN condominio_condominio AS con ON con.id_con = con_usu.id_con
		        WHERE
		            usu.id_per = ? AND
		            con.id_con = ".$condo." AND
		            sup_ven.id_vend IN (".implode(',',$arreglo_vendedor).") 
		        GROUP BY 
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.nombre_con,
		            usu.nombre_usu,
		            usu.id_cat_vend,
		            con_usu.id_con
		        ";
		    $conexion->consulta_form($consulta,array(5));
		    $cantidad_venta_supervisor = $conexion->total();
		    if($cantidad_venta_supervisor > 0){
		        ?>
		        <div class="col-sm-12">
		            <h4>Supervisores</h4>
		        </div>
		        <?php
		    }
		    $fila_consulta = $conexion->extraer_registro();
		    if(is_array($fila_consulta)){
		        foreach ($fila_consulta as $fila) {
		            $monto_bono_supervisor_acumulado_uf = 0;
		            $monto_bono_supervisor_acumulado_plata = 0;
		            $consulta = 
		                "
		                SELECT
		                    sup_ven.id_vend
		                FROM
		                    usuario_usuario AS usu
		                    INNER JOIN vendedor_supervisor_vendedor AS sup_ven ON sup_ven.id_usu = usu.id_usu
		                    INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		                WHERE
		                    usu.id_usu = ? AND
		                    con_usu.id_con = ? AND
		                    sup_ven.id_vend IN (".implode(',',$arreglo_vendedor).") 
		                ";
		            $conexion->consulta_form($consulta,array($fila["id_usu"],$fila["id_con"]));
		            $fila_consulta_usuario = $conexion->extraer_registro();
		            if(is_array($fila_consulta_usuario)){
		                foreach ($fila_consulta_usuario as $fila_usu) {
		                    
		                    if(!in_array($fila_usu["id_vend"],$arreglo_vendedor_supervisor)){
		                        $arreglo_vendedor_supervisor[$fila_usu["id_vend"]] = $fila_usu["id_vend"];

		                        $monto_bono_supervisor_acumulado_uf = $monto_bono_supervisor_acumulado_uf + $arreglo_vendedor_bono_uf[$fila_usu["id_vend"]];
		                        $monto_bono_supervisor_acumulado_plata = $monto_bono_supervisor_acumulado_plata + $arreglo_vendedor_bono_plata[$fila_usu["id_vend"]];

		                    }
		                }
		            }

					// comisión y categoría supervisor
					$consulta = 
		                "
		                SELECT
		                    valor2_par,
		                    valor_par
		                FROM
		                    parametro_parametro
		                WHERE
		                    id_con = ? AND
		                    valor2_par IN (23,24,25,9)
		                ";
		            $conexion->consulta_form($consulta,array($fila['id_con']));
		            $fila_consulta = $conexion->extraer_registro();
		            if(is_array($fila_consulta)){
		                foreach ($fila_consulta as $fila_par) {
		                    if($fila_par['valor2_par'] == 9){
		                        $porcentaje_comision_usuario = $fila_par['valor_par'];
		                    }
		                    else{
		                        if($fila_par['valor2_par'] == ($fila['id_cat_vend']+22)){
		                            $porcentaje_multiplo_categoria = $fila_par['valor_par'];
		                        }
		                    }
		                }
		            }
					
					$porcentaje_comision_usuario = $porcentaje_comision_usuario * $porcentaje_multiplo_categoria;
		            // $consulta = 
		            //     "
		            //     SELECT
		            //         valor2_par,
		            //         valor_par
		            //     FROM
		            //         parametro_parametro
		            //     WHERE
		            //         id_con = ? AND
		            //         valor2_par IN (9)
		            //     ";
		            // $conexion->consulta_form($consulta,array($fila['id_con']));
		            // $fila_consulta = $conexion->extraer_registro_unico();
		            // if(is_array($fila_consulta)){
		            //     $porcentaje_comision_usuario = $fila_consulta['valor_par'];
		            // }
		            $monto_acumulado_a_pagar = 0;
		            $consulta = 
		                "
		                SELECT
		                    vend.id_vend,
		                    vend.nombre_vend,
		                    vend.apellido_paterno_vend,
		                    vend.apellido_materno_vend,
		                    his.id_est_ven,
		                    ven.monto_ven,
		                    ven.promesa_monto_comision_supervisor_ven,
		                    ven.escritura_monto_comision_supervisor_ven,
		                    ven.total_comision_supervisor_ven,
		                    CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                    ven.promesa_bono_precio_supervisor_ven,
		                    ven.escritura_bono_precio_supervisor_ven,
		                    ven.total_bono_precio_supervisor_ven,
		                    viv.nombre_viv,
		                    uf.valor_uf
		                FROM
		                    vendedor_vendedor AS vend
		                    INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                    INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                    INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                WHERE
		                    tor.id_con = ? AND
		                    ven.fecha_promesa_ven <= '".$fecha_hasta_consulta."' AND
		                    vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND
		                    his.id_est_ven IN (4,6) AND NOT EXISTS
		                    (
		                    SELECT
		                        b.id_ven
		                    FROM
		                        cierre_venta_cierre AS b
		                    WHERE
		                        b.id_ven = ven.id_ven AND
		                        b.id_est_ven = his.id_est_ven
		                    ) AND NOT EXISTS
		                            (
		                            SELECT
		                                des_ven.id_ven
		                            FROM
		                                venta_desestimiento_venta AS des_ven
		                            WHERE
		                                des_ven.id_ven = ven.id_ven
		                            )
		                    
		                ";
		            $conexion->consulta_form($consulta,array($fila['id_con']));
		            $cantidad_consulta = $conexion->total();
		            $fila_consulta_detalle = $conexion->extraer_registro();
		            $contador_promesa = 0;
		            if ($cantidad_consulta > 0) {
		                ?>
		                <div class="col-sm-12 table-responsive">
		                    <table class="table table-striped table-bordered">
		                        <tr>
		                            <td colspan="12"><?php echo utf8_encode($fila['nombre_con']); ?> - <?php echo utf8_encode($fila['nombre_usu']." ".$fila['apellido1_usu']." ".$fila['apellido2_usu']);?> - <?php echo utf8_encode($fila['nombre_cat_vend']); ?> - <?php echo number_format($porcentaje_comision_usuario, 3, ',', '.');?></td>
		                        </tr>
		                        <tr class="font-weight-bold">
		                            <td colspan="3"></td>
		                            <td colspan="5" class="text-center">Comisiones</td>
		                            <td colspan="3" class="text-center">Bono al Precio</td>
		                            <td></td>
		                        </tr>
		                        <tr class="active font-weight-bold">
		                            <td>Unidad</td>
		                            <td>Cliente</td>
		                            <td>Valor Venta</td>
		                            <td>Comisión</td>
		                            <td>Comisión Promesa UF</td>
		                            <td>Comisión Promesa $</td>
		                            <td>Comisión Escritura UF</td>
		                            <td>Comisión Escritura $</td>
		                            <td>B. Precio</td>
		                            <td>B. Precio Promesa</td>
		                            <td>B. Precio Escritura</td>
		                            <td>Desistimiento</td>
		                        </tr>
		                        <?php  
		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                his.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_supervisor_ven,
		                                ven.escritura_monto_comision_supervisor_ven,
		                                ven.total_comision_supervisor_ven,
		                                CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                                ven.promesa_bono_precio_supervisor_ven,
		                                ven.escritura_bono_precio_supervisor_ven,
		                                ven.total_bono_precio_supervisor_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf,
		                            	ven.id_pie_abo_ven,
		                            	ven.descuento_ven
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                                INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                            WHERE
		                                tor.id_con = ? AND
		                                ven.fecha_promesa_ven > '".$fecha_desde_consulta."' AND
		                                ven.fecha_promesa_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND
		                                his.id_est_ven IN (4) AND NOT EXISTS
		                                (
		                                SELECT
		                                    b.id_ven
		                                FROM
		                                    cierre_venta_cierre AS b
		                                WHERE
		                                    b.id_ven = ven.id_ven AND
		                                    b.id_est_ven = his.id_est_ven
		                                ) AND NOT EXISTS
			                            (
			                            SELECT
			                                des_ven.id_ven
			                            FROM
			                                venta_desestimiento_venta AS des_ven
			                            WHERE
			                                des_ven.id_ven = ven.id_ven
			                            )
		                                
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $cantidad_consulta = $conexion->total();
		                        $fila_consulta_detalle = $conexion->extraer_registro();


		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_comision_promesa = round($fila_det['promesa_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_comision_escritura = round($fila_det['escritura_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_promesa = round($fila_det['promesa_bono_precio_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_escritura = round($fila_det['escritura_bono_precio_supervisor_ven'] * $fila_det['valor_uf']);
		                                
										// revisar valor de la venta
								        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
								        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
								        } else {
								        	$monto_ven_comision = $fila_det['monto_ven'];
								        }

		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?></td>
		                                    <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                    <td>UF <?php echo number_format($monto_ven_comision, 2, ',', '.');?></td>
		                                    <td><?php echo number_format($fila_det['total_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_promesa;
		                                    $contador_promesa++;
		                                    ?>
		                                    <td><?php echo number_format($fila_det['promesa_monto_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                    <td><?php echo number_format($monto_comision_promesa, 0, ',', '.');?></td>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    <td><?php echo number_format($fila_det['total_bono_precio_supervisor_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_promesa;
		                                    ?>
		                                    <td><?php echo number_format($fila_det['promesa_bono_precio_supervisor_ven'], 2, ',', '.');?> ($<?php echo number_format($monto_bono_promesa, 0, ',', '.');?>.-)</td>
		                                    <td>0,00 ($0.-)</td>
		                                    <td>---</td>
		                                </tr>
		                                <?php
		                            }
		                        }


		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                his.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_supervisor_ven,
		                                ven.escritura_monto_comision_supervisor_ven,
		                                ven.total_comision_supervisor_ven,
		                                CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                                ven.promesa_bono_precio_supervisor_ven,
		                                ven.escritura_bono_precio_supervisor_ven,
		                                ven.total_bono_precio_supervisor_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf,
		                            	ven.id_pie_abo_ven,
		                            	ven.descuento_ven
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                                INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                            WHERE
		                                tor.id_con = ? AND
		                                ven.fecha_escritura_ven > '".$fecha_desde_consulta."' AND
		                                ven.fecha_escritura_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND
		                                his.id_est_ven IN (6) AND NOT EXISTS
		                                (
		                                SELECT
		                                    b.id_ven
		                                FROM
		                                    cierre_venta_cierre AS b
		                                WHERE
		                                    b.id_ven = ven.id_ven AND
		                                    b.id_est_ven = his.id_est_ven
		                                ) AND NOT EXISTS
			                            (
			                            SELECT
			                                des_ven.id_ven
			                            FROM
			                                venta_desestimiento_venta AS des_ven
			                            WHERE
			                                des_ven.id_ven = ven.id_ven
			                            )
		                                
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $cantidad_consulta = $conexion->total();
		                        $fila_consulta_detalle = $conexion->extraer_registro();

		                        
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_comision_promesa = round($fila_det['promesa_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_comision_escritura = round($fila_det['escritura_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_promesa = round($fila_det['promesa_bono_precio_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_escritura = round($fila_det['escritura_bono_precio_supervisor_ven'] * $fila_det['valor_uf']);
		                                
										// revisar valor de la venta
								        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
								        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
								        } else {
								        	$monto_ven_comision = $fila_det['monto_ven'];
								        }

		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?></td>
		                                    <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                    <td>UF <?php echo number_format($monto_ven_comision, 2, ',', '.');?></td>
		                                    <td><?php echo number_format($fila_det['total_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_escritura;
		                                    ?>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    <td><?php echo number_format($fila_det['escritura_monto_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                    <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>
		                                    <td><?php echo number_format($fila_det['total_bono_precio_supervisor_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_escritura;
		                                    ?>
		                                    <td>0,00 ($0.-)</td>
		                                    <td><?php echo number_format($fila_det['escritura_bono_precio_supervisor_ven'], 2, ',', '.');?> ($<?php echo number_format($monto_bono_escritura, 0, ',', '.');?>.-)</td>
		                                    <td>---</td>
		                                </tr>
		                                <?php
		                            }
		                        }
		                        ?>
		                        
		                        
		                        <tr>
		                            <td class="active" colspan="12"><b>Desistimiento</b></td>
		                        </tr>
		                        <?php  
		                        $total_desistimiento_acumulado = 0;
		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                ven.id_ven,
		                                ven.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_supervisor_ven,
		                                ven.escritura_monto_comision_supervisor_ven,
		                                ven.total_comision_supervisor_ven,
		                                ven.promesa_bono_precio_supervisor_ven,
		                                ven.escritura_bono_precio_supervisor_ven,
		                                ven.total_bono_precio_supervisor_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN venta_desestimiento_venta AS des_ven ON des_ven.id_ven = ven.id_ven
		                                -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                            WHERE
		                                tor.id_con = ? AND
		                                des_ven.fecha_des_ven > '".$fecha_desde_consulta."' AND
		                                des_ven.fecha_des_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND 
		                                des_ven.id_tip_des = 1 AND 
		                                ven.id_est_ven = 3 AND NOT 
		                                EXISTS(
		                                    SELECT 
		                                        ven_cie.id_ven_cie
		                                    FROM 
		                                        cierre_venta_cierre AS ven_cie
		                                    WHERE
		                                        ven_cie.id_ven = ven.id_ven AND
		                                        ven_cie.id_est_ven = 3
		                                ) AND  
		                                EXISTS(
		                                    SELECT 
		                                        ven_cie.id_ven_cie
		                                    FROM 
		                                        cierre_venta_cierre AS ven_cie
		                                    WHERE
		                                        ven_cie.id_ven = ven.id_ven AND
		                                        (ven_cie.id_est_ven = 4 OR ven_cie.id_est_ven = 6)
		                                )

		                                
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_comision_promesa = round($fila_det['promesa_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $monto_comision_escritura = round($fila_det['escritura_monto_comision_supervisor_ven'] * $fila_det['valor_uf']);
		                                $total_desistimiento = 0;

		                                
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        id_est_ven
		                                    FROM
		                                        cierre_venta_cierre
		                                    WHERE
		                                        id_ven = ? AND
		                                        id_est_ven = ?
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila_det['id_ven'],4));
		                                $cantidad_estado_promesa = $conexion->total();

		                                $consulta = 
		                                    "
		                                    SELECT
		                                        id_est_ven
		                                    FROM
		                                        cierre_venta_cierre
		                                    WHERE
		                                        id_ven = ? AND
		                                        id_est_ven = ?
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila_det['id_ven'],6));
		                                $cantidad_estado_escritura = $conexion->total();
		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?></td>
		                                    <td></td>
		                                    <td></td>
		                                    <td></td>
		                                    <?php  
		                                    if($cantidad_estado_promesa > 0){
		                                        $total_desistimiento = $total_desistimiento + $monto_comision_promesa;
		                                        ?>
		                                        <td><?php echo number_format($fila_det['promesa_monto_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                        <td><?php echo number_format($monto_comision_promesa, 0, ',', '.');?></td>
		                                        <?php
		                                    }
		                                    if($cantidad_estado_escritura > 0){
		                                        $total_desistimiento = $total_desistimiento + $monto_comision_escritura;
		                                        ?>
		                                        <td><?php echo number_format($fila_det['escritura_monto_comision_supervisor_ven'], 2, ',', '.');?></td>
		                                        <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>

		                                        <?php
		                                    }
		                                    else{
		                                        ?>
		                                        <td>0,00</td>
		                                        <td>0</td>
		                                        <?php
		                                    }
		                                    ?>
		                                    <td></td>
		                                    <td></td>
		                                    <td></td>
		                                    <td><?php echo number_format($total_desistimiento, 0, ',', '.');?>.-</td>
		                                </tr>
		                                <?php
		                                $total_desistimiento_acumulado = $total_desistimiento_acumulado + $total_desistimiento;
		                            }
		                        }
		                        ?>
		                        
		                        <?php 
		                        // $monto_bono_rango = 0;
		                        // $monto_bono_rango_plata = 0;
		                        // if($monto_bono_supervisor_acumulado_uf > 0){
		                        //     $monto_bono_rango = $monto_bono_supervisor_acumulado_uf * ($porcentaje_bono_precio_supervisor / 100);
		                        //     $monto_bono_rango_plata = ($monto_bono_supervisor_acumulado_plata * ($porcentaje_bono_precio_supervisor / 100)) * $valor_uf;
		                            
		                        //     $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;

		                        // }   
		                        $consulta = 
		                            "
		                            SELECT
		                                monto_bon,
		                            	nombre_bon
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                desde_bon <= ? AND
		                                hasta_bon >= ? AND
		                                id_tip_bon = 2 AND
		                                id_con = ? AND
		                                id_cat_bon = ?
		                            ";
		                        $conexion->consulta_form($consulta,array($contador_promesa,$contador_promesa,$fila['id_con'],1));
		                        $cantidad_bono = $conexion->total();
		                        if($cantidad_bono > 0){
			                        $fila_consulta_detalle = $conexion->extraer_registro();
				                    if(is_array($fila_consulta_detalle)){
				                        foreach ($fila_consulta_detalle as $fila_bono) {
					                        // $fila_bono = $conexion->extraer_registro_unico();
					                        $monto_bono_rango = 0;
					                        $monto_bono_rango_plata = 0;
					                        $nombre_bon = utf8_encode($fila_bono["nombre_bon"]);
				                            $monto_bono_rango = $fila_bono["monto_bon"];
				                            $monto_bono_rango_plata = $fila_bono["monto_bon"] * $valor_uf;

				                            $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
					                        ?>
					                        <tr>
					                            <td class="active" colspan="9"><b><?php echo $nombre_bon ?></b></td>
					                            <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
					                            <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
					                            <td></td>
					                        </tr>
					                        <?php 
					                    }
					                }
					            }

		                        //---- BONO CATEGORIA FECHA SIN MODELO 
		                        $consulta = 
		                            "
		                            SELECT
		                                *
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                id_tip_bon = 2 AND
		                                id_con = ? AND
		                                id_cat_bon = ? AND
		                                MONTH(fecha_hasta_bon) = '".$mes."' AND
		                                YEAR(fecha_hasta_bon) = '".$anio."'
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con'],2));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_bono_rango = 0;
		                                $monto_bono_rango_plata = 0;
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        ven.id_ven 
		                                    FROM
		                                        vendedor_vendedor AS vend
		                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                        -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
		                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    WHERE
		                                        tor.id_con = ? AND
		                                        ven.fecha_promesa_ven >= ? AND
		                                        ven.fecha_promesa_ven <= ? AND
		                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND NOT
		                                        ven.id_est_ven = 3 AND NOT EXISTS
		                                        (
		                                        SELECT
		                                            b.id_ven_bon
		                                        FROM
		                                            bono_venta_bono AS b
		                                        WHERE
		                                            b.id_ven = ven.id_ven AND
		                                            b.id_bon = ?
		                                        )
		                                    GROUP BY 
		                                        ven.id_ven 
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila['id_vend'],$fila_det["id_bon"]));
		                                $cantidad_bono = $conexion->total();
		                                if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                    $monto_bono_rango = $fila_det["monto_bon"];
		                                    $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                    ?>
		                                    <tr>
		                                        <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                        <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                        <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                        <td></td>
		                                    </tr>
		                                    <?php

		                                }
		                            }
		                        }


		                        //---- BONO CATEGORIA FECHA CON MODELO 
		                        $consulta = 
		                            "
		                            SELECT
		                                *
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                id_tip_bon = 2 AND
		                                id_con = ? AND
		                                id_cat_bon = ? AND
		                                MONTH(fecha_hasta_bon) = '".$mes."' AND
		                                YEAR(fecha_hasta_bon) = '".$anio."'
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con'],3));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_bono_rango = 0;
		                                $monto_bono_rango_plata = 0;
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        ven.id_ven 
		                                    FROM
		                                        vendedor_vendedor AS vend
		                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                        -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
		                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    WHERE
		                                        tor.id_con = ? AND
		                                        ven.fecha_promesa_ven >= ? AND
		                                        ven.fecha_promesa_ven <= ? AND
		                                        viv.id_mod = ? AND
		                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND NOT
		                                        ven.id_est_ven = 3 AND NOT EXISTS
		                                        (
		                                        SELECT
		                                            b.id_ven_bon
		                                        FROM
		                                            bono_venta_bono AS b
		                                        WHERE
		                                            b.id_ven = ven.id_ven AND
		                                            b.id_bon = ?
		                                        )
		                                    GROUP BY 
		                                        ven.id_ven
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila_det["id_mod"],$fila['id_vend'],$fila_det["id_bon"]));
		                                $cantidad_bono = $conexion->total();
		                                if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                    $monto_bono_rango = $fila_det["monto_bon"];
		                                    $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                    ?>
		                                    <tr>
		                                        <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                        <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                        <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                        <td></td>
		                                    </tr>
		                                    <?php

		                                }
		                            }
		                        }

		                        //---- BONO TÉRMINO VENTAS 
			                    $no_termino = 0;

								// preguntar si estoy en el mes de cierre venta
								$consulta_termino = 
			                        "
			                        SELECT
			                            valor_par
			                        FROM
			                            parametro_parametro
			                        WHERE
			                            valor2_par = ? AND
			                            id_con = ? 
			                        ";
			                    
			                    $conexion->consulta_form($consulta_termino,array(26,$fila['id_con']));
			                    $fila_term = $conexion->extraer_registro_unico();
			                    $fecha_termino = $fila_term['valor_par'];
			                    if ($fecha_termino<>'' & $fecha_termino<>null) {
			                    	$mes_termino = date("n",strtotime($fecha_termino));
			                    } else {
			                    	$no_termino = 1;
			                    }

			                    if ($mes_termino<>$mes) {
			                    	$no_termino = 1;
			                    }

								if ($no_termino==0) {
								// echo $mes_termino." - ".$mes;
									$consulta = 
				                        "
				                        SELECT
				                            *
				                        FROM
				                            bono_bono
				                        WHERE
				                            id_est_bon = 1 AND
				                            id_tip_bon = 2 AND
				                            id_con = ? AND
				                            id_cat_bon = ? AND
				                            MONTH(fecha_hasta_bon) = '".$mes."' AND
				                            YEAR(fecha_hasta_bon) = '".$anio."'
				                        ";
				                    $conexion->consulta_form($consulta,array($fila['id_con'],4));

				                    $fila_consulta_detalle = $conexion->extraer_registro();
				                    if(is_array($fila_consulta_detalle)){
				                        foreach ($fila_consulta_detalle as $fila_det) {
				                        	// echo $mes_termino." - ".$mes;
											
											if ($fila_det["desde_bon"]==0 && $fila_det["hasta_bon"]==0) {
												// cuando no hay rango, se paga directo
												$monto_bono_rango = $fila_det["monto_bon"];
		                                    	$monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    	$monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;

												?>
				                                <tr>
				                                    <td class="active" colspan="9"><b>aaa<?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
				                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
				                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
				                                    <td></td>
				                                </tr>
				                                <?php

											} else {
												$monto_bono_rango = 0;
		                                		$monto_bono_rango_plata = 0;
					                            $consulta = 
			                                    "
			                                    SELECT
			                                        ven.id_ven 
			                                    FROM
			                                        vendedor_vendedor AS vend
			                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
			                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
			                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
			                                        -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
			                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
			                                    WHERE
			                                        tor.id_con = ? AND
			                                        ven.fecha_promesa_ven >= ? AND
			                                        ven.fecha_promesa_ven <= ? AND
			                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_supervisor).") AND NOT
			                                        ven.id_est_ven = 3 AND NOT EXISTS
			                                        (
			                                        SELECT
			                                            b.id_ven_bon
			                                        FROM
			                                            bono_venta_bono AS b
			                                        WHERE
			                                            b.id_ven = ven.id_ven AND
			                                            b.id_bon = ?
			                                        )
			                                    GROUP BY 
			                                        ven.id_ven 
			                                    ";
					                            $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila['id_vend'],$fila_det["id_bon"]));
					                            $cantidad_bono = $conexion->total();
					                            if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
					                                $monto_bono_rango = $fila_det["monto_bon"];
		                                    		$monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    		$monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
					                                ?>
					                                <tr>
					                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
					                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
					                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
					                                    <td></td>
					                                </tr>
					                                <?php

					                            }

											}
				                            
				                        }
				                    }
				                }

		                        $monto_acumulado_a_pagar = $monto_acumulado_a_pagar - $total_desistimiento_acumulado;
		                        ?>
		                        <tr class="success">
		                            <td colspan="2"><b>Total a Pagar</b></td>
		                            <td colspan="2"><?php echo number_format($monto_acumulado_a_pagar, 0, ',', '.');?>.-</td>
		                            <td colspan="8"></td>
		                        </tr>
		                    </table>
		                </div>
		                <?php
		            }
		                
		        }
		    }



		    //--------- JEFE DE VENTAS ---------
		    $arreglo_vendedor_jefe = array();
		    $monto_acumulado_a_pagar = 0;
		    $total_desistimiento = 0;
		    $total_desistimiento_acumulado = 0;

		    $consulta = 
		        "
		        SELECT
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.id_con,
		            con.nombre_con,
		            usu.id_cat_vend,
		            cat_vend.nombre_cat_vend
		        FROM
		            usuario_usuario AS usu
		            INNER JOIN vendedor_jefe_vendedor AS jef_ven ON jef_ven.id_usu = usu.id_usu
		            INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		            INNER JOIN vendedor_categoria_vendedor AS cat_vend ON cat_vend.id_cat_vend = usu.id_cat_vend
		            INNER JOIN condominio_condominio AS con ON con.id_con = con_usu.id_con
		        WHERE
		            usu.id_per = ? AND
		            con.id_con = ".$condo." AND
		            jef_ven.id_vend IN (".implode(',',$arreglo_vendedor).") 
		        GROUP BY 
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.nombre_con,
		            usu.id_cat_vend,
		            con_usu.id_con
		        ";
		    $conexion->consulta_form($consulta,array(2));
		    $cantidad_venta_supervisor = $conexion->total();
		    if($cantidad_venta_supervisor > 0){
		        ?>
		        <div class="col-sm-12">
		            <h4>Jefe de Ventas</h4>
		        </div>
		        <?php
		    }
		    $fila_consulta = $conexion->extraer_registro();
		    if(is_array($fila_consulta)){
		        foreach ($fila_consulta as $fila) {
		            $monto_bono_jefe_acumulado_uf = 0;
		            $monto_bono_jefe_acumulado_plata = 0;
		            
		            $consulta = 
		                "
		                SELECT
		                    jef_ven.id_vend
		                FROM
		                    usuario_usuario AS usu
		                    INNER JOIN vendedor_jefe_vendedor AS jef_ven ON jef_ven.id_usu = usu.id_usu
		                    INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		                WHERE
		                    usu.id_usu = ? AND
		                    con_usu.id_con = ? AND
		                    jef_ven.id_vend IN (".implode(',',$arreglo_vendedor).") 
		                ";
		            $conexion->consulta_form($consulta,array($fila["id_usu"],$fila["id_con"]));
		            $fila_consulta_usuario = $conexion->extraer_registro();
		            if(is_array($fila_consulta_usuario)){
		                foreach ($fila_consulta_usuario as $fila_usu) {
		                    
		                    if(!in_array($fila_usu["id_vend"],$arreglo_vendedor_jefe)){
		                        $arreglo_vendedor_jefe[$fila_usu["id_vend"]] = $fila_usu["id_vend"];
		                        $monto_bono_jefe_acumulado_uf = $monto_bono_jefe_acumulado_uf + $arreglo_vendedor_bono_uf[$fila_usu["id_vend"]];
		                        $monto_bono_jefe_acumulado_plata = $monto_bono_jefe_acumulado_plata + $arreglo_vendedor_bono_plata[$fila_usu["id_vend"]];
		                    }
		                }
		            }
		            // $consulta = 
		            //     "
		            //     SELECT
		            //         valor2_par,
		            //         valor_par
		            //     FROM
		            //         parametro_parametro
		            //     WHERE
		            //         id_con = ? AND
		            //         valor2_par IN (10)
		            //     ";
		            // $conexion->consulta_form($consulta,array($fila['id_con']));
		            // $fila_consulta = $conexion->extraer_registro_unico();
		            // if(is_array($fila_consulta)){
		            //     $porcentaje_comision_usuario = $fila_consulta['valor_par'];
		            // }

					// comisión y categoría supervisor
					$consulta = 
		                "
		                SELECT
		                    valor2_par,
		                    valor_par
		                FROM
		                    parametro_parametro
		                WHERE
		                    id_con = ? AND
		                    valor2_par IN (20,21,22,10)
		                ";
		            $conexion->consulta_form($consulta,array($fila['id_con']));
		            $fila_consulta = $conexion->extraer_registro();
		            if(is_array($fila_consulta)){
		                foreach ($fila_consulta as $fila_par) {
		                    if($fila_par['valor2_par'] == 10){
		                        $porcentaje_comision_usuario = $fila_par['valor_par'];
		                    }
		                    else{
		                        if($fila_par['valor2_par'] == ($fila['id_cat_vend']+19)){
		                            $porcentaje_multiplo_categoria = $fila_par['valor_par'];
		                        }
		                    }
		                }
		            }
					
					$porcentaje_comision_usuario = $porcentaje_comision_usuario * $porcentaje_multiplo_categoria;


		            $monto_acumulado_a_pagar = 0;
		            $consulta = 
		                "
		                SELECT
		                    vend.id_vend,
		                    vend.nombre_vend,
		                    vend.apellido_paterno_vend,
		                    vend.apellido_materno_vend,
		                    his.id_est_ven,
		                    ven.monto_ven,
		                    ven.promesa_monto_comision_jefe_ven,
		                    ven.escritura_monto_comision_jefe_ven,
		                    ven.total_comision_jefe_ven,
		                    CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                    ven.promesa_bono_precio_jefe_ven,
		                    ven.escritura_bono_precio_jefe_ven,
		                    ven.total_bono_precio_jefe_ven,
		                    viv.nombre_viv,
		                    uf.valor_uf
		                FROM
		                    vendedor_vendedor AS vend
		                    INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                    INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                    INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                WHERE
		                    tor.id_con = ? AND
		                    ven.fecha_ven <= '".$fecha_hasta_consulta."' AND
		                    vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND
		                    his.id_est_ven IN (4,6) AND NOT EXISTS
		                    (
		                    SELECT
		                        b.id_ven
		                    FROM
		                        cierre_venta_cierre AS b
		                    WHERE
		                        b.id_ven = ven.id_ven AND
		                        b.id_est_ven = his.id_est_ven
		                    ) AND NOT EXISTS
		                            (
		                            SELECT
		                                des_ven.id_ven
		                            FROM
		                                venta_desestimiento_venta AS des_ven
		                            WHERE
		                                des_ven.id_ven = ven.id_ven
		                            )
		                    
		                ";
		            $conexion->consulta_form($consulta,array($fila['id_con']));
		            $cantidad_consulta = $conexion->total();
		            $fila_consulta_detalle = $conexion->extraer_registro();
		            $contador_promesa = 0;
		            if ($cantidad_consulta > 0) {
		                ?>
		                <div class="col-sm-12 table-responsive">
		                    <table class="table table-striped table-bordered">
		                        <tr>
		                            <td colspan="12">jefe<?php echo utf8_encode($fila['nombre_con']); ?> - <?php echo utf8_encode($fila['nombre_usu']." ".$fila['apellido1_usu']." ".$fila['apellido2_usu']);?> - <?php echo utf8_encode($fila['nombre_cat_vend']); ?> - <?php echo number_format($porcentaje_comision_usuario, 3, ',', '.');?></td>
		                        </tr>
		                        <tr class="font-weight-bold">
		                            <td colspan="3"></td>
		                            <td colspan="5" class="text-center">Comisiones</td>
		                            <td colspan="3" class="text-center">Bono al Precio</td>
		                            <td></td>
		                        </tr>
		                        <tr class="active font-weight-bold">
		                            <td>Unidad</td>
		                            <td>Cliente</td>
		                            <td>Valor Venta</td>
		                            <td>Comisión</td>
		                            <td>Comisión Promesa UF</td>
		                            <td>Comisión Promesa $</td>
		                            <td>Comisión Escritura UF</td>
		                            <td>Comisión Escritura $</td>
		                            <td>B. Precio</td>
		                            <td>B. Precio Promesa</td>
		                            <td>B. Precio Escritura</td>
		                            <td>Desistimiento</td>
		                        </tr>
		                        <?php  
		                        // PROMESAS JEFE
		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                his.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_jefe_ven,
		                                ven.escritura_monto_comision_jefe_ven,
		                                ven.total_comision_jefe_ven,
		                                CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                                ven.promesa_bono_precio_jefe_ven,
		                                ven.escritura_bono_precio_jefe_ven,
		                                ven.total_bono_precio_jefe_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf,
		                            	ven.id_pie_abo_ven,
		                            	ven.descuento_ven,
		                            	ven.id_ven
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                                INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                            WHERE
		                                tor.id_con = ? AND
		                                ven.fecha_promesa_ven > '".$fecha_desde_consulta."' AND
		                                ven.fecha_promesa_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND
		                                his.id_est_ven IN (4) AND NOT EXISTS
		                                (
		                                SELECT
		                                    b.id_ven
		                                FROM
		                                    cierre_venta_cierre AS b
		                                WHERE
		                                    b.id_ven = ven.id_ven AND
		                                    b.id_est_ven = his.id_est_ven
		                                ) AND NOT EXISTS
			                            (
			                            SELECT
			                                des_ven.id_ven
			                            FROM
			                                venta_desestimiento_venta AS des_ven
			                            WHERE
			                                des_ven.id_ven = ven.id_ven
			                            )
		                                
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $cantidad_consulta = $conexion->total();
		                        $fila_consulta_detalle = $conexion->extraer_registro();


		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                // $monto_comision_promesa = round($fila_det['promesa_monto_comision_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_comision_escritura = round($fila_det['escritura_monto_comision_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_bono_promesa = round($fila_det['promesa_bono_precio_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_bono_escritura = round($fila_det['escritura_bono_precio_jefe_ven'] * $fila_det['valor_uf']);

		                                // revisar valor de la venta
								        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
								        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
								        } else {
								        	$monto_ven_comision = $fila_det['monto_ven'];
								        }

								        $comision_promesa_jefe_red = floor($fila_det['promesa_monto_comision_jefe_ven'] * 1000) / 1000;
								        $comision_promesa_jefe_red = round($comision_promesa_jefe_red, 2);

								        // $monto_comision_promesa = round($fila_det['promesa_monto_comision_ven'] * $fila_det['valor_uf']);
			                            $monto_comision_promesa_jefe = round($comision_promesa_jefe_red * $UF_LIQUIDACION);
			                            // $monto_bono_promesa = round($fila_det['promesa_bono_precio_ven'] * $fila_det['valor_uf']);
			                            $promesa_bono_precio_jefe_ven = round($fila_det['promesa_bono_precio_jefe_ven'],2);
			                            $monto_bono_promesa_jefe = round($promesa_bono_precio_jefe_ven * $UF_LIQUIDACION);
		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?> <?php echo $fila_det['id_ven']; ?></td>
		                                    <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                    <td>UF <?php echo number_format($monto_ven_comision, 2, ',', '.');?></td>
		                                    <td><?php echo number_format($fila_det['total_comision_jefe_ven'], 3, ',', '.');?></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_promesa_jefe;
		                                    $contador_promesa++;
		                                    ?>
		                                    <td><?php echo $comision_promesa_jefe_red;?></td>
		                                    <td><?php echo number_format($monto_comision_promesa_jefe, 0, ',', '.');?></td>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    
		                                    <td><?php echo number_format($fila_det['total_bono_precio_jefe_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_promesa_jefe;
		                                    ?>
		                                    <td><?php echo number_format($fila_det['promesa_bono_precio_jefe_ven'], 2, ',', '.');?> ($<?php echo number_format($monto_bono_promesa_jefe, 0, ',', '.');?>.-)</td>
		                                    <td>0,00 ($0.-)</td>
		                                    <td>---</td>
		                                </tr>
		                                <?php
		                            }
		                        }

		                        // ESCRITURAS JEFE
		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                his.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_jefe_ven,
		                                ven.escritura_monto_comision_jefe_ven,
		                                ven.total_comision_jefe_ven,
		                                CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                                ven.promesa_bono_precio_jefe_ven,
		                                ven.escritura_bono_precio_jefe_ven,
		                                ven.total_bono_precio_jefe_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf,
		                            	ven.id_pie_abo_ven,
		                            	ven.descuento_ven,
		                            	ven.id_ven
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                                INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                            WHERE
		                                tor.id_con = ? AND
		                                ven.fecha_escritura_ven > '".$fecha_desde_consulta."' AND
		                                ven.fecha_escritura_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND
		                                his.id_est_ven IN (6) AND NOT EXISTS
		                                (
		                                SELECT
		                                    b.id_ven
		                                FROM
		                                    cierre_venta_cierre AS b
		                                WHERE
		                                    b.id_ven = ven.id_ven AND
		                                    b.id_est_ven = his.id_est_ven
		                                ) AND NOT EXISTS
			                            (
			                            SELECT
			                                des_ven.id_ven
			                            FROM
			                                venta_desestimiento_venta AS des_ven
			                            WHERE
			                                des_ven.id_ven = ven.id_ven
			                            )
		                                
		                            ";
		                        // echo $consulta;
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $cantidad_consulta = $conexion->total();
		                        $fila_consulta_detalle = $conexion->extraer_registro();


		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                // $monto_comision_promesa = round($fila_det['promesa_monto_comision_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_comision_escritura = round($fila_det['escritura_monto_comision_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_bono_promesa = round($fila_det['promesa_bono_precio_jefe_ven'] * $fila_det['valor_uf']);
		                                // $monto_bono_escritura = round($fila_det['escritura_bono_precio_jefe_ven'] * $fila_det['valor_uf']);

		                                // revisar valor de la venta
								        if ($fila_det['id_pie_abo_ven']==1) { //si aplica desceunto a pie
								        	$monto_ven_comision = $fila_det['monto_ven'] - $fila_det['descuento_ven'];
								        } else {
								        	$monto_ven_comision = $fila_det['monto_ven'];
								        }

								        $comision_escritura_jefe_red = floor($fila_det['escritura_monto_comision_jefe_ven'] * 1000) / 1000;
								        $comision_escritura_jefe_red = round($comision_escritura_jefe_red, 2);

								        // $monto_comision_promesa = round($fila_det['promesa_monto_comision_ven'] * $fila_det['valor_uf']);
			                            $monto_comision_escritura_jefe = round($comision_escritura_jefe_red * $UF_LIQUIDACION);
			                            // $monto_bono_promesa = round($fila_det['promesa_bono_precio_ven'] * $fila_det['valor_uf']);

			                            $escritura_bono_precio_jefe_ven = round($fila_det['escritura_bono_precio_jefe_ven'],2);
			                            $monto_bono_escritura_jefe = round($escritura_bono_precio_jefe_ven * $UF_LIQUIDACION);
		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?> <?php echo $fila_det['id_ven']; ?></td>
		                                    <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                    <td>UF <?php echo number_format($monto_ven_comision, 2, ',', '.');?></td>
		                                    <td><?php echo number_format($fila_det['total_comision_jefe_ven'], 3, ',', '.');?></td>
		                                    <?php  
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_escritura_jefe;
		                                    ?>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    <td><?php echo $comision_escritura_jefe_red;?></td>
		                                    <td><?php echo number_format($monto_comision_escritura_jefe, 0, ',', '.');?></td>
		                                        
		                                    
		                                    <td><?php echo number_format($fila_det['total_bono_precio_jefe_ven'], 2, ',', '.');?></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_escritura_jefe;
		                                    ?>
		                                    <td>0,00 ($0.-)</td>
		                                    <td><?php echo number_format($fila_det['escritura_bono_precio_jefe_ven'], 2, ',', '.');?> ($<?php echo number_format($monto_bono_escritura_jefe, 0, ',', '.');?>.-)</td>
		                                    <td>---</td>
		                                </tr>
		                                <?php
		                            }
		                        }
		                        ?>
		                        
		                        
		                        <tr>
		                            <td class="active" colspan="12"><b>Desistimiento</b></td>
		                        </tr>
		                        <?php  
		                        $total_desistimiento_acumulado = 0;
		                        $consulta = 
		                            "
		                            SELECT
		                                vend.id_vend,
		                                vend.nombre_vend,
		                                vend.apellido_paterno_vend,
		                                vend.apellido_materno_vend,
		                                ven.id_ven,
		                                ven.id_est_ven,
		                                ven.monto_ven,
		                                ven.promesa_monto_comision_jefe_ven,
		                                ven.escritura_monto_comision_jefe_ven,
		                                ven.total_comision_jefe_ven,
		                                ven.promesa_bono_precio_jefe_ven,
		                                ven.escritura_bono_precio_jefe_ven,
		                                ven.total_bono_precio_jefe_ven,
		                                viv.nombre_viv,
		                                uf.valor_uf
		                            FROM
		                                vendedor_vendedor AS vend
		                                INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                INNER JOIN venta_desestimiento_venta AS des_ven ON des_ven.id_ven = ven.id_ven
		                                -- INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(des_ven.fecha_des_ven)
		                                INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                            WHERE
		                                tor.id_con = ? AND
		                                des_ven.fecha_des_ven > '".$fecha_desde_consulta."' AND
		                                des_ven.fecha_des_ven <= '".$fecha_hasta_consulta."' AND
		                                vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND 
		                                des_ven.id_tip_des = 1 AND 
		                                ven.id_est_ven = 3 AND NOT 
		                                EXISTS(
		                                    SELECT 
		                                        ven_cie.id_ven_cie
		                                    FROM 
		                                        cierre_venta_cierre AS ven_cie
		                                    WHERE
		                                        ven_cie.id_ven = ven.id_ven AND
		                                        ven_cie.id_est_ven = 3
		                                ) AND  
		                                EXISTS(
		                                    SELECT 
		                                        ven_cie.id_ven_cie
		                                    FROM 
		                                        cierre_venta_cierre AS ven_cie
		                                    WHERE
		                                        ven_cie.id_ven = ven.id_ven AND
		                                        (ven_cie.id_est_ven = 4 OR ven_cie.id_est_ven = 6)
		                                )

		                                
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con']));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                            	$UF_DESISTIMIENTO_VENTA = 0;

		                        		$UF_DESISTIMIENTO_VENTA = get_uf_disistimiento($fila_det['id_ven']);

		                                $monto_comision_promesa = round(round($fila_det['promesa_monto_comision_jefe_ven'],2) * $UF_DESISTIMIENTO_VENTA);
		                                $monto_comision_escritura = round(round($fila_det['escritura_monto_comision_jefe_ven'],2) * $UF_DESISTIMIENTO_VENTA);
		                                $total_desistimiento = 0;

		                              //   if ($fila_det['id_ven'] == 484) {

			                            	// $promesa_monto_comision_ven_desistimiento = round($fila_det['promesa_monto_comision_jefe_ven'],2);
			                            	
			                            	// $monto_comision_promesa = $promesa_monto_comision_ven_desistimiento * 29706.87;

		                              //   }

		                              //   if ($fila_det['id_ven'] == 509) {

			                            	// $promesa_monto_comision_ven_desistimiento = round($fila_det['promesa_monto_comision_jefe_ven'],2);
			                            	
			                            	// $monto_comision_promesa = $promesa_monto_comision_ven_desistimiento * 29753.8;

		                              //   }
		                                
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        id_est_ven
		                                    FROM
		                                        cierre_venta_cierre
		                                    WHERE
		                                        id_ven = ? AND
		                                        id_est_ven = ?
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila_det['id_ven'],4));
		                                $cantidad_estado_promesa = $conexion->total();

		                                $consulta = 
		                                    "
		                                    SELECT
		                                        id_est_ven
		                                    FROM
		                                        cierre_venta_cierre
		                                    WHERE
		                                        id_ven = ? AND
		                                        id_est_ven = ?
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila_det['id_ven'],6));
		                                $cantidad_estado_escritura = $conexion->total();
		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv'])." ".$fila_det['id_ven'];?></td>
		                                    <td></td>
		                                    <td></td>
		                                    <td></td>
		                                    <?php  
		                                    if($cantidad_estado_promesa > 0){
		                                        $total_desistimiento = $total_desistimiento + $monto_comision_promesa;
		                                        ?>
		                                        <td><?php echo number_format($fila_det['promesa_monto_comision_jefe_ven'], 2, ',', '.');?></td>
		                                        <td><?php echo number_format($monto_comision_promesa, 0, ',', '.');?></td>
		                                        <?php
		                                    }
		                                    if($cantidad_estado_escritura > 0){
		                                        $total_desistimiento = $total_desistimiento + $monto_comision_escritura;
		                                        ?>
		                                        <td><?php echo number_format($fila_det['escritura_monto_comision_jefe_ven'], 2, ',', '.');?></td>
		                                        <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>

		                                        <?php
		                                    }
		                                    else{
		                                        ?>
		                                        <td>0,00</td>
		                                        <td>0</td>
		                                        <?php
		                                    }
		                                    ?>
		                                    <td></td>
		                                    <td></td>
		                                    <td></td>
		                                    <td><?php echo number_format($total_desistimiento, 0, ',', '.');?>.-</td>
		                                </tr>
		                                <?php
		                                $total_desistimiento_acumulado = $total_desistimiento_acumulado + $total_desistimiento;
		                            }
		                        }
		                        ?>
		                        
		                        <?php  
		                        // $monto_bono_rango = 0;
		                        // $monto_bono_rango_plata = 0;
		                        // if($monto_bono_jefe_acumulado_uf > 0){
		                        //     $monto_bono_rango = $monto_bono_jefe_acumulado_uf * ($porcentaje_bono_precio_jefe / 100);
		                        //     $monto_bono_rango_plata = ($monto_bono_jefe_acumulado_plata * ($porcentaje_bono_precio_jefe / 100)) * $valor_uf;
		                            
		                        //     $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;

		                        // } 
		                        $consulta = 
		                            "
		                            SELECT
		                                monto_bon,
		                            	nombre_bon
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                desde_bon <= ? AND
		                                hasta_bon >= ? AND
		                                id_tip_bon = 1 AND
		                                id_con = ? AND
		                                id_cat_bon = ?
		                            ";
		                        $conexion->consulta_form($consulta,array($contador_promesa,$contador_promesa,$fila['id_con'],1));
		                        $cantidad_bono = $conexion->total();
		                        if($cantidad_bono > 0){
			                        $fila_consulta_detalle = $conexion->extraer_registro();
				                    if(is_array($fila_consulta_detalle)){
				                        foreach ($fila_consulta_detalle as $fila_bono) {
					                        // $fila_bono = $conexion->extraer_registro_unico();
					                        $monto_bono_rango = 0;
					                        $monto_bono_rango_plata = 0;
					                        // if($cantidad_bono > 0){
					                        $nombre_bon = utf8_encode($fila_bono["nombre_bon"]);
				                            $monto_bono_rango = $fila_bono["monto_bon"];
				                            $monto_bono_rango_plata = $fila_bono["monto_bon"] * $valor_uf;


				                            $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
					                        // }
					                        ?>
					                        <tr>
					                            <td class="active" colspan="9"><b><?php echo $nombre_bon ?></b></td>
					                            <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
					                            <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
					                            <td></td>
					                        </tr>
					                        <?php  
					                    }
					                }
					            }

		                        //---- BONO CATEGORIA FECHA SIN MODELO 
		                        $consulta = 
		                            "
		                            SELECT
		                                *
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                id_tip_bon = 1 AND
		                                id_con = ? AND
		                                id_cat_bon = ? AND
		                                MONTH(fecha_hasta_bon) = '".$mes."' AND
		                                YEAR(fecha_hasta_bon) = '".$anio."'
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con'],2));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_bono_rango = 0;
		                                $monto_bono_rango_plata = 0;
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        ven.id_ven 
		                                    FROM
		                                        vendedor_vendedor AS vend
		                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    WHERE
		                                        tor.id_con = ? AND
		                                        ven.fecha_promesa_ven >= ? AND
		                                        ven.fecha_promesa_ven <= ? AND
		                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND NOT
		                                        ven.id_est_ven = 3 AND NOT EXISTS
		                                        (
		                                        SELECT
		                                            b.id_ven_bon
		                                        FROM
		                                            bono_venta_bono AS b
		                                        WHERE
		                                            b.id_ven = ven.id_ven AND
		                                            b.id_bon = ?
		                                        )
		                                    GROUP BY 
		                                        ven.id_ven 
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila_det["id_bon"]));
		                                $cantidad_bono = $conexion->total();
		                                if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                    $monto_bono_rango = $fila_det["monto_bon"];
		                                    $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                    ?>
		                                    <tr>
		                                        <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                        <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                        <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                        <td></td>
		                                    </tr>
		                                    <?php

		                                }
		                            }
		                        }


		                        //---- BONO CATEGORIA FECHA CON MODELO 
		                        $consulta = 
		                            "
		                            SELECT
		                                *
		                            FROM
		                                bono_bono
		                            WHERE
		                                id_est_bon = 1 AND
		                                id_tip_bon = 1 AND
		                                id_con = ? AND
		                                id_cat_bon = ? AND
		                                MONTH(fecha_hasta_bon) = '".$mes."' AND
		                                YEAR(fecha_hasta_bon) = '".$anio."'
		                            ";
		                        $conexion->consulta_form($consulta,array($fila['id_con'],3));
		                        $fila_consulta_detalle = $conexion->extraer_registro();
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_bono_rango = 0;
		                                $monto_bono_rango_plata = 0;
		                                $consulta = 
		                                    "
		                                    SELECT
		                                        ven.id_ven 
		                                    FROM
		                                        vendedor_vendedor AS vend
		                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
		                                    WHERE
		                                        tor.id_con = ? AND
		                                        ven.fecha_promesa_ven >= ? AND
		                                        ven.fecha_promesa_ven <= ? AND
		                                        viv.id_mod = ? AND
		                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND NOT
		                                        ven.id_est_ven = 3 AND NOT EXISTS
		                                        (
		                                        SELECT
		                                            b.id_ven_bon
		                                        FROM
		                                            bono_venta_bono AS b
		                                        WHERE
		                                            b.id_ven = ven.id_ven AND
		                                            b.id_bon = ?
		                                        )
		                                    GROUP BY 
		                                        ven.id_ven
		                                    ";
		                                $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila_det["id_mod"],$fila_det["id_bon"]));
		                                $cantidad_bono = $conexion->total();
		                                if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
		                                    $monto_bono_rango = $fila_det["monto_bon"];
		                                    $monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
		                                    ?>
		                                    <tr>
		                                        <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
		                                        <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
		                                        <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
		                                        <td></td>
		                                    </tr>
		                                    <?php

		                                }
		                            }
		                        }

		                        //---- BONO TÉRMINO VENTAS 
			                    $no_termino = 0;

								// preguntar si estoy en el mes de cierre venta
								$consulta_termino = 
			                        "
			                        SELECT
			                            valor_par
			                        FROM
			                            parametro_parametro
			                        WHERE
			                            valor2_par = ? AND
			                            id_con = ? 
			                        ";
			                    
			                    $conexion->consulta_form($consulta_termino,array(26,$fila['id_con']));
			                    $fila_term = $conexion->extraer_registro_unico();
			                    $fecha_termino = $fila_term['valor_par'];
			                    if ($fecha_termino<>'' & $fecha_termino<>null) {
			                    	$mes_termino = date("n",strtotime($fecha_termino));
			                    } else {
			                    	$no_termino = 1;
			                    }

			                    if ($mes_termino<>$mes) {
			                    	$no_termino = 1;
			                    }

								if ($no_termino==0) {
								// echo $mes_termino." - ".$mes;
									$consulta = 
				                        "
				                        SELECT
				                            *
				                        FROM
				                            bono_bono
				                        WHERE
				                            id_est_bon = 1 AND
				                            id_tip_bon = 1 AND
				                            id_con = ? AND
				                            id_cat_bon = ? AND
				                            MONTH(fecha_hasta_bon) = '".$mes."' AND
				                            YEAR(fecha_hasta_bon) = '".$anio."'
				                        ";
				                    $conexion->consulta_form($consulta,array($fila['id_con'],4));

				                    $fila_consulta_detalle = $conexion->extraer_registro();
				                    if(is_array($fila_consulta_detalle)){
				                        foreach ($fila_consulta_detalle as $fila_det) {
				                        	// echo $mes_termino." - ".$mes;
											
											if ($fila_det["desde_bon"]==0 && $fila_det["hasta_bon"]==0) {
												// cuando no hay rango, se paga directo
												$monto_bono_rango = $fila_det["monto_bon"];
		                                    	$monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    	$monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;

												?>
				                                <tr>
				                                    <td class="active" colspan="9"><b>aaa<?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
				                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
				                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
				                                    <td></td>
				                                </tr>
				                                <?php

											} else {
												$monto_bono_rango = 0;
		                                		$monto_bono_rango_plata = 0;
					                            $consulta = 
			                                    "
			                                    SELECT
			                                        ven.id_ven 
			                                    FROM
			                                        vendedor_vendedor AS vend
			                                        INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
			                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
			                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
			                                        INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(ven.fecha_ven)
			                                    WHERE
			                                        tor.id_con = ? AND
			                                        ven.fecha_promesa_ven >= ? AND
			                                        ven.fecha_promesa_ven <= ? AND
			                                        vend.id_vend IN (".implode(',',$arreglo_vendedor_jefe).") AND NOT
			                                        ven.id_est_ven = 3 AND NOT EXISTS
			                                        (
			                                        SELECT
			                                            b.id_ven_bon
			                                        FROM
			                                            bono_venta_bono AS b
			                                        WHERE
			                                            b.id_ven = ven.id_ven AND
			                                            b.id_bon = ?
			                                        )
			                                    GROUP BY 
			                                        ven.id_ven 
			                                    ";
					                            $conexion->consulta_form($consulta,array($fila['id_con'],$fila_det["fecha_desde_bon"],$fila_det["fecha_hasta_bon"],$fila_det["id_bon"]));
					                            $cantidad_bono = $conexion->total();
					                            // echo $cantidad_bono."----".print_r($arreglo_vendedor_jefe)."sdsd";
					                            if($cantidad_bono >= $fila_det["desde_bon"] && $cantidad_bono <= $fila_det["hasta_bon"]){
					                                $monto_bono_rango = $fila_det["monto_bon"];
		                                    		$monto_bono_rango_plata = $fila_det["monto_bon"] * $valor_uf;
		                                    
		                                    		$monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_bono_rango_plata;
					                                ?>
					                                <tr>
					                                    <td class="active" colspan="9"><b><?php echo utf8_encode($fila_det['nombre_bon']);?></b></td>
					                                    <td style="background-color: #FFFFFF">UF <?php echo number_format($monto_bono_rango, 2, ',', '.');?></td>
					                                    <td style="background-color: #FFFFFF">$ <?php echo number_format($monto_bono_rango_plata, 0, ',', '.');?>.-</td>
					                                    <td></td>
					                                </tr>
					                                <?php

					                            }

											}
				                            
				                        }
				                    }
				                }

		                        $monto_acumulado_a_pagar = $monto_acumulado_a_pagar - $total_desistimiento_acumulado;
		                        ?>
		                        <tr class="success">
		                            <td colspan="2"><b>Total a Pagar</b></td>
		                            <td colspan="2"><?php echo number_format($monto_acumulado_a_pagar, 0, ',', '.');?>.-</td>
		                            <td colspan="8"></td>
		                        </tr>
		                    </table>
		                </div>
		                <?php
		            }
		        }
		    }



		    //--------- OPERACIONES ---------
		    $arreglo_vendedor_operacion = array();
		    
		    $monto_acumulado_a_pagar = 0;
		    $total_desistimiento = 0;
		    $total_desistimiento_acumulado = 0;

		    // selecciona vendedores activos, un nuevo array de vendedores, con todos los activos
		    

		    // print_r($arreglo_vendedores_operacion);


		    $consulta = 
		        "
		        SELECT
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.id_con,
		            con.nombre_con
		        FROM
		            usuario_usuario AS usu
		            INNER JOIN venta_venta AS ven ON ven.id_operacion_ven = usu.id_usu
		            INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		            INNER JOIN condominio_condominio AS con ON con.id_con = con_usu.id_con
		            INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		        WHERE
		            usu.id_per = ? AND
		            ven.id_vend IN (".implode(',',$arreglo_vendedores_operacion).") AND
		            con.id_con = ".$condo." AND
		            his.id_est_ven = 6
		        GROUP BY 
		            usu.id_usu,
		            usu.nombre_usu,
		            usu.apellido1_usu,
		            usu.apellido2_usu,
		            con.nombre_con,
		            con.id_con
		        ";
		    // echo $consulta;
		    $conexion->consulta_form($consulta,array(3));
		    $cantidad_venta_oopp = $conexion->total();
		    if($cantidad_venta_oopp > 0){
		        ?>
		        <div class="col-sm-12">
		            <h4>Operaciones</h4>
		        </div>
		        <?php
		    }
		    $fila_consulta = $conexion->extraer_registro();
		    if(is_array($fila_consulta)){
		        foreach ($fila_consulta as $fila) {
		            // $monto_bono_jefe_acumulado_uf = 0;
		            // $monto_bono_jefe_acumulado_plata = 0;
		            
		            $consulta = 
		                "
		                SELECT
		                    DISTINCT(ven.id_vend)
		                FROM
		                    usuario_usuario AS usu
		                    INNER JOIN venta_venta AS ven ON ven.id_operacion_ven = usu.id_usu 
		                    INNER JOIN usuario_condominio_usuario AS con_usu ON con_usu.id_usu = usu.id_usu
		                WHERE
		                    usu.id_usu = ? AND
		                    con_usu.id_con = ? AND
		                    ven.id_vend IN (".implode(',',$arreglo_vendedores_operacion).") 
		                ";
		            // echo $consulta;
		            $conexion->consulta_form($consulta,array($fila["id_usu"],$fila["id_con"]));
		            $fila_consulta_usuario = $conexion->extraer_registro();
		            if(is_array($fila_consulta_usuario)){
		                foreach ($fila_consulta_usuario as $fila_usu) {
		                    
		                    if(!in_array($fila_usu["id_vend"],$arreglo_vendedor_operacion)){
		                        $arreglo_vendedor_operacion[$fila_usu["id_vend"]] = $fila_usu["id_vend"];
		                    }
		                }
		            }
		            $monto_acumulado_a_pagar = 0;
		            $consulta = 
		                "
		                SELECT
		                    vend.id_vend,
		                    vend.nombre_vend,
		                    vend.apellido_paterno_vend,
		                    vend.apellido_materno_vend,
		                    his.id_est_ven,
		                    ven.monto_ven,
		                    ven.promesa_monto_comision_jefe_ven,
		                    ven.escritura_monto_comision_operacion_ven,
		                    ven.total_comision_jefe_ven,
		                    CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente, 
		                    ven.promesa_bono_precio_jefe_ven,
		                    ven.escritura_bono_precio_jefe_ven,
		                    ven.total_bono_precio_jefe_ven,
		                    viv.nombre_viv,
		                    eta_cam_ven.valor_campo_eta_cam_ven,
		                    uf.valor_uf,
		                    ven.id_ven
		                FROM
		                    vendedor_vendedor AS vend
		                    INNER JOIN venta_venta AS ven ON ven.id_vend = vend.id_vend
		                    INNER JOIN venta_etapa_venta AS eta_ven ON eta_ven.id_ven = ven.id_ven
		                    INNER JOIN venta_etapa_campo_venta AS eta_cam_ven ON eta_cam_ven.id_ven = ven.id_ven
		                    INNER JOIN uf_uf AS uf ON uf.fecha_uf = DATE(eta_cam_ven.valor_campo_eta_cam_ven)
		                    INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
		                    INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
		                    INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
		                    INNER JOIN venta_estado_historial_venta AS his ON his.id_ven = ven.id_ven
		                WHERE
		                    tor.id_con = ? AND
		                    ven.fecha_escritura_ven > '".$fecha_desde_consulta."' AND
		                    ven.fecha_escritura_ven <= '".$fecha_hasta_consulta."' AND
		                    his.id_est_ven IN (6) AND
		                    ((eta_ven.id_eta = 27 AND eta_ven.id_est_eta_ven = 1) OR (eta_ven.id_eta = 6 AND eta_ven.id_est_eta_ven = 1)) AND
		                    (eta_cam_ven.id_cam_eta = 32 OR eta_cam_ven.id_cam_eta = 5)
		                    
		                ";


		            // echo $consulta;
		                // fecha firma
		                // contado es id_cam_eta = 5
		                // credito es id_cam_eta = 32
		            $conexion->consulta_form($consulta,array($fila["id_con"]));
		            $cantidad_consulta = $conexion->total();
		            $fila_consulta_detalle = $conexion->extraer_registro();
		            $contador_promesa = 0;
		            if($cantidad_consulta > 0){
		                ?>
		                <div class="col-sm-12 table-responsive">
		                    <table class="table table-striped table-bordered">
		                        <tr>
		                            <td colspan="12"><?php echo utf8_encode($fila['nombre_usu']." ".$fila['apellido1_usu']." ".$fila['apellido2_usu']);?></td>
		                        </tr>
		                        <tr class="font-weight-bold">
		                            <td colspan="3"></td>
		                            <td colspan="5" class="text-center">Comisiones</td>
		                            <td colspan="3" class="text-center">Bono al Precio</td>
		                            <td></td>
		                        </tr>
		                        <tr class="active font-weight-bold">
		                            <td>Unidad</td>
		                            <td>Cliente</td>
		                            <td>Valor Venta</td>
		                            <td>Comisión</td>
		                            <td>Comisión Promesa UF</td>
		                            <td>Comisión Promesa $</td>
		                            <td>Comisión Escritura UF</td>
		                            <td>Comisión Escritura $</td>
		                            <td>B. Precio</td>
		                            <td>B. Precio Promesa</td>
		                            <td>B. Precio Escritura</td>
		                            <td>Desistimiento</td>
		                        </tr>
		                        <?php  
		                        
		                        if(is_array($fila_consulta_detalle)){
		                            foreach ($fila_consulta_detalle as $fila_det) {
		                                $monto_comision_promesa = round($fila_det['promesa_monto_comision_jefe_ven'] * $fila_det['valor_uf']);
		                                $monto_comision_escritura = round($fila_det['escritura_monto_comision_operacion_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_promesa = round($fila_det['promesa_bono_precio_jefe_ven'] * $fila_det['valor_uf']);
		                                $monto_bono_escritura = round($fila_det['escritura_bono_precio_jefe_ven'] * $fila_det['valor_uf']);
		                                ?>
		                                <tr>
		                                    <td><?php echo utf8_encode($fila_det['nombre_viv']);?> - id venta: <?php echo $fila_det['id_ven']; ?></td>
		                                    <td><?php echo utf8_encode($fila_det['cliente']);?></td>
		                                    <td>UF <?php echo number_format($fila_det['monto_ven'], 2, ',', '.');?></td>
		                                    <td></td>
		                                    <?php  
		                                    $monto_acumulado_a_pagar = $monto_acumulado_a_pagar + $monto_comision_escritura;
		                                    ?>
		                                    <td>0,00</td>
		                                    <td>0</td>
		                                    <td><?php echo number_format($fila_det['escritura_monto_comision_operacion_ven'], 2, ',', '.');?></td>
		                                    <td><?php echo number_format($monto_comision_escritura, 0, ',', '.');?></td>
		                                        
		                                    
		                                    <td></td>
		                                    
		                                    <td>0,00 ($0.-)</td>
		                                    <td>0,00 ($0.-)</td>
		                                        
		                                    
		                                    <td>---</td>
		                                </tr>
		                                <?php
		                            }
		                        }
		                        ?>
		                        
		                        
		                        
		                        <?php  
		                        
		                          
		                        // $monto_acumulado_a_pagar = $monto_acumulado_a_pagar - $total_desistimiento_acumulado;
		                        ?>
		                        <tr class="success">
		                            <td colspan="2"><b>Total a Pagar</b></td>
		                            <td colspan="2"><?php echo number_format($monto_acumulado_a_pagar, 0, ',', '.');?>.-</td>
		                            <td colspan="8"></td>
		                        </tr>
		                    </table>
		                </div>
		                <?php
		            }     
		        }
		    }

		    

		}
		else{
		    ?>
		    <div class="col-sm-12">
		        <h4>Vendedores y Jefe de Ventas</h4>
		    </div>
		    <div class="col-xs-12">
		        <h4 style="font-size: 14px">
		            <?php echo $nombre_con; ?>: <b>No se encuentra ninguna venta para liquidar</b>
		        </h4>
		        <hr>
		    </div>
		    <?php
		}

		// JEFE OPERACIONES
		$consulta_jefe_op = 
		    "
		    SELECT
		        CONCAT(nombre_usu,' ', apellido1_usu) as jefe_ope,
		        id_usu
		    FROM
		        usuario_usuario
		    WHERE
		        id_per = 7 AND
		        id_est_usu = 1 
		    ";
		$conexion->consulta($consulta_jefe_op);
		$fila_jefeop = $conexion->extraer_registro_unico();
		$id_usu_jefop = $fila_jefeop['id_usu'];
		?>
		<div class="col-sm-12">
	        <h4>Jefe de Operaciones</h4>
	    </div>
		<div class="col-sm-12 table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="9"><?php echo$nombre_con; ?> - <?php echo utf8_encode($fila_jefeop['jefe_ope']);?></td>
                </tr>
                <tr class="active font-weight-bold">
                    <td>Unidad</td>
                    <td>Cliente</td>
                    <td>Forma de Pago</td>
                    <td>Fecha Escritura</td>
                    <td>Fecha Liquidación</td>
                    <td>Semanas</td>
                    <td>Nombre Bono</td>
                    <td>Monto UF</td>
                    <td>Monto $</td>
                </tr>

			<?php

			$acumula_monto_uf_bono = 0;
			$acumula_monto_pesos_bono = 0;

			$consulta_jo = 
	            "
	            SELECT
	                ven.monto_ven,
	                CONCAT(pro.nombre_pro,' ', pro.apellido_paterno_pro) as cliente,
	                viv.id_mod,
	                viv.nombre_viv,
	                ven.id_ven,
	                ven_liq.fecha_liq_ven,
	                ven.fecha_escritura_ven,
	                ven.id_for_pag,
	                ven_cam.ciudad_notaria_ven
	            FROM
	                venta_venta AS ven
	                INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
	                INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
	                INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
	                INNER JOIN venta_liquidado_venta AS ven_liq ON ven_liq.id_ven = ven.id_ven
	                LEFT JOIN venta_campo_venta AS ven_cam ON ven_cam.id_ven = ven.id_ven
	            WHERE
	                tor.id_con = ? AND
	                (MONTH(ven_liq.fecha_liq_ven) = ".$mes_desde_liq." OR MONTH(ven_liq.fecha_liq_ven) = ".$mes_hasta_liq.") AND
	                YEAR(ven_liq.fecha_liq_ven) = ".$_SESSION["sesion_anio_liquidacion_panel"]." AND 
	                ven_liq.fecha_liq_ven >= '".$fecha_desde_consulta."' AND 
	                ven_liq.fecha_liq_ven < '".$fecha_hasta_consulta."' AND 
	                ven_liq.monto_liq_uf_ven <> '' AND
	                NOT EXISTS
	                (
	                SELECT
	                    cie_bon_ven.id_ven
	                FROM
	                    cierre_bono_cierre_venta AS cie_bon_ven
	                WHERE
	                    cie_bon_ven.id_ven = ven.id_ven AND 
	                    cie_bon_ven.id_usu = ".$id_usu_jefop."
	                )
	                
	            ";

	        $conexion->consulta_form($consulta_jo,array($fila['id_con']));
	        $fila_consulta_joperaciones = $conexion->extraer_registro();
	        $contador_jo = 0;
	        if(is_array($fila_consulta_joperaciones)){
	            foreach ($fila_consulta_joperaciones as $fila_jo) {
	            	$cliente = utf8_encode($fila_jo["cliente"]);
	            	$nombre_viv = utf8_encode($fila_jo["nombre_viv"]);
	            	$id_ven = $fila_jo["id_ven"];
	            	
	            	$fecha_liq_ven = $fila_jo["fecha_liq_ven"];
	            	$fecha_escritura_ven = $fila_jo["fecha_escritura_ven"];
	            	$id_for_pag = $fila_jo["id_for_pag"];

	            	$ciudad_notaria_ven = $fila_jo["ciudad_notaria_ven"];

	            	$fecha_escritura = date("d/m/Y",strtotime($fecha_escritura_ven));
	            	$fecha_liquidacion = date("d/m/Y",strtotime($fecha_liq_ven));

	            	$rango_dias= (strtotime($fecha_liq_ven)-strtotime($fecha_escritura_ven))/86400;
					$rango_dias = abs($rango_dias); 
					$rango_dias = floor($rango_dias);



					$rango_en_semanas = $rango_dias / 7;
					$rango_en_semanas = round($rango_en_semanas);

					// echo $id_ven."---".$rango_dias."- -".$rango_en_semanas." - ".$ciudad_notaria_ven."<br>";

					// echo $condo." - ".$id_ven." - ".$fecha_liq_ven." - ".$fecha_escritura_ven." - ".$rango_dias." - ".$rango_en_semanas."<br>";

	            	// segun forma de pago va a buscar ciudad, cambiar cuando se cambie lugar CIUDAD
	            	if ($id_for_pag==1) {
			        	$ciudad_cre = $ciudad_notaria_ven;
			        	// $ciudad_cre="2";
			        	if($ciudad_cre==1) {
			        		// si es Serena
			        		$bono_cat = 5;
			        		$consulta_bono = 
		                        "
		                        SELECT
		                            nombre_bon,
		                            monto_bon
		                        FROM
		                            bono_bono
		                        WHERE
		                            id_est_bon = 1 AND
		                            id_tip_bon = 4 AND
		                            id_con = ? AND
		                            id_cat_bon = ? AND
		                            desde_bon <= ? AND
			                        hasta_bon >= ?
		                        ";
		                    $conexion->consulta_form($consulta_bono,array($condo,$bono_cat,$rango_en_semanas,$rango_en_semanas));
		                    $tiene_bono = $conexion->total();
		                    if ($tiene_bono>0) {
		                    	$fila_conbono = $conexion->extraer_registro_unico();
		                    	$bono_uf = $fila_conbono['monto_bon'];
		                    	$acumula_monto_uf_bono = $acumula_monto_uf_bono + $bono_uf;
		                    	$bono_pesos = $UF_LIQUIDACION * $fila_conbono['monto_bon'];
		                    	$acumula_monto_pesos_bono = $acumula_monto_pesos_bono + $bono_pesos;
		                    	$bono_pesos = number_format($bono_pesos, 0, ',', '.');
		                    	?>
		                    	<tr>
		                    		<td><?php echo $nombre_viv; ?> - <?php echo $id_ven; ?></td>
		                    		<td><?php echo $cliente; ?></td>
		                    		<td>Crédito</td>
		                    		<td><?php echo $fecha_escritura; ?></td>
		                    		<td><?php echo $fecha_liquidacion; ?></td>
		                    		<td><?php echo $rango_en_semanas; ?></td>
		                    		<td><?php echo utf8_encode($fila_conbono['nombre_bon']); ?></td>
		                    		<td><?php echo $bono_uf; ?></td>
		                    		<td><?php echo $bono_pesos; ?></td>
		                    	</tr>
		                    	<?php

		                    }
		                    
			        	} else if($ciudad_cre==2) {
			        		// Si es Santiago
			        		$bono_cat = 6;
			        		$consulta_bono = 
		                        "
		                        SELECT
		                            nombre_bon,
		                            monto_bon
		                        FROM
		                            bono_bono
		                        WHERE
		                            id_est_bon = 1 AND
		                            id_tip_bon = 4 AND
		                            id_con = ? AND
		                            id_cat_bon = ? AND
		                            desde_bon <= ? AND
			                        hasta_bon >= ?
		                        ";
		                    $conexion->consulta_form($consulta_bono,array($condo,$bono_cat,$rango_en_semanas,$rango_en_semanas));
		                    $tiene_bono = $conexion->total();
		                    if ($tiene_bono>0) {
		                    	$fila_conbono = $conexion->extraer_registro_unico();
		                    	$bono_uf = $fila_conbono['monto_bon'];
		                    	$acumula_monto_uf_bono = $acumula_monto_uf_bono + $bono_uf;
		                    	$bono_pesos = $UF_LIQUIDACION * $fila_conbono['monto_bon'];
		                    	$acumula_monto_pesos_bono = $acumula_monto_pesos_bono + $bono_pesos;
		                    	$bono_pesos = number_format($bono_pesos, 0, ',', '.');
		                    	?>
		                    	<tr>
		                    		<td><?php echo $nombre_viv; ?></td>
		                    		<td><?php echo $cliente; ?></td>
		                    		<td>Crédito</td>
		                    		<td><?php echo $fecha_escritura; ?></td>
		                    		<td><?php echo $fecha_liquidacion; ?></td>
		                    		<td><?php echo $rango_en_semanas; ?></td>
		                    		<td><?php echo utf8_encode($fila_conbono['nombre_bon']); ?></td>
		                    		<td><?php echo $bono_uf; ?></td>
		                    		<td><?php echo $bono_pesos; ?></td>
		                    	</tr>
		                    	<?php

		                    }

			        	} else {
			        		// no cargaron ciudad
			        		?>
	                    	<tr>
	                    		<td><?php echo $nombre_viv; ?></td>
	                    		<td><?php echo $cliente; ?></td>
	                    		<td>Crédito</td>
	                    		<td><?php echo $fecha_escritura; ?></td>
		                    	<td><?php echo $fecha_liquidacion; ?></td>
		                    	<td><?php echo $rango_en_semanas; ?></td>
	                    		<td colspan="3">NO TIENE CARGADA CIUDAD</td>
	                    	</tr>
	                    	<?php
			        	}
			            
	            	} else {
	            		// si es contado
	            		$bono_cat = 7;
	            		$consulta_bono = 
	                        "
	                        SELECT
	                            nombre_bon,
	                            monto_bon
	                        FROM
	                            bono_bono
	                        WHERE
	                            id_est_bon = 1 AND
	                            id_tip_bon = 4 AND
	                            id_con = ? AND
	                            id_cat_bon = ? AND
	                            desde_bon <= ? AND
		                        hasta_bon >= ?
	                        ";
	                    $conexion->consulta_form($consulta_bono,array($condo,$bono_cat,$rango_en_semanas,$rango_en_semanas));
	                    $tiene_bono = $conexion->total();
	                    if ($tiene_bono>0) {
	                    	$fila_conbono = $conexion->extraer_registro_unico();
	                    	$bono_uf = $fila_conbono['monto_bon'];
	                    	$acumula_monto_uf_bono = $acumula_monto_uf_bono + $bono_uf;
	                    	$bono_pesos = $UF_LIQUIDACION * $fila_conbono['monto_bon'];

	                    	$acumula_monto_pesos_bono = $acumula_monto_pesos_bono + $bono_pesos;

	                    	$bono_pesos = number_format($bono_pesos, 0, ',', '.');
	                    	?>
	                    	<tr>
	                    		<td><?php echo $nombre_viv; ?> - <?php echo $id_ven; ?></td>
	                    		<td><?php echo $cliente; ?></td>
	                    		<td>Contado</td>
	                    		<td><?php echo $fecha_escritura; ?></td>
	                    		<td><?php echo $fecha_liquidacion; ?></td>
	                    		<td><?php echo $rango_en_semanas; ?></td>
	                    		<td><?php echo utf8_encode($fila_conbono['nombre_bon']); ?></td>
	                    		<td><?php echo $bono_uf; ?></td>
	                    		<td><?php echo $bono_pesos; ?></td>
	                    	</tr>
	                    	<?php

	                    }
	            	}
	            	

	            }
	        }


	    ?>
	    		<tr class="success">
                    <td colspan="2"><b>Total a Pagar</b></td>
                    <td colspan="2"><?php echo number_format($acumula_monto_pesos_bono, 0, ',', '.');?>.-</td>
                    <td colspan="5"></td>
                </tr>
	    	</table>
	    </div>


	    <?php

    }
}

if($cantidad_venta_totales > 0){
    ?>
    <div class="col-sm-1" style="padding-top: 20px;">
        <button type="button" class="btn btn-primary pull-center" id="guarda">Cerrar Mes</button>
    </div>
    <?php
}

?>





<script src="<?php echo _ASSETS?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo _ASSETS?>plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
        $(function () {
          $('[data-toggle="popover"]').popover()
        });

        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            // startDate: '-0d',
            todayHighlight: true,
            language: 'es',
            autoclose: true
        });


        
    });    
</script>