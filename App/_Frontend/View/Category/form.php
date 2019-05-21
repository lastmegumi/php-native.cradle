<?php
$con_arr = array();
$con_arr[] = array("title" => "Name", "type" => "text", "key" => "name", "required" => true, "class"  => "");
$con_arr[] = array("title" => "Image", "type" => "text", "key" => "image", "class" => "");
$con_arr[] = array("title" => "Description", "type" => "text", "key" => "description", "class" => "");
?>
	<form id="form">
		<div class="row">
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
		<?php endforeach;?>
	</div>
		<input type="hidden" name="id" value="<?php echo @$data->id;?>" />
		<button type="submit" class="btn btn-primary float-right">Save</button>
	</form>
<script type="text/javascript">
$(document).ready(() => {
	$("form#form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "/category/save",//url
			data : $(this).serializeArray(),
			success: function (result) {
				alert(result);
				return;
			    alert(result.message);
			    if(result.status){
			    $("#modal").modal("hide");
			    window.location.replace(result.url);}
			},
			error : function() {
			    alert("异常！");
			}
		});
		return false;
	});
})
</script>