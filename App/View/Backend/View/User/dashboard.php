<h6>Dashboard</h6>
<div class="row">
<div class="col s3">
	<div class="p-3 white">
	Orders
	<p class="right-align m-0">Total: <?php echo Order::Total();?></p>
</div>
</div>
<div class="col s3">
	<div class="p-3 white">
	Customers
	<p class="right-align m-0">Total: <?php echo User::Total();?></p>
</div>
</div>
<div class="col s3">
	<div class="p-3 white">
	Product
	<p class="right-align m-0">Total: <?php echo Product::Total();?></p>
</div>
</div>
<div class="col s3">
	<div class="p-3 white">
	Category
	<p class="right-align m-0">Total: <?php echo Category::Total();?></p>
</div>
</div>

</div>
<div class="row">
	<div class="col s12">
		<div class="p-3 white">
			<p>Last 5 Orders:</p>
			<?php $data = Order::findAll([],['order by'	=>	['created DESC'], "limit"	=>	5])?>
			<?php $this->assign("data", $data);?>
			<?php echo $this->cache("Backend/view/Order/table");?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12">
		<div class="p-3 white">
			<p>Last 5 Reviews:</p>
			<?php $data = Product_Review::findAll([],['order by'	=>	['timestamp DESC'], "limit"	=>	5])?>
			<?php $this->assign("data", $data);?>
			<?php echo $this->cache("Backend/view/Product_Review/table");?>
		</div>
	</div>
</div>