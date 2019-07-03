<?php
$con_arr = array();
$con_arr[] = array("title" => "Name", "type" => "text", "key" => "name", "required" => true, "class"  => "");
$con_arr[] = array("title" => "Price", "type" => "text", "key" => "price", "class" => "");
$con_arr[] = array("title" => "SKU", "type" => "text", "key" => "sku", "class" => "");
$con_arr[] = array("title" => "category", "type" => "checkbox_arr", "key" => "categorys", "data_key" => "category_ids", "class" => "col s12", "data_arr"	=>	$category);
$con_arr[] = array("title" => "Short Description", "type" => "text-area", "key" => "short_description", "class" => "");
$con_arr[] = array("title" => "Description", "type" => "text-area", "key" => "description", "class" => "editor");
?>
	<form id="save_product">
		  <div class="row">
		    <div class="col s12">
		      <ul class="tabs">
		        <li class="tab col s2"><a class="active" href="#test1">Basic</a></li>
		        <li class="tab col s2"><a href="#test2">Image</a></li>
		        <li class="tab col s2"><a href="#test3">Feature</a></li>
		        <li class="tab col s2"><a href="#test4">Attrbute</a></li>
		        <li class="tab col s2"><a href="#test5">Inventory Control</a></li>
		      </ul>
		    </div>
		    <div id="test1" class="col s12">
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
		    <div id="test2" class="col s12">
		    	<?php
		    	$imgs = $data->getImages();?>
		    	<div class="image-block" id="product_images">
		    		<?php $this->backend_image_block($imgs);?>
		    	</div>
				    <div class="file-field input-field">
				      <div class="btn">
				        <span>File</span>
				        <input type="file" id="product_image_upload" name="image" multiple>
				      </div>
				      <div class="file-path-wrapper">
				        <input class="file-path validate" type="text" placeholder="Upload one or more files">
				      </div>
				    </div>

		    </div>
		    <div id="test3" class="col s12">
		    	<div class="feature_block">
		    	<?php
		    	$attrs = $data->getFeature();
		    	if(!$attrs):
		    		$attrs[] = ['name'	=>	"",	'value'	=>	""];
		    	endif;
	    		$attr_count = 0;
	    		foreach ($attrs as $k => $v) :?>
	    		<div class="row product-feature">
			        <div class="input-field col s6">
			          <input id="feature_name_0" name="feature[<?php echo $attr_count;?>][name]" type="text" class="validate" value="<?php echo @$v->name?>">
			          <label for="feature_name_0">Name</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="feature_value_0" type="text" name="feature[<?php echo $attr_count;?>][value]" class="validate" value="<?php echo @$v->value?>">
			          <label for="feature_value_0">Value</label>
			        </div>
			    </div>
	    		<?php
	    		$attr_count++;
	    		endforeach;
		    	?>
				</div>
			    <button type="button" class="btn" id="add-feature">Add</button>
		    </div>
		    <div id="test4" class="col s12">
		    	<div class="attribute_block">
		    	<?php
		    	$attrs = $data->getAttributes();
		    	if(!$attrs):
		    		$attrs[] = ['name'	=>	"",	'value'	=>	""];
		    	endif;
	    		$attr_count = 0;
	    		foreach ($attrs as $k => $v) :?>
	    		<div class="row product-attribute">
			        <div class="input-field col s6">
			          <input id="attribute_name_0" name="attributes[<?php echo $attr_count;?>][name]" type="text" class="validate" value="<?php echo @$v->name?>">
			          <label for="attribute_name_0">Name</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="attribute_value_0" type="text" name="attributes[<?php echo $attr_count;?>][value]" class="validate" value="<?php echo @$v->value?>">
			          <label for="attribute_value_0">Value</label>
			        </div>
			    </div>
	    		<?php
	    		$attr_count++;
	    		endforeach;
		    	?>
				</div>
			    <button type="button" class="btn" id="add-attribute">Add</button>
		    </div>
		    <div id="test5" class="col s12">
		    	<div class="input-field col s12">
				    <select name="for_sale">
				      <option value="" disabled selected>Choose your option</option>
				      <option value="1" <?php echo $data->for_sale == 1? "selected" : ""?>>Start Sale</option>
				      <option value="0" <?php echo $data->for_sale == 0? "selected" : ""?>>Hide Price</option>
				    </select>
				    <label>Is Salable</label>
				  </div>
		    	<div class="input-field col s12">
				  <select name="enabled">
				      <option value="" disabled selected>Choose your option</option>
				      <option value="1" <?php echo $data->enabled == 1? "selected" : ""?>>Enabled</option>
				      <option value="0" <?php echo $data->enabled == 0? "selected" : ""?>>Disabled</option>
				    </select>
				    <label>Status</label>
				</div>
		    	<div class="input-field col s12">
				  <select name="in_stock">
				      <option value="" disabled selected>Choose your option</option>
				      <option value="1" <?php echo $data->in_stock == 1? "selected" : ""?>>Out of stock</option>
				      <option value="0" <?php echo $data->in_stock == 0? "selected" : ""?>>Instock</option>
				    </select>
				    <label>Inventory</label>
				</div>
		  </div>
		<input type="hidden" name="id" value="<?php echo @$data->id;?>" />
	</div>
	<div class="row">
		<div class="col s12">
			<button type="submit" class="btn red lighten-2 float-right">Save</button>
			<a href="javascript:void(0)" class="btn btn-primary right grey delete_product" data-id="<?php echo @$data->id?>">Delete</a>
		</div>
	</div>
	</form>
<script type="text/javascript">
$(document).ready(() => {
	var i = $(".product-attribute").length;
	var j = $(".product-feature").length

	$('.tabs').tabs();

	$(".remove_item").click(function(){
	    $(this).parents(".product-attribute").remove();
	})
	
	$("#add-attribute").click(function(){
	    let newitem= $(".product-attribute").eq(0).clone(true, true);
	    ++i;
        newitem.find('input').each(function() {
            this.name = this.name.replace('[0]', '['+ i+1 +']');
            this.id = this.id.replace('0', i );
            this.value = null;
        });
        newitem.find('label').each(function() {
            $(this).attr("for", $(this).attr("for").replace('0', i ));
        });
        $('.attribute_block').append(newitem);
	});
	$("#add-feature").click(function(){
	    let newitem= $(".product-feature").eq(0).clone(true, true);
	    ++i;
        newitem.find('input').each(function() {
            this.name = this.name.replace('[0]', '['+ i+1 +']');
            this.id = this.id.replace('0', i );
            this.value = null;
        });
        newitem.find('label').each(function() {
            $(this).attr("for", $(this).attr("for").replace('0', i ));
        });
        $('.feature_block').append(newitem);
	});
})
</script>