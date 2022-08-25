<?php 
session_start(); 
require "../../config.php"; 
require_once _INCLUDE."head.php";
if (!isset($_SESSION["sesion_usuario_panel"])) {
    header("Location: "._ADMIN."index.php");
}
if (!isset($_SESSION["modulo_evaluacion_panel"])) {
    header("Location: "._ADMIN."panel.php");
}
?>
<style>
    .borde{
        border:1px solid #D7DBDD;
    }
    .borde2{
        border:3px solid #D7DBDD;
    }
    table, tr, td{
    border:none;
    vertical-align: middle !important;
    }    
    .bg-yellow, .callout.callout-warning, .alert-warning, .label-warning, .modal-warning .modal-body {
        color: #8a6d3b !important; 
        background-color: #fcf8e3 !important; 
        border: none !important; 
    }
    .inputStyle{
        color:
    }
    .redNumbers{
        text-align:center;
        color:#dd131a;
        font-weight: 900;
        font-size:1.6em;
    }
    .blackNumbers{
        text-align:center;
        color:black;
        font-weight: 900;
        font-size:2em;
    }
    .blackNumbers2{
        text-align:center;
        color:black;
        font-weight: 900;
        font-size:1.6em;
    }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php 
        include _INCLUDE."class/conexion.php";
        $conexion = new conexion();
        require_once _INCLUDE."menu_modulo.php";
        $year = date('Y');
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Informe de Desempeño
                    <small>Detalle</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo _ADMIN?>panel.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Evaluacion</a></li>
                    <li class="active">Detalle</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-12">
                      <!-- general form elements -->
                        <div class="box box-primary" >   
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 text-center" style="margin-bottom:3%">
                                        <h3>ANEXO 02: INFORME DE DESEMPEÑO <small>PR-AX- 02- INFORME DESEMPEÑO / VERSIÓN 01/2021</small></h3>
                                    </div>
                                    <div class="col-md-6 text-right" style="font-size:1.8rem;"> <b>CICLO DE EVALUACIÓN : <?php echo $year?> - <?php echo ($year + 1)?></b></div>
                                    <div class="col-md-6" style="font-size:1.8rem;"> <b>FECHA EVALUACIÓN : <?php echo Date('d-m-Y');?></b></div>
                                    
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
                                         <!-- Primer formulario -->
                                        <table class="table"  style="margin-bottom:70px;">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" ><strong>1. IDENTIFICACIÓN PERSONA EVALUADA.</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="borde">NOMBRE PERSONA EVALUADA</td>
                                                    <td colspan="4" class="borde"> <select name="persona" id="persona" class="form-control" autocomplete="off"></select></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">CARGO / FUNCIÓN</td>
                                                    <td colspan="4" class="borde">Asesor Inmobiliario. </tr>
                                                <tr>
                                                    <td class="borde">NOMBRE EVALUADOR/A</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="evaluador" id="evaluador" class="form-control" autocomplete="off" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">CARGO / FUNCIÓN</td>
                                                    <td colspan="4" class="borde">
                                                        <!-- gerente de ventas y operaciones   /  jefa de operaciones -->
                                                        <select name="cargoEvaluador" id="cargoEvaluador" class="form-control" autocomplete="off">
                                                            <option value="0">Seleccione cargo de evaluador</option>
                                                            <option value="1">Gerente de ventas y operaciones</option>
                                                            <option value="7">Jefa de operaciones</option>
                                                        </select>                                                    
                                                </tr>
                                                <tr>
                                                    <td class="borde"> OBSERVACIONES DE DESEMPEÑO:</td>
                                                    <td class="borde">APLICA AUSENTISMO HASTA POR 60 DÍAS HÁBILES</td>
                                                    <td class="borde" width="12%"> 
                                                        <select name="ausentismo" id="ausentismo" class="form-control">
                                                            <option value="NO">NO</option>
                                                            <option value="SI">SI</option>
                                                        </select>
                                                    </td>
                                                    <td class="borde">APLICA CRITERIO DE COMPENSACIÓN POR 15 DÍAS DE AUSENTISMO CONTINUO</td>
                                                    <td class="borde" width="12%">
                                                    <select name="compensa" id="compensa" class="form-control">
                                                            <option value="NO">NO</option>
                                                            <option value="SI">SI</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>  
                                        
                                        <table class="table"  style="margin-bottom:50px; text-align:center;">
                                            <thead>
                                                <tr>
                                                    <td colspan="4" class="text-left"><strong>2.- CRITERIOS DE EVALUACIÓN.</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="borde">2.1 META ASIGNADA</td>
                                                    <td class="borde"><button class="btn btn-info" id="sumarAsignada" type="button">  Σ  </button>  META ASIGNADA</td>
                                                    <td class="borde"><button class="btn btn-info" id="sumarLograda" type="button">  Σ  </button>  META LOGRADA</td>
                                                    <td class="borde"><button class="btn btn-info" id="calTot" type="button">  %  </button>  LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 1 ENERO</td>
                                                    <td class="borde"><input type="number" id="asign-1" name="asign-1" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-1" name="lograda-1" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-1" name="logro-1" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 2 FEBRERO</td>
                                                    <td class="borde"><input type="number" id="asign-2" name="asign-2" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-2" name="lograda-2" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-2" name="logro-2" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 3 MARZO</td>
                                                    <td class="borde"><input type="number" id="asign-3" name="asign-3" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-3" name="lograda-3" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-3" name="logro-3" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 4 ABRIL</td>
                                                    <td class="borde"><input type="number" id="asign-4" name="asign-4" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-4" name="lograda-4" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-4" name="logro-4" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 5 MAYO</td>
                                                    <td class="borde"><input type="number" id="asign-5" name="asign-5" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-5" name="lograda-5" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-5" name="logro-5" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 6 JUNIO</td>
                                                    <td class="borde"><input type="number" id="asign-6" name="asign-6" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-6" name="lograda-6" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-6" name="logro-6" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 7 JULIO</td>
                                                    <td class="borde"><input type="number" id="asign-7" name="asign-7" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-7" name="lograda-7" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-7" name="logro-7" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 8 AGOSTO</td>
                                                    <td class="borde"><input type="number" id="asign-8" name="asign-8" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-8" name="lograda-8" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-8" name="logro-8" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 9 SEPTIEMBRE</td>
                                                    <td class="borde"><input type="number" id="asign-9" name="asign-9" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-9" name="lograda-9" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-9" name="logro-9" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 10 OCTUBRE</td>
                                                    <td class="borde"><input type="number" id="asign-10" name="asign-10" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-10" name="lograda-10" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-10" name="logro-10" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 11 NOVIEMBRE</td>
                                                    <td class="borde"><input type="number" id="asign-11" name="asign-11" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-11" name="lograda-11" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-11" name="logro-11" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">MES 12 DICIEMBRE</td>
                                                    <td class="borde"><input type="number" id="asign-12" name="asign-12" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="lograda-12" name="lograda-12" class="form-control limpia redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="logro-12" name="logro-12" class="form-control limpia blackNumbers2" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">TOTALES</td>
                                                    <td class="borde"><input type="number" id="totalAsignado" name="totalAsignado" class="form-control limpia blackNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="totalLogrado" name="totalLogrado" class="form-control limpia blackNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="porcentajeTotal" name="porcentajeTotal" class="form-control limpia blackNumbers" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left">FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><textarea name="fundamentacion1" class="form-control" id="fundamentacion1" cols="30" rows="3" autocomplete="off"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.2 COMPETENCIA 1</strong> </td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">ORIENTACIÓN AL CLIENTE</td>
                                                    <td class="borde"><input type="number" id="orientacionAlCLiente1" name="orientacionAlCLiente1" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="orientacionAlCLiente2" name="orientacionAlCLiente2" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="orientacionAlCLiente3" name="orientacionAlCLiente3" class="form-control blackNumbers" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><textarea name="fundamentacion2" class="form-control" id="fundamentacion2" cols="30" rows="3" autocomplete="off"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.3 COMPETENCIA 2</strong></td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">HABILIDADES INTERPERSONALES</td>
                                                    <td class="borde"><input type="number" id="habilidades1" name="habilidades1" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="habilidades2" name="habilidades2" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="habilidades3" name="habilidades3" class="form-control blackNumbers" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><textarea name="fundamentacion3" class="form-control" id="fundamentacion3" cols="30" rows="3" autocomplete="off"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.4 COMPETENCIA 3</strong></td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">ORIENTACIÓN AL LOGRO</td>
                                                    <td class="borde"><input type="number" id="orientacionAlLogro1" name="oreintacionAlLogro1" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="orientacionAlLogro2" name="oreintacionAlLogro2" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="orientacionAlLogro3" name="oreintacionAlLogro3" class="form-control blackNumbers" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><textarea name="fundamentacion4" class="form-control" id="fundamentacion4" cols="30" rows="3" autocomplete="off"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.5 COMPETENCIA 4</strong> </td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">NEGOCIACIÓN</td>
                                                    <td class="borde"><input type="number" id="negociacion1" name="negociacion1" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="negociacion2" name="negociacion2" class="form-control redNumbers" autocomplete="off"></td>
                                                    <td class="borde"><input type="number" id="negociacion3" name="negociacion3" class="form-control blackNumbers" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><textarea name="fundamentacion5" class="form-control" id="fundamentacion5" cols="30" rows="3" autocomplete="off"></textarea></td>
                                                </tr>         

                                            </tbody>
                                        </table>
                                        
                                        <table class="table text-center " style="width:100%; margin-bottom:50px;">
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
                                                    <td class="borde2">
                                                    <select name="demerito" id="demerito" class="form-control">
                                                            <option value="NO" selected>NO</option>
                                                            <option value="SI">SI</option>
                                                        </select>
                                                    </td>
                                                    </td>
                                                    <td colspan="2" class="borde2" >APLICA REDUCCIÓN DEL 20% AL TOTAL LOGRADO</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="borde2">ANOTACIONES DE MÉRITO (20%)</td>
                                                    <td class="borde2">
                                                    <select name="merito" id="merito" class="form-control">
                                                            <option value="NO" selected>NO</option>
                                                            <option value="SI">SI</option>
                                                        </select>
                                                    </td>
                                                    </td>
                                                    <td colspan="2" class="borde2">APLICA AUMENTO DEL 20% AL TOTAL LOGRADO</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="borde2"> NIVEL DE DESARROLLO ALCANZADO</td>
                                                    <td colspan="4" class="borde2"> <b id="desarrollo">AUSENCIA</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <table class="table">
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
                                                <td colspan="2" class="borde"><textarea name="obsmejora" class="form-control" id="obsmejora" cols="30" rows="3"></textarea></td>
                                            </tr> 
                                            <tr>
                                                <td class="borde">EVIDENCIAS PARA PREPARAR LA MEJORA (HECHOS ACONTECIDOS EN EL AÑO)</td>
                                                <td class="borde" width="70%"> <textarea name="hecho" class="form-control" id="hecho" cols="30" rows="3"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">OBJETIVOS PARA LA MEJORA CONTINUA (OBJETIVOS SMART)</td>
                                                <td class="borde"><textarea name="objetivo" class="form-control" id="objetivo" cols="30" rows="3"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">PLAN PARA LA MEJORA CONTINUA</td>
                                                <td class="borde"><textarea name="mejora" class="form-control" id="mejora" cols="30" rows="3"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="borde">KPI´s de Control (Indicadores de Gestión Personal)</td>
                                                <td class="borde"><textarea name="kpi" class="form-control" id="kpi" cols="30" rows="3"></textarea></td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div> 
                                </div> <!--.row-->
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

                                <div class="row" style="padding-bottom:3%;">
                                    <div class="container">
                                        <div class="col-md-12 text-center"><small>DOCUMENÉNTESE ELECTRÓNICAMENTE Y EN CARPETA FÍSICA DEL/LA TRABAJADOR/A</small></div>
                                    </div>
                                </div>

                            </div>
                        </div>                      
                    </div>                    
                </div>
            </section>            
        </div>        
