<table class="responsive-table striped">
  <thead>
    <tr>
      <th>Id</th>
      <th>Buyer Name</th>
      <th>Buyer Phone</th>
      <th>Order Token</th>
      <th>Base Amount</th>
      <th>Tax</th>
      <th>Paid</th>
      <th>Discount</th>
      <th>Status</th>      
      <th>Payment</th>
      <th>Updated</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
        <tr class="clickable" data-href='<?php echo  HOME . BACKEND .'order/?id=' . $v->id ?>'>
            <td><?php echo $v->id;?></td>
            <td><?php echo $v->buyer_name;?></td>
            <td><?php echo $v->buyer_phone;?></td>
            <td><?php echo $v->token;?></td>
            <td class="clearfix text-right"><?php echo Product::getCurrency(). Product::format_price($v->amount_base);?></td>
            <td class="clearfix text-right"><?php echo Product::getCurrency(). Product::format_price($v->amount_tax);?></td>
            <td class="clearfix text-right"><?php echo Product::getCurrency(). Product::format_price($v->amount_paid);?></td>
            <td class="clearfix text-right"><?php echo Product::getCurrency(). Product::format_price($v->amount_discount);?></td>
            <td><?php echo $v->getStatus();?></td>
            <td><?php echo $v->getPaymentMethod();?></td>
            <td><?php echo _T($v->updated);?></td>
        </tr>
      <?php endforeach;?> 
  </tbody>
</table>

