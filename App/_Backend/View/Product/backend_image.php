<?php foreach($data as $i):?>
	<div class="row">
<div class="col s2">
	<img class="img-responsive" src="<?php echo $i['url']?>">
	<input type="hidden" name="images[]" value="<?php echo $i['url']?>"?>
</div>
<div class="col s10">
	<p><?php echo $i['url']?></p>
</div>
</div>
<?php endforeach;?>