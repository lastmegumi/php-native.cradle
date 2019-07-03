<section class="row">
<div class="address col s6 p-3">
	<div class="p-3 white">
	<h6 class="title">Billing to</h6>
	<p class="clearfix"><?php echo $billing->first_name . $billing->last_name?></p>
	<p class="clearfix"><?php echo $billing->phone;?></p>
	<p class="clearfix"><?php echo $billing->address1 . $billing->address2?></p>	
	<p class="clearfix"><?php echo $billing->city . ' ' . $billing->state . ' ' . $billing->zipcode?></p>
</div>
</div>

<div class="address col s6 p-3">
	<div class="p-3 white">
	<h6 class="title">Shipping to</h6>
	<p class="clearfix"><?php echo $shipping->first_name . $shipping->last_name?></p>
	<p class="clearfix"><?php echo $shipping->phone;?></p>
	<p class="clearfix"><?php echo $shipping->address1 . $shipping->address2?></p>	
	<p class="clearfix"><?php echo $shipping->city . ' ' . $shipping->state . ' ' . $shipping->zipcode?></p>
</div>
</div>

</section>