<?php
class Product{
	function __construct(){
		
	}

}
class _Product extends _Controller{
	protected $_attr = ["id", "title", "imgs", "price", "options", "status", "store", "created", "updated"];
	protected $_table = "product";
	private $main_key = "id";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$this->model = new Product();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function _route(){
	}

	function list(){
		print_r($this->findAll());
	}

}
?>