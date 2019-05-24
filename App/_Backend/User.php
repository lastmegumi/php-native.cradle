<?php
class _User extends _Controller{
	protected $_attr = ["id", "main_id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "user";
	private $main_key = "id";
	public $template_dir = "user";
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

	function register(){

	}

	function login(){

	}

	function cart(){
		
	}

	function dashboard(){

	}

	function orders(){

	}

	function info(){

	}
	
	function address(){

	}

	function review(){

	}

	function newsletters(){

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
		$p = array(
			"title"	=>	"titl22222_dddee",
		);
		_MongoDB::init()->setDatabase('test52');
		$this->build($p);
		//print_r($this->model);
		//return;
		var_dump($this->save());

	}

}
?>