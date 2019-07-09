<section class="col s12">
<h5>My Dashboard</h5>
<section class="row">
	<div class="p-3 white">
		<h6>Recent Orders
		<a class="right" href="orders/">View all</a></h6>
		<?php
		$orders = Order::findAll(["user_id"	=>	['eq' => _USER::current("id")], 'parent'	=>	['eq'	=>	0]], ['class'	=>	true,'order by'	=>	['created DESC'], 'limit'	=>	5]);
		$this->assign("data", $orders);
		echo $this->cache("orders");
		?>
	</div>
</section>
<section class="row">
	<div class="p-3 white">
		<h6>Account Information
				<a class="right" href="profile/">Edit</a></h6>
	</div>
</section>
<section class="row">
	<div class="p-3 white">
		<h6>Recent Reviews
			<a class="right" href="reviews/">View all</a></h6>
			<?php
			$reviews = Product_Review::findAll(["user_id"	=>	['eq' => _USER::current("id")]], ['class'	=>	true,'order by'	=>	['timestamp DESC'], 'limit'	=>	5]);
			$this->assign("data", $reviews);
			echo $this->cache("reviews");
			?>
	</div>
</section>
</section>