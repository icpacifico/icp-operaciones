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
$container = array();
try {
    foreach($data as $val){           
        $data2 = conexion::select("SELECT id_cot,id_vend FROM cotizacion_cotizacion WHERE id_pro =".$val['id_pro']." and id_vend not in(10,13,15,19,20) GROUP BY id_cot DESC LIMIT 0,1");
            if(count($data2)>0){                
                foreach($data2 as $var){   
                    // $delete = "DELETE FROM vendedor_propietario_vendedor WHERE id_pro=?";                
                    // $insert = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
                    // $conexion->consulta_form($delete,array($val['id_pro']));
                    // $conexion->consulta_form($insert,array($var['id_vend'],$val['id_pro']));
                    array_push($container,$val['id_pro']);
                    $count += 1;                  
                }                
            }        
    }
    $total = COUNT($container);
    echo 'total de clientes '.$total.'<br>';    
    $division = round($total / 4) - 1;
    $multiplicador = 2;   
    $div2 = $division * 2;
    $div3 = $division * 3;
    
    for ($i=0; $i < $total; $i++) { 

        if($i < $division ){
            $insert = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
            $conexion->consulta_form($insert,array(13,$container[$i]));
        }
        if($i > $division && $i < $div2){
            $insert = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
            $conexion->consulta_form($insert,array(15,$container[$i]));
        }
        if($i > $div2 && $i < $div3){
            $insert = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
            $conexion->consulta_form($insert,array(19,$container[$i]));
        }
        if($i > $div3){
            $insert = "INSERT INTO vendedor_propietario_vendedor(id_vend,id_pro)VALUES(?,?)";
            $conexion->consulta_form($insert,array(20,$container[$i]));
        }
        
    }

} catch (\Throwable $th) {
    throw $th;
} catch(Exception $e){
    echo $e->getMessage();
} catch (PDOException $e){
    echo $e->getMessage();
}

echo 'listo, revisa que onda por id';

?>