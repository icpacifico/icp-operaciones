var url_web=window.location.href;
 var arr=url_web.split('/');
 var cont = arr.length - 1;
 var modulo = arr[cont-1]+'/'+arr[cont]; 
 var menuModulo = new Array(
	 'banco','bodega','bono','carro','condominio','cotizacion','descuento','documento','estacionamiento','etapa','evento','informe','liquidacion','login','mailing','modelo','operacion','pago','parametro','premio','profesion','promesa','propietario','torre','uf','unidad','usuario','vendedor','venta','vivienda','evaluacion'
 )
 var proceso = new Array(
	'select','select_envios','insert','insert_condominio','supervisor','jefe','cliente','lista','meta','insert_privilegio',''
 )
 let menuActive = (mod,submod) =>{
    $('.sidebar-menu li').removeClass('active');
    if(mod == 'condominio' || mod == 'torre' || mod == 'modelo' || mod =='vivienda' || mod =='estacionamiento' || mod =='bodega')
    {
        $('#menu_condominio_estructura').addClass('active');$('#menu_'+mod).addClass('active');
        $('#'+mod+'-'+submod).addClass('active');
    }else{
        $('#menu_'+mod).addClass('active');
        $('#'+mod+'-'+submod).addClass('active');
    }
}
for (let i = 0; i < menuModulo.length; i++) {
    for (let j = 0; j < proceso.length; j++) {
        	if(modulo == menuModulo[i]+'/form_'+proceso[j]+'.php'){
                	menuActive(menuModulo[i],proceso[j]);
                }
            }
        }
        if(arr[cont] == "panel.php")
        {
            $('.sidebar-menu li').removeClass('active');$('#escritorio').addClass('active');
        }