<?php 
session_start(); 
require "../../config.php"; 
if (!isset($_SESSION["sesion_usuario_panel"])) {
    header("Location: "._ADMIN."index.php");
}
require_once _INCLUDE."head_informe.php";
?>
<title>Venta - Listado</title>
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.bootstrap.min.css">
<link rel="stylesheet" href="<?php echo _ASSETS?>plugins/select2/select2.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<style type="text/css">
.container-fluid .content .filtros .form-control {
    display: block;
    width: 100%;
    height: 24px;
    padding: 8px 4px;
    font-size: 12px;
    line-height: 1.3;
    height: 35px;
}

.container-fluid .content .input-group .form-control.chico {
    display: block;
    width: 100%;
    /*height: 24px;*/
    padding: 3px 4px;
    font-size: 12px;
    line-height: 1.3;
    height: 24px;
}

.container-fluid .content .filtros .form-control.chico {
    display: block;
    width: 100%;
    padding: 3px 4px;
    font-size: 12px;
    line-height: 1.3;
    height: 24px;
}

.filtros .input-group-addon {
    padding: 4px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #555;
    text-align: center;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 0px;
}

#contenedor_filtro .label {
    display: inline;
    padding: .6em .8em .6em;
    font-size: 80%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}

.bg-grays{
  background-color: #e8f0f5;
}

.filtros label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0px;
    font-weight: 600;
    font-size: 90%;
}

h4.titulo_informe{
  margin-top: 0;
}

.form-group.filtrar {
    margin-bottom: 0px;
    padding-top: 20px;
}

