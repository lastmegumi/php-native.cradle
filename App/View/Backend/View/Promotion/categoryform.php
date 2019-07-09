<h6>Category Promotion</h6>
<form action="../save" method="POST" class="white p-3">
	  <?php include(__DIR__ . "/form_common.php");?>
	  <div class="row">
      <div class="col s12">
      <label for="">Selete Category</label>
      <div>
      <?php
        foreach ($category as $k => $v) : ?>
        <label>
          <input name="target_value" type="radio" value="<?php echo $v->id;?>" <?php echo $data->target_value == $v->id? "checked":""; ?> />
          <span><?php echo $v->getName();?></span>
        </label>
      <?php 
      endforeach;
      ?>
    </div>
    </div>
	  </div>

    <?php include(__DIR__ . "/form_action_common.php"); ?>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepicker').datepicker({
    	format: 'yyyy-mm-dd'
    });
  });
</script>