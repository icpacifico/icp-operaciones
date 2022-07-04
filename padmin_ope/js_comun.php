<?php include_once 'config.php';?>
<script src="<?php echo _ASSETS?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo _ASSETS?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/fastclick/fastclick.js"></script>
<script src="<?php echo _ASSETS?>dist/js/app.min.js"></script>
<script src="<?php echo _ASSETS?>plugins/alert_prueba/dist/sweetalert-dev.js"></script>
<script src="<?php echo _ASSETS?>dist/js/app.min.js"></script>
<script src="<?php echo _ASSETS?>dist/js/active.js"></script>

<!-- Para marcar los active -->
<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>