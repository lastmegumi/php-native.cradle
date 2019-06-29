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
	<div class="right">
		<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Edit tracking</a>
		<a  href="javascript:void(0)" id="mark_shipping" data-id="<?php echo $shipping->order_id;?>" class="btn red lighten-2">Mark as shipped</a>
		<a  href="javascript:void(0)" id="mark_delivered" data-id="<?php echo $shipping->order_id;?>" class="btn blue lighten-2">Mark as delivered</a>
	</div>
</section>

<!-- Modal Structure -->
<div id="modal1" class="modal">
  <form action="../shipping" method="POST">
<div class="modal-content">
  <h4>Edit Tracking Information</h4>
  	<div class="row">
        <div class="input-field col s6">
          <input id="career" name="career" type="text" class="validate">
          <label for="career">Career</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
          <input id="tracking" name="tracking" type="text" class="validate">
          <label for="tracking">Tracking Number</label>
        </div>
     </div>
     <input type="hidden" name="order_id" value="<?php echo $shipping->order_id;?>">
     <input type="hidden" name="id" value="<?php echo $shipping->id;?>">

</div>
<div class="modal-footer">
     <button class="btn red lighten-2">Save</button>
</div>
  </form>
</div>

<script type="text/javascript">
$('.modal').modal();

</script>