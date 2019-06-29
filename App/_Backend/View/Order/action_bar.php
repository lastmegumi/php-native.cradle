<section class='right'>
	<a href="/<?php echo BACKEND ?>invoice/?id=<?php echo $order->id;?>" class="btn">Print Invoice</a>
	<a href="javascript:void(0)" class="btn red lighten-2">Send Invoice Email</a>	
	<a href="/<?php echo BACKEND ?>order/refund?id=<?php echo $order->id;?>" class="btn blue lighten-2">Refund</a>
	<a href="/<?php echo BACKEND ?>order/cancel?id=<?php echo $order->id;?>" class="btn red lighten-2">Cancel</a>
</section>