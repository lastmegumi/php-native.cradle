<?php
$con_arr = array();
$con_arr[] = array("title" => "Last Name", "type" => "text", "key" => "last_name", "required" => true, "class"  => "col s6");
$con_arr[] = array("title" => "First Name", "type" => "text", "key" => "first_name", "class" => "col s6");
$con_arr[] = array("title" => "Phone", "type" => "text", "key" => "phone", "class" => "");
$con_arr[] = array("title" => "Address1", "type" => "text", "key" => "address1", "class" => "");
$con_arr[] = array("title" => "Address2", "type" => "text", "key" => "address2", "class" => "");
$con_arr[] = array("title" => "City", "type" => "text", "key" => "city", "class" => "col s4");
$con_arr[] = array("title" => "State", "type" => "text", "key" => "state", "class" => "col s4");
$con_arr[] = array("title" => "Zipcode", "type" => "text", "key" => "zipcode", "class" => "col s4");

$shipping = array();
$shipping[] = array("title" => "Last Name", "type" => "text", "key" => "ship_last_name", "required" => true, "class"  => "col s6");
$shipping[] = array("title" => "First Name", "type" => "text", "key" => "ship_first_name", "class" => "col s6");
$shipping[] = array("title" => "Phone", "type" => "text", "key" => "ship_phone", "class" => "");
$shipping[] = array("title" => "Address1", "type" => "text", "key" => "ship_address1", "class" => "");
$shipping[] = array("title" => "Address2", "type" => "text", "key" => "ship_address2", "class" => "");
$shipping[] = array("title" => "City", "type" => "text", "key" => "ship_city", "class" => "col s4");
$shipping[] = array("title" => "State", "type" => "text", "key" => "ship_state", "class" => "col s4");
$shipping[] = array("title" => "Zipcode", "type" => "text", "key" => "ship_zipcode", "class" => "col s4");

$card_arr[] = array("title" => "Card Number", "type" => "text", "key" => "card", "class" => "");
$card_arr[] = array("title" => "Expiration Date", "type" => "text", "key" => "expiration", "class" => "col s6");
$card_arr[] = array("title" => "CVC/CSC", "type" => "text", "key" => "cvc", "class" => "col s6");
?>
<div class="container">
<form id="check_out">
	<div class="row">
		<h6>Billing Address:</h6>
		<?php form_exp($con_arr);?>
	</div>
	<div class="row">
		<h6>Shipping Address:</h6>
		<?php form_exp($shipping);?>
	</div>
	<div class="row">
		<h6>Payment:</h6>
		<?php form_exp($card_arr);?>
	</div>
	<button type="submit" class="btn btn-primary float-right">Submit</button>
</form>
</div>
<?php
function form_exp($con_arr){
	foreach($con_arr as $c):
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
		<div class="form-group <?php echo $c['class']?$c['class']:'col s12'; ?>">
			<label for="description"><?php echo $c['title'];?></label>
			<textarea name="description" style="min-height:5rem" class="form-control"><?php 
			$data_key = $c['key'];
			echo @$data->$data_key;?></textarea>
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
				        value="<?php echo $value['id']?>"
				        <?php 
				        $data_key = $c['data_key'];
				        echo in_array( $value['id'], explode(",", $data->$data_key))? "checked":"";?>
				        />
				        <span><?php echo @$value['name'] ?></span>
				      </label>
				    </div>
			<?php endforeach;?>
		</div>
		<?php endforeach;

}
?>