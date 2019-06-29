<div class="container cart-list white p-3 clearfix">
<h5>My shopping cart</h5>
<table class="responsive-table striped">
  <thead>
    <tr>
      <td></td><td>Name</td><td>Qty</td><td>Unit Price</td><td>Total price</td>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($product_list as $k => $v) :?>
    <tr class="" data-href='<?php echo @$name? HOME . $name . '/edit?id=' . $v['id']:"" ?>'>
      <td width="10%"><img class="img-responsive" src="<?php echo $v->getThumbnail();?>" /></td>
      <td><a href="<?php echo @$v->getLink()?>" title="<?php echo @$v->name?>" target="_blank">
        <?php echo @$v->name?></a>
        <p class="text-grey text-lighten-2 small">SKU: <?php echo @$v->sku;?></p></td>
      <td><?php echo @$cart[$v->id]?></td>
      <td><?php echo Product::getCUrrency() . $v->getPrice();?></td>      
      <td><?php echo Product::getCUrrency() . $v->getPrice($cart[$v->id])?></td>
      <td><a class="btn-floating waves-effect waves-light remove-from-cart" data-id="<?php echo $v->id;?>"><i class="material-icons">remove</i></a>
 </td>
    </tr>
      <?php endforeach;?> 
  </tbody>
</table>
<div class="right">
<table>
  <tr>
    <td class="p-0">Subtatal:</td>
    <td class="right p-0">
      <p><?php echo Product::getCUrrency() . Product::format_price($Subtotal);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Tax:</td>
    <td class="right p-0">
      <p><?php echo  Product::getCUrrency() . Product::format_price($Tax);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Discount:</td>
    <td class="right p-0">
      <p>:<?php echo Product::getCUrrency() . Product::format_price($Discount);?></p>
    </td>
  </tr>
  <tr>
    <td class="p-0">Total:</td>
    <td class="right p-0">
      <p><?php echo Product::getCUrrency() . Product::format_price($FinalPrice);?></p>
    </td>
  </tr>
</table>
<a class="btn right red" href="/checkout">Check Out</a>
</div>
</div>