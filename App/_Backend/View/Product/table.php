<table class="responsive-table striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>SKU</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
    <tr class="clickable" data-href='<?php echo 'edit?id=' . $v->id?>'>
      <td><?php echo $v->name;?></td>
      <td><?php echo $v->sku;?></td>
      <td><?php echo $v->price;?></td>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>

