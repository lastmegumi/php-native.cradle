<section class="p-3 white">
<h6>Shipping</h6>
	<p class="clearfix"><span class="left">Shipping Cost</span>
		<span class="right"><?php echo Product::getCurrency() . $shipping->getCost();?></span>
	</p>
	<p class="clearfix"><span class="left">Shipping Career</span>
		<span class="right"><?php echo $shipping->getCareer()?></span>
		</p>	
	<p class="clearfix"><span class="left">Shipping Tracking</span>
		<span class="right"><?php echo  $shipping->getTracking()?></span>
	</p>
	<p class="clearfix"><span class="left">Is Mailed</span>
		<span class="right"><?php echo $shipping->getMailed()?></span>
	</p>
	<p class="clearfix"><span class="left">Notes</span>
		<span class="right"><?php echo $shipping->notes?></span>
	</p>
</section>
