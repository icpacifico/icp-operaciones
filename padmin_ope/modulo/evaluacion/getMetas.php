<?php
 require "../../config.php"; 
 include _INCLUDE."class/conexion.php";
 $conexion = new conexion();
 
    try {
        if(isset($_POST['vendedor'])){
        $resp = conexion::select("SELECT anio_mes as anio,id_mes as mes,valor_met_ven as meta FROM vendedor_meta_vendedor WHERE id_vend = ".$_POST['vendedor']);
        if(is_array($resp)){
            if(count($resp)>0){
                response($resp,true);
            }else{
                response('sin registros',false);
            }            
        }else{
            response('sin data',false);
        }    
    }else{
        response('falta el vendedor',false);
     }   
        
    } 
    catch(\PDOException $e) {response($e->getMessage(),false);}
    catch(Exception $e){response($e->getMessage(),false);}   
    
    function response($message,$state){
        $objJson['data']=$message;
        $objJson['state']=$state;
        echo json_encode($objJson);
    }
 