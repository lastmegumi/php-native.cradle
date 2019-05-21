<?php
class _Checkout extends _Base{
	protected $_attr = ["id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "product";
	private $main_key = "id";
	public $template_dir = "product";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Checkout";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Product();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function placeorder(){
		$cart = array();

		// $price = $cart->getPrice();
		// $total = $price['final'];
		$token = $this->check_card();
		try{
			if(!$token['status']){return;}
			$token = $token['data']->id;
			$amount = 100;
			$description  = 'test';
			//$charge = $this->charge($token, $amount, $description);
			
			$obj = array(
					"buyer_email"	=>	"lastyanqing@gmail.com",
					"buyer_name"	=>	"yanqing",
					"buyer_phone"	=>	"6464791555",
					"token"	=>	"abcdefg",
					"amount_base"	=>	$amount,
					"amount_discount"	=>	'abcde',
					"amount_paid"	=>	$amount,
					"amount_tax"	=>	0,
					"description"	=>	"description",
					"message"	=>	"message",
					"payment_method"	=>	"credit_strpie",
					"status"	=>	"1",
					"updated"	=>	strtotime('now'),
				);
			_DB::init()->conn->beginTransaction();
			$order_id = $this->create_order($obj);
			var_dump($order_id);
			$this->create_shipping($order_id);
			$this->create_payment($order_id);
			_DB::init()->conn->commit();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			echo $e->getMessage();
		}

	}

	private function create_order($obj){
		$order = new Order();
		$order->buyer_email	=	$obj['buyer_email'];
		$order->buyer_name	=	$obj['buyer_name'];
		$order->buyer_phone	=	$obj['buyer_phone'];
		$order->token	=	$obj['token'];
		$order->amount_base	=	$obj['amount_base'];
		$order->amount_discount	=	$obj['amount_discount'];
		$order->amount_paid	=	$obj['amount_paid'];
		$order->amount_tax	=	$obj['amount_tax'];
		$order->description	=	$obj['description'];
		$order->message	=	$obj['message'];
		$order->payment_method	=	$obj['payment_method'];
		$order->status	=	$obj['status'];
		$order->updated	=	$obj['updated'];
		return $order->save();
	}

	private function create_shipping($order_id){
		$shipping = new Shipping();
		$shipping->order_id = $order_id;
		$shipping->cost = "";
		$shipping->career_id = "";
		$shipping->tracking = "";
		$shipping->notes = "";
		$shipping->is_mailed = "";
		$shipping->status = "";
		$shipping->updated = "";
		$shipping->save();
	}

	private function create_payment($order_id){
		$payment = new Payment();
		$payment->order_id	=	$order_id;
		$payment->type	=	"";
		$payment->amount	=	"";
		$payment->status	=	"";
		$payment->updated	=	"";
		$payment->save();
	}

	private function charge($token, $amount, $description){
		return stripe::init()::charge($token, $amount, $description);
	}

	private function check_card(){
		$card = [
			    "number"		=> "4242424242424242",
			    "exp_month" 	=> "11",
			    "exp_year" 		=> "22",
			    "cvc" 			=> "333",
			    "name"			=> "yan",
			    "address_line1"	=> "86-11",
			    "address_line2"	=> "apt",
			    "address_city"	=> "Howard Beach",
			    "address_state"	=> "New York",
			    "address_zip"	=> "11414",
			    //"address_line1"	=> $obj['address_line1'],
			  ];
		$token = stripe::init()->card_token($card);
		return $token;
	}

	function _route(){
		$contents[] = $this->cache("form");
		$this->show($contents);
	}
}
?>