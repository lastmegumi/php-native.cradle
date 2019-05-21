<?php
class Cart{
	function __construct(){
		
	}

}

class _Cart extends _Controller{
	protected $_attr = ["id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "product";
	private $main_key = "id";
	public $template_dir = "product";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Product";
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
		var_dump($id);
		if(!$d){return;}
		$product->build($d);
		$_SESSION['cart'][session_id()][]	=	array("product_id"	=>	$product->id, "qty"	=>	$qty);
		print_r($_SESSION['cart'][session_id()]);
	}

	function clear(){
		$_SESSION['cart'][session_id()] = array();
	}


	function _route(){
		print_r(@$_SESSION['cart'][session_id()]);
	}

	function list(){
		print_r($this->findAll());
	}
}
?>