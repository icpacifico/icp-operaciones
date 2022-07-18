<?php 
session_start(); 
require "../../config.php"; 
require_once _INCLUDE."head.php";
if (!isset($_SESSION["sesion_usuario_panel"])) {
    header("Location: "._ADMIN."index.php");
}
if (!isset($_SESSION["modulo_cotizacion_panel"])) {
    header("Location: "._ADMIN."panel.php");
}
$_SESSION["modulo_propietario_panel"] = 1;
?>
<!-- DataTables -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables/extensions/buttons/buttons.bootstrap.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables5/DataTables-1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/css/buttons.bootstrap5.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<!-- <link rel="stylesheet" href="<?php echo _ASSETS?>plugins/iCheck/all.css"> -->
<!-- siempre al final los ajustes -->
<link rel="stylesheet" href="<?php echo _ASSETS?>dist/css/ajustes.css">
<?php 
if ($_SESSION["sesion_perfil_panel"]==4) { //le oculta al vendedor los botontes tabla
	?>
	<style type="text/css">
	.dt-buttons.btn-group{
		display: none;
	}
	</style>
	<?php
}
 ?>
 <?php 
if ($_SESSION["sesion_perfil_panel"]==='2') {
 ?>
 <style type="text/css">
 	table#example{
	width: 160% !important;
}

.wmd-view-topscroll, .wmd-view {
    overflow-x: scroll;
    overflow-y: hidden;
    width: 100%;
    border: none 0px RED;
}

.wmd-view-topscroll { height: 20px; }
.wmd-view { height: 100%; }
.scroll-div1 { 
    width: 160%; 
    overflow-x: scroll;
    overflow-y: hidden;
    height:20px;
}
.scroll-div2 { 
    width: 3000px; 
    height:20px;
}
 </style>
<?php } ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php 
        include _INCLUDE."class/conexion.php";
        $conexion = new conexion();
        require_once _INCLUDE."menu_modulo.php";
        ?>
        <!-- Modal Ver -->
        <!-- Modal -->
        <div class="modal fade" id="contenedor_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        </div>

        <!-- Fin modal -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cotización
                    <small>Listado</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo _ADMIN?>panel.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Cotización</a></li>
                    <li class="active">Listado</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-sm-12">
                        <div id="contenedor_opcion"></div>
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <!-- <div class="box-header with-border">
                                <h3 class="box-title">Complete el formulario</h3>
                            </div> -->
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                            	<?php 
								if ($_SESSION["sesion_perfil_panel"]<>4) {
                            	 ?>
                            	<p><b>Nota:</b> Las cotizaciones que pasan a promesa debe buscarlas en el Módulo Venta <a href="<?php echo _MODULO?>venta/form_select.php">Ir a ventas</a></p>
								<br>
								<a href="listado_cotizacion_exc.php" target="_blank" class="btn btn-sm btn-info">Exportar Listado Completo a Excel</a>
                            	<?php } ?>
                            	<div class="wmd-view-topscroll">
								    <div class="scroll-div1">
								    </div>
								</div>
								<div class="table-responsive wmd-view">
	                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	                                    <thead>
	                                        <tr>
	                                            <th width="5">
	                                                <input type="checkbox" name="check_todo" id="check_todo">
	                                                <label for="check_todo"><span></span></label>
	                                            </th>
	                                            <th>Id</th>
	                                            <th>Condomin.</th>
	                                            <th>Torre</th>
	                                            <th>Modelo</th>
	                                            <th>Depto</th>
	                                            <th>Cliente</th>
	                                            <th>RUT</th>
	                                            <?php 
												if ($_SESSION["sesion_perfil_panel"]==='2') {
				                            	 ?>
				                            	 <th>Email</th>
				                            	 <th>Fono</th>
				                            	 <th>Comuna</th>
				                            	 <th>Profesión</th>
				                            	 <th>Sexo</th>
				                            	 <?php 
				                            	}
				                            	  ?>
	                                            <th>Canal</th>
	                                            <th>Preaprob.</th>
	                                            <th>Interés</th>
	                                            <th>Vendedor</th>
	                                            <th>Fecha</th>
	                                            <th>Estado</th>
	                                            <th style="width:14%">Acción</th>
	                                        </tr>
	                                    </thead>
	                                    <tfoot>
	                                        <tr>
	                                            <th>
												<?php 
												if ($_SESSION["sesion_perfil_panel"]<>4) {
				                            	 ?>
	                                            	<button type="button" class="btn btn-xs btn-icon btn-danger borra_todo" data-toggle="tooltip" data-original-title="Eliminar Seleccionados"><i class="fa fa-trash"></i></button>
												<?php } ?>
	                                            </th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <?php 
												if ($_SESSION["sesion_perfil_panel"]==='2') {
				                            	 ?>
				                            	 <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
				                            	 <?php 
				                            	}
				                            	  ?>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                            <th></th>
	                                        </tr>
	                                    </tfoot>
	                                    <tbody>
	                                        
	                                    </tbody>
	                                </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>
                    <!--/.col (left) -->
                </div>
            <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<?php include_once _INCLUDE."footer_comun.php";?>
