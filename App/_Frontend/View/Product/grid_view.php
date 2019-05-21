<section class="container">
<div class="row">
<?php foreach ($data as $k => $v) :?>
<div class="col s3  " style="padding:15px">  
    <div class="product_block white">
      <a href='<?php echo HOME . "product" . '?id=' . $v['id']?>'>
        <img src="3" />
        <p><?php echo @$v['name'];?></p>
      </a>
    </div>
</div>
<?php endforeach;?>
</div>
</section>