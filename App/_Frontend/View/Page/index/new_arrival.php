<?php
$c = new _Product();
$ReflectionClass = new ReflectionClass("product");
$data = $ReflectionClass->newInstanceWithoutConstructor()->findAll(['id'	=>	['in'	=>	[901, 904]]]);
foreach ($data as $k => $v) {
	$products[] = $ReflectionClass->newInstanceWithoutConstructor()->build($v);	
}
if(!$products){return;}
?>
<div class="container">
	<h3 class="center">New Arrivals</h3>
<?php
$c->assign("data", $products);
echo $c->cache("card_view");
?>
</div>