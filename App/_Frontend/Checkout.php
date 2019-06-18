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

		if(!_User::is_logged()){
			_H(HOME . 'user/login');
		}
	}

	function placeorder(){
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
		$sql = "SELECT sum(qty) as qty, product_id, session_id 
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";
		$sql .= " AND user_id = :user_id group by product_id, session_id ORDER BY product_id DESC";
		$data = ['user_id'	=>	_User::current("id")];
		$data = _DB::init()->select($data, $sql);

		if(!$data){
			$this->json_return("noitem");
		return;}
		$c = array_column($data, "qty", "product_id");
		$cartinfo = $cart_c->Calculate($c);
		$cartinfo['session_id'] = $data[0]['session_id'];

		$shipping_cost = _Shipping::Cost($cartinfo['product_list'], $c, $shipping);

		$user = new User();
		$user->build($user->find(['id'	=>	['eq'	=>	_User::current("id")]]));

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

		$FINAL_AMOUNT = $cartinfo['final_price'] + $shipping_cost;
		try{

			_DB::init()->conn->beginTransaction();
			if(!$token['status']){return; $this->json_return("notoken");}
			$token = $token['data']->id;
			$FINAL_AMOUNT = $FINAL_AMOUNT * 100;
			$description  = 'test';
			$charge = $this->charge($token, $FINAL_AMOUNT, $description);
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
					"created"	=>	strtotime("now"),
					"updated"	=>	strtotime('now'),
				);
				
			$order_id = $this->create_order($obj);			
			$this->create_address($order_id, $billing, $shipping);			
			$this->create_shipping($order_id, $shipping_cost);

			$this->create_payment($order_id, $FINAL_AMOUNT, $charge['data']);
			$this->create_orderproduct($order_id, $cartinfo['product_list'], $c);

			$cart->deleteAll(["session_id" =>	['eq'	=>	$cartinfo['session_id']]]);
			_DB::init()->conn->commit();
			$this->response['status'] =	 1;
			$this->response['url']	=	"/user/dashboard/orders?id=" . $order_id;
			$this->json_return();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			#$this->json_return("failed");
			$this->json_return($e->getMessage());
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
		$order->created	=	$obj['created'];
		$order->updated	=	$obj['updated'];
		$order->user_id	=	_User::current("id");
		$res = $order->save();
		if(!$res):
			throw new Exception("Error on create order", 1);
		endif;
		return $res;		
	}

	private function create_shipping($order_id, $cost){
		$shipping = new Shipping();
		$shipping->order_id = $order_id;
		$shipping->cost = $cost;
		$shipping->career_id = "default";
		$shipping->tracking = "";
		$shipping->notes = "";
		$shipping->is_mailed = "";
		$shipping->status = 0;
		$shipping->updated = strtotime("now");
		$shipping->save();
	}

	private function create_payment($order_id, $final_price, $data){
		// print_r($final_price);
		// print_r($data);
		if(intval($final_price) != intval($data['amount']) || $data['captured'] != 1 || $data['paid'] != 1){
			stripe::init()::refund($data['id'], $data['amount']);
			throw new Exception("Error Processing Card Payment", 1);
			return;			
		}
		// stripe::init()::refund($data['id'], $data['amount']);
		// throw new Exception("Error Processing Card Payment", 1);
		return;
		$payment = new Payment();
		$payment->order_id	=	$order_id;
		$payment->type	=	"credit_strpie";
		$payment->amount	=	$data->amount / 100;
		$payment->status	=	1;
		$payment->updated	=	strtotime("now");
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
		$this->show($contents);
	}
}
?>