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
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php 
        include _INCLUDE."class/conexion.php";
        $conexion = new conexion();
        require_once _INCLUDE."menu_modulo.php";
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
                                    <div class="col-md-6 text-right" style="font-size:1.8rem;"> <b>CICLO DE EVALUACIÓN : 2020 - 2021</b></div>
                                    <div class="col-md-6" style="font-size:1.8rem;"> <b>FECHA EVALUACIÓN : <?php echo Date('d-m-Y');?></b></div>
                                    
                                </div>
                                <div class="row">
                                <div class="col-md-8 col-md-offset-2" style=margin-top:3%;>
                                        <div class="alert alert-warning" role="alert" style="padding:30px;">
                                        <i class="fa fa-warning" aria-hidden="true" style="font-size:2.4rem; padding:0 1% 1% 0;"></i>  En consideración de este ciclo de evaluación de desempeño, ambas partes concuerdan que, al momento de la evaluación de desempeño, se tuvo presente, la asignación de metas de ciclo de evaluación y el Descriptor de Cargo. Se solicita <strong>completar solo campos en blanco.</strong>
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
                                                    <td colspan="4" class="borde"> 
                                                        <select name="cargoPersona" id="cargoPersona" class="form-control" autocomplete="off">
                                                            <option value="0">seleccione un/una cargo/función</option>
                                                            <option value="3">Operaciones</option>
                                                            <option value="4">Vendedor</option>
                                                        </select>
                                                        <!-- <input type="text" name="cargoPersona" id="cargoPersona" class="form-control" autocomplete="off"></td> -->

                                                </tr>
                                                <tr>
                                                    <td class="borde">NOMBRE EVALUADOR/A</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="evaluador" id="evaluador" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">CARGO / FUNCIÓN</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="cargoEvaluador" id="cargoEvaluador" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde"> OBSERVACIONES DE DESEMPEÑO:</td>
                                                    <td class="borde">APLICA AUSENTISMO HASTA POR 60 DÍAS HÁBILES</td>
                                                    <td class="borde"> <b>NO</b></td>
                                                    <td class="borde">APLICA CRITERIO DE COMPENSACIÓN POR 15 DÍAS DE AUSENTISMO CONTINUO</td>
                                                    <td class="borde"><b>NO</b></td>
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
                                                    <td class="borde">META ASIGNADA</td>
                                                    <td class="borde">META LOGRADA</td>
                                                    <td class="borde">% LOGRO</td>
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
                                                    <td colspan="3" class="borde"><input type="text" name="fundamentacion1" id="fundamentacion1" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.2 COMPETENCIA 1</strong> </td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">ORIENTACIÓN AL CLIENTE</td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><input type="text" name="fundamentacion2" id="fundamentacion2" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.3 COMPETENCIA 2</strong></td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">HABILIDADES INTERPERSONALES</td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><input type="text" name="fundamentacion3" id="fundamentacion3" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.4 COMPETENCIA 3</strong></td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">ORIENTACIÓN AL LOGRO</td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><input type="text" name="fundamentacion4" id="fundamentacion4" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left"><strong>2.5 COMPETENCIA 4</strong> </td>
                                                    <td class="borde">DESARROLLO PROPUESTO</td>
                                                    <td class="borde">AÑO ACTUAL</td>
                                                    <td class="borde">% LOGRO</td>
                                                </tr>
                                                <tr>
                                                    <td class="borde text-left">NEGOCIACIÓN</td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                    <td class="borde"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="borde text-left" >FUNDAMENTACIÓN</td>                                                    
                                                    <td colspan="3" class="borde"><input type="text" name="fundamentacion5" id="fundamentacion5" class="form-control" autocomplete="off"></td>
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
                                                    <td class="borde2">116</td>
                                                    <td class="borde2">0,7</td>
                                                    <td class="borde2">81</td>
                                                    <td class="borde2">88</td>
                                                    <td class="borde2">0,3</td>
                                                    <td class="borde2">26</td>
                                                    <td class="borde2" rowspan="3" style="font-size:3em;">107</td>                                               
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="borde2">ANOTACIONES DEMÉRITO (20%)</td>
                                                    <td class="borde2">NO</td>
                                                    <td colspan="2" class="borde2" >APLICA REDUCCIÓN DEL 20% AL TOTAL LOGRADO</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="borde2">ANOTACIONES DE MÉRITO (20%)</td>
                                                    <td class="borde2">NO</td>
                                                    <td colspan="2" class="borde2">APLICA AUMENTO DEL 20% AL TOTAL LOGRADO</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="borde2"> NIVEL DE DESARROLLO ALCANZADO</td>
                                                    <td colspan="4" class="borde2"> <b>SOBRESALIENTE</b></td>
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
                                         <p class="text-center">NOMBRE PERSONA EVALUADA</p>
                                         <p class="text-center">CARGO</p>
                                       </div>
                                        <div class="col-md-4 text-right"><hr style="height:1px;border:none;color:#333;background-color:#333;">
                                        <p class="text-center">NOMBRE PERSONA EVALUADORA</p>
                                         <p class="text-center">JEFATURA DE VENTAS</p>
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

     

    $("#cargoPersona").change(function(eve){ 
        let personas ='';
        if( $(this).val() != 0){
            req({cargo : $(this).val()},'getPersonas.php');           
        }else{
            $("#persona").html('');
        }
        eve.preventDefault();
    });


    let req = (data,url) => {       
        $.ajax({
            data: data,
            type: 'POST',
            url: url,
            // dataType:dtype,
            success:function(data){
               $("#persona").html(data);
            }
        });       
    }




});
</script>
</body>
</html>
