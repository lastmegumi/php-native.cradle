<?php
class Order extends _Model{
	public $id;
	public $buyer_mail;
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

class _Order extends _Controller{
	protected $_attr = ["id", "main_id", "buyer", "payment", "shipping", "product_ids", "created", "status", "updated"];
	protected $_table = "order";
	private $main_key = "id";
	public $template_dir = "order";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Order";
		$this->template_dir = APP . "view/".$name."/";
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$this->display('form');
	}

	function _route(){
		$order = new Order();
		$order->build()->save();
	}

	function list(){
		print_r($this->findAll());
	}

	function add(){
		var_dump($this->save());

	}

}
?>