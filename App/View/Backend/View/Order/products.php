<section class="white p-3">
<table>
<thead>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>SubTotal</th>
</thead>
<tbody>
<?php
foreach ($data as $k => $v) :?>
	<tr>
		<td width="5%"><img class="img-responsive w-100" src="<?php
		echo Product::find(['id' => ['eq' => $v->product_id]],['class'=>true])->getThumbnail();
		//echo
		?>" /></td>
		<td><?php echo $v->product_name?>
			<p class="small">SKU:<?php echo $v->product_sku;?></p></td>
		<td><?php echo Product::getCurrency() . Product::format_price($v->product_price);?></td>
		<td><?php echo $v->qty?></td>
		<td><?php echo Product::getCurrency() . Product::format_price($v->product_price * $v->qty);?></td>
	</tr>
<?php
endforeach;
?>
</tbody>
</table>
</section>
