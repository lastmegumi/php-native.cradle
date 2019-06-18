<?php 
if(!$data){return;}
foreach($data as $i):?>
<div class="row product_image_edit">
<div class="col s1">
	<img class="img-responsive" src="<?php echo $i['url']?>">
	<input type="hidden" name="images[]" value="<?php echo $i['url']?>"?>
</div>
<div class="col s11">
	<p><?php echo $i['url']?></p>
    <a class="btn-floating waves-effect waves-light remove_photo" data-id="<?php echo $i['id'];?>"><i class="material-icons">remove</i></a>
</div>
</div>
<?php endforeach;?>