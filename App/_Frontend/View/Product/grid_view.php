<section class="product_block container" data-load="ajax" data-func="loadProduct" id="product_block">
  <div class="progress">
      <div class="indeterminate"></div>
  </div>
</section>

<?php return;?>
<section class="container grid_view">
<div class="row">
<?php foreach ($data as $k => $v) :?>
<div class="col s3" style="padding:15px">  
    <div class="product_block">
    	<div class="card">
        <div class="card-image">
        	<img class="img-responsive lazy" src="<?php echo $v->default_img() ?>" data-src="<?php echo $v->getThumbnail();?>" />
          <span class="card-title"></span>
        </div>
        <div class="card-content">
	      <a href='<?php echo HOME . "product" . '?id=' . $v->id?>'>	        
	       	<p class="product_name"><?php echo @$v->name;?></p>
	      </a>
        <?php if($v->for_sale): ?>
            <a class="right btn-floating waves-effect waves-light red add-to-cart" id="add-to-cart" data-id="<?php echo $v->id ?>">
            <i class="material-icons">add</i></a>
        <?php endif;?>
          <p><?php echo @$v->getCurrency();?><?php echo @$v->getPrice();?></p>
        </div>
      </div>
    </div>
</div>
<?php endforeach;?>
</div>
<p>Total: <?php echo count($data);?> Items</p>
</section>