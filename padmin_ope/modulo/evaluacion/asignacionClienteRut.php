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
try {
    foreach($data as $val){           
        $data2 = conexion::select("SELECT id_cot,id_vend FROM cotizacion_cotizacion WHERE id_pro =".$val['id_pro']." GROUP BY id_cot DESC LIMIT 0,1");
            if(count($data2)>0){                
                foreach($data2 as $var){   
                    $delete = "DELETE FROM vendedor_rutpropietario_vendedor WHERE rut_pro=?";                
                    $query = "INSERT INTO vendedor_rutpropietario_vendedor(id_vend,rut_pro)VALUES(?,?)";
                    $conexion->consulta_form($delete,array($val['rut_pro']));
                    $conexion->consulta_form($query,array($var['id_vend'],$val['rut_pro']));
                    $count += 1;
                }                
            }        
    }
} catch (\Throwable $th) {
    throw $th;
} catch(Exception $e){
    echo $e->getMessage();
} catch (PDOException $e){
    echo $e->getMessage();
}
echo 'Se han registrado '.$count.'enlaces en vendedor->propietario , congratuleishons';

?>