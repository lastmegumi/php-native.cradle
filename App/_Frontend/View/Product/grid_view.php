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
            <a class="right btn-floating waves-effect waves-light red add-to-cart" id="add-to-cart" data-id="<?php echo $v->id ?>">
            <i class="material-icons">add</i></a>
          <p><?php echo @$v->getCurrency();?><?php echo @$v->getPrice();?></p>
        </div>
      </div>
    </div>
</div>
<?php endforeach;?>
</div>
<p>Total: <?php echo count($data);?> Items</p>
</section>