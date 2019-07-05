<section class="order_status col s4 white">
		<p class="bold clearfix"><span class="left">Order Date</span><span class="right"><?php echo _T($order->created);?></span></p>		
		<p class="bold clearfix"><span class="left">Last update</span><span class="right"><?php echo _T($order->updated);?></span></p>
		<p class="bold clearfix"><span class="left">Order Status</span><span class="right"><?php echo $order->getStatus()?></span></p>
</section>