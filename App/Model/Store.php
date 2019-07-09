<?php
class Store extends _Model{
	public $id;
	public $name;
	public $phone;
	public $phone2;
	public $email;
	public $email2;
	public $address;
	public $logo;
	public $logo_small;
	public $description;
	public $status;
	public $type;
	public $created;
	public $updated;
	public $owner;

	const _table = "store";

	function __construct(){
		
	}

	static function _table(){
		return "store";
	}

	function small_logo(){
		return $this->logo_small? $this->logo_small:"";
	}

	function Name(){
		return $this->name? $this->name:"";
	}

	function logo(){
		return $this->logo? $this->logo:"";
	}

	function getPhone(){
		return $this->phone;
	}

	function getEmail(){
		return $this->email;
	}

	function getAddress(){
		return $this->address;
	}

	function getLink(){
		return "/store?id=" . $this->id;
	}

	static function Email(){
		return "info@tempest-freezer.com";
	}
	static function Phone(){
		return "(800) 900-200-333";
	}
	static function Address(){
		return "117 Industrial Avenue Hasbrouck Heights NJ 07604";
	}

	static function TotalSoldAmount(){
		$sql = "SELECT SUM(amount_base) as base, SUM(amount_tax) as tax, SUM(amount_discount) as discount
				FROM `order` WHERE store_id = :store_id";
		$data = ['store_id'	=>	Admin::store()->id];

		$sale = _DB::init()->selectone($data, $sql);
		$shipping_sql = "SELECT SUM(cost) as cost
						FROM order_shipping
						WHERE store_id = :store_id";
		$shipping = _DB::init()->selectone($data, $sql);

		return Product::getCurrency().Product::format_price($sale["base"]);

	}

	static function TotalSoldProduct(){
		$sql = "SELECT SUM(qty) as qty
				FROM `order_product` WHERE store_id = :store_id";
		$data = ['store_id'	=>	Admin::store()->id];
		$res = _DB::init()->selectone($data, $sql);

		return $res['qty'] ? $res['qty']:0;
	}

}


class Platform{

	static function Name(){
		return "Raptor NJ Trading";
	}

	static function Email(){
		return "raptortradingnj@gmail.com";
	}
	static function Phone(){
		return "(800) 900-200-333";
	}
	static function Address(){
		return "117 Industrial Avenue Hasbrouck Heights NJ 07604";
	}

	static function Discription(){
		return "Tempest™ Freezers are designed with the combination of quick-freeze technology and ultra-mobile stability in refrigeration systems. Manufactured by enthusiasts for enthusiasts, we ensure the highest quality at the best prices. All our products satisfy industry standards for Polypropylene Plastic as well as safety standards for voltage protection.";
	}
}