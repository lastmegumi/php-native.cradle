<?php
class _Shipping extends _Base{
	protected $_attr = ["id", "from", "to", "carrear", "tracking", "order_id"];
	protected $_table = "shipping";
	private $main_key = "id";
	public $template_dir = "shipping";
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

	function new(){
		$this->display('form');
	}

	function _route(){
		if(_R() == "POST"):
			$shipping = Shipping::find(["id"	=>	['eq'	=>	_P("id")],
										"order_id"	=>	['eq'	=>	_P('order_id')],
										],['class'	=>	true]);
			$shipping->tracking = _P('tracking');
			$shipping->notes = _P("notes");
			$shipping->save();
			header("location: ". $_SERVER['HTTP_REFERER']);
		endif;
	}

	function list(){
		print_r($this->findAll());
	}
}
?>