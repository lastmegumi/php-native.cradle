<?php
class _Payment extends _Controller{
	protected $_attr = ["id", "order_id", "created", "updated"];
	protected $_table = "order_payment";
	private $main_key = "id";
	public $template_dir = "payment";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Payment";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Shipping();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$this->display('form');
	}

	function _route(){
	}

	function list(){
		print_r($this->findAll());
	}

	function add(){

	}

	function charge(){

	}



}
?>