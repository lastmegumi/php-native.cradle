<h6>Store Setting</h6>
<?php
$con_arr = array();
$con_arr[] = array("title" => "Name", "type" => "text", "key" => "name", "required" => true, "class"  => "");
$con_arr[] = array("title" => "Logo", "type" => "text", "key" => "logo", "class" => "");
$con_arr[] = array("title" => "Logo Small", "type" => "text", "key" => "logo_small", "class" => "");
$con_arr[] = array("title" => "Description", "type" => "text", "key" => "description", "class" => "");
?>
	<form class="white p-3 clearfix" method="post" action="save">
		<div class="row">
			<div class="col s12">
		<?php foreach($con_arr as $c):
			if($c['type'] != "text"){ continue;}
		?>
			<div class="<?php echo $c['class']?$c['class']:'col s12'; ?> form-group">
				<label><?php echo $c['title'];?></label>
					<input type="text" class="form-control" name="<?php echo $c['key'];?>" value="<?php $key = $c['key']; echo @$data->$key;?>"
					<?php echo @$c['required']?" required":""?>/>
			</div>
		<?php endforeach;?>

		<?php
		foreach ($con_arr as $c):
			if($c['type'] != "text-area"){ continue;}?>
		<div class="form-group col s12">
			<div>
			<label for="description"><?php echo $c['title'];?></label>
			<textarea style="min-height: 500px !important;" name="description" style="min-height:5rem" class="form-control" id="<?php echo $c['class']?$c['class']:''; ?>"><?php 
			$data_key = $c['key'];
			echo @$data->$data_key;?></textarea>
		</div>
		</div>
		<?php endforeach;?>

		<?php
		foreach ($con_arr as $c) :
			if($c['type'] != "checkbox_arr" || !$c['data_arr']){ continue;}?>
		<div class="form-group <?php echo $c['class']?$c['class']:'col s12'; ?>">
			<?php foreach ($c['data_arr'] as $key => $value) :?>
				    <div class>
				      <label>
				        <input type="checkbox" name="<?php echo $c['key'];?>[]"
				        value="<?php echo $value->id?>"
				        <?php 
				        $data_key = $c['data_key'];
				        echo in_array( $value->id, explode(",", @$data->$data_key))? "checked":"";?>
				        />
				        <span><?php echo $value->name ?></span>
				      </label>
				    </div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>
		</div>
		<button class="btn red lighten-2 right">Save</button>
	</form>
