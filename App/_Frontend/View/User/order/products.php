<section class="white p-3">
<table>
<thead>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>SubTotal</th>
</thead>
<tbody>
<?php
foreach ($data as $k => $v) :?>
	<tr>
		<td><?php echo $v->product_name?></td>
		<td><?php echo $v->product_price?></td>
		<td><?php echo $v->qty?></td>
		<td><?php echo $v->product_price * $v->qty?></td>
	</tr>
<?php
endforeach;
?>
</tbody>
</table>
</section>