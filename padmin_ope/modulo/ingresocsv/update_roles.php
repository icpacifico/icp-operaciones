<?php
session_start();
require "../../config.php"; 
if(!isset($_SESSION["sesion_usuario_panel"])) header("Location: ../../index.php");
if(!isset($_SESSION["modulo_uf_panel"])) header("Location: ../../panel.php");
if($_FILES['file_condominio'] == ''){
	header("Location: "._ADMIN."index.php");
	exit();
}
?>
<link rel="stylesheet" href="<?php echo _ASSETS?>plugins/alert_prueba/dist/sweetalert.css">
<script src="<?php echo _ASSETS?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include _INCLUDE."class/conexion.php";
$conexion = new conexion();

try {
	

		$condominio = isset($_POST["condominio"]) ? $_POST["condominio"] : "";
		$r=array("//","\\","//");
		$rr=array("/","/","/");		
		$destino =  "../../../archivo/".$_FILES['file_condominio']['name'];
		copy($_FILES['file_condominio']['tmp_name'],$destino);
			
		$rol_viv = 0;
		$rol_bod = 0;
		$aCadena = file($destino);
			$resultado = count($aCadena);
			$resultado = $resultado-1;             
			for ($i = 1; $i <= $resultado; $i++) {
				$dato = explode(";",$aCadena[$i]);

				$vivienda = $dato[0];
				$rol_vivienda = $dato[1];
				$rol_bodega = $dato[2];

                /**  PRIMERO OBTENGO EL ID DE VIVIENDA PARA PORDER ACTUALIZAR EL REGISTRO DE BODEGA DEL CONDOMINIO RESPECTIVO */
				            				
				$conexion->consulta("SELECT id_viv FROM vivienda_vivienda WHERE id_tor = ".$condominio." and nombre_viv='".$vivienda."'");
				$id_vivi = $conexion->extraer_registro_unico();
				$id_vivienda = $id_vivi['id_viv'];

                /** AHORA EJECUTO LA ACTUALIZACION DE REGISTRO DE ROLES A LA TABLA BODEGA */

                $conexion->consulta("UPDATE bodega_bodega SET rol_bod = '".$rol_bodega."' WHERE id_viv = ".$id_vivienda." ");
                $conexion->consulta("UPDATE vivienda_vivienda SET rol_viv = '".$rol_vivienda."' WHERE id_viv = ".$id_vivienda." ");

				
				// if (empty($vivienda) || $vivienda == "") {

				// 	if ($estacionamiento != "") {						
				// 		$query = "SELECT nombre_esta FROM estacionamiento_estacionamiento WHERE nombre_esta = '".$estacionamiento."' AND id_con = '".$condominio."' ";
				// 		$conexion->consulta($query);
				// 		$nrows = $conexion->total();

				// 		if ($nrows == 0) {
				// 			$inserta = "INSERT INTO estacionamiento_estacionamiento VALUES (0,'".$condominio."',0,1,'".$estacionamiento."','".$valor."')";
				// 			$conexion->consulta($inserta);
				// 		}
				// 	}

				// 	if ($bodega != "") {						
				// 		$query = "SELECT nombre_bod FROM bodega_bodega WHERE nombre_bod = '".$bodega."' AND id_con = '".$condominio."' ";
				// 		$conexion->consulta($query);
				// 		$nrows = $conexion->total();
				// 		if ($nrows == 0) {
				// 			$inserta = "INSERT INTO bodega_bodega VALUES (0,'".$condominio."',0,1,'".$bodega."','".$valor."','".$rol_bod."')";
				// 			$conexion->consulta($inserta);
				// 		}
				// 		else{							
				// 			$consulta = "UPDATE bodega_bodega SET rol_bod = ? WHERE nombre_bod = ? AND id_con = ? ";
				// 			$conexion->consulta_form($consulta,array($rol_bodega,$bodega,$condominio));
				// 		}
				// 	}
				// }
				// else{
					
				// 	$query = "SELECT nombre_viv, id_est_viv, id_viv FROM vivienda_vivienda WHERE nombre_viv = '".$vivienda."' AND id_pis = '".$piso."' AND id_tor = '".$id_tor."' ";
				// 	$conexion->consulta($query);
				// 	$nrows = $conexion->total();					
				// 	if ($nrows == 0) {
						
				// 		$consulta = 
				// 			"
				// 			SELECT
				// 				id_mod
				// 			FROM
				// 				modelo_modelo
				// 			WHERE
				// 				nombre_mod = '".$modelo."'
				// 			";
				// 		$conexion->consulta($consulta);
				// 		$fila_ban = $conexion->extraer_registro_unico();
				// 		$id_mod	= $fila_ban['id_mod'];

				// 		$consulta = 
				// 			"
				// 			SELECT
				// 				id_ori_viv
				// 			FROM
				// 				vivienda_orientacion_vivienda
				// 			WHERE
				// 				nombre_ori_viv = '".$orientacion."'
				// 			";
				// 		$conexion->consulta($consulta);
				// 		$fila_ban = $conexion->extraer_registro_unico();
				// 		$id_ori_viv	= $fila_ban['id_ori_viv'];
				// 		$inserta = "INSERT INTO vivienda_vivienda VALUES (0,1,'".$id_tor."','".$id_mod."','".$id_ori_viv."',1,'".$piso."','".$vivienda."','".$valor."','".$metro."','".$metro_terraza."','".$metro_total."','".$bono_vendedor."','".$prorrateo."','".$rol_viv."')";					
				// 		$conexion->consulta($inserta);		

				// 		$id_viv = $conexion->ultimo_id();
				// 		if ($estacionamiento != "") {
				// 			$inserta = "INSERT INTO estacionamiento_estacionamiento VALUES (0,'".$condominio."','".$id_viv."',1,'".$estacionamiento."',0)";							
				// 			$conexion->consulta($inserta);
				// 		}
				// 		if ($bodega != "") {
				// 			$inserta = "INSERT INTO bodega_bodega VALUES (0,'".$condominio."','".$id_viv."',1,'".$bodega."',0,'".$rol_bod."')";							
				// 			$conexion->consulta($inserta);
				// 		}

				// 	}
				// 	else {
				// 		$fila_est = $conexion->extraer_registro_unico();
				// 		$id_est_viv	= $fila_est['id_est_viv'];
				// 		$id_viv	= $fila_est['id_viv'];					
				// 		$consulta = "UPDATE vivienda_vivienda SET prorrateo_viv = ? WHERE nombre_viv = ? AND id_pis = ? AND id_tor = ? ";						
				// 		$conexion->consulta_form($consulta,array($prorrateo,$vivienda,$piso,$id_tor));
						
				// 	}
				// }
			}           

	} catch (\Throwable $th) {
		throw $th;
	}catch (Exception $e){
		echo $e->getMessage();
	}catch(PDOException $e){
		echo $e->getMessage();		
	}
?>
<!-- <script>
$(document).ready(function(){
	swal({
	  title: "Excelente!",
	  text: "Estructura de condominio ingresada con éxito!",
	  icon: "success"		
	}).then(()=> window.location.replace("form_select.php"));
});
</script> -->