<!-- .wrapper cierra en el footer -->
<?php include_once _INCLUDE."js_comun.php";?>

<!-- DataTables -->
<script src="<?php echo _ASSETS?>plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/datatables.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/DataTables-1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/js/datatables.buttons.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/js/buttons.html5.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/js/buttons.print.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/datatables5/Buttons-2.2.3/js/buttons.colVis.min.js"></script>

<!-- iCheck 1.0.1 -->
<!-- <script src="<?php // echo _ASSETS?>plugins/iCheck/icheck.min.js"></script> -->

<script>
    // cheks
    var valor;
    jQuery.fn.getCheckboxValues = function(){
        var values = [];
        var i = 0;
        this.each(function(){
            // guarda los valores en un array
            valor = $(this).val();
            values[i++] = valor;
        });
        if(i == 0 ){
            return i;
        }
        else{
            return values;
        }
    }

    $(function(){
	    $(".wmd-view-topscroll").scroll(function(){
	        $(".wmd-view")
	            .scrollLeft($(".wmd-view-topscroll").scrollLeft());
	    });
	    $(".wmd-view").scroll(function(){
	        $(".wmd-view-topscroll")
	            .scrollLeft($(".wmd-view").scrollLeft());
	    });
	});

    $(document).ready(function() {
        // $(document).on('icheck', function(){
        //     $('input[type=checkbox].flat-red').iCheck({
        //         checkboxClass: 'icheckbox_flat-red'
        //     });
        // }).trigger('icheck');
        <?php 
		if ($_SESSION["sesion_perfil_panel"]<>'2') {
    	 ?>
        // var table = $('#example').DataTable( {
        //     dom:'lfBrtip',
        //     stateSave: true,          
        //     "lengthChange": true,
        //     "pageLength": 50,
        //     buttons: [ 'copy', 'excelHtml5', 'pdf', 'print', 'colvis' ],
        //     "bProcessing": true,
        //     "bServerSide": true,
        //     responsive: true,
        //     "sAjaxSource": "select-new.php",
        //     "sPaginationType": "full_numbers",
        //     "aaSorting": [[ 1, "desc" ]],
        //     "aoColumns": [
        //         { "bSortable": false },
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         null,
        //         { "bSortable": false },
        //         { "bSortable": false },
        //         { "bSortable": false }
        //     ]
        // });
        // $(document).ready(function () {
        //         $('#example').DataTable({
        //             processing: true,
        //             serverSide: true,
        //             ajax: 'select-new.php'
        //         });
        //     });

            $(document).ready(function () {
               $.ajax({
                url : "select-new.php",
                dataType : "json",                
                success : function(data){
                    console.log("la data => "+data)
                }
               })
            });
        <?php 
		} else {
         ?>
        // var table = $('#example').DataTable( {
        //     dom:'lfBrtip',
        //     stateSave: true,           
        //     "lengthChange": true,
        //     "pageLength": 50,
        //     buttons: [ 'copy', 'excelHtml5', 'pdf', 'print', 'colvis' ],
        //     "bProcessing": true,
        //     "bServerSide": true,
        //     responsive: true,
        //     "sAjaxSource": "select_jventa.php",
        //     "sPaginationType": "full_numbers",
        //     "aaSorting": [[ 1, "desc" ]],
        //     "aoColumns": [
        //         { "bSortable": false },
        //         { "aDataSort": [ 0 ] },
        //         null,
        //         null,
        //         null,
        //         null,
        //         { "aDataSort": [ 6,7,8,9 ] },
        //     	{ "aDataSort": [ 11 ] },
        //         { "aDataSort": [ 12 ] },
        //         { "aDataSort": [ 13 ] },
        //         { "aDataSort": [ 14 ] },
        //         { "aDataSort": [ 15 ] },
        //         { "aDataSort": [ 16 ] },
        //         { "aDataSort": [ 17 ] },
        //         { "aDataSort": [ 18 ] },
        //         { "aDataSort": [ 19 ] },
        //         { "bSortable": false },
        //         { "bSortable": false },
        //         { "bSortable": false },
        //         { "bSortable": false }
        //     ]
        // });

        <?php
    	} 
    	?>
 
        // table.buttons().container()
        //     .appendTo( '#example_wrapper .col-sm-6:eq(1)' );

        // eliminar
        function resultado(data) {
            if(data.envio == 1){
                swal({
                  title: "Excelente!",
                  text: "Registros eliminados con éxito!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#9bde94",
                  confirmButtonText: "Aceptar",
                  closeOnConfirm: false
                },
                function(){
                    location.reload();
                });
            }
            if(data.envio == 3){
                swal("Error!", "Favor intentar denuevo","error");
            }
            /*if(data.envio != ""){
                alert(data.envio);
            }*/
        }
        function resultado_eliminar(data) {
            if(data.envio == 1){
                swal({
                  title: "Excelente!",
                  text: "Registro eliminado con éxito!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#9bde94",
                  confirmButtonText: "Aceptar",
                  closeOnConfirm: false
                },
                function(){
                    location.reload();
                });
            }
            if(data.envio == 3){
                swal("Error!", "Favor intentar denuevo","error");
            }
            /*if(data.envio != ""){
                alert(data.envio);
            }*/
        }
        $(document).on( "click",".eliminar" , function() {
            valor = $(this).val();
            swal({
                title: "Está Seguro?",
                text: "Desea eliminar el registro seleccionado!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Aceptar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
            },
            function(){
                $.ajax({
                    type: 'POST',
                    url: ("delete.php"),
                    data:"valor="+valor,
                    dataType:'json',
                    success: function(data) {
                        resultado_eliminar(data);
                    }
                })
            });
        });

        $('.borra_todo').click(function(){
            valor = $(".check_registro:checked").getCheckboxValues();
            var_check = $(".check_registro:checked").length;
            swal({
                title: "Está Seguro?",
                text: "Desea eliminar los registros seleccionados!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Aceptar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: 'POST',
                    url: ("delete_todo.php"),
                    data:"valor="+valor+"&cantidad="+var_check,
                    dataType:'json',
                    success: function(data) {
                        resultado(data);
                    }
                })
            });
        });
        $('#check_todo').on('change', function(event){
            $('.check_registro:enabled').each( function() {  
                if($("input[name=check_todo]:checked").length == 1){
                    $(this).prop("checked", "checked");
                } 
                else {
                    $(this).prop("checked", "");
                }
            });
        });

        // ver modal
        $(document).on( "click",".detalle" , function() {
            valor = $(this).val();
            $.ajax({
                type: 'POST',
                url: ("form_detalle.php"),
                data:"valor="+valor,
                success: function(data) {
                     $('#contenedor_modal').html(data);
                     $('#contenedor_modal').modal('show');
                }
            })
        });

        $(document).on( "click",".agrega_seguimiento" , function() {
            $('#contenedor_opcion').html('<img src="<?php echo _ASSETS;?>img/loading.gif">');
            valor = $(this).val();
            $.ajax({
                type: 'POST',
                url: ("form_insert_seguimiento.php"),
                data:"valor="+valor,
                success: function(data) {
                     $('#contenedor_opcion').html(data);
                }
            })
            $("html, body").animate({
                scrollTop: 100
            }, 1000);
        }); 

        $(document).on( "click",".promesa" , function() {
            $('#contenedor_opcion').html('<img src="<?php echo _ASSETS;?>img/loading.gif">');
            valor = $(this).val();
            $.ajax({
                type: 'POST',
                url: ("form_insert_promesa.php"),
                data:"valor="+valor,
                success: function(data) {
                     $('#contenedor_opcion').html(data);
                }
            })
            $("html, body").animate({
                scrollTop: 100
            }, 1000);
        }); 

        $(document).on( "click",".edita" , function() {
            $('#contenedor_opcion').html('<img src="<?php echo _ASSETS;?>img/loading.gif">');
            valor = $(this).val();
            $.ajax({
                type: 'POST',
                url: ("form_update.php"),
                data:"valor="+valor,
                success: function(data) {
                     $('#contenedor_opcion').html(data);
                }
            })
            $("html, body").animate({
                scrollTop: 100
            }, 1000);
        }); 
        
        $(document).on( "click",".estado" , function() {
            valor = $(this).val();
            swal({
                title: "Está Seguro?",
                text: "Desea cambiar el estado del registro seleccionado!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Aceptar',
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: 'POST',
                    url: ("estado.php"),
                    data:"valor="+valor,
                    dataType:'json',
                    success: function(data) {
                        resultado_estado(data);                 
                    }
                })
            });
        });

		// registro de eventos
		$(document).on( "click",".agrega_evento" , function() {
            $('#contenedor_opcion').html('<img src="<?php echo _ASSETS;?>img/loading.gif">');
            valor = $(this).val();
            $.ajax({
                type: 'POST',
                url: ("form_insert_evento.php"),
                data:"valor="+valor,
                success: function(data) {
                     $('#contenedor_opcion').html(data);
                }
            })
            $("html, body").animate({
                scrollTop: 100
            }, 1000);
        }); 

        function resultado_estado(data) {
            if(data.envio == 1){
                swal({
                  title: "Excelente!",
                  text: "Estado modificado con éxito!",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#9bde94",
                  confirmButtonText: "Aceptar",
                  closeOnConfirm: false
                },
                function(){
                    location.reload();
                });
            }
            if(data.envio == 3){
                swal("Error!", "Favor intentar denuevo","error");
            }
        } 


        $(document).on( "click",".agrega_documento" , function() {
	            $('#contenedor_opcion').html('<img src="<?php echo _ASSETS;?>img/loading.gif">');
	            valor = $(this).val();
	            $.ajax({
	                type: 'POST',
	                url: ("../propietario/form_update_docs.php"),
	                data:"valor="+valor+"&origen=cotizacion",
	                success: function(data) {
	                     $('#contenedor_opcion').html(data);
	                }
	            })
	            $("html, body").animate({
	                scrollTop: 100
	            }, 1000);
	        }); 
    } );
</script>
</body>
</html>
