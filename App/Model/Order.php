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

	function getStatus(){
		switch ($this->status) {
			case 1:
				return "Paid, wait shipping";
				break;
			case 2:
				return "Shipped, on the way.";
				break;
			case 3:
				return "Delivered.";
				break;
			case -1:
				return "refunded";
				break;
			case -2:
				return "canceled";
				break;
			default:
				return "N/A";
				break;
		}
	}

	function invoicenum(){
		return crc32($this->token);
	}

	function getBuyerName(){
		return $this->buyer_name;
	}

	function getBuyerEmail(){
		return $this->buyer_email;
	}

	function getBuyerPhone(){
		return $this->buyer_phone;
	}

	function getStoreName(){
		return Platform::Name();
	}

	function getStorePhone(){
		return Platform::Phone();
	}

	function getStoreEmail(){
		return Platform::Email();
	}

	function getStoreAddress(){
		return Platform::Address();
	}

	function getShippingCost(){
		$shipping = shipping::find(['order_id'	=>	['eq'	=>	$this->id]]);
		return $shipping? $shipping->getCost(): 0;
	}

	function getTotal(){
		return $this->amount_base + $this->amount_tax - $this->amount_discount + $this->getShippingCost();
	}

	function Billingto(){
		return Order_Address::find(['order_id'	=>	['eq'	=>	$this->id],
									'type'		=>	['eq'	=> "billing"]]);
	}

	function Shippingto(){
		return Order_Address::find(['order_id'	=>	['eq'	=>	$this->id],
									'type'		=>	['eq'	=> "shipping"]]);
	}

	function getPaymentMethod(){
		switch ($this->payment_method) {
			case 'credit_strpie':
				return "Credit Card (Stripe)";
				break;			
			default:
				return "N/A";
				break;
		}
	}

	function getAmount(){
		return $this->amount_base + $this->tax - $this->discount;		
	}
}

class Order_Product extends _Model{
	public $id;
	public $order_id;
	public $product_id;
	public $store_id;
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

	function getSeller(){
		return Store::find(['id'	=>	['eq'	=>	$this->store_id]]);
	}
}

class _Address extends _Model{
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $zipcode;
	public $country;

	const _table = "address";	
}

class Order_Address extends _Address{

	const _table = "order_address";

	static function _table(){
		return "order_address";
	}

	function __construct(){
		return $this;
	}

	function getName(){
		return $this->first_name . ' ' . $this->last_name;
	}

	function getPhone(){
		return $this->phone;
	}

	function getAddress(){
		return $this->format_address();
	}

	function format_address(){		
		$str = $this->address1? $this->address1 .", " : '';
		$str .= $this->address2? $this->address2 .", " : '';
		$str .= $this->city? $this->city .", " : '';
		$str .= $this->state? $this->state .", " : '';
		$str .= $this->zipcode? $this->zipcode .", " : '';
		$str .= $this->country? $this->country .", " : '';
		return $str;
	}
	public $id;
	public $first_name;
	public $last_name;
	public $order_id;
	public $type;
	public $notes;
	public $phone;
}
