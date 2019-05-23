<?php

?>
<table class="responsive-table striped">
  <thead>
    <tr>
      <td>Name</td><td>Qty</td><td>Unit Price</td><td>Total price</td>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($product_list as $k => $v) :?>
    <tr class="clickable" data-href='<?php echo @$name? HOME . $name . '/edit?id=' . $v['id']:"" ?>'>
      <td><?php echo @$v->name?></td>
      <td><?php echo @$cart[$v->id]?></td>
      <td><?php echo $v->getPrice();?></td>      
      <td><?php echo $v->getPrice($cart[$v->id])?></td>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>
<div class="right">
<p>Subtatal:<?php echo $Subtotal;?></p>
<p>Tax:<?php echo $Tax;?></p>
<p>Discount:<?php echo $Discount;?></p>
<p>Total:<?php echo $FinalPrice;?></p>

<a class="btn">Check Out</a>
</div>
