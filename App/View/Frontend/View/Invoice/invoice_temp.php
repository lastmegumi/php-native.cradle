<seciton class="col s12 z-depth-2 white print-area" id="printarea">
	<div class="p-3">
	<h5 class="center-align">Invoice: <?php echo $order->invoicenum();?></h5>
	<div class="row">
		<div class="col s6">
			<h6><strong>Seller</strong></h6>
			<p><?php echo $order->getStoreName();?></p>
			<p><?php echo $order->getStoreEmail();?></p>
			<p><?php echo $order->getStorePhone();?></p>
			<p><?php echo $order->getStoreAddress();?></p>
		</div>
		<div class="col s6">
			<h6><strong>Customer</strong></h6>
			<p>Name:	<?php echo $order->getBuyerName();?></p>
			<p>Phone:	<?php echo $order->getBuyerPhone();?></p>
			<p>E-mail:	<?php echo $order->getBuyerEmail();?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s6">
			<h6><strong>Shipping</strong></h6>
			<p>Name: <?php echo $shipping_address->getName(); ?></p>
			<p>Phone: <?php echo $shipping_address->getPhone(); ?></p>
			<p>Address: <?php echo $shipping_address->getAddress(); ?></p>
		</div>
		<div class="col s6">
			<h6><strong>Billing</strong></h6>
			<p>Name: <?php echo $billing_address->getName();?></p>
			<p>Phone: <?php echo $billing_address->getPhone();?></p>
			<p>Address: <?php echo $billing_address->getAddress();?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<h6><strong>Payment</strong></h6>
			<p>Payment Method: <?php echo $order->getPaymentMethod();?></p>
		</div>
	</div>
	<div class="row">
		<div class="col s12">
			<h6><strong>Order list</strong></h6>
			<table>
				<thead>
					<th width="5%">Image</th>
					<th>Name</th>
					<th class="right-align">Price</th>
					<th class="right-align">Qty</th>
					<th class="right-align">Discount</th>
					<th class="right-align">Tax</th>
					<th class="right-align">Subtotal</th>
				</thead>
				<tbody>
					<?php foreach($order_products as $p):?>
					<tr>
						<td><?php echo "image";?></td>
						<td><?php echo $p->product_name;?>
							<p class="small">SKU: <?php echo $p->product_sku;?></p></td>
						<td class="right-align"><?php echo Product::getCurrency() . $p->product_price;?></td>
						<td class="right-align"><?php echo $p->qty;?></td>
						<td class="right-align red-text text-darken-2">- <?php echo Product::getCurrency() . Product::format_price($p->qty * $p->product_discount);?></td>
						<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($p->qty * $p->product_tax);?></td>
						<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($p->qty * $p->product_price);?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="col s3 offset-s9">
			<table class="right">
				<tr><td class="right-align">Subtotal:</td>
					<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($order->amount_base);?></td></tr>
				<tr><td class="right-align">Discount:</td>
					<td class="right-align red-text">- <?php echo Product::getCurrency() . Product::format_price($order->amount_discount);?></td></tr>
				<tr><td class="right-align">Tax:</td>
					<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($order->amount_tax);?></td></tr>
				<tr><td class="right-align">Shipping:</td>
					<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($shipping->cost);?></td></tr>
				<tr><td class="right-align">Total:</td>
					<td class="right-align"><?php echo Product::getCurrency() . Product::format_price($order->amount_base);?></td></tr>
			</table>
		</div>
	</div>
</div>
</seciton>
<seciton class="col s12">
	<a class="btn red lighten-2" onclick="print('printarea')">
		Print Invoice
	</a>
</seciton>
<script type="text/javascript">
function print (id) {
	var prtContent = document.getElementById(id);
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
	// body...
}

</script>