<?php
class Order extends _Model{
	public $id;
	public $user_id;
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
	public $created;
	public $updated;


	const _table = "order";

	static function _table(){
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
	public $product_tax;
	public $product_price;
	public $product_discount;
	public $qty;
	public $status;
	public $notes;
	public $updated;

	const _table = "order_product";

	static function _table(){
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

	const _table = "order_address";

	static function _table(){
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
