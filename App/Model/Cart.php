<?php
class Cart extends _Model{
	public $product_id;
	public $user_id;
	public $session_id;
	public $updated;
	public $qty;

	const _table = "cart";

	static function _table(){
		return "cart";
	}

	function __construct(){
		
	}

	static function mycart(){
		$sql = "SELECT sum(qty) as qty, product_id, session_id 
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
		return  $c;
	}

	static function getDiscount(){
		return 0;
	}

	static function Calculate($data){
		$subtotal = 0;
		$tax = 0;
		$discount = 0;
		$final = 0;
		$product_list = [];
		foreach ($data as $k => $v) {
			$p = Product::find(['id'	=>	["eq" => $k]], ['class'	=>	true]);
			$product_list[]	= $p;
			$subtotal += $p->getPrice($v);
			$tax += $p->getTax($v);
		}


		$data = ['user_id'	=>	_User::current("id")];
		$store_sql = "SELECT DISTINCT store_id FROM cart
				   INNER JOIN product ON product.id = cart.product_id
				   WHERE 1
				    AND user_id = :user_id 
				    group by product_id, session_id 
				    ORDER BY product_id DESC";
		$stores = _DB::init()->select($data, $store_sql);

		$shipping	= self::CalculateShpping($stores, $product_list);

		return array("product_list"	=>	$product_list, 
					 "subtotal"	=>	$subtotal,
					 "tax"	=>	$tax,
					 "shipping"	=>	$shipping,
					 "discount"	=>	self::getdiscount(),
					 "final_price"	=>	$subtotal + $tax);
	}

	static function CalculateShpping($store, $products){
		$shipping = 0;
		foreach ($store as $key => $value) {
			$shipping += _Shipping::Cost($products, $value, new Order_Address());
		}
		return $shipping;
	}

}