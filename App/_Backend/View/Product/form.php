<?php
$con_arr = array();
$con_arr[] = array("title" => "Name", "type" => "text", "key" => "name", "required" => true, "class"  => "");
$con_arr[] = array("title" => "Price", "type" => "text", "key" => "price", "class" => "");
$con_arr[] = array("title" => "SKU", "type" => "text", "key" => "sku", "class" => "");
$con_arr[] = array("title" => "category", "type" => "checkbox_arr", "key" => "categorys", "data_key" => "category_ids", "class" => "col s12", "data_arr"	=>	$category);
$con_arr[] = array("title" => "Description", "type" => "text-area", "key" => "description", "class" => "");
?>
	<form id="form">
		  <div class="row">
		    <div class="col s12">
		      <ul class="tabs">
		        <li class="tab col s3"><a class="active" href="#test1">Basic</a></li>
		        <li class="tab col s3"><a href="#test2">Image</a></li>
		        <li class="tab col s3"><a href="#test3">Attrbute</a></li>
		        <li class="tab col s3"><a href="#test4">Options</a></li>
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
							        echo in_array( $value['id'], explode(",", @$data->$data_key))? "checked":"";?>
							        />
							        <span><?php echo $value['name'] ?></span>
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
				        <input class="file-path validate"  type="text" placeholder="Upload one or more files">
				      </div>
				    </div>

		    </div>
		    <div id="test3" class="col s12">
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
			          <input id="attribute_name_0" name="attributes[<?php echo $attr_count;?>][name]" type="text" class="validate" value="<?php echo @$v['name']?>">
			          <label for="attribute_name_0">Name</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="attribute_value_0" type="text" name="attributes[<?php echo $attr_count;?>][value]" class="validate" value="<?php echo @$v['value']?>">
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
		    <div id="test4" class="col s12">Test 4</div>
		  </div>
		<input type="hidden" name="id" value="<?php echo @$data->id;?>" />
		<button type="submit" class="btn btn-primary float-right">Save</button>
	</form>
<script type="text/javascript">
$(document).ready(() => {
	var i = <?php echo count($attrs);?>

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

	$("form#form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: "POST",//方法类型
			dataType: "HTML",//预期服务器返回的数据类型
			url: "save",//url
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


	$("#product_image_upload").change(function(e){
		e.preventDefault();		
        var file_data = $('#product_image_upload').prop('files');
        var form_data = new FormData();
        var data = [];
        for(let i = 0; i < file_data.length; i++){
			form_data.append('data[]', file_data[i]);
        }
        
        	
		$.ajax({
                // xhr: function() {
                //     var xhr = new window.XMLHttpRequest();
                //     xhr.upload.addEventListener("progress", function(evt) {
                //         if (evt.lengthComputable) {
                //             var percentComplete = (evt.loaded / evt.total) * 100;
                //             //Do something with upload progress here
                //              $("#upload_progress").width(percentComplete + '%');
                //         }
                //    }, false);
                //    return xhr;
                // },
                type: "POST",//方法类型
                dataType: "HTML",//预期服务器返回的数据类型
                url: "upload_image",//url
            	cache: false,
	            contentType: false,
	            processData: false,
                data : form_data,
                beforeSend: function(result){
                    $(".progress").show();
                    $("form#upload_photo").html("Uploading...");
                },
                success: function (result) {
                    try {
					  $("#product_images").append(result);
					}
					catch(err) {
					  //
					}
                },
                error : function() {
                    alert("异常！");
                }
              });
		return false;
	})
})
</script>