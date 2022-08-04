<?php
session_start();
require "../../config.php";
if(!isset($_SESSION["sesion_usuario_panel"])){
    header("Location: ../../index.php");
}

include _INCLUDE."class/conexion.php";
$conexion = new conexion();

$id_ven = $_POST["valor"];


$consulta = 
    "
    SELECT
        ven.id_for_pag,
        viv.nombre_viv,
        ven.fecha_promesa_ven
    FROM
        venta_venta as ven,
        vivienda_vivienda as viv
    WHERE 
        ven.id_ven = ? AND
        ven.id_viv = viv.id_viv
    ";
$conexion->consulta_form($consulta,array($id_ven));
$fila = $conexion->extraer_registro_unico();
$id_for_pag = utf8_encode($fila['id_for_pag']);
$nombre_viv = utf8_encode($fila['nombre_viv']);
$fecha_promesa_ven = utf8_encode($fila['fecha_promesa_ven']);
if ($fecha_promesa_ven<>null) {
	$fecha_liq_com = date("d-m-Y",strtotime($fecha_promesa_ven));
}

$consultahay = 
    "
    SELECT
        monto_liq_uf_ven,
        monto_liq_pesos_ven,
        fecha_liq_ven
    FROM
        venta_liquidado_venta
    WHERE 
        id_ven = ?
    ";
$conexion->consulta_form($consultahay,array($id_ven));
$insert = $conexion->total();
if ($insert>0) {
	$fila = $conexion->extraer_registro_unico();
	$fecha_liq_ven = utf8_encode($fila['fecha_liq_ven']);
	$monto_liq_uf_ven = utf8_encode($fila['monto_liq_uf_ven']);
	$monto_liq_pesos_ven = utf8_encode($fila['monto_liq_pesos_ven']);
	if ($fecha_liq_ven<>null) {
		$fecha_liq = date("d-m-Y",strtotime($fecha_liq_ven));
	}
}

$consultacampos = 
    "
    SELECT
        numero_factura_ven,
        monto_factura_ven,
        monto_nc_ven,
        numero_nc_ven,
        valor_cre_ven,
        fecha_alzamiento_ven,
        fecha_cargo_301_ven,
        fecha_abono_330_ven,
        ciudad_notaria_ven
    FROM
        venta_campo_venta
    WHERE 
        id_ven = ?
    ";
$conexion->consulta_form($consultacampos,array($id_ven));
$filacam = $conexion->extraer_registro_unico();
$numero_factura_ven = utf8_encode($filacam['numero_factura_ven']);
$monto_factura_ven = utf8_encode($filacam['monto_factura_ven']);
$numero_ncredito_ven = utf8_encode($filacam['numero_nc_ven']);
$monto_ncredito_ven = utf8_encode($filacam['monto_nc_ven']);
$valor_cre_ven = utf8_encode($filacam['valor_cre_ven']);
$ciudad_notaria_ven = $filacam['ciudad_notaria_ven'];
$fecha_alzamiento_ven = utf8_encode($filacam['fecha_alzamiento_ven']);
if ($fecha_alzamiento_ven<>null) {
	$fecha_alzamiento_ven = date("d-m-Y",strtotime($fecha_alzamiento_ven));
}

$fecha_cargo_301_ven = utf8_encode($filacam['fecha_cargo_301_ven']);
if ($fecha_cargo_301_ven<>null) {
	$fecha_cargo_301_ven = date("d-m-Y",strtotime($fecha_cargo_301_ven));
}

$fecha_abono_330_ven = utf8_encode($filacam['fecha_abono_330_ven']);
if ($fecha_abono_330_ven<>null) {
	$fecha_abono_330_ven = date("d-m-Y",strtotime($fecha_abono_330_ven));
}

