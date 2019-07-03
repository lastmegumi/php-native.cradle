<section class="col s12">
<h6>My Review on <span class="red-text text-lighten-2"><a href="<?php echo $product->getLink();?>"><?php echo $product->getTitle();?></a></span></h6>
	<div class="row">
		<div class="col s2 clearfix">
			<div class="p-3 white">
				<img class="img-responsive w-100" src="<?php echo $product->getThumbnail();?>" />
			</div>
		</div>
		<div class="col s10">
			<div class="p-3 white">
					<label>Rating:</label>
					<p>
					<?php
					echo $data->getRate();
					?></p>
					<label>Contents</label>
					<p><?php echo $data->getContent();?></p>
			</div>
		</div>
</section>