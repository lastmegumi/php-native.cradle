<h6>Simple Promotion</h6>
<form action="save" method="POST" class="white p-3">
	  <?php include(__DIR__ . "/form_common.php");?>
      <div class="row">
      	<div class="col s12">
      		<button class="btn red lighten-2">Save</button>
      		<button class="btn blue lighten-2 right">Delete</button>
      	</div>
      </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
    	format: 'yyyy-mm-dd'
    });
  });
</script>