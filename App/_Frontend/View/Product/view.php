<section class="row">
	<div class="col s4 white">
		<?php $img = $product->getImages();
			if($img):?>
			<img class="img-responsive" src="<?php echo $img[0]['url'];?>" />
		<?php endif;
		?>
	</div>

	<div class="col s8 white">
		<h2><?php echo $product->getTitle();?></h2>
		<h4><small><?php echo $product->getCurrency();?></small><?php echo $product->getPrice();?></h4>
		<div class="row">
			<div class="input-field col s2">
			    <select class="browser-default" id="product_qty">
			      <option value="" disabled>0</option>
			      <option value="1" selected>1</option>
			      <option value="2">2</option>
			      <option value="3">3</option>
			    </select>
			 </div>
			 <div class="col s4">
			 	<div class style="padding:1rem">
					<a class="waves-effect waves-light btn red add-to-cart" id="add-to-cart" data-id="<?php echo $product->id ?>">
						<i class="material-icons left">add_shopping_cart</i>Add to cart</a>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="row">
	<div class="col s12">
		<div class="description white">
			<?php echo $product->getDescription();?>
		</div>
	</div>
</section>
<script type="text/javascript">
$(document).ready(() => {

})
</script>