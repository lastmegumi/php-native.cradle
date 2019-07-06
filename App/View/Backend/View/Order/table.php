<table class="responsive-table striped white">
  <thead>
    <tr>
      <th>Id</th>
      <th>Billing</th>
      <th>Shipping</th>
      <th>Status</th>      
      <th>Payment</th>
      <th class="right-align">Amount</th>
      <th class="right-align">Updated</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($data as $k => $v) :?>
        <tr class="clickable" data-href='<?php echo  HOME . BACKEND .'order/?id=' . $v->id ?>'>
            <td><?php echo $v->id;?></td>
            <td><?php echo $v->Billingto()->getName();?></td>
            <td><?php echo $v->Shippingto()->getName();?></td>
            <td><?php echo $v->getStatus();?></td>
            <td><?php echo $v->getPaymentMethod();?></td>
            <td class="right-align"><?php echo Product::getCurrency() . Product::format_Price($v->getAmount());?></td>
            <td class="right-align"><?php echo _T($v->updated);?></td>
        </tr>
      <?php endforeach;?> 
  </tbody>
</table>

