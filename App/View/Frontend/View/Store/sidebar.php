<section class="row">
<div class="col s12">
<div class="p-3">
<img class="img-responsive w-100" src="<?php echo $store->logo();?>"/>

<h5 class="center-align"><?php 
echo $store->Name();?></h5>
<ul>
	<li class="">
		<p>Summary:</p>
		<p class="p-3 grey lighten-4"><?php echo $store->description;?><p>
	</li>
	<li>
		<p>Contact:</p></li>
	<li><div class="p-3 grey lighten-4"><i style="vertical-align: top;" class="left material-icons">phone</i>
		<div class="right-align"><?php echo $store->getPhone();?></div>
	</div></li>
	<li><div class="p-3 grey lighten-4"><i style="vertical-align: top;" class="left material-icons">email</i>
		<div class="right-align"><?php echo $store->getEmail();?></div>
	</div></li>
	<li><div class="p-3 grey lighten-4"><i style="vertical-align: top;" class="left material-icons">location_on</i>
		<div class="right-align"><?php echo $store->getAddress();?></div>
	</div></li>
</ul>
</div>
</div>
</section>