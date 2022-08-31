<?php 
ob_start();//Enables Output Buffering
session_start(); 
date_default_timezone_set('Chile/Continental');
include 'mpdf/mpdf.php';
require "../../config.php"; 
include _INCLUDE."class/conexion.php";
$year = date('Y');
// var_dump($_POST);
$html = '';

$html .='
<!DOCTYPE html>
<html>
<head>
    <title>Formato evaluacion de desempeño en pdf</title>
    <meta charset="utf-8">    
</head>
<body>
<div class="wrapper">    
    <div class="content-wrapper">        
        <section class="content-header">
            <h2 style="text-align:center;">
                Informe de Desempeño
                <small>Detalle</small>
            </h2>            
        </section>       
        <section class="content">
            <div class="row">                
                <div class="col-sm-12">                  
                    <div class="box box-primary">   
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center" style="margin-bottom:3%">
                                    <h4>ANEXO 02: INFORME DE DESEMPEÑO <br><small>PR-AX- 02- INFORME DESEMPEÑO / VERSIÓN 01/2021</small></h4>
                                </div>
                                <div class="col-md-6 text-left" style="font-size:1.2em;"> <b>CICLO DE EVALUACIÓN : '.$year.' - '.($year + 1).'</b></div>
                                <div class="col-md-6" style="font-size:1.2em;"> <b>FECHA EVALUACIÓN : '.Date('d-m-Y').'</b></div>                                
                            </div>
                            <div class="row">
                            <div class="col-md-8 col-md-offset-2" style=margin-top:3%;>
                                    <div class="alert alert-warning" role="alert" style="padding:30px;">
                                    <i class="fa fa-warning" aria-hidden="true" style="font-size:2.4rem; padding:0 1% 1% 0;"></i>  En consideración de este ciclo de evaluación de desempeño, ambas partes concuerdan que, al momento de la evaluación de desempeño, se tuvo presente, la asignación de metas de ciclo de evaluación y el Descriptor de Cargo.
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="container" >
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2" style=margin-top:3%;>                                      
                                    <table class="table table-bordered"  style="margin-bottom:70px;">
                                        <thead>
                                            <tr>
                                                <td colspan="5" ><strong>1. IDENTIFICACIÓN PERSONA EVALUADA.</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="borde">NOMBRE PERSONA EVALUADA</td>
                                                <td colspan="4" class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">CARGO / FUNCIÓN</td>
                                                <td colspan="4" class="borde"> Asesor Inmobiliario. </tr>
                                            <tr>
                                                <td class="borde">NOMBRE EVALUADOR/A</td>
                                                <td colspan="4" class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">CARGO / FUNCIÓN</td>
                                                <td colspan="4" class="borde"></td>                                                   
                                            </tr>
                                            <tr>
                                                <td class="borde"> OBSERVACIONES DE DESEMPEÑO:</td>
                                                <td class="borde">APLICA AUSENTISMO HASTA POR 60 DÍAS HÁBILES</td>
                                                <td class="borde" width="12%">NO</td>
                                                <td class="borde">APLICA CRITERIO DE COMPENSACIÓN POR 15 DÍAS DE AUSENTISMO CONTINUO</td>
                                                <td class="borde" width="12%">NO</td>
                                            </tr>
                                        </tbody>
                                    </table>  
                                    
                                    <table class="table table-bordered"  style="margin-bottom:50px; text-align:center;">
                                        <thead>
                                            <tr>
                                                <td colspan="4" class="text-left"><strong>2.- CRITERIOS DE EVALUACIÓN.</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="borde">2.1 META ASIGNADA</td>
                                                <td class="borde">META ASIGNADA</td>
                                                <td class="borde">META LOGRADA</td>
                                                <td class="borde">LOGRO</td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 1 ENERO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 2 FEBRERO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 3 MARZO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 4 ABRIL</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 5 MAYO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 6 JUNIO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 7 JULIO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 8 AGOSTO</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 9 SEPTIEMBRE</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 10 OCTUBRE</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 11 NOVIEMBRE</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">MES 12 DICIEMBRE</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">TOTALES</td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                                <td class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="borde text-left">FUNDAMENTACIÓN</td>                                                    
                                                <td colspan="3" class="borde"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left"><strong>2.2 COMPETENCIA 1</strong> </td>
                                                <td class="borde">DESARROLLO PROPUESTO</td>
                                                <td class="borde">AÑO ACTUAL</td>
                                                <td class="borde">% LOGRO</td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left">ORIENTACIÓN AL CLIENTE</td>
                                                <td class="borde redNumbers">4</td>
                                                <td class="borde"></td>
                                                <td class="borde blackNumbers limpiaText" id="total1">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                <td colspan="3" class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left"><strong>2.3 COMPETENCIA 2</strong></td>
                                                <td class="borde">DESARROLLO PROPUESTO</td>
                                                <td class="borde">AÑO ACTUAL</td>
                                                <td class="borde">% LOGRO</td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left">HABILIDADES INTERPERSONALES</td>
                                                <td class="borde redNumbers">4</td>
                                                <td class="borde"></td>
                                                <td class="borde blackNumbers limpiaText" id="total2">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                <td colspan="3" class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left"><strong>2.4 COMPETENCIA 3</strong></td>
                                                <td class="borde">DESARROLLO PROPUESTO</td>
                                                <td class="borde">AÑO ACTUAL</td>
                                                <td class="borde">% LOGRO</td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left">ORIENTACIÓN AL LOGRO</td>
                                                <td class="borde redNumbers">4</td>
                                                <td class="borde"></td>
                                                <td class="borde blackNumbers limpiaText" id="total3">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                <td colspan="3" class="borde"></td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left"><strong>2.5 COMPETENCIA 4</strong> </td>
                                                <td class="borde">DESARROLLO PROPUESTO</td>
                                                <td class="borde">AÑO ACTUAL</td>
                                                <td class="borde">% LOGRO</td>
                                            </tr>
                                            <tr>
                                                <td class="borde text-left">NEGOCIACIÓN</td>
                                                <td class="borde redNumbers">4</td>
                                                <td class="borde"></td>
                                                <td class="borde blackNumbers limpiaText" id="total4">0</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                <td colspan="3" class="borde"></td>
                                            </tr>         

                                        </tbody>
                                    </table>
                                    
                                    <table class="table table-bordered text-center " style="width:100%; margin-bottom:50px;">
                                        <tbody>
                                            <tr class="borde2">
                                                <td colspan="3" class="borde2">RESULTADOS DE METAS</td>
                                                <td colspan="3" class="borde2">RESULTADOS DE COMPETENCIAS</td>
                                                <td rowspan="2" class="borde2" style="vertical-align:middle">TOTAL LOGRADO %</td>
                                            </tr>
                                       
                                        
                                            <tr>
                                                <td class="borde2">RESULTADOS</td>
                                                <td class="borde2">PONDERACION</td>
                                                <td class="borde2">TOTAL</td>
                                                <td class="borde2">RESULTADOS</td>
                                                <td class="borde2">PONDERACION</td>
                                                <td class="borde2">TOTAL</td>                                                                                                   
                                            </tr>
                                            <tr>
                                                <td class="borde2" id="resultadoMeta">0</td>
                                                <td class="borde2">0,7</td>
                                                <td class="borde2 blackNumbers2" id="totalMeta">0</td>
                                                <td class="borde2" id="resultadoCompetencia">0</td>
                                                <td class="borde2">0,3</td>
                                                <td class="borde2 blackNumbers2" id="totalCompetencia">0</td>
                                                <td class="borde2 blackNumbers" rowspan="3" style="font-size:3em;" id="total">0</td>                                               
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="borde2">ANOTACIONES DEMÉRITO (20%)</td>
                                                <td class="borde2">NO</td>
                                                </td>
                                                <td colspan="2" class="borde2" >APLICA REDUCCIÓN DEL 20% AL TOTAL LOGRADO</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="borde2">ANOTACIONES DE MÉRITO (20%)</td>
                                                <td class="borde2">NO</td>
                                                </td>
                                                <td colspan="2" class="borde2">APLICA AUMENTO DEL 20% AL TOTAL LOGRADO</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="borde2"> NIVEL DE DESARROLLO ALCANZADO</td>
                                                <td colspan="4" class="borde2"> <b id="desarrollo">AUSENCIA</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td colspan="2"><strong>3.- FEEDBACK PARA EL DESARROLLO.</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody >
                                        <tr >
                                            <td colspan="2" class="borde text-center">OBSERVACIONES GENERALES PARA LA MEJORA</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="borde"></td>
                                        </tr> 
                                        <tr>
                                            <td class="borde">EVIDENCIAS PARA PREPARAR LA MEJORA (HECHOS ACONTECIDOS EN EL AÑO)</td>
                                            <td class="borde" width="70%"></td>
                                        </tr>
                                        <tr>
                                            <td class="borde">OBJETIVOS PARA LA MEJORA CONTINUA (OBJETIVOS SMART)</td>
                                            <td class="borde"></td>
                                        </tr>
                                        <tr>
                                            <td class="borde">PLAN PARA LA MEJORA CONTINUA</td>
                                            <td class="borde"></td>
                                        </tr>
                                        <tr>
                                            <td class="borde">KPI´s de Control (Indicadores de Gestión Personal)</td>
                                            <td class="borde"></textarea></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div> 
                            </div> 
                            <div class="row" style="margin:50px 0 50px 0;">
                                <div class="container">
                                    <div class="col-md-4 col-md-offset-2 text-left"><hr style="height:1px;border:none;color:#333;background-color:#333;">
                                     <p class="text-center" id="firmaEvaluado">NOMBRE PERSONA EVALUADA</p>
                                     <p class="text-center">Asesor Inmobiliario</p>
                                   </div>
                                    <div class="col-md-4 text-right"><hr style="height:1px;border:none;color:#333;background-color:#333;">
                                    <p class="text-center" id="firmaEvaluador">NOMBRE PERSONA EVALUADORA</p>
                                     <p class="text-center" id="evaluadorCargo">JEFATURA DE VENTAS</p>
                                  </div>
                                </div>        
                            </div>                              
                        </div>
                    </div>                      
                </div>                    
            </div>
        </section>            
    </div>
</body>
</html>';

$mpdf = new mPDF('c','A4'); 
// $mpdf->charset_in='UTF-8';
// $mpdf->allow_charset_conversion=true;
$url = _ASSETS."bootstrap/css/bootstrap.min.css";
$url2 = _ASSETS."dist/css/AdminLTE.min.css";
$stylesheet = file_get_contents($url);
$stylesheet .= file_get_contents($url2);
$mpdf->writeHTML($stylesheet,1);
$mpdf->writeHTML($html,2);
// $mpdf->AddPage();
// $mpdf->WriteHTML($html2);
$nombre = 'evaluacion/evaluaciones/eva_'.date('dmYHi').'.pdf';
ob_end_clean();//End Output Buffering
// $fecha = date('Y-m-d H:i:s');
$pdf = $mpdf->output($nombre ,'I');

?>
