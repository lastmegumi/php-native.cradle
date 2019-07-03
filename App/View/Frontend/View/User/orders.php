<div class="row">
  <div class="col s12">
    <div class="p-3 white">
<table class="responsive-table striped">
  <thead>
    <tr>
      <td>Order ID</td>
      <td>Order Status</td>
      <td class="right-align">Order Price</td>
      <td class="right-align">Order Date</td>
    </tr>
  </thead>
  <tbody>
    <?php
    if($data):
      foreach($data as $k => $v):?>
    <tr class="clickable" data-href='<?php echo "/user/dashboard/orders?id=" . $v->id?>'>
      <td><?php echo @$v->id?></td>
      <td><?php echo @$v->getStatus()?></td>
      <td class="right-align"><?php echo Product::getCurrency() . Product::format_price(@$v->getAmount())?></td>
      <td class="right-align"><?php echo _T(@$v->created)?></td>
    </tr>
    <?php endforeach;
    endif;?>
  </tbody>
</table>
</div>
</div>
</div>