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
 var menuModulo = new Array(
	 'banco','bodega','bono','carro','condominio','cotizacion','descuento','documento','estacionamiento','etapa','evento','informe','liquidacion','login','mailing','modelo','operacion','pago','parametro','premio','profesion','promesa','propietario','torre','uf','unidad','usuario','vendedor','venta','vivienda'
 )
 var proceso = new Array(
	'select','select_envios','insert','insert_condominio','supervisor','jefe','cliente','lista','meta','insert_privilegio',''
 )
 let menuActive = (mod,submod) =>{
	$('.sidebar-menu li').removeClass('active');			 
		if(mod == 'condominio' || mod == 'torre' || mod == 'modelo' || mod =='vivienda' || mod =='estacionamiento' || mod =='bodega'){
			$('#menu_condominio_estructura').addClass('active');
			$('#menu_'+mod).addClass('active');
			$('#'+mod+'-'+submod).addClass('active');
		}else{
			$('#menu_'+mod).addClass('active');
			$('#'+mod+'-'+submod).addClass('active');
		}	 
 }
 for (let i = 0; i < menuModulo.length; i++) {	
	for (let j = 0; j < proceso.length; j++) {	if(modulo == menuModulo[i]+'/form_'+proceso[j]+'.php'){	menuActive(menuModulo[i],proceso[j]);}}	 
 }
if(arr[cont] == "panel.php"){
	$('.sidebar-menu li').removeClass('active');
	$('#escritorio').addClass('active');		
}
</script>