?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"> Información de la Operación</h4>
        </div>
        

        <div class="modal-body">

            <label><b>Venta:</b> </label> <span><?php echo $id_ven;?></span><br>
            <label><b>Unidad:</b> </label> <span><?php echo $nombre_viv;?></span><br>

            <form id="formulario" method="POST" action="insert_liquida_venta.php" role="form">
                <input type="hidden" id="id" value="<?php echo $id_ven;?>" name="id" />
                <input type="hidden" id="insert" value="<?php echo $insert;?>" name="insert" />

                 <div class="modal-body">
                        

	            <!-- area nueva / solo gerencia -->
	            <?php 
	            if ($_SESSION["sesion_perfil_panel"] == 1) {
	            	$consulta_esta_liquidado = 
					    "
					    SELECT
					        id_cie
					    FROM
					        cierre_venta_cierre
					    WHERE 
					        id_ven = ? AND
					        id_est_ven = 4
					    ";
					$conexion->consulta_form($consulta_esta_liquidado,array($id_ven));
					$hay_liquidacion = $conexion->total();
					if($hay_liquidacion>0){
						$readonly = "disabled";
						$text_aclara = "- venta ya liquidada";
					} else {
						$readonly = "";
						$text_aclara = "";
					}
	            ?>
	            <hr>
            	<div class="row margin-bottom-40">
                	<div class="col-sm-6">
                    	<div class="form-group">
                            <label for="fecha_liq_com">Fecha/Período Liquidación Comisiones:</label>
                            <input type="text" name="fecha_liq_com" value="<?php echo $fecha_liq_com; ?>" class="form-control datepicker elemento" id="fecha_liq_com" <?php echo $readonly; ?>/>
                        </div>
                        <p><?php echo $text_aclara; ?></p>
                    </div>
               	</div>
				<hr>
	            <?php
	            }
	             ?>

	            <p>Cargue las fechas y valores fuera de Etapa.</p>
	            
                        <div class="row margin-bottom-40">
                        	<div class="col-sm-6">
                            	<div class="form-group">
                                    <label for="val_cre">Valor CRE:</label>
                                    <input type="text" name="val_cre" value="<?php echo $valor_cre_ven; ?>" class="form-control numero elemento" id="val_cre"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            	<div class="form-group">
                                    <label for="val_cre">Ciudad Notaría:</label>
                                    <select name="ciudad_notaria" class="form-control" id="ciudad_notaria">
                                    	<option value="1" <?php echo $ciudad_notaria_ven == 1 ? "selected" : '' ?>>La Serena</option>
                                    	<option value="2" <?php echo $ciudad_notaria_ven == 2 ? "selected" : '' ?>>Santiago</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_alzamiento_ven">Alzamiento - Fecha Sol. Contab.:</label>
                                    <input type="text" name="fecha_alzamiento_ven" value="<?php echo $fecha_alzamiento_ven; ?>" class="form-control datepicker elemento" id="fecha_alzamiento_ven"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_cargo_301_ven">Alzamiento - Fecha Cargo CC 301:</label>
                                    <input type="text" name="fecha_cargo_301_ven" value="<?php echo $fecha_cargo_301_ven; ?>" class="form-control datepicker elemento" id="fecha_cargo_301_ven"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_abono_330_ven">Alzamiento - Fecha Abono CC 330:</label>
                                    <input type="text" name="fecha_abono_330_ven" value="<?php echo $fecha_abono_330_ven; ?>" class="form-control datepicker elemento" id="fecha_abono_330_ven"/>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                            	<div class="form-group">
                                    <label for="val_factura">Valor Factura:</label>
                                    <input type="text" name="val_factura" value="<?php echo $monto_factura_ven; ?>" class="form-control numero elemento" id="val_factura"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="num_factura">N° Factura:</label>
                                    <input type="text" name="num_factura" value="<?php echo $numero_factura_ven; ?>" class="form-control numero elemento" id="num_factura"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            	<div class="form-group">
                                    <label for="val_ncredito">Valor Nota Crédito:</label>
                                    <input type="text" name="val_ncredito" value="<?php echo $monto_ncredito_ven; ?>" class="form-control numero elemento" id="val_ncredito"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="num_ncredito">N° Nota Crédito:</label>
                                    <input type="text" name="num_ncredito" value="<?php echo $numero_ncredito_ven; ?>" class="form-control numero elemento" id="num_ncredito"/>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            	<div class="form-group">
                                    <label for="monto_liq_uf">Monto Fondos Liquidados UF:</label>
                                    <input type="text" name="monto_liq_uf" value="<?php echo $monto_liq_uf_ven; ?>" class="form-control elemento numero" id="monto_liq_uf"/>
                                </div>
                                <div class="form-group">
                                    <label for="monto_liq_pesos">Monto Fondos Liquidados Pesos:</label>
                                    <input type="text" name="monto_liq_pesos" value="<?php echo $monto_liq_pesos_ven; ?>" class="form-control elemento numero" id="monto_liq_pesos"/>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_liq">Fecha Liquidación Fondos:</label>
                                    <input type="text" name="fecha_liq" value="<?php echo $fecha_liq; ?>" class="form-control datepicker elemento" id="fecha_liq"/>
                                </div>
                                
                            </div>
                            
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                    
                    <button type="submit" id="guarda_fecha" class="btn btn-primary">Registrar Información</button>
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
        	</form>
        </div>
    </div>
