<table class="responsive-table striped white">
  <thead>
    <tr>
      <th width="5%">Image</th>
      <th>Name</th>
      <th>SKU</th>
      <th class="right-align">Instock</th>
      <th class="right-align">Price</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
    <tr class="clickable" data-href='<?php echo 'edit?id=' . $v->id?>'>
      <td><img class="img-responsive lazy" src="<?php echo $v->default_img()?>" data-src="<?php echo $v->getThumbnail();?>"></td>
      <td><?php echo $v->name;?></td>
      <td><?php echo $v->sku;?></td>
      <td class="right-align"><?php echo $v->getStock();?></td>
      <td class="right-align"><?php echo Product::getCUrrency() . Product::format_price($v->getPrice());?></td>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>

