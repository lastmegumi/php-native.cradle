<div class="row">
  <div class="col s12">
    <div class="p-3 white">
<table class="responsive-table striped">
  <thead>
    <tr>
      <td>Order ID</td>
      <td>Order Status</td>
      <td>Order Price</td>
      <td>Order Date</td>
    </tr>
  </thead>
  <tbody>
    <?php
    if($data):
      foreach($data as $k => $v):?>
    <tr class="clickable" data-href='<?php echo "?id=" . $v->id?>'>
      <td><?php echo @$v->id?></td>
      <td><?php echo @$v->status?></td>
      <td><?php echo @$v->amount?></td>
      <td><?php echo _T(@$v->created)?></td>
    </tr>
    <?php endforeach;
    endif;?>
  </tbody>
</table>
</div>
</div>
</div>