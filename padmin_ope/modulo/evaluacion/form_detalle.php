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
                                        <table class="table"  style="margin-bottom:100px;">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" ><strong>1. IDENTIFICACIÓN PERSONA EVALUADA.</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="borde">NOMBRE PERSONA EVALUADA</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="persona" id="persona" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">CARGO / FUNCIÓN</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="cargoPersona" id="cargoPersona" class="form-control" autocomplete="off"></td>
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
                                        
                                        <table class="table"  style="margin-bottom:100px;">
                                            <thead>
                                                <tr>
                                                    <td colspan="4" ><strong>2.- CRITERIOS DE EVALUACIÓN.</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="borde">NOMBRE PERSONA EVALUADA</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="persona" id="persona" class="form-control" autocomplete="off"></td>
                                                </tr>
                                                <tr>
                                                    <td class="borde">CARGO / FUNCIÓN</td>
                                                    <td colspan="4" class="borde"> <input type="text" name="cargoPersona" id="cargoPersona" class="form-control" autocomplete="off"></td>
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
</body>
</html>
