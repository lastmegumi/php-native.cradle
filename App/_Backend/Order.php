<?php
class _Order extends _Base{
	protected $_attr = ["id",  "buyer_name", "buyer_email", "buyer_phone", "token", "amount_base", "amount_tax", "amount_discount", "amount_paid", "description", "message", "payment_method", "status", "updated"];
	protected $_table = "order";
	private $main_key = "id";
	public $template_dir = "order";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Order";
		$this->template_dir = APP_DIR . "view/".$name."/";
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$this->display('form');
	}

	function _route(){
		if(_G('id')){
			$contents[] = $this->cache("action_bar");
			$order = Order::find(['id'	=>	['eq'	=>	_G("id")]],['class'	=>	true]);
			$this->assign("order", $order);
			$contents[] = $this->cache("status");
			$contents[]	= $this->cache("basic_card");

			$user = User::find(['id'	=>	["eq" => $order->user_id]],['class'	=>	true]);
			$this->assign("data", $user);
			$contents[]	= $this->cache("buyer_card");

			$payment = Payment::find(['order_id'	=>	["eq" => $order->id]], ['class'	=>	true]);
			$this->assign("payment", $payment);
			$contents[]	= $this->cache("payment_card");
			$contents[]	= $this->cache("status_card");

			$billing = order_address::find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "billing"]],['class'	=>	true]);
			$shipping = order_address::find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "shipping"]],['class'	=>	true]);
			$this->assign("billing", $billing);
			$this->assign("shipping", $shipping);


			$contents[]	= $this->cache("billing_shipping");
			$shipping = Shipping::find(['order_id'	=>	["eq" => $order->id]],['class'	=>	true]);
			$this->assign("shipping", $shipping);			
			$contents[]	= $this->cache("shipping_card");

			$Order_Product = Order_Product::findAll(['order_id'	=>	["eq" => $order->id]],['class'	=>	true]);
			$this->assign("data", $Order_Product);			
			$contents[]	= $this->cache("products");
			$this->show($contents);
		}
	}

	function list(){
		$data = Order::findAll([],["order by"	=>	["created DESC"],'class'	=>	true]);
		$this->assign("data", $data);
		$contents[] = $this->cache("table");
		$this->show($contents);
	}

	function shipped(){
		$id = _P('order_id');
		$order = Order::find(['id'	=>	['eq'	=>	$id]],['class'	=>	true]);
		$order->status = 2;
		$order->save();
		$shipping = Shipping::find(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);
		$shipping->status = 1;
		$shipping->updated = strtotime('now');
		$shipping->save();
		$this->response['url']	= $_SERVER['HTTP_REFERER'];
		$this->response['status']	=	1;
		$this->json_return();
	}

	function delivered(){
		$id = _P('order_id');
		$order = Order::find(['id'	=>	['eq'	=>	$id]],['class'	=>	true]);
		$order->status = 3;
		$order->save();
		$shipping = Shipping::find(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);
		$shipping->status = 2;
		$shipping->updated = strtotime('now');
		$shipping->save();
		$this->response['url']	= $_SERVER['HTTP_REFERER'];
		$this->response['status']	=	1;
		$this->json_return();
	}

	function add(){
		return;
		$data = array(
				'id'	=>	'',
				'buyer_email'	=>	'lastmegumi@gmail.com',
				'buyer_name'	=>	'yan_ren',
				'buyer_phone'	=>	'9292453662',
				'token'	=>	rid('128'),
				'amount_base'	=>	55,
				'amount_discount'	=>	10,
				'amount_paid'	=>	55,
				'amount_tax'	=>	10,
				'description'	=>	'第一单',
				'message'	=>	'烧腊',
				'payment_method'	=>	'credit_stripe',
				'status'	=>	1,
				'updated'	=>	strtotime("now"),
			);
		$order = new Order();
		$order->build($data)->save();
	}

}
?>