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
			$order = Order::find(['id'	=>	['eq'	=>	_G("id")]],['class'	=>	true]);
			$this->assign("order", $order);
			$contents[] = $this->cache("action_bar");
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
			$billing = $billing? $billing: new order_address();
			$shipping = order_address::find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "shipping"]],['class'	=>	true]);
			$shipping = $billing? $billing: new order_address();
			$this->assign("billing", $billing);
			$this->assign("shipping", $shipping);


			$contents[]	= $this->cache("billing_shipping");
			$shipping = Shipping::find(['order_id'	=>	["eq" => $order->id]],['class'	=>	true]);
			$this->assign("shipping", $shipping);			
			$contents[]	= $this->cache("shipping_card");

			$Order_Product = Order_Product::findAll(['order_id'	=>	["eq" => $order->parent],
													 'store_id'	=>	["eq"	=>	Admin::Store()->id]],['class'	=>	true]);
			$this->assign("data", $Order_Product);			
			$contents[]	= $this->cache("products");
			$this->show($contents);
		}
	}

	function list(){
		$page_size = 20;
		$page_index = _G("page") && is_numeric(_G("page")) ? _G("page") - 1 : 0;

		$options = ['class'	=>	true, 
					'order by'	=>	['id DESC'],
					'limit'	=>	$page_index * $page_size . ',' . $page_size];

		$data = Order::findAll(['store_id'	=>	['eq'	=>	Admin::store()->id]],$options);
		$total = Order::total(['store_id'	=>	['eq'	=>	Admin::store()->id]]);
		$this->assign("data", $data);
		$contents[] = $this->cache("table");


		$pages	=	intval(($total + $page_size - 1) / $page_size );
		$this->assign("index", $page_index + 1);
		$this->assign("pages", $pages);
		$this->assign("total", $total);
		
		$contents[] = $this->cache("Helper/pages");
		$this->show($contents);
	}

	function shipped(){
		$id = _P('order_id');
		try{
			_DB::init()->conn->beginTransaction();

			$order = Order::find(['id'	=>	['eq'	=>	$id]],['class'	=>	true]);
			$order->status = 2;
			$order->save();
			$shipping = Shipping::find(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);
			$shipping->status = 1;
			$shipping->updated = strtotime('now');
			$shipping->save();

			$sql = "UPDATE order_Product SET status = 2 WHERE order_id = :order_id AND store_id = :store_id";
			$data = ['order_id'	=> $order->parent, "store_id"	=>	Admin::store()->id];
			_DB::init()->update($data, $sql);
			_DB::init()->conn->commit();
			$this->response['url']	= $_SERVER['HTTP_REFERER'];
			$this->response['status']	=	1;
			$this->json_return();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			$this->json_return($e->getMessage());
		}
	}

	function delivered(){
		$id = _P('order_id');
		try{
			_DB::init()->conn->beginTransaction();

			$order = Order::find(['id'	=>	['eq'	=>	$id]],['class'	=>	true]);
			$order->status = 3;
			$order->save();
			$shipping = Shipping::find(['order_id'	=>	['eq'	=>	$order->id]],['class'	=>	true]);
			$shipping->status = 2;
			$shipping->updated = strtotime('now');
			$shipping->save();

			$sql = "UPDATE order_Product SET status = 3 WHERE order_id = :order_id AND store_id = :store_id";
			$data = ['order_id'	=> $order->parent, "store_id"	=>	Admin::store()->id];
			_DB::init()->update($data, $sql);
			_DB::init()->conn->commit();
			$this->response['url']	= $_SERVER['HTTP_REFERER'];
			$this->response['status']	=	1;
			$this->json_return();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			$this->json_return($e->getMessage());
		}

	}

	function refund(){
		$id = _G("id");
		$order = Order::find(['id'	=>	['eq'	=>	$id]], ['class'	=>	true]);
		try{
			if($order->status != -1):
				$payment = Payment::find(['order_id'	=>	['eq'	=>	$order->parent],'status'	=>	['eq'	=>	1]], ['class'	=>	true]);
				if($payment->refund($order->getTotal()));
				$order->status = -1;
				$order->save();

				$sql = "UPDATE order_Product SET status = -1 WHERE order_id = :order_id AND store_id = :store_id";
				$data = ['order_id'	=> $order->parent, "store_id"	=>	Admin::store()->id];
				_DB::init()->update($data, $sql);
				_DB::init()->conn->commit();
				$this->response['url']	= $_SERVER['HTTP_REFERER'];
				$this->response['status']	=	1;
			endif;
		}catch(Exception $e){
		}
		header('Location: ' .  $_SERVER['HTTP_REFERER']);
	}

	function cancel(){
		$id = _G("id");
		$order = Order::find(['id'	=>	['eq'	=>	$id]], ['class'	=>	true]);
		try{
			$payment = Payment::find(['order_id'	=>	['eq'	=>	$order->id],'status'	=>	['eq'	=>	1]], ['class'	=>	true]);
			if($payment->refund());
			$order->status = -2;
			$order->save();
		}catch(Exception $e){
		}
		header('Location: ' .  $_SERVER['HTTP_REFERER']);
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