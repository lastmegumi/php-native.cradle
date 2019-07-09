<?php
class _Store extends _Base{
	public $template_dir = "store";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Store";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Product();
	}

	function _route(){
		if(!$this->single()){
			$this->list();
		}
	}

	function list(){
		$store = Store::findAll();
		$this->assign("data", $store);
		$contents[] = $this->cache('list');
		$this->show($contents);
	}

	function single(){
		$id = _G("id");
		$store = Store::find(['id'	=>	['eq'	=>	$id]]);
		if(!$store){return false;}

		$this->assign("store", $store);
		$contents['store'] = $this->cache('sidebar');

		$product = Product::findall(['store_id'	=>	['eq'	=>	$id]]);
		$this->assign("data", $product);
		$contents['product'] = $this->cache('product');
		$this->show($contents,'single_store');
		return true;
	}
}
?>