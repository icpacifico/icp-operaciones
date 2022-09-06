<?php
require "../../config.php"; 
 include _INCLUDE."class/conexion.php";
 $conexion = new conexion();
 
    try {
        $response = conexion::select("SELECT * FROM vendedor_vendedor WHERE id_est_vend=1 ");
        $html='<option value="" selected>Seleccione persona a evaluar</option>';
        foreach($response as $resp){            
           $html .= '<option value="'.$resp['id_vend'].'">'.utf8_encode($resp['nombre_vend']).' '.utf8_encode($resp['apellido_paterno_vend']).' '.utf8_encode($resp['apellido_materno_vend']).'</option>';            
        }  
        $operador = conexion::select("SELECT * FROM usuario_usuario WHERE id_per=3"); 
        foreach($operador as $opr){
            $html .= '<option value="'.$opr['id_usu'].'">'.utf8_encode($opr['nombre_usu']).' '.utf8_encode($opr['apellido1_usu']).' '.utf8_encode($opr['apellido2_usu']).'</option>';
        }
        echo $html;     
    } 
    catch(\PDOException $e) { echo $e->getMessage();}
    catch(Exception $e){echo $e->getMessage();}    
 
 ?>