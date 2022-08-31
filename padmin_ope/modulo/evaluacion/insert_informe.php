<?php
session_start();
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: "._ADMIN."index.php");
    exit();
}
require "../../config.php"; 
include _INCLUDE."class/conexion.php";
$conexion = new conexion();
function status($title,$message,$icon){
    $jsondata['title'] = $title;
    $jsondata['message'] = $message;
    $jsondata['icon'] = $icon;
    echo json_encode($jsondata);
    die();
}
try {
    $query_desarrollo = "SELECT id FROM matriz_desarrollo WHERE id_vendedor=".$_POST['persona'];
    $id = conexion::select($query_desarrollo);   
    $query = "INSERT INTO matriz_informe VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $conexion->consulta_form($query,array(0,
                                          $id[0]['id'],
                                          $_POST['persona'],
                                          $_POST['cargoEvaluador'],
                                          $_POST['evaluador'],
                                          'Asesor Inmobiliario',
                                          $_POST['merito'],
                                          $_POST['demerito'],
                                          $_POST['desarrollo'],
                                          $_POST['fundamentacion1'],
                                          $_POST['fundamentacion2'],
                                          $_POST['fundamentacion3'],
                                          $_POST['fundamentacion4'],
                                          $_POST['fundamentacion5'],
                                          $_POST['obsmejora'],
                                          $_POST['hecho'],
                                          $_POST['objetivo'],
                                          $_POST['mejora'],
                                          $_POST['kpi'],
                                          $_POST['ausentismo'],
                                          $_POST['compensa']
                                        ));
    
    status("Registrado!","Evaluación de desempeño registrada con éxito.","success");
}catch(Exception $e) {
    status("Error!","A ocurrido un error grave, contactar al administrador. codigo de error : ".$e->message()." ","danger");
}catch(PDOException $e) {
    status("Error!","A ocurrido un error grave, contactar al administrador. codigo de error : ".$e->message()." ","danger");           
}   
?>