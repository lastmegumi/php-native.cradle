<div class="row">
  <div class="col s12">
    <div class="p-3 white">
<table class="responsive-table striped">
  <thead>
    <tr>
      <td width="5%">Image</td>
      <td>Product</td>
      <td>Reviewed Rate</td>
      <td>Reviewed Date</td>
    </tr>
  </thead>
  <tbody>
    <?php
    if($data):
      foreach($data as $k => $v):?>
   	<tr class="clickable" data-href='<?php echo "?id=" . $v->id?>'>
      <td class="clearfix"><img class="w-100 img-responsive" src="
      	<?php echo Product::find(['id'	=>	['eq'	=>	$v->product_id]],['class'	=>	true])->getThumbnail()?>" /></td>
      <td><?php echo Product::find(['id'	=>	['eq'	=>	$v->product_id]],['class'	=>	true])->getTitle()?></td>
      <td><?php echo @$v->getRate()?></td>
      <td><?php echo _T($v->timestamp);?></td>
    </tr>
    <?php endforeach;
    endif;?>
  </tbody>
</table>
</div>
</div>
</div>