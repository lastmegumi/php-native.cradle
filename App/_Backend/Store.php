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
		$store = Store::find(['id'	=>	['eq'	=>	Admin::store()->id]]);
		$store = $store? $store: new Store();
		$this->assign("data", $store);
		$contents[] = $this->cache("form");
		$this->show($contents);
	}

	function save(){
		$store = Store::find(['id'	=>	['eq'	=>	Admin::store()->id]]);

		$store->name = _P("name");

		$store->phone = check_phone(_P("phone"));
		$store->phone2 = check_phone(_P("phone2"));
		$store->email = _P("email");
		$store->email2 = _P("email2");
		$store->address = _P("address");

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