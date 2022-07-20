<?php
session_start();
require "../../config.php";
include _INCLUDE."class/conexion.php";
$conexion = new conexion();
$usuario_usu = isset($_POST["usuario_usu"]) ? htmlentities(utf8_decode($_POST["usuario_usu"])) : "";
$contrasena_usu = isset($_POST["contrasena_usu"]) ? htmlentities(utf8_decode($_POST["contrasena_usu"])) : "";

$consulta = 
	"
	SELECT 
		usuario_usuario.nombre_usu,
		usuario_usuario.apellido1_usu,
		usuario_usuario.id_usu,
		usuario_usuario.id_per,
		usuario_perfil.nombre_per
	FROM 
		usuario_usuario,
		usuario_perfil
	WHERE 
		usuario_usuario.usuario_usu = ? AND
		usuario_usuario.contrasena_usu = ? AND
		usuario_usuario.id_est_usu = 1 AND
		usuario_usuario.id_per = usuario_perfil.id_per
	";
$conexion->consulta_form($consulta,array($usuario_usu,$contrasena_usu));
$cantidad = $conexion->total();
if($cantidad > 0){
	$fila_consulta = $conexion->extraer_registro();
	foreach ($fila_consulta as $fila) {
		$id_usuario = $fila["id_usu"];
		$id_perfil = $fila["id_per"];
		$nombre_per = utf8_encode($fila["nombre_per"]);
		
		if ($id_perfil == 1) {
			$nombre_usuario_sesion = utf8_encode($fila["nombre_usu"]);
		}
    	else{
    		$nombre_usuario_sesion = utf8_encode($fila["nombre_usu"]." ".$fila["apellido1_usu"]);
    	}
    	// if($id_perfil == 3){
    	// 	$_SESSION["sesion_id_vendedor_panel"] = $fila["id_pro"];
    	// }
		
	}
	$_SESSION["sesion_usuario_panel"] = $nombre_usuario_sesion;
	$_SESSION["sesion_id_panel"] = $id_usuario;
	
	$_SESSION["sesion_perfil_panel"] = $id_perfil;
	$_SESSION["sesion_nombre_perfil_panel"] = $nombre_per;

	if ($_SESSION["sesion_perfil_panel"]==4) {
		$consulta = 
                "
                SELECT 
                    id_vend 
                FROM 
                    vendedor_vendedor 
                WHERE 
                    id_usu = ".$id_usuario."
                ";
        $conexion->consulta($consulta);
        $fila = $conexion->extraer_registro_unico();
        $id_vend = $fila["id_vend"];
        $_SESSION["sesion_id_vend"] = $id_vend;
	}

	
	//VALIDACION DOBLE REGISTRO
	// $hoy = date("Y-m-d");
	// $hora= date("H:i:s");
	// $consulta = 
	//     "
	//     SELECT
	//         id_int_usu
	//     FROM 
	//         usuario_interaccion_usuario 
	//     WHERE 
	//         fecha_int_usu = '".$hoy."' AND
	//         hora_int_usu = '".$hora."' AND
	//         id_usu = '".$_SESSION["sesion_id_panel"]."'
	//     ";
	// $conexion->consulta_form($consulta,array($hoy,$contrasena_usu));
	// $conexion->consulta($consulta);
	// $total_validacion = $conexion->total();
	
	// if ($total_validacion == 0) {
	// 	//-- * REGISTRO HISTORIAL * --
	// 	$consulta_historial="INSERT INTO usuario_interaccion_usuario VALUES(0,'".$_SESSION["sesion_id_panel"]."',0,0,'".date("Y-m-d")."','".date("H:i:s")."',0,0,'".utf8_decode("Inicio Sesión")."',0,0,'Login') ";
	// 	$conexion->consulta($consulta_historial);
	// }
	// title,message,icon
	$jsondata['title'] = "Excelente!";
	$jsondata['message'] = "Usuario ingresado con éxito!";
	$jsondata['icon'] = "success";
	$jsondata['action'] = "panel.php";
	echo json_encode($jsondata);
	exit();
}
else{
	$jsondata['title'] = "Atención!";
	$jsondata['message'] = "Usuario no reconocido o clave inválida";
	$jsondata['icon'] = "warning";
	$jsondata['action'] = "#";
	echo json_encode($jsondata);
	exit();
}
?>