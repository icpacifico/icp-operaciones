<?php 
session_start(); 
require "../../config.php"; 
require_once _INCLUDE."head.php";
if (!isset($_SESSION["sesion_usuario_panel"])) header("Location: "._ADMIN."index.php");
if (!isset($_SESSION["modulo_evaluacion_panel"])) header("Location: "._ADMIN."panel.php");
?>
<style>
    table{
        text-align:center;
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
        <div class="content-wrapper">            
            <section class="content-header">
                <h1>
                    Evaluacion de desempeño al vendedor
                    <small>Ingreso</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo _ADMIN?>panel.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Evaluacion</a></li>
                    <li class="active">Ingreso</li>
                </ol>
            </section>           
            <section class="content">
                <div class="row">                    
                    <div class="col-sm-12">                      
                        <div class="box box-primary">
                            <div class="row">
                                <div class="col-lg-10 col-md-offset-1" style="margin-top:3%;">
                                <?php  
                                    $consulta = "SELECT * FROM matriz_preguntas";
                                    $conexion->consulta($consulta);
                                    $matriz = $conexion->extraer_registro();   
                                    // echo '<pre>';
                                    // var_dump($matriz);                                
                                    // echo '</pre>';
                                ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td colspan="3"></td>                                    
                                                <td>CRITERIOS</td>
                                                <td>AUSENCIA</td>
                                                <td>BAJA</td>
                                                <td>MODERADA</td>
                                                <td>ALTA</td>
                                                <td>SOBRESALIENTE</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i=0; $i < count($matriz); $i++) {                                                                                             
                                            ?>
                                            <tr>
                                                <td><?php echo $matriz[$i]['id']?></td>
                                                <td><?php echo utf8_encode($matriz[$i]['competencia'])?></td>
                                                <td><?php echo utf8_encode($matriz[$i]['frase'])?></td>
                                                <td><?php echo utf8_encode($matriz[$i]['pregunta'])?></td>
                                                <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios<?php echo $matriz[$i]['id']?>" id="matriz1<?php echo $matriz[$i]['id']?>" value="<?php echo $matriz[$i]['id']?>" checked>                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios<?php echo $matriz[$i]['id']?>" id="matriz2<?php echo $matriz[$i]['id']?>" value="<?php echo $matriz[$i]['id']?>" checked>                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios<?php echo $matriz[$i]['id']?>" id="matriz3<?php echo $matriz[$i]['id']?>" value="<?php echo $matriz[$i]['id']?>" checked>                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios<?php echo $matriz[$i]['id']?>" id="matriz4<?php echo $matriz[$i]['id']?>" value="<?php echo $matriz[$i]['id']?>" checked>                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios<?php echo $matriz[$i]['id']?>" id="matriz5<?php echo $matriz[$i]['id']?>" value="<?php echo $matriz[$i]['id']?>" checked>                                                            
                                                        </label>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                           
                        </div>                    
                    </div>                   
                </div>            
            </section>            
        </div>        
<?php include_once _INCLUDE."footer_comun.php";?>
<?php include_once _INCLUDE."js_comun.php";?>
<script>
    for (let index = 1; index < 5; index++) {
        for (let i = 1; i < 6; i++) {
            console.log('matriz'+i+''+index);
        }        
    }
</script>
</body>
</html>
