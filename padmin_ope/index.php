<?php include_once 'config.php';?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Plataforma Online</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo _ASSETS?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo _ASSETS?>font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo _ASSETS?>dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?php echo _ASSETS?>plugins/alert/sweet-alert.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b>Sistema  </b>Operaciones</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- <img src="<?php echo _ASSETS?>img/medicina.png" width="79" class="img-responsive center-block"> -->
    <p class="login-box-msg">Iniciar Sesión</p>

    <form action="modulo/login/valida_login.php" id="formulario" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario_usu" id="usuario_usu" required>
        <span class="fa fa-user-circle form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="contrasena_usu" id="contrasena_usu" minlength="4" maxlength="6" required>
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-6 col-xs-offset-3">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo _ASSETS?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo _ASSETS?>bootstrap/js/bootstrap.min.js"></script>
<!-- sweet alert -->
<script src="<?php echo _ASSETS?>plugins/alert/sweet-alert.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    function resultado(data) {
      if(data.envio == 1){
        swal({
          title: "Excelente!",
          text: "Usuario ingresado con éxito!",
          type: "success",
          showCancelButton: false,
          confirmButtonColor: "#9bde94",
          confirmButtonText: "Aceptar",
          closeOnConfirm: false
        },
        function(){
          location.href = "panel.php";
        });
      }
      if(data.envio == 2){
        swal("Atención!", "Usuario no reconocido o clave inválida","warning");
        $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
      }
      if(data.envio == 3){
        alert(data.error_consulta);
        swal("Error!", "Favor intentar denuevo o contáctese con administrador","error");
        $('#contenedor_boton').html('<input type="button" name="boton" class="btn2" value="Guardar" id="bt"/>');
      }
      /*if(data.envio != ""){
        alert(data.envio);
      }*/
    }
    $('#formulario').submit(function() {
        var dataString = $('#formulario').serialize();
        //alert(dataString);
        $.ajax({
          data: dataString,
          type: 'POST',
          url: $(this).attr('action'),
          dataType:'json',
          success: function(data) {
            resultado(data);
          }           
        })
      return false;
    });   
});
</script>

</body>
</html>
