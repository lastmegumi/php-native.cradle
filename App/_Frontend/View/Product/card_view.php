<div class="row">
<?php foreach($data as $d):?>
    <div class="col s6 m6">
      <div class="card">
        <div class="card-image">
          <img class="img-responsive" src="<?php echo $d->getThumbnail();?>">
          <a class="btn-floating halfway-fab waves-effect waves-light red" href="<?php echo $d->getLink();?>"><i class="material-icons">visibility</i></a>
        </div>
        <div class="card-content">
          <span class="card-title"><?php echo $d->name;?></span>
          <p><?php echo $d->getShortdescription();?></p>
        </div>
      </div>
    </div>
<?php endforeach;?>
</div>