</div>

<?php include_once _INCLUDE."js_comun.php";?>
<script src="<?php echo _ASSETS?>plugins/validate/jquery.validate.js"></script>
<script src="<?php echo _ASSETS?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo _ASSETS?>plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<script src="<?php echo _ASSETS?>plugins/validate/jquery.numeric.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
      
document.addEventListener('DOMContentLoaded', (event) => { 
		$('.numero').numeric();

  		$('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            // startDate: '-0d',
            todayHighlight: true,
            language: 'es',
            autoclose: true
        });

        const resultado = (data) => {   
            switch (data.envio) {
                case 1:
                    Swal.fire({
                    title: "Excelente!",
                    text: "Información ingresada con éxito!",
                    icon: "success",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#9bde94'
                    }).then(() => {
                        location.href = "operacion_listado.php";
                    })
                    break;
                case 2:
                    Swal.fire({
                    icon: 'warning',
                    title: 'Atención!',
                    text: 'Registro ya ha sido ingresado'
                    })
                    $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
                    break;
                case 3:
                    Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Favor intentar denuevo o contáctese con Osman'
                    })
                    $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
                    break;
            
                default:
                
                    Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Problema no identificado, contactar con Osman urgente!',
                    footer: '<a href="#">Esto no es un simulacro :(</a>'
                    })
                    
                    break;
            }
            
        }
        




        // function resultado(data) {
        //     if (data.envio == 1) {
        //         swal({
        //             title: "Excelente!",
        //             text: "Información ingresada con éxito!",
        //             type: "success",
        //             showCancelButton: false,
        //             confirmButtonColor: "#9bde94",
        //             confirmButtonText: "Aceptar",
        //             closeOnConfirm: false
        //         },
        //         function () {
        //             location.href = "operacion_listado.php";
        //         });
        //     }
        //     if (data.envio == 2) {
        //         swal("Atención!", "Registro ya ha sido ingresado", "warning");
        //         $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
        //     }
        //     if (data.envio == 3) {
        //         swal("Error!", "Favor intentar denuevo o contáctese con administrador", "error");
        //         $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
        //     }
           
        // }
        
        $('#formulario').submit(function () {
            
            if ($("#formulario").validate().form() == true){
                //$('#contenedor_boton').html('<img src="../../assets/img/loading.gif">');
                var dataString = $('#formulario').serialize();
                $.ajax({
                    data: dataString,
                    type: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    success: function (data) {
                        resultado(data);
                    }
                })
            }
            return false;
        });

        $("#formulario").validate({
            rules: {
                monto_gas: { 
                    required: true
                }
            },
            messages: { 
                monto_gas: {
                    required: "Ingrese Monto"
                }
            }
        });

  });  
     
</script>   
