<?php
class _Invoice extends _Base{
	function __construct(){
		$name = "Invoice";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Shipping();
	}

	function _route(){
		if(_R()	==	"GET"):
			$order = Order::find(["id"	=>	['eq'	=>	_G("id")]],['class'	=>	true]);
			$contents[] = $this->getTemp($order);
			$this->assign("order", $order);
			$contents[]	= $this->cache("action_bar");
			$this->show($contents, $temp = "user_backend");
		endif;
	}

	protected function getTemp(Order $order){
			$order_products = Order_Product::findAll(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);

			$shipping_address = Order_Address::find(['order_id'	=>	['eq'	=>	$order->id],
													'type'	=>	['eq' => "shipping"]],['class'	=>	true]);
			$billing_address = Order_Address::find(['order_id'	=>	['eq'	=>	$order->id],
													'type'	=>	['eq' => "billing"]],['class'	=>	true]);

			$shipping = Shipping::find(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);

			$payment = Payment::find(["order_id"	=>	['eq'	=>	$order->id]],['class'	=> true]);

			$this->assign("order", $order);
			$this->assign("order_products", $order_products);
			$this->assign("shipping_address", $shipping_address);
			$this->assign("billing_address", $billing_address);
			$this->assign("shipping", $shipping);
			$this->assign("payment", $payment);
			return $this->cache("Invoice_temp");
	}
}
?>