.container-fluid .content .form-control {
    display: inline-block;
    width: auto;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #d2d6de;
    border-radius: 0px;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 26px;
    user-select: none;
    -webkit-user-select: none;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 21px;
}
</style>
<link rel="stylesheet" href="<?php echo _ASSETS?>plugins/datepicker/datepicker3.css">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
<?php 
include _INCLUDE."class/conexion.php";
$conexion = new conexion();
require_once _INCLUDE."menu_modulo_no_aside.php";
 ?>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Pagos
          <small>informe</small>
        </h1>
        <ol class="breadcrumb">
            <li></i> Home</li>
            <li>Pagos</li>
            <li class="active">informe</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-sm-12">
            <!-- general form elements -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 1 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="../informe/operacion_listado.php">LISTADO VENTAS</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 14 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="condominio_disponibilidad_listado.php">DISPONIBILIDAD</a></li>
                                <?php
                            }
                            
                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 4 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_velocidad_listado.php">VELOCIDAD DE VENTAS</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 15 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_recuperacion_listado.php">RECUPERACIÓN</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 8 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_estadistica_venta.php">ANÁLISIS DE VENTAS</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 10 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_cotizacion_venta.php">LISTADO COTIZACIONES</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 11 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="ficha_cliente_proceso.php">FICHA DE CLIENTE</a></li>
                                <?php
                            }

                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 12 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li class="active"><a href="venta_pago_venta.php">LISTADO PAGOS</a></li>
                                <?php
                            }
                            // alzamiento
                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 16 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_alzamiento_listado.php">ALZAMIENTO</a></li>
                                <?php
                            }
                            // fondo explotación
                            $consulta = 
                                "
                                SELECT 
                                    usu.id_mod 
                                FROM 
                                    usuario_usuario_proceso AS usu,
                                    usuario_proceso AS proceso
                                WHERE 
                                    usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                    usu.id_mod = 1 AND
                                    proceso.opcion_pro = 18 AND
                                    proceso.id_pro = usu.id_pro AND
                                    proceso.id_mod = 1
                                ";
                            $conexion->consulta($consulta);
                            $cantidad_opcion = $conexion->total();
                            if($cantidad_opcion > 0){
                                ?>
                                <li><a href="venta_fondo_listado.php">FONDO EXPLOTACIÓN</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php  
                        $consulta = 
                            "
                            SELECT 
                                usu.id_mod 
                            FROM 
                                usuario_usuario_proceso AS usu,
                                usuario_proceso AS proceso
                            WHERE 
                                usu.id_usu = ".$_SESSION["sesion_id_panel"]." AND
                                usu.id_mod = 1 AND
                                (proceso.opcion_pro = 1 OR proceso.opcion_pro = 12) AND
                                proceso.id_pro = usu.id_pro AND
                                proceso.id_mod = 1
                            ";
                        $conexion->consulta($consulta);
                        $cantidad_opcion = $conexion->total();
                        // echo "fff".$cantidad_opcion;
                        if($cantidad_opcion > 0){
                            ?>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="box-body" style="padding-top: 0">
                                        <div class="row">
                                            <div id="contenedor_opcion"></div>
                                            <div class="col-sm-12 filtros">
                                                <div class="row">
                                                    <div class="col-sm-3 radiomio">
                                                        <div class="radio bg-grays" style="margin-top: 20px; padding: 5px">
                                                            <?php  
                                                            $consulta = "SELECT * FROM pago_categoria_pago ORDER BY nombre_cat_pag";
                                                            $conexion->consulta($consulta);
                                                            $fila_consulta = $conexion->extraer_registro();
                                                            if(is_array($fila_consulta)){
                                                                foreach ($fila_consulta as $fila) {
                                                                    ?>
                                                                    <input id="categoria_pago<?php echo $fila['id_cat_pag'];?>" type="radio" name="categoria_pago" class="filtro" value="<?php echo $fila['id_cat_pag'];?>">
                                                                    <label for="categoria_pago<?php echo $fila['id_cat_pag'];?>"><?php echo utf8_encode($fila['nombre_cat_pag']);?></label>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                                
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="col-sm-5">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fecha_desde">Fecha Real Desde:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                                                        <input type="text" class="form-control chico pull-right datepicker" name="fecha_desde" id="fecha_desde">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="fecha_hasta">Fecha Real Hasta:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                                                        <input type="text" class="form-control chico pull-right datepicker" name="fecha_hasta" id="fecha_hasta">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="banco">Banco:</label>
                                                                      <!-- <span class="input-group-addon"><i class="fa fa-car" aria-hidden="true"></i></span> -->
                                                                    <select class="form-control select2 chico" id="banco" name="banco"> 
                                                                        <option value="">Seleccione banco</option>
                                                                        <?php  
                                                                        $consulta = "SELECT * FROM banco_banco ORDER BY nombre_ban";
                                                                        $conexion->consulta($consulta);
                                                                        $fila_consulta_banco_original = $conexion->extraer_registro();
                                                                        if(is_array($fila_consulta_banco_original)){
                                                                            foreach ($fila_consulta_banco_original as $fila) {
                                                                                ?>
                                                                                <option value="<?php echo $fila['id_ban'];?>"><?php echo utf8_encode($fila['nombre_ban']);?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="cliente">Cliente:</label>
                                                                      <!-- <span class="input-group-addon"><i class="fa fa-car" aria-hidden="true"></i></span> -->
                                                                    <select class="form-control chico select2" id="cliente" name="cliente"> 
                                                                        <option value="">Seleccione Cliente</option>
                                                                        <?php  
                                                                        $consulta = "SELECT id_pro,nombre_pro,apellido_paterno_pro,apellido_materno_pro FROM propietario_propietario ORDER BY nombre_pro, apellido_paterno_pro, apellido_materno_pro";
                                                                        $conexion->consulta($consulta);
                                                                        $fila_consulta_propietario_original = $conexion->extraer_registro();
                                                                        if(is_array($fila_consulta_propietario_original)){
                                                                            foreach ($fila_consulta_propietario_original as $fila) {
                                                                                ?>
                                                                                <option value="<?php echo $fila['id_pro'];?>"><?php echo utf8_encode($fila['nombre_pro']." ".$fila['apellido_paterno_pro']." ".$fila['apellido_materno_pro']);?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1 text-center">
                                                      <div class="form-group filtrar">
                                                          <input type="button" value="FILTRAR" name="filtro" id="filtro" class="btn btn-xs btn-icon btn-primary"></input>
                                                      </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <div id="resultado" class="text-center"></div>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            
                                            
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" id="contenedor_filtro">
                                                <button class="btn btn-xs btn-primary borra_sesion">Ver Todos</button>
                                                <h6 class="pull-right" style="font-style: italic; color:#ccc; font-size: 13px">
                                                  <i>Filtro: 
                                                    <?php 
                                                    $filtro_consulta = '';
                                                    $elimina_filtro = 0;
                                                    if(isset($_SESSION["sesion_filtro_categoria_pago_panel"])){
                                                        $elimina_filtro = 1;

                                                        $consulta = "SELECT * FROM pago_categoria_pago WHERE id_cat_pag = ".$_SESSION["sesion_filtro_categoria_pago_panel"]." ORDER BY nombre_cat_pag";
                                                        $conexion->consulta($consulta);
                                                        $fila_consulta = $conexion->extraer_registro();
                                                        if(is_array($fila_consulta)){
                                                            foreach ($fila_consulta as $fila) {
                                                                $texto_filtro = utf8_encode($fila['nombre_cat_pag']);
                                                                $filtro_consulta .= " AND cat_pag.id_cat_pag = '".$_SESSION["sesion_filtro_categoria_pago_panel"]."'";
                                                            }
                                                        }

                                                        ?>
                                                        <span class="label label-primary"><?php echo $texto_filtro;?></span> | 
                                                        <?php
                                                        //$filtro_consulta = " AND alu.id_alu = ".$_SESSION["id_alumno_filtro_panel"];
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-default">Sin filtro</span> | 
                                                        <?php       
                                                    }
                                                    
                                                    if(isset($_SESSION["sesion_filtro_fecha_desde_panel"])){
                                                        $elimina_filtro = 1;
                                                        ?>
                                                        <span class="label label-primary"><?php echo $_SESSION["sesion_filtro_fecha_desde_panel"];?></span> |
                                                        <?php
                                                        $fecha = date("Y-m-d",strtotime($_SESSION["sesion_filtro_fecha_desde_panel"]));
                                                        $filtro_consulta .= " AND pag.fecha_real_pag >= '".$fecha."'";
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-default">Sin filtro</span> | 
                                                        <?php       
                                                    }
                            
                            
                                                    if(isset($_SESSION["sesion_filtro_fecha_hasta_panel"])){
                                                        $elimina_filtro = 1;
                                                        ?>
                                                        <span class="label label-primary"><?php echo $_SESSION["sesion_filtro_fecha_hasta_panel"];?></span> |
                                                        <?php
                                                        $fecha = date("Y-m-d",strtotime($_SESSION["sesion_filtro_fecha_hasta_panel"]));
                                                        $filtro_consulta .= " AND pag.fecha_real_pag <= '".$fecha."'";
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-default">Sin filtro</span> |
                                                        <?php       
                                                    }

                                                    if(isset($_SESSION["sesion_filtro_banco_panel"])){
                                                        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($fila_consulta_banco_original));
                                                        $fila_consulta_banco = array();
                                                        foreach($it as $v) {
                                                            $fila_consulta_banco[]=$v;
                                                        }
                                                        $elimina_filtro = 1;

                                                        $flipped_banco = array_flip($fila_consulta_banco);
                                                        
                                                        if(is_array($fila_consulta_banco)){
                                                            foreach ($fila_consulta_banco as $fila) {
                                                                // if(in_array($_SESSION["sesion_filtro_banco_panel"],$fila_consulta_banco)){
                                                                //     $key = array_search($_SESSION["sesion_filtro_banco_panel"], $fila_consulta_banco);
                                                                //     $texto_filtro = $fila_consulta_banco[$key + 1];
                                                                // }

                                                                if(isSet($flipped_banco[$_SESSION["sesion_filtro_banco_panel"]])){
                                                            		$key = array_search($_SESSION["sesion_filtro_banco_panel"], $fila_consulta_banco);
                                                                    $texto_filtro = $fila_consulta_banco[$key + 1];
                                                            	}
                                                            }
                                                        }
                                                        ?>
                                                        <span class="label label-primary"><?php echo utf8_encode($texto_filtro);?></span> |  
                                                        <?php
                                                        $filtro_consulta .= " AND pag.id_ban = ".$_SESSION["sesion_filtro_banco_panel"];
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-default">Sin filtro</span> | 
                                                        <?php       
                                                    }
                                                    if(isset($_SESSION["sesion_filtro_propietario_panel"])){
                                                        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($fila_consulta_propietario_original));
                                                        $fila_consulta_propietario = array();
                                                        foreach($it as $v) {
                                                            $fila_consulta_propietario[]=$v;
                                                        }
                                                        $elimina_filtro = 1;

                                                        $flipped_propietario = array_flip($fila_consulta_propietario);
                                                        
                                                        if(is_array($fila_consulta_propietario)){
                                                            foreach ($fila_consulta_propietario as $fila) {
                                                                // if(in_array($_SESSION["sesion_filtro_propietario_panel"],$fila_consulta_propietario)){
                                                                //     $key = array_search($_SESSION["sesion_filtro_propietario_panel"], $fila_consulta_propietario);
                                                                //     $texto_filtro = $fila_consulta_propietario[$key + 1]." ".$fila_consulta_propietario[$key + 2]." ".$fila_consulta_propietario[$key + 3];
                                                                // }

                                                                if(isSet($flipped_propietario[$_SESSION["sesion_filtro_propietario_panel"]])){
                                                            		$key = array_search($_SESSION["sesion_filtro_propietario_panel"], $fila_consulta_propietario);
                                                                    $texto_filtro = $fila_consulta_propietario[$key + 1]." ".$fila_consulta_propietario[$key + 2]." ".$fila_consulta_propietario[$key + 3];
                                                            	}
                                                            }
                                                        }
                                                        ?>
                                                        <span class="label label-primary"><?php echo utf8_encode($texto_filtro);?></span> 
                                                        <?php
                                                        $filtro_consulta .= " AND ven.id_pro = ".$_SESSION["sesion_filtro_propietario_panel"];
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-default">Sin filtro</span> 
                                                        <?php       
                                                    }
                                                    

                                                    if ($elimina_filtro<>0) {
                                                      ?>
                                                      <i class="fa fa-times fa-2x borra_sesion" style="cursor: pointer;" aria-hidden="true"></i> 
                                                      <?php
                                                    }

                                                    ?>
                                                    
                                                </i>
                                              </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row" id="contenedor_tabla">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Listado de Pagos</h3>
                                                        <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Exportar Excel">
                                                        	<a href="venta_pago_venta_exc.php" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-file-excel-o text-green"></i></a>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-header -->
                                                    <div class="box-body no-padding">
                                                        <!-- <table class="table table-striped"> -->
                                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Condominio</th>
                                                                    <th>Depto</th>
                                                                    <th>Rut Cliente</th>
                                                                    <th>Nombre Cliente</th>
                                                                    <th>Fono Cliente</th>
                                                                    <th>Categoría</th>
                                                                    <th>Banco</th>
                                                                    <th>Forma de Pago</th>
                                                                    <th>Fecha</th>
                                                                    <th>Fecha Real</th>
                                                                    <th>Documento</th>
                                                                    <!-- <th>Serie</th> -->
                                                                    <th>Monto</th>
                                                                    <th>Estado</th>
                                                                    <th>Valor UF</th>
                                                                    <th>Monto Abono UF</th>
                                                                </tr>    
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $acumulado_monto = 0;
                                                                
                                                                
                                                                $consulta = 
                                                                    "
                                                                    SELECT
                                                                        con.nombre_con,
                                                                        pag.id_pag,
                                                                        cat_pag.nombre_cat_pag,
                                                                        ban.nombre_ban,
                                                                        for_pag.nombre_for_pag,
                                                                        pag.fecha_pag,
                                                                        pag.fecha_real_pag,
                                                                        pag.numero_documento_pag,
                                                                        pag.numero_serie_pag,
                                                                        pag.monto_pag,
                                                                        est_pag.nombre_est_pag,
                                                                        pag.id_est_pag,
                                                                        pag.id_ven,
                                                                        viv.nombre_viv,
                                                                        pro.rut_pro,
                                                                        pro.nombre_pro,
                                                                        pro.apellido_paterno_pro,
                                                                        pro.apellido_materno_pro,
                                                                        pro.fono_pro,
                                                                        pag.id_for_pag
                                                                    FROM 
                                                                        pago_pago AS pag 
                                                                        INNER JOIN pago_categoria_pago AS cat_pag ON cat_pag.id_cat_pag = pag.id_cat_pag
                                                                        INNER JOIN pago_estado_pago AS est_pag ON est_pag.id_est_pag = pag.id_est_pag
                                                                        LEFT JOIN banco_banco AS ban ON ban.id_ban = pag.id_ban
                                                                        INNER JOIN pago_forma_pago AS for_pag ON for_pag.id_for_pag = pag.id_for_pag
                                                                        INNER JOIN venta_venta AS ven ON ven.id_ven = pag.id_ven
                                                                        INNER JOIN vivienda_vivienda AS viv ON viv.id_viv = ven.id_viv
                                                                        INNER JOIN torre_torre AS tor ON tor.id_tor = viv.id_tor
                                                                        INNER JOIN condominio_condominio AS con ON con.id_con = tor.id_con
                                                                        INNER JOIN propietario_propietario AS pro ON pro.id_pro = ven.id_pro
                                                                    WHERE 
                                                                        pag.id_pag > 0 AND
                                                                        ven.id_est_ven <> 3
                                                                        ".$filtro_consulta."
                                                                    ORDER BY 
                                                                        pag.fecha_pag DESC
                                                                    "; 
                                                                // echo $consulta;
                                                                $conexion->consulta($consulta);
                                                                $fila_consulta = $conexion->extraer_registro();
                                                                if(is_array($fila_consulta)){
                                                                    foreach ($fila_consulta as $fila) {
                                                                        if ($fila['fecha_cot'] == '0000-00-00') {
                                                                            $fecha_cotizacion = "";
                                                                        }
                                                                        else{
                                                                            $fecha_cotizacion = date("d/m/Y",strtotime($fila['fecha_cot']));
                                                                        }
                                                                        $acumulado_monto = $acumulado_monto + $fila['monto_ven'];
                                                                        
                                                                        
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo utf8_encode($fila['nombre_con']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_viv']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['rut_pro']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_pro']." ".$fila['apellido_paterno_pro']." ".$fila['apellido_materno_pro']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['fono_pro']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_cat_pag']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_ban']); ?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_for_pag']); ?></td>
                                                                            <td><?php echo date("d/m/Y",strtotime($fila["fecha_pag"]));?></td>
                                                                            <td>
                                                                            	<?php
                                                                            	$monto_abono = 0;
                                                                            	if ($fila["fecha_real_pag"]<>'0000-00-00' && $fila["fecha_real_pag"]<>null) {
                                                                            		echo date("d/m/Y",strtotime($fila["fecha_real_pag"]));
                                                                            		// busca la uF
																			        $consultauf = 
																			            "
																			            SELECT
																			                valor_uf
																			            FROM
																			                uf_uf
																			            WHERE
																			                fecha_uf = '".$fila["fecha_real_pag"]."'
																			            ";
																			        // echo $consultauf;
																			        $conexion->consulta($consultauf);
																			        $filauf = $conexion->extraer_registro_unico();
																			        $valor_uf = $filauf["valor_uf"];
																			        if ($valor_uf<>'') {
																				        if ($fila["id_for_pag"]==6) { // si es pago contra escritura UF
																				        	$monto_abono = $fila['monto_pag'] * $valor_uf;
																				        	$valor_uf = number_format($valor_uf, 2, ',', '.');
																				        	$monto_abono = number_format($monto_abono, 0, ',', '.');
																				        } else {
																							$monto_abono = $fila['monto_pag'] / $valor_uf;
																				        	$valor_uf = number_format($valor_uf, 2, ',', '.');
																				        	$monto_abono = number_format($monto_abono, 2, ',', '.');
																				        }
																				    }
                                                                            	} else {
                                                                            		echo "--";
                                                                            		$valor_uf = "";
                                                                            		$monto_abono = "";
                                                                            	}
                                                                            	?>
                                                                            </td>
                                                                            <td><?php echo utf8_encode($fila['numero_documento_pag']); ?></td>
                                                                            <!-- <td><?php //echo utf8_encode($fila['numero_serie_pag']); ?></td> -->
                                                                            <td><?php echo number_format($fila['monto_pag'], 0, ',', '.');?></td>
                                                                            <td><?php echo utf8_encode($fila['nombre_est_pag']); ?></td>

                                                                            <td><?php echo $valor_uf; ?></td>
                                                                            <td><?php echo $monto_abono; ?></td>
                                                                        </tr>
                                                                        <?php
                                                                        
                                                                    }
                                                                }
                                                                ?>   
                                                            </tbody>
                                                            <!-- <tfoot>
                                                                <tr>
                                                                    <td colspan="9"></td>
                                                                    
                                                                    <td>$<?php echo number_format($acumulado_monto, 0, ',', '.'); ?></td>
                                                                </tr> 
                                                            </tfoot> -->
                                                            
                                                            
                                                        </table>
                                                    </div>
                                                    <!-- /.box-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <?php
                        }
                        ?>
                        
                        <!-- nav-tabs-custom -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once _INCLUDE."footer_comun.php";?>
<!-- .wrapper cierra en el footer -->
<?php include_once _INCLUDE."js_comun.php";?>
<script src="<?php echo _ASSETS?>plugins/daterangepicker/moment.min.js"></script>
<!-- DataTables -->
<script src="<?php echo _ASSETS?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/datetime-moment.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/dataTables.buttons.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.bootstrap.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/jszip.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/pdfmake.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/vfs_fonts.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.html5.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.print.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.colVis.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo _ASSETS?>plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo _ASSETS?>plugins/select2/select2.full.min.js"></script>

<script type="text/javascript">
    jQuery.fn.dataTable.ext.type.search.string = function(data) {
    return !data ?
        '' :
        typeof data === 'string' ?
        data
        .replace(/έ/g, 'ε')
        .replace(/ύ/g, 'υ')
        .replace(/ό/g, 'ο')
        .replace(/ώ/g, 'ω')
        .replace(/ά/g, 'α')
        .replace(/ί/g, 'ι')
        .replace(/ή/g, 'η')
        .replace(/\n/g, ' ')
        .replace(/[áÁ]/g, 'a')
        .replace(/[éÉ]/g, 'e')
        .replace(/[íÍ]/g, 'i')
        .replace(/[óÓ]/g, 'o')
        .replace(/[úÚ]/g, 'u')
        .replace(/[üÜ]/g, 'u')
        .replace(/ê/g, 'e')
        .replace(/î/g, 'i')
        .replace(/ô/g, 'o')
        .replace(/è/g, 'e')
        .replace(/ï/g, 'i')
        .replace(/ã/g, 'a')
        .replace(/õ/g, 'o')
        .replace(/ç/g, 'c')
        .replace(/ì/g, 'i') :
        data;
    };
    $(document).ready(function () {

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });

        // $('#example_filter input').keyup(function() {
        //     table
        //       .search(
        //         jQuery.fn.dataTable.ext.type.search.string(this.value)
        //       )
        //       .draw();
        // });

        $(document).on( "click","#filtro" , function() {
            //$('#contenedor_filtro').html('<img src="../../assets/img/loading.gif">');
            var_fecha_desde = $('#fecha_desde').val();
            var_fecha_hasta = $('#fecha_hasta').val();
            var_categoria_pago = $('.filtro:checked').val();
            var_banco = $('#banco').val();
            var_cliente = $('#cliente').val();
            var_forma_pago = $('#forma_pago').val();
            $.ajax({
                type: 'POST',
                url: ("filtro_update.php"),
                data:"fecha_desde="+var_fecha_desde+"&fecha_hasta="+var_fecha_hasta+"&cliente="+var_cliente+"&banco="+var_banco+"&categoria_pago="+var_categoria_pago+"&forma_pago="+var_forma_pago,
                success: function(data) {
                    location.reload();
                }
            })
        });

        $(document).on( "click",".borra_sesion" , function() {
            // $('#contenedor_filtro').html('<img src="../../assets/img/loading.gif">');
            $.ajax({
                type: 'POST',
                url: ("filtro_delete.php"),
                // data:"fecha_desde="+var_fecha_desde+"&fecha_hasta="+var_fecha_hasta+"&estado="+var_estado+"&vehiculo="+var_vehiculo,
                success: function(data) {
                    location.reload();
                }
            })
        });
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            language: 'es',
            autoclose: true
        });
        
        var table = $('#example').DataTable( {
            "pageLength": 1000,
            dom:'lfBrtip',
            // success de tabla
            lengthChange: true,
            buttons: [ 'copy', {
                extend: 'excelHtml5',
                exportOptions: {
                	orthogonal: 'export',
                    columns: ':visible',
          //           format: {
	         //            body: function(data, row, column, node) {
	         //            	if (typeof data !== 'undefined') {
          //           			if (data !== null) {
          //           				if (column === 12) {
										// return "hola";
          //           				} else {
										// return data;
          //           				}
          //           				if (column === 12 || column === 13 || column === 18 || column === 19){
										// //data contain only one comma we need to split there
		        //                         var arr = data;
		        //                         arr = arr.replace( /[\.]/g, "" );
		        //                         arr = arr.replace( /[\,]/g, "." );
	         //                        	return arr;
          //           				} else if (column === 2) {
          //           					var arr = data;
          //           					arr = arr.split("-");
          //           					return arr[0];
          //           				} else {
          //           					return data;
          //           				}
                    		// 	} else {
                    		// 		return data;
                    		// 	}
                    		// } else {
                    		// 	return data;
                    		// }
	                    	// return data.replace('.', '');
	                        // return data.replace(',', '');
	                    // }
                	// }
                }
            }, 'pdf', 'print', 'colvis' ],
            "bProcessing": true,
            //"bServerSide": true,
            responsive: true,
            //"sAjaxSource": "select_alumno.php",
            "sPaginationType": "full_numbers",
            "aaSorting": [[ 1, "asc" ]],
            "aoColumns": [
                { "sType": "string" },
                { "sType": "string" },
                { "sType": "string" },
                { "sType": "string" },
                { "sType": "string" },
                { "sType": "string" },
                { "sType": "string" },
                // { "sType": "string" },
                { "sType": "string" },
                { "sType": "date-uk" },
                { "sType": "date-uk" },
                { "sType": "string" },
                { "sType": "numeric", render: function (data, type, row) {
                	if (type === 'export') {
						var arr = data;
		                arr = arr.replace( /[\.]/g, "" );
		                arr = arr.replace( /[\,]/g, "." );
	                    return arr;
                	} else {
                		return data;
                	}
	            } }, //13
                { "sType": "string" },
                { "sType": "numeric", render: function (data, type, row) {
                	if (type === 'export') {
						var arr = data;
		                arr = arr.replace( /[\.]/g, "" );
		                arr = arr.replace( /[\,]/g, "." );
	                    return arr;
                	} else {
                		return data;
                	}
	            } }, //13
                { "sType": "numeric", render: function (data, type, row) {
                	if (type === 'export') {
						var arr = data;
		                arr = arr.replace( /[\.]/g, "" );
		                arr = arr.replace( /[\,]/g, "." );
	                    return arr;
                	} else {
                		return data;
                	}
	            } }, //13
            ]
        });

        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function ( a ) {
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        $.fn.dataTable.moment( 'DD.MM.YYYY' );
        table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(1)' );
        
    });
</script>
</body>
</html>
