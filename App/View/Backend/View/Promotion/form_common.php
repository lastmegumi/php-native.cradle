      <div class="row">
        <div class="input-field col s12">
          <input id="name" name="name" type="text" class="validate" Value="<?php echo $data->getName();?>">
          <label for="name">Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="description" name="description" type="text" class="validate" Value="<?php echo $data->getDescription();?>">
          <label for="description">Description</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">       	
		    <select name="type" class="">
		      <option value="" disabled>Choose your option</option>
		      <option <?php echo $data->getType() == 1?"selected":""; ?> value=1>Persentage %</option>
		      <option <?php echo $data->getType() == 2?"selected":""; ?> value=2>Flat -</option>
		    </select>
		    <label>Discount Type</label>
        </div>
        <div class="input-field col s6">
          <input id="value" name="value" type="text" class="validate" value="<?php echo $data->getValue();?>">
          <label for="value">Value</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="start" name="start" type="text" class="datepicker" value="<?php echo $data->getStart();?>">
          <label for="start">Start</label>
        </div>
        <div class="input-field col s6">
          <input id="end" name="end" type="text" class="datepicker" value="<?php echo $data->getEnd();?>">
          <label for="end">End</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <select name="status" class="">
            <option value="" disabled>Choose your option</option>
            <option <?php echo $data->status == 0?"selected":""; ?> value='0'>Pending</option>
            <option <?php echo $data->status == 1?"selected":""; ?> value='1'>Active</option>
            <option <?php echo $data->status == -1?"selected":""; ?> value="-1">Disabled</option>
          </select>
          <label for="status">Status</label>
        </div>
        <div class="input-field col s6">
          <input id="priority" name="priority" type="text" class="validate" value="<?php echo $data->getPriority();?>">
          <label for="priority">Priority</label>
        </div>
      </div>
      <input type="hidden" name='id' value=<?php echo $data->id;?> />
      <input type="hidden" name='target' value=<?php echo $data->target;?> />