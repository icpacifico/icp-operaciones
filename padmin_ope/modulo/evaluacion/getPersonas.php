<?php
require "../../config.php"; 
 include _INCLUDE."class/conexion.php";
 $conexion = new conexion();
 if(isset($_POST['cargo'])){
    try {
        $response = conexion::select("SELECT * FROM usuario_usuario WHERE id_per = ".$_POST['cargo']." and id_est_usu = 1 and id_usu != 42");
        $html='<option value="" selected>Seleccione persona a evaluar</option>';
        foreach($response as $resp){
            
           $html .= '<option value="'.$resp['id_usu'].'">'.utf8_encode($resp['nombre_usu']).' '.utf8_encode($resp['apellido1_usu']).' '.utf8_encode($resp['apellido2_usu']).'</option>';
            
        }   
        echo $html;     
    } catch (\PDOException $e) {       
        echo $e->getMessage();
    }catch(Exception $e){
        echo $e->getMessage();
    }    
 }else{
    echo 'no hay valor';
 }
 ?>