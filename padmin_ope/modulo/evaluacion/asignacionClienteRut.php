<?php
session_start();
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: "._ADMIN."index.php");
    exit();
}
require "../../config.php"; 
include _INCLUDE."class/conexion.php";
$conexion = new conexion();
$data = conexion::select("SELECT rut_pro,id_pro FROM propietario_propietario");
$count = 0;
// echo '<ul>';
try {
    foreach($data as $val){   
        // echo '<li style="border:1px solid black;padding:3px;width:150px;">cliente : '.$val['nombre_pro'].'</li>';
        $data2 = conexion::select("SELECT id_cot,id_vend FROM cotizacion_cotizacion WHERE id_pro =".$val['id_pro']." GROUP BY id_cot DESC LIMIT 0,1");
            if(count($data2)>0){
                // echo '<ul>';
                foreach($data2 as $var){
                    // echo '<li>N° coti. '.$var['id_cot'].' -> vendedor n° '.$var['id_vend'].'</li>';
                    // $query = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
                    // $conexion->consulta_form($query,array($var['id_vend'],$val['id_pro']));
                    // $count += 1;

                    $query = "INSERT INTO vendedor_rutpropietario_vendedor(id_vend,rut_pro)VALUES(?,?)";
                    $conexion->consulta_form($query,array($var['id_vend'],$val['rut_pro']));
                    $count += 1;
                }
                // echo '</ul>';
            }
        
    }
} catch (\Throwable $th) {
    throw $th;
} catch(Exception $e){
    echo $e->message();
} catch (PDOException $e){
    echo $e->message();
}
echo 'Se han registrado '.$count.'enlaces en vendedor->propietario , congratuleishons';

?>