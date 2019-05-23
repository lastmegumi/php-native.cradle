<?php
class Order extends _Model{
	public $id;
	public $buyer_email;
	public $buyer_name;
	public $buyer_phone;
	public $token;
	public $amount_base;
	public $amount_discount;
	public $amount_paid;
	public $amount_tax;
	public $description;
	public $message;
	public $payment_method;
	public $status;
	public $updated;
	protected function _table(){
		return "order";
	}
}

class Order_Product extends _Model{
	public $id;
	public $order_id;
	public $product_id;
	public $product_name;
	public $product_img;
	public $product_sku;
	public $product_price;
	public $product_tax;
	public $product_discount;
	public $status;
	public $notes;
	public $updated;

	protected function _table(){
		return "order_product";
	}

	function __construct(){
		return $this;
	}
}

class _Address extends _Model{
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $zipcode;
	public $country;
}

class Order_Address extends _Address{

	protected function _table(){
		return "order_address";
	}

	function __construct(){
		return $this;
	}
	public $id;
	public $first_name;
	public $last_name;
	public $order_id;
	public $type;
	public $notes;
	public $phone;
}

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
			$order = new Order();
			$data = $order->find(['id'	=>	['eq'	=>	12]]);
			$order->build($data);
			$this->assign("order", $order);
			$contents[] = $this->cache("status");

			$user = new User();
			$udata = $user->find(['id'	=>	["eq" => $data['user_id']]]);
			$user->build($udata);

			$contents[]	= $this->cache("basic_card");
			$this->assign("buyer", $user);
			$contents[]	= $this->cache("buyer_card");

			$payment = new Payment();
			$udata = $payment->find(['order_id'	=>	["eq" => $data['id']]]);
			$payment->build($udata);			
			$this->assign("payment", $payment);
			$contents[]	= $this->cache("payment_card");
			$contents[]	= $this->cache("status_card");
			$shipping = new Shipping();
			$udata = $shipping->find(['order_id'	=>	["eq" => $data['id']]]);
			$shipping->build($udata);			
			$this->assign("shipping", $shipping);			
			$contents[]	= $this->cache("shipping_card");

			$Order_Product = new Order_Product();
			$ReflectionClass = new ReflectionClass("Order_Product");
			$udata = $Order_Product->findAll(['order_id'	=>	["eq" => $data['id']]]);
			foreach ($udata as $k => $v) {
				$products[] = $ReflectionClass->newInstanceWithoutConstructor()->build($v);	
			}		
			$this->assign("order_product", $products);			
			$contents[]	= $this->cache("products");
			$this->show($contents);
		}
	}

	function list(){		
		$sql = "SELECT `{$this->_table}`.* FROM `{$this->_table}`
				WHERE 1 ORDER BY";
		$data = array();
		$data = _DB::init()->select($data, $sql);
		$header = $this->_attr;
		foreach ($data as $k => $v) {
			$c = [];
			foreach ($header as $k2 => $v2) {
				$c[$v2]	=	@$v[$v2];
			}
			$table_data[] = $c;
		}
		$contents[] = $this->cache("action_bar");
		
		$this->assign("header", $header);
		$this->assign("data", $table_data);
		$this->assign("name", $this->_table);
		$contents[] = $this->cache("table");
		$this->show($contents);
	}

	function add(){
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