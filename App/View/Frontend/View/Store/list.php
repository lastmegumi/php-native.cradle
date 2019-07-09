<section class="container">
	<h6>Authorized Stores</h6>
  <div class="row">
<?php foreach($data as $k => $v):?>	
    <div class="col s6">
      <div class="card">
        <div class="card-image p-3 clearfix">
          <img src="<?php echo $v->logo();?>" />
        </div>
          <h6 class="card-title black-text p-3"><?php echo $v->Name();?></h6>
        <div class="card-content">
          <p><?php echo $v->description?></p>
        </div>
        <div class="card-action right-align">
          <a href="/store?id=<?php echo $v->id;?>">View Store</a>
        </div>
      </div>
    </div>
<?php endforeach;?>
  </div>
</section>