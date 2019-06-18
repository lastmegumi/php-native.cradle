<section class="container">
<div class="row">
	<div class="col s-12 ">
<div class="product white">
	<div class="row">
	<div class="col s4">
		<div class="image p-3 white">
		<?php $thumbnail = $product->getThumbnail();?>
		<div class="mail-thumbnail">
			<img class="img-responsive mb-1" src="<?php echo $thumbnail;?>">
		</div>
		<div>
			<div class="clearfix" style="width:max-content">
				<?php $imgs = $product->getImages();
				foreach ($imgs as $k => $v) :?>
					<a class="fancybox-thumb border1" style="width:4rem;float:left;margin:.25rem" rel="fancybox-thumb" href="<?php echo $v['url']?>" title="">
						<img src="<?php echo $v['url']?>" alt="" class="img-responsive small-thumb"/>
					</a>
				<?php endforeach;?>
			</div>
		</div>
		</div>
	</div>

	<div class="col s8">
		<div class="information white p-3">
		<h4 style="margin-top:0"><?php echo $product->getTitle();?></h4>
		<span>SKU: <?php echo $product->sku;?></span>
		<?php if($product->is_forsale()):?>
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
	<?php endif;?>
		<div class="col s12">
			<div class="feature white">
				<ul class="product_feature">
					<?php 
					$data = $product->getFeature();
					for($i = 0; $i < count($data); $i++):?>
				  <li>
				    <span class="feature_title"><?php echo @$data[$i]['name']?></span><br/>
				    <span class="feature_des"><?php echo @$data[$i]['value']?></span>
				  </li>
				<?php endfor;?>
				</ul>
			</div>
		</div>
			</div>
	</div>
	</div>
</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="attribute white p-3">
			<h5>Technical Details</h5>
			<table class="responsive-table technical-details">
			<tbody>
				<?php 
				$data = $product->getAttributes();
				for($i = 0; $i < count($data); $i = $i + 2):?>
			  <tr>
			    <td class="grey lighten-2 center"><?php echo @$data[$i]['name']?></td>
			    <td class="right"><?php echo @$data[$i]['value']?></td>
			    <td class="grey lighten-2 center"><?php echo @$data[$i + 1]['name']?></td>
			    <td class="right"><?php echo @$data[$i + 1]['value']?></td>
			  </tr>
			<?php endfor;?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="description white p-3">
			<h5>Production Details</h5>
			<?php echo html_entity_decode($product->getDescription());?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="description white p-3">
			<h5>Production Reviews</h5>
			<?php 
			$data = $product->getReview();
			$this->assign("data", $data);
			$this->assign("product",	$product);
			echo $this->cache("reviews");?>
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