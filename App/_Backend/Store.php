<?php
class _Store extends _Base{
	public $template_dir = "store";

	function __construct(){
		$name = "Store";
		$this->template_dir = APP_DIR . "view/".$name."/";
	}

	function new(){
		$this->display('form');
	}

	function _route(){
	}
	
	function setting(){
		$store = Store::find(['id'	=>	['eq'	=>	Admin::getStoreID()]]);
		$store = $store? $store: new Store();
		$this->assign("data", $store);
		$contents[] = $this->cache("form");
		$this->show($contents);
	}

	function save(){
		$store = Store::find(['id'	=>	['eq'	=>	Admin::getStoreID()]]);

		$store->name = _P("name");
		$store->logo = _P("logo");
		$store->logo_small = _P("logo_small");
		$store->description = _P("description");
		$store->updated = strtotime('now');
		$store->save();
		_H($_SERVER['HTTP_REFERER']);
	}

	function edit(){
		//$data = Store::find();
	}

	function list(){
		print_r($this->findAll());
	}
}
?>