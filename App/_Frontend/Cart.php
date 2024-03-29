<?php
class _Cart extends _Base{
	protected $_attr = ["id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "Cart";
	private $main_key = "id";
	public $template_dir = "Cart";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Cart";
		$this->template_dir = APP_DIR . "view/".$name."/";
	}

	function add(){
		$id = _P("pid");
		$qty = _P("quantity");
		$product = new Product();
		$d = Product::find(['id'	=>	['eq'	=>	$id]]);

		if(!$qty || !$d){return;}
		$cart = new Cart();
		$cart->product_id	=	$d->id;
		 $cart->user_id		= 	_User::current("id")?_User::current("id") : -1;
		 $cart->session_id =	session_id();
		 $cart->qty		=	$qty;
		 $cart->updated	=	strtotime("now");
		try{
			$cart->save();
			echo "add to cart";
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function remove(){
		$id = _P("pid");
		$product = new Product();
		$d = Product::find(['id'	=>	['eq'	=>	$id]]);
		$cart = new Cart();
		try{
			if(_User::is_logged()){
				$cart->deleteAll(['product_id'	=>	['eq'	=>	$id], "user_id"	=>	_User::current("id")]);
			}else{
				$cart->deleteAll(['product_id'	=>	['eq'	=>	$id], "session_id"	=>	session_id()]);
			}
			echo "removed";
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function mycart(){
		$cart = new Cart();
		$sql = "SELECT sum(qty) as qty, product_id, session_id , store_id
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";

		$data = ['user_id'	=>	_User::current("id")];
		$store_sql = "SELECT DISTINCT store_id FROM cart
				   INNER JOIN product ON product.id = cart.product_id
				   WHERE 1
				    AND user_id = :user_id 
				    group by product_id, session_id 
				    ORDER BY product_id DESC";
		$stores = _DB::init()->select($data, $store_sql);

		if(_User::is_logged()){
			$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
			$data = ['user_id'	=>	_User::current("id")];
		}else{
			$sql .= " AND session_id = :session_id group by product_id ORDER BY product_id DESC";
			$data = ['session_id'	=>	session_id()];
		}
		$data = _DB::init()->select($data, $sql);

		if(!$data){
			$contents[] = $this->cache('empty_cart');
			$this->show($contents);
			return;
		}

		$c = array_column($data, "qty", "product_id");
		$cartinfo = $this->Calculate($c);
		$this->assign("cart", $c);
		$this->assign("product_list", $cartinfo["product_list"]);
		$this->assign("Subtotal", $cartinfo['subtotal']);
		$this->assign("Tax", $cartinfo['tax']);
		$this->assign("Discount", $cartinfo['discount']);
		$cartinfo['shipping']	=	 $this->CalculateShpping($stores, $cartinfo["product_list"]);
		$this->assign("FinalPrice", $cartinfo['subtotal'] + $cartinfo["tax"] + $cartinfo['shipping'] - $cartinfo['discount']);


		$this->assign("Shipping", $cartinfo['shipping']);
		$contents[] = $this->cache('mycart');
		$this->show($contents);
	}

	function CalculateShpping($store, $products){
		$shipping = 0;
		foreach ($store as $key => $value) {
			$shipping += _Shipping::Cost($products, $value, new Order_Address());
		}
		return $shipping;

	}

	function get(){
		$cart = new Cart();
		$sql = "SELECT sum(qty) as qty, product_id, session_id, user_id
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";
		if(_User::is_logged()){
			$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
			$data = ['user_id'	=>	_User::current("id")];
		}else{
			$sql .= " AND session_id = :session_id group by product_id ORDER BY product_id DESC";
			$data = ['session_id'	=>	session_id()];
		}

		$data = _DB::init()->select($data, $sql);

		if(!$data){
			$this->json_return("empty cart");
			return;
		}

		$c = array_column($data, "qty", "product_id");
		$cartinfo = $this->Calculate($c);

		foreach ($cartinfo['product_list'] as $key => $value) {
			$d[] = array("id"	=>	$value->id,
						 "name"		=>	$value->name,
						 "price"	=>	$value->getPrice(),
						 "thumbnail"	=>	$value->getThumbnail(),
						 "qty"	=>	$c[$value->id]
						 );
		}

		$this->response['data']	= array("items"	=>	$d, 
										"subtotal"	=>	 number_format((float)$cartinfo['subtotal'], 2, '.', ''));
		$this->response['status'] = 1;
		$this->json_return();
	}

	function reload(){
		$cart = new Cart();
		$sql = "SELECT sum(qty) as qty, product_id, session_id, user_id
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";
		if(_User::is_logged()){
			$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
			$data = ['user_id'	=>	_User::current("id")];
		}else{
			$sql .= " AND session_id = :session_id group by product_id ORDER BY product_id DESC";
			$data = ['session_id'	=>	session_id()];
		}
		$data = _DB::init()->select($data, $sql);
		$c = array_column($data, "qty", "product_id");
		$cartinfo = $this->Calculate($c);

		$this->assign("cart", $c);
		$this->assign("product_list", $cartinfo["product_list"]);
		$this->assign("Subtotal", $cartinfo['subtotal']);
		$this->assign("Tax", $cartinfo['tax']);
		$this->assign("Discount", $cartinfo['discount']);
		$this->assign("FinalPrice", $cartinfo['subtotal'] + $cartinfo["tax"] - $cartinfo['discount']);
		echo $this->cache('mycart');
	}

	function Calculate($data){
		$subtotal = 0;
		$tax = 0;
		$discount = 0;
		$final = 0;
		$product_list = [];
		foreach ($data as $k => $v) {
			$p = Product::find(['id'	=>	["eq" => $k]], ['class'	=>	true]);
			$product_list[]	= $p;
			$subtotal += $p->getPrice($v);
			$discount += cart::getDiscount($v);
			$tax += $p->getTax($v);
		}

		return array("product_list"	=>	$product_list, 
					 "subtotal"	=>	$subtotal,
					 "tax"	=>	$tax,
					 "discount"	=>	$discount,
					 "final_price"	=>	$subtotal + $tax - $discount);
	}

	function getSubtotal(){

	}

	function getDiscount(){

	}

	function getTax(){

	}

	function getFinal(){

	}

	function clear(){
	}


	function _route(){
		print_r(@$_SESSION['cart'][session_id()]);
	}

	function list(){
	}
}
?>