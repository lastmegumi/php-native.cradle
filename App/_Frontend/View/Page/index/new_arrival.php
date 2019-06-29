<?php
$c = new _Product();
$products = Product::findAll(['id'	=>	['in'	=>	[901, 904]]],['class'	=>	true]);

if(!$products){return;}
?>
<div class="container">
	<h3 class="center">New Arrivals</h3>
<?php
$c->assign("data", $products);
echo $c->cache("card_view");
?>
</div>