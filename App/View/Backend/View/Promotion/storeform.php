<h6>Simple Promotion</h6>
<form action="../save" method="POST" class="white p-3">
	  <?php include(__DIR__ . "/form_common.php");?>

    <?php include(__DIR__ . "/form_action_common.php"); ?>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
    	format: 'yyyy-mm-dd'
    });
  });
</script>