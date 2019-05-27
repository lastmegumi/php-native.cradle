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
		$this->model = new Product();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function add(){
		$id = _P("pid");
		$qty = _P("quantity");
		$product = new Product();
		$d = $product->find(['id'	=>	['eq'	=>	$id]]);

		if(!$qty || !$d){return;}
		$cart = new Cart();
		$obj = array("product_id"	=>	$d['id'],
					 "user_id"		=> 	1,
					 "session_id"	=>	session_id(),
					 "qty"			=>	$qty,
					 "updated"		=>	strtotime("now"),
					);
		$cart->build($obj);
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
		$d = $product->find(['id'	=>	['eq'	=>	$id]]);
		#if(!$d){return;}
		$cart = new Cart();
		try{
			$cart->deleteAll(['product_id'	=>	['eq'	=>	$id], "session_id"	=>	session_id()]);
			echo "removed";
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	function mycart(){
		$cart = new Cart();
		$sql = "SELECT sum(qty) as qty, product_id, session_id 
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";
		$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
		$data = ['user_id'	=>	1];
		$data = _DB::init()->select($data, $sql);
		$c = array_column($data, "qty", "product_id");
		$cartinfo = $this->Calculate($c);

		$this->assign("cart", $c);
		$this->assign("product_list", $cartinfo["product_list"]);
		$this->assign("Subtotal", $cartinfo['subtotal']);
		$this->assign("Tax", $cartinfo['tax']);
		$this->assign("Discount", $cartinfo['discount']);
		$this->assign("FinalPrice", $cartinfo['subtotal'] + $cartinfo["tax"] - $cartinfo['discount']);
		$contents[] = $this->cache('mycart');
		$this->show($contents);
	}

	function reload(){
		$cart = new Cart();
		$sql = "SELECT sum(qty) as qty, product_id, session_id 
				FROM cart
				INNER JOIN product ON product.id = cart.product_id
				WHERE 1";
		$sql .= " AND user_id = :user_id group by product_id ORDER BY product_id DESC";
		$data = ['user_id'	=>	1];
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
		// /print_r($data);
		$ReflectionClass = new ReflectionClass("Product");
		foreach ($data as $k => $v) {
			$c = $ReflectionClass->newInstanceWithoutConstructor()->find(['id'	=>	["eq" => $k]]);
			$p =$ReflectionClass->newInstanceWithoutConstructor()->build($c);
			$product_list[]	= $p;
			$subtotal += $p->getPrice($v);
			$discount += $p->getDiscount($v);
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