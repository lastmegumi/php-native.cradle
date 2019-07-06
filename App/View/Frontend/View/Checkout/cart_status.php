<div class="cart-list white p-3 clearfix">
<table class="responsive-table striped">
  <thead>
    <tr>
      <td></td><td>Name</td><td>Qty</td><td>Unit Price</td><td>Total price</td>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($product_list as $k => $v) :?>
    <tr class="">
      <td width="10%"><img class="img-responsive" src="<?php echo $v->getThumbnail();?>" /></td>
      <td><a href="<?php echo @$v->getLink()?>" title="<?php echo @$v->name?>" target="_blank">
        <?php echo @$v->name?></a>
        <p class="text-grey text-lighten-2 small">SKU: <?php echo @$v->sku;?></p></td>
      <td><?php echo @$cart[$v->id]?></td>
      <td><?php echo Product::getCUrrency() . $v->getPrice();?></td>      
      <td><?php echo Product::getCUrrency() . $v->getPrice($cart[$v->id])?></td>
 </td>
    </tr>
      <?php endforeach;?> 

  </tbody>
</table>
<div class="right">
<table>
  <tr>
    <td class="p-0">Subtatal:</td>
    <td></td>
    <td class="right p-0">
      <p><?php echo Product::getCUrrency() . Product::format_price($Subtotal);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Tax:</td>
    <td></td>
    <td class="right p-0">
      <p><?php echo  Product::getCUrrency() . Product::format_price($Tax);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Discount:</td>
    <td></td>
    <td class="right p-0">
      <p><?php echo Product::getCUrrency() . Product::format_price($Discount);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Total:</td>
    <td></td>
    <td class="right p-0">
      <p><?php echo Product::getCUrrency() . Product::format_price($FinalPrice);?></p>
    </td>
  </tr>
</table>
</div>
</div>