<?php include_once _INCLUDE."footer_comun.php";?>
<?php include_once _INCLUDE."js_comun.php";?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', (event) => {   
    const asign_ = (arreglo) =>{   
        let sum = 0;             
        for (let index = 0; index < arreglo.length; index++) {                
                 sum += parseInt(arreglo[index].meta);
                $("#asign-"+arreglo[index].mes).val(arreglo[index].meta)                                                        
            }
            $("#totalAsignado").val(sum);
    } 
    const lograda_ = (arreglo) =>{
        sum = 0;
        for (let index = 0; index < arreglo.length; index++) {
            sum += parseInt(arreglo[index].meta);
            if(arreglo[index].meta>0){
                $("#lograda-"+arreglo[index].mes).val(arreglo[index].meta)
            }
                        
        }
        $("#totalLogrado").val(sum);
    }
    const sigma = (column) =>{
        if(column == 'asign'){
            sum = 0;
            for (let index = 1; index < 13; index++) {
                if($("#asign-"+index).val()){
                    sum += parseInt($("#asign-"+index).val());
                }            
            }
            $("#totalAsignado").val(sum);
       }
       if(column == 'lograda'){
            sum = 0;
            for (let index = 1; index < 13; index++) {
                if($("#lograda-"+index).val()){
                    sum += parseInt($("#lograda-"+index).val());
                }            
            }
            $("#totalLogrado").val(sum);
       }
    }
    const logro_ = () =>{
        let cont = 0;
        let sum= 0;
        for (let index = 1; index < 13; index++) {      
                     
                    let lograda = parseInt($("#lograda-"+index).val());                    
                    let asign = parseInt($("#asign-"+index).val());
                    let total = (lograda * 100) / asign;
                    
                    if(!isNaN(total)){                        
                        cont += 1;
                        sum += Math.round(total);
                        $("#logro-"+index).val(Math.round(total));   
                    }
                                                               
        }        
        let promedio = sum / cont;        
        $("#porcentajeTotal").val(Math.round(promedio));
        $("#resultadoMeta").text(Math.round(promedio));
        $("#totalMeta").text(Math.round(Math.round(promedio) * 0.7));
        let total1 = parseInt($("#totalMeta").text());
        let total2 = parseInt($("#totalCompetencia").text());
        let sumaTotal = total1 + total2;
        $("#total").text(sumaTotal);
        criterio(sumaTotal);
    }
    const req = (data,url,id) => {$.ajax({data: data,type: 'POST',url: url,success:function(data){
         if(id=='evaluador'){
            $("#"+id+"").val(data)
            $("#firmaEvaluador").text(data)
        }else{$("#"+id+"").html(data)}
        }
    })}
    const metas = (data,url,asignada) =>{
        $.ajax({
            data : data,
            type: 'POST',
            url: url,
            dataType: 'json',
            success:function(data){
                if(data.state){
                   if(asignada){
                    asign_(data.data)
                    }else{
                    lograda_(data.data)
                    }                    
                }else{
                    console.log(data);
                }                
            }
        });
    }
    req('','getPersonas.php','persona');
    $("#persona").change(function(){
        $('.limpia').val('');
        if($(this).val()!=0){            
            metas({vendedor:$(this).val(),opt:1},'getMetas.php',true);
            metas({vendedor:$(this).val(),opt:2},'getMetas.php',false);            
            $("#firmaEvaluado").text($("#persona option:selected").text());
        }else{           
            $("#firmaEvaluado").text("NOMBRE PERSONA EVALUADA");
        }
    });
    $("#cargoEvaluador").change(function(){
        if($(this).val()!=0){
            req({cargo:$(this).val()},'getEvaluador.php','evaluador');           
            $("#evaluadorCargo").text($("#cargoEvaluador option:selected").text());
        }else{
            $("#firmaEvaluador").text("NOMBRE PERSONA EVALUADORA");
            $("#evaluadorCargo").text("JEFATURA DE VENTAS");
        }
    });
    $("#sumarAsignada").click(function(){ sigma('asign'); return false});
    $("#sumarLograda").click(function(){ 
        console.log("sumarLograda");
        sigma('lograda'); 
        return false
    });
    $("#calTot").click(function(){ logro_(); });

    const inputFunc = (id) => {
        $('#'+id+'1').on('input', function() {
            let val1 = parseInt($('#'+id+'1').val());
            let val2 = parseInt($('#'+id+'2').val());
            let total = (val2 * 100) / val1;
            $("#"+id+'3').val(total);
            sumaCompetencias('orientacionAlCLiente','habilidades','orientacionAlLogro','negociacion')
        });
        $('#'+id+'2').on('input', function() {
            let val1 = parseInt($('#'+id+'1').val());
            let val2 = parseInt($('#'+id+'2').val());
            let total = (val2 * 100) / val1;
            $("#"+id+'3').val(total);
            sumaCompetencias('orientacionAlCLiente','habilidades','orientacionAlLogro','negociacion')
        });
        
    }
    const sumaCompetencias = (com1,com2,com3,com4) => {
        let val1 = parseInt($("#"+com1+"3").val());
        let val2 = parseInt($("#"+com2+"3").val());
        let val3 = parseInt($("#"+com3+"3").val());
        let val4 = parseInt($("#"+com4+"3").val());
        let total = (val1 + val2 + val3 + val4) / 4;
        $("#resultadoCompetencia").text(Math.round(total));
        $("#totalCompetencia").text(Math.round(total * 0.3));
        let total1 = parseInt($("#totalMeta").text());
        let total2 = parseInt($("#totalCompetencia").text());
        let sumaTotal = total1 + total2;
        $("#total").text(sumaTotal);
        criterio(sumaTotal);
    }
    inputFunc('orientacionAlCLiente')
    inputFunc('habilidades')
    inputFunc('orientacionAlLogro')
    inputFunc('negociacion')
    

// merito y demerito

$("#merito").on('change',function(){
    let val = $(this).val();
    if(val=="SI"){
        let total = parseInt($("#total").text());
        total += 20;
        $("#total").text(total);
        criterio(total);
    }else{
        let total = parseInt($("#total").text());
        total -= 20;
        $("#total").text(total);
        criterio(total);
    }
})
$("#demerito").on('change',function(){
    let val = $(this).val();
    if(val=="SI"){
        let total = parseInt($("#total").text());
        total -= 20;
        $("#total").text(total);
        criterio(total);
    }else{
        let total = parseInt($("#total").text());
        total += 20;
        $("#total").text(total);
        criterio(total);
    }
})

const criterio = (valor) => {
    if(valor >= 100){
        $("#desarrollo").text("SOBRESALIENTE")
    }
    if(valor >= 75 && valor <100){
        $("#desarrollo").text("ALTA")
    }
    if(valor >= 50 && valor <75){
        $("#desarrollo").text("MODERADA")
    }
    if(valor >= 25 && valor <50){
        $("#desarrollo").text("BAJA")
    }
    if(valor< 25){
        $("#desarrollo").text("AUSENCIA")
    }
}    
});
</script>
</body>
</html>
