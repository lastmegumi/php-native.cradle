<?php
class _Checkout extends _Base{
	protected $_attr = ["id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "Checkout";
	private $main_key = "id";
	public $template_dir = "Checkout";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());

		$name = "Checkout";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Product();
	}

	function placeorder(){
		$cart = array();

		$billing = new Order_Address();
		$billing->build(array("address1"	=>	_P("address1"),
						 "address2"	=>	_P("address2"),
						 "city"	=>	_P("city"),
						 "state"	=>	_P("state"),
						 "zipcode"	=>	_P("zipcode"),
						 "country"	=>	_P("country"),
						 "last_name"	=>	_P("last_name"),
						 "first_name"	=>	_P("first_name"),
						 "phone"	=>	_P("phone")?_P("phone"):0,
						 "notes"		=>	"notes",
						 "type"		=>	"billing"));

		$shipping = new Order_Address();
		$shipping->build(array("address1"	=>	_P("ship_address1"),
						 "address2"	=>	_P("ship_address2"),
						 "city"	=>	_P("ship_city"),
						 "state"	=>	_P("ship_state"),
						 "zipcode"	=>	_P("ship_zipcode"),
						 "country"	=>	_P("ship_country"),
						 "last_name"	=>	_P("ship_last_name"),
						 "first_name"	=>	_P("ship_first_name"),
						 "phone"	=>	_P("ship_phone")?_P("ship_phone"):0,
						 "notes"		=>	"notes",
						 "type"		=>	"shipping"));

		$cart = new Cart();
		$cart_c = new _Cart();
		$sql = "SELECT sum(qty) as qty, product_id FROM cart WHERE 1";
		$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
		$data = ['user_id'	=>	1];
		$data = _DB::init()->select($data, $sql);
		$c = array_column($data, "qty", "product_id");
		$cartinfo = $cart_c->Calculate($c);

		$user = new User();
		$user->build($user->find(['id'	=>	['eq'	=>	1]]));

		$data = [
			    "number"		=> _P('card'),
			    "exp_month" 	=> explode("/", _P('expiration'))[0],
			    "exp_year" 		=> explode("/", _P('expiration'))[1],
			    "cvc" 			=> _P('cvc'),
			    "name"			=> _P('name'),
			    "address_line1"	=> _P('address1'),
			    "address_line2"	=> _P('address2'),
			    "address_city"	=> _P('city'),
			    "address_state"	=> _P('state'),
			    "address_zip"	=> _P('zipcode'),
			    //"address_line1"	=> $obj['address_line1'],
			  ];
		$token = $this->check_card($data);		
		try{

			_DB::init()->conn->beginTransaction();
			if(!$token['status']){return;}
			$token = $token['data']->id;
			$amount = $cartinfo['final_price'] * 100;
			$description  = 'test';
			$charge = $this->charge($token, $amount, $description);
			if(!$charge['status']){throw new Exception("Error Processing Request", 1);
			}


			$obj = array(
					"buyer_email"	=>	$user->uemail,
					"buyer_name"	=>	$billing->last_name . ' ' . $billing->first_name,
					"buyer_phone"	=>	$billing->phone,
					"token"			=>	$token,
					"amount_base"	=>	$cartinfo['subtotal'],
					"amount_discount"	=>	$cartinfo['discount'],
					"amount_paid"	=>	0,
					"amount_tax"	=>	$cartinfo['tax'],
					"amount_shipping"	=>	@$cartinfo['shipping']?	$cartinfo['shipping']:0,
					"description"	=>	"description",
					"message"	=>	"message",
					"payment_method"	=>	"credit_strpie",
					"status"	=>	"1",
					"updated"	=>	strtotime('now'),
				);
			$order_id = $this->create_order($obj);
			$this->create_address($order_id, $billing, $shipping);
			$this->create_shipping($order_id);
			$this->create_payment($order_id, $charge['data']);
			$this->create_orderproduct($order_id, $cartinfo['product_list'], $c);
			_DB::init()->conn->commit();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			echo $e->getMessage();
		}

	}

	private function create_orderproduct($order_id, $product_list, $cart){
		$ReflectionClass = new ReflectionClass("Order_Product");
		// public $order_id;
		// public $product_id;
		// public $product_name;
		// public $product_img;
		// public $product_sku;
		// public $product_tax;
		// public $product_discount;
		// public $status;
		// public $notes;
		// public $updated;
		foreach ($product_list as $k => $v) {
			$p = array( "order_id"	=>	$order_id,
						"product_id"	=>	$v->id,
						"product_name"	=>	$v->name,
						"product_img"	=>	@$v->img,
						"product_sku"	=>	$v->sku,
						"product_tax"	=>	$v->getTax(),
						"product_discount"	=>	$v->getDiscount(),
						"product_price"	=>	$v->getPrice(),
						"qty"	=>	$cart[$v->id],
						"status"	=>	1,
						"notes"	=>	"",
						"updated"	=>	strtotime('now'),
				);
			$ReflectionClass->newInstanceWithoutConstructor()->build($p)->save();
		}
	}

	private function create_address($order_id, $billing, $shipping){
		$billing->order_id = $order_id;
		$billing->save();

		$shipping->order_id = $order_id;
		$shipping->save();
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

	private function create_payment($order_id, $data){
		$payment = new Payment();
		$payment->order_id	=	$order_id;
		$payment->type	=	"";
		$payment->amount	=	"";
		$payment->status	=	"";
		$payment->updated	=	"";
		$payment->track_back = urlencode(json_encode($data));
		$payment->save();
	}

	private function charge($token, $amount, $description){
		return stripe::init()::charge($token, $amount, $description);
	}

	private function check_card($card){
		$data = [
			    "number"		=> $card['number'],
			    "exp_month" 	=> $card['exp_month'],
			    "exp_year" 		=> $card['exp_year'],
			    "cvc" 			=> $card['cvc'],
			    "name"			=> $card['name'],
			    "address_line1"	=> $card['address_line1'],
			    "address_line2"	=> $card['address_line2'],
			    "address_city"	=> $card['address_city'],
			    "address_state"	=> $card['address_state'],
			    "address_zip"	=> $card['address_zip'],
			    //"address_line1"	=> $obj['address_line1'],
			  ];
		$token = stripe::init()->card_token($data);
		return $token;
	}

	function _route(){
		$contents[] = $this->cache("form");
		$this->show($contents, "checkout");
	}
}
?>