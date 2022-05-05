<?php include_once 'config.php';?>
<!-- jQuery 2.2.3 -->
<!-- <script src="<?php echo _ASSETS?>plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo _ASSETS?>plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo _ASSETS?>bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo _ASSETS?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo _ASSETS?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo _ASSETS?>dist/js/app.min.js"></script>
<!-- sweet alert -->
<script src="<?php echo _ASSETS?>plugins/alert_prueba/dist/sweetalert-dev.js"></script>

<!-- Para marcar los active -->
<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})
 
 var url_web=window.location.href;
 var arr=url_web.split('/');
 var cont = arr.length - 1;
 var modulo = arr[cont-1]+'/'+arr[cont];


   	if(arr[cont] == "panel.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#escritorio').addClass('active');		
	}
	else if(modulo == "reserva/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_reserva').addClass('active');
		$('#reserva-insert').addClass('active');
	}
	else if(modulo == "reserva/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_reserva').addClass('active');
		$('#reserva-select').addClass('active');
	}
	else if(modulo == "proyecto/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_proyecto').addClass('active');
		$('#proyecto-insert').addClass('active');
	}
	else if(modulo == "proyecto/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_proyecto').addClass('active');
		$('#proyecto-select').addClass('active');
	}
	else if(modulo == "proyecto/form_select_detalle.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_proyecto').addClass('active');
		$('#proyecto-select').addClass('active');
	}
	else if(modulo == "proveedor/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_proveedor').addClass('active');
		$('#proveedor-insert').addClass('active');
	}
	else if(modulo == "proveedor/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_proveedor').addClass('active');
		$('#proveedor-select').addClass('active');
	}
	else if(modulo == "funcionario/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_funcionario').addClass('active');
		$('#funcionario-insert').addClass('active');
	}
	else if(modulo == "funcionario/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_funcionario').addClass('active');
		$('#funcionario-select').addClass('active');
	}
	else if(modulo == "condominio/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_condominio').addClass('active');
		$('#condominio-insert').addClass('active');
	}
	else if(modulo == "condominio/form_insert_condominio.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_condominio').addClass('active');
		$('#condominio-insert_condominio').addClass('active');
	}
	//PROFESION
	else if(modulo == "profesion/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_profesion').addClass('active');
		$('#profesion-insert').addClass('active');
	}
	else if(modulo == "profesion/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_profesion').addClass('active');
		$('#profesion-select').addClass('active');
	}
	else if(modulo == "condominio/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_condominio').addClass('active');
		$('#condominio-select').addClass('active');
	}
	else if(modulo == "usuario/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_usuario').addClass('active');
		$('#usuario-insert').addClass('active');
	}
	else if(modulo == "usuario/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_usuario').addClass('active');
		$('#usuario-select').addClass('active');
	}
	else if(modulo == "usuario/form_insert_privilegio.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_usuario').addClass('active');
		$('#usuario-privilegio').addClass('active');
	}
	else if(modulo == "usuario/form_insert_unidad.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_usuario').addClass('active');
		$('#usuario-unidad').addClass('active');
	}
	else if(modulo == "parametro/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_parametro').addClass('active');
		$('#parametro-insert').addClass('active');
	}
	
	else if(modulo == "servicio_vivienda/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_servicio').addClass('active');
		$('#menu_servicio_vivienda').addClass('active');
		$('#servicio_vivienda-insert').addClass('active');
	}
	else if(modulo == "servicio_vivienda/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_servicio').addClass('active');
		$('#menu_servicio_vivienda').addClass('active');
		$('#servicio_vivienda-select').addClass('active');
	}
	//ESTACIONAMIENTO
	else if(modulo == "estacionamiento/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_estacionamiento').addClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#estacionamiento-insert').addClass('active');
	}
	else if(modulo == "estacionamiento/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_estacionamiento').addClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#estacionamiento-select').addClass('active');
	}
	//BODEGA
	else if(modulo == "bodega/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bodega').addClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#bodega-insert').addClass('active');
	}
	else if(modulo == "bodega/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bodega').addClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#bodega-select').addClass('active');
	}

	else if(modulo == "programa/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_programa').addClass('active');
		$('#programa-insert').addClass('active');
	}
	else if(modulo == "programa/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_programa').addClass('active');
		$('#programa-select').addClass('active');
	}
	else if(modulo == "modelo/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_modelo').addClass('active');
		$('#modelo-insert').addClass('active');
	}
	else if(modulo == "modelo/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_modelo').addClass('active');
		$('#modelo-select').addClass('active');
	}
	//TORRE
	else if(modulo == "torre/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_torre').addClass('active');
		$('#torre-insert').addClass('active');
	}
	else if(modulo == "torre/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_torre').addClass('active');
		$('#torre-select').addClass('active');
	}
	//VIVIENDA
	else if(modulo == "vivienda/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_vivienda').addClass('active');
		$('#vivienda-insert').addClass('active');
	}
	else if(modulo == "vivienda/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_condominio_estructura').addClass('active');
		$('#menu_vivienda').addClass('active');
		$('#vivienda-select').addClass('active');
	}
	//ASEO
	else if(modulo == "aseo/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_aseo').addClass('active');
		$('#aseo-insert').addClass('active');
	}
	else if(modulo == "aseo/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_aseo').addClass('active');
		$('#aseo-select').addClass('active');
	}
	//PROPIETARIO
	else if(modulo == "propietario/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_propietario').addClass('active');
		$('#propietario-insert').addClass('active');
	}
	else if(modulo == "propietario/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_propietario').addClass('active');
		$('#propietario-select').addClass('active');
	}
	//INGRESO
	else if(modulo == "ingreso/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ingreso').addClass('active');
		$('#ingreso-insert').addClass('active');
	}
	else if(modulo == "ingreso/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ingreso').addClass('active');
		$('#ingreso-select').addClass('active');
	}
	else if(modulo == "ingreso/form_select_detalle.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ingreso').addClass('active');
		$('#ingreso-select').addClass('active');
	}
	else if(modulo == "ingreso/form_select_anulado.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ingreso').addClass('active');
		$('#ingreso-select-anulado').addClass('active');
	}
	//LIQUIDACION
	else if(modulo == "liquidacion/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_liquidacion').addClass('active');
		$('#liquidacion-insert').addClass('active');
	}
	else if(modulo == "liquidacion/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_liquidacion').addClass('active');
		$('#liquidacion-select').addClass('active');
	}
	else if(modulo == "liquidacion/form_select_detalle.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_liquidacion').addClass('active');
		$('#liquidacion-select').addClass('active');
	}
	//ARRENDATARIO
	else if(modulo == "arrendatario/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_arrendatario').addClass('active');
		$('#arrendatario-insert').addClass('active');
	}
	else if(modulo == "arrendatario/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_arrendatario').addClass('active');
		$('#arrendatario-select').addClass('active');
	}
	//TICKET
	else if(modulo == "ticket/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ticket').addClass('active');
		$('#ticket-insert').addClass('active');
	}
	else if(modulo == "ticket/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ticket').addClass('active');
		$('#ticket-select').addClass('active');
	}
	else if(modulo == "ticket/form_select_detalle.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_ticket').addClass('active');
		$('#ticket-select').addClass('active');
	}
	//BLOQUEO DE FECHAS
	else if(modulo == "bloqueo/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bloqueo').addClass('active');
		$('#bloqueo-insert').addClass('active');
	}
	else if(modulo == "bloqueo/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bloqueo').addClass('active');
		$('#bloqueo-select').addClass('active');
	}
	//UF
	else if(modulo == "uf/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_uf').addClass('active');
		$('#uf-insert').addClass('active');
	}
	else if(modulo == "uf/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_uf').addClass('active');
		$('#uf-select').addClass('active');
	}
	//VENDEDOR
	else if(modulo == "vendedor/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_vendedor').addClass('active');
		$('#vendedor-insert').addClass('active');
	}
	else if(modulo == "vendedor/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_vendedor').addClass('active');
		$('#vendedor-select').addClass('active');
	}
	else if(modulo == "vendedor/form_supervisor.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_vendedor').addClass('active');
		$('#vendedor-supervisor').addClass('active');
	}
	else if(modulo == "vendedor/form_cliente.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_vendedor').addClass('active');
		$('#vendedor-cliente').addClass('active');
	}
	//BONO

	else if(modulo == "bono/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bono').addClass('active');
		$('#bono-insert').addClass('active');
	}
	else if(modulo == "bono/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_bono').addClass('active');
		$('#bono-select').addClass('active');
	}
	//DESCUENTO
	else if(modulo == "descuento/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_descuento').addClass('active');
		$('#descuento-insert').addClass('active');
	}
	else if(modulo == "descuento/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_descuento').addClass('active');
		$('#descuento-select').addClass('active');
	}
	//PREMIO
	else if(modulo == "premio/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_premio').addClass('active');
		$('#premio-insert').addClass('active');
	}
	else if(modulo == "premio/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_premio').addClass('active');
		$('#premio-select').addClass('active');
	}
	//ETAPA
	else if(modulo == "etapa/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_etapa').addClass('active');
		$('#etapa-insert').addClass('active');
	}
	else if(modulo == "etapa/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_etapa').addClass('active');
		$('#etapa-select').addClass('active');
	}
	else if(modulo == "etapa/form_select_detalle.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_etapa').addClass('active');
		$('#etapa-select').addClass('active');
	}
	//COTIZACION
	else if(modulo == "cotizacion/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_cotizacion').addClass('active');
		$('#cotizacion-insert').addClass('active');
	}
	else if(modulo == "cotizacion/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_cotizacion').addClass('active');
		$('#cotizacion-select').addClass('active');
	}
	//PROMESA
	else if(modulo == "promesa/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_promesa').addClass('active');
		$('#promesa-select').addClass('active');
	}
	//VENTA
	else if(modulo == "venta/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_venta').addClass('active');
		$('#venta-insert').addClass('active');
	}
	else if(modulo == "venta/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_venta').addClass('active');
		$('#venta-select').addClass('active');
	}
	//PAGO
	else if(modulo == "pago/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_pago').addClass('active');
		$('#pago-select').addClass('active');
	}
	//BANCO
	else if(modulo == "banco/form_insert.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_banco').addClass('active');
		$('#banco-insert').addClass('active');
	}
	else if(modulo == "banco/form_select.php"){
		$('.sidebar-menu li').removeClass('active');
		$('#menu_banco').addClass('active');
		$('#banco-select').addClass('active');
	}
</script>