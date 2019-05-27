<section class="container">
<div class="row">
	<div class="col s4 white">
		<?php $thumbnail = $product->getThumbnail();?>
		<div class="mail-thumbnail">
			<img class="img-responsive mb-1" src="<?php echo $thumbnail;?>">
		</div>
		<div>
			<div class="row" style="width:max-content">
		<?php $imgs = $product->getImages();
		foreach ($imgs as $k => $v) :?>
			<a class="fancybox-thumb" style="width:6rem;float:left" rel="fancybox-thumb" href="<?php echo $v['url']?>" title="">
				<img src="<?php echo $v['url']?>" alt="" class="img-responsive small-thumb"/>
			</a>
		<?php endforeach;?>
			</div>
		</div>
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
</div>
<div class="row">
	<div class="col s12">
		<div class="description white">
			<?php echo $product->getDescription();?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="attribute white p5">
			<table class="responsive-table striped">
			<tbody>
				<?php 
				$data = $product->getAttributes();
				foreach($data as $k => $v):?>
			  <tr>
			    <td><?php echo $v['name']?></td>
			    <td><?php echo $v['value']?></td>
			  </tr>
			<?php endforeach;?>
			</tbody>
			</table>
		</div>
	</div>
</div>
</section>
<script type="text/javascript">
$('img.small-thumb').hover(function(){
    	try{
    		$('.mail-thumbnail img').attr('src', $(this).attr('src'));
    	}catch{

    	}
    })
</script>