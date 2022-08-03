<?php
session_start();
date_default_timezone_set('America/Santiago');
//$curso = $_GET["id"];
?>
<div class="col-md-12 fecha"><i class="fa fa-calendar-o"></i> <?php echo $_POST['currentDay'];?>-<?php echo $_POST['currentMonth'];?>-<?php echo $_POST['currentYear'];?></div>
<?php
include '../../../config.php';
include '../../../class/conexion.php';
$conexion = new conexion(); 
$consulta = 
	"
	SELECT 
		eve.nombre_eve,
		eve.fecha_eve,
		eve.descripcion_eve,
		eve.id_cat_eve,
		eve.id_est_eve,
		eve.id_eve,
		eve.time_eve,
		pro.nombre_pro,
		pro.apellido_paterno_pro,
		pro.apellido_materno_pro,
		eve.id_cot
	FROM 
		evento_evento AS eve,
		propietario_propietario AS pro
	WHERE
		eve.id_cat_eve = 1 AND
		eve.id_usu = ".$_SESSION["sesion_id_panel"]." AND
		YEAR(eve.fecha_eve) = ".$_POST['currentYear']." AND
		MONTH(eve.fecha_eve) = ".$_POST['currentMonth']." AND
		DAYOFMONTH(eve.fecha_eve) = ".$_POST['currentDay']." AND
		eve.id_pro = pro.id_pro
	ORDER BY
		eve.time_eve ASC
	";
	// echo $consulta;
	//echo "<br>".$_SESSION['curso'];
	$conexion->consulta($consulta);
	$nquery = $conexion->total();
	$conta = 0;
	$fila_consulta = $conexion->extraer_registro();
    if(is_array($fila_consulta)){
        foreach ($fila_consulta as $fila) {
			$fecha_eve = $fila["fecha_eve"];
			$nombre_eve = utf8_encode($fila["nombre_eve"]);
			$descripcion_eve = utf8_encode($fila["descripcion_eve"]);
			$descripcion_eve = str_replace("\n", "<br>", $descripcion_eve);
			$id_cat_eve = $fila["id_cat_eve"];
			$time_eve = utf8_encode($fila["time_eve"]);
			$time_format = date("H:i",strtotime($time_eve));
			$id_eve = $fila["id_eve"];
			$id_cot = $fila["id_cot"];
			$id_est_eve = $fila["id_est_eve"];
			$nombre_pro = utf8_encode($fila["nombre_pro"]." ".$fila["apellido_paterno_pro"]." ".$fila["apellido_materno_pro"]);

			// if($id_cat_eve==1){
				// $gene = "(General)";
			// } else {
				// $gene = "";
			// }
			$con_alerta = 0;
			if ($id_est_eve == 2) {
				$clase_realizado = "realizado";
			} else {
				$clase_realizado = "";

				$fecha_actual = date("Y-m-d");
				$hora_actual = date("H:i:00");
				
				if ($fecha_eve < $fecha_actual) {
					$con_alerta = 1;
				}

				if ($fecha_eve == $fecha_actual && $time_eve < $hora_actual) {
					$con_alerta = 1;
				}			
			}

			

			?>
			<div class=" col-md-12 <?php echo $clase_realizado; ?>" style="border-bottom: 1px dotted #cccccc">
				<div class="row">
					<div class="col-md-9">
						<h4><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $time_format; ?> | <?php echo $con_alerta == 1 ? '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' : ''; ?> <?php echo $nombre_eve;?> </h4>
						<h5>
							<b>Cliente:</b> <?php echo $nombre_pro; ?> | <b>Cotización:</b> <?php echo $id_cot; ?> <button class="detalle_cot btn btn-link" value="<?php echo $id_cot; ?>"><i class="fa fa-search" aria-hidden="true"></i></button>
						</h5>
						<p class="describe"><?php echo $descripcion_eve;?></p>
					</div>
					<div class="col-md-3" style="padding-top: 20px">
						<?php 
						if ($id_est_eve == 1) {
						 ?>
						 <button value="<?php echo $id_eve; ?>" type="button" title="reagendar" class="btn btn-warning edita_evento btn-sm">
						  <i class="fa fa-pencil" aria-hidden="true"></i>
						</button>
						<button value="<?php echo $id_eve; ?>" type="button" title="Pasar a Realizado" class="btn btn-info estado_evento btn-sm">
						  <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
						</button>
						<?php 
						}
						 ?>
					</div>
				</div>
			</div>

    		<?php
		}
	}
?>
