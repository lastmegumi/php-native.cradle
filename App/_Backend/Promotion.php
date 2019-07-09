<?php
class _Promotion extends _Base{
	public $template_dir = "Promotion";


	function __construct(){
		$name = "Promotion";
		$this->template_dir = APP_DIR . "view/".$name."/";

		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$this->display('form');
	}

	function _route(){
		$pro = Promotion::findAll(['store_id'	=>	['eq'	=>	Admin::store()->id]],['order by'	=>	['updated DESC']]);
		$this->assign("data", $pro);
		$contents[] = $this->cache("index");
		$contents[] = $this->cache("action_bar");
		$this->show($contents);
	}

	function simpleform(){
		$pro = new Promotion();
		$pro->target = 1;
		$pro->type = 1;
		$pro->created = $pro->updated = $pro->start = $pro->end = strtotime("now");
		$pro->priority = -1;
		$pro->status = 0;
		$pro->store_id = Admin::store()->id;
		$pro->save();
		_H(HOME. BACKEND . "promotion/edit/?id=" . $pro->id);
	}

	function categoryform(){
		$pro = new Promotion();
		$pro->target = 2;
		$pro->type = 1;
		$pro->created = $pro->updated = $pro->start = $pro->end = strtotime("now");
		$pro->priority = -1;
		$pro->status = 0;

		$pro->save();
		_H(HOME. BACKEND . "promotion/edit/?id=" . $pro->id);
	}

	function storeform(){
		$pro = new Promotion();
		$pro->target = 3;
		$pro->type = 1;
		$pro->created = $pro->updated = $pro->start = $pro->end = strtotime("now");
		$pro->priority = -1;
		$pro->status = 0;

		$pro->save();
		_H(HOME. BACKEND . "promotion/edit/?id=" . $pro->id);
	}

	function edit(){
		$id = _G("id");
		$pro = Promotion::find(["id"	=>	['eq'	=>	$id]]);
		$this->assign("data", $pro);
		switch ($pro->target) {
			case 1:
				$contents[] = $this->cache("simpleform");
				break;
			case 2:
				$category = Category::findAll();
				$this->assign("category", $category);
				$contents[] = $this->cache("categoryform");
				break;	
			case 3:
				$contents[] = $this->cache("storeform");
				break;	
			default:
				# code...
				break;
		}

		$this->show($contents);
	}

	function save(){
			$pro = Promotion::find(['id'	=>	['eq'	=>	_P("id")]]);
			if(!$pro):
				$pro = new Promotion();
			endif;
			$pro->type = _P("type");
			$pro->value = _P("value");
			$pro->target_value = _P("target_value");
			$pro->name = _P("name");
			$pro->description = _P("description");
			$pro->start = strtotime(_P("start"));
			$pro->end = strtotime(_P("end"));
			$pro->target_limited = _P("target_limited")? _P("target_limited"):-1;
			$pro->code = _P("code");
			$pro->target_group = _P("target_group");
			$pro->created = $pro->created ? $pro->created : strtotime('now');
			$pro->updated = strtotime('now');
			$pro->status = _P("status");
			$pro->store_id = Admin::store()->id;
			$pro->priority = _P("priority");
			$pro->save();
			_H($_SERVER['HTTP_REFERER']);
	}

	function delete(){
		$pro = Promotion::find(['id'	=>	['eq'	=>	_G("id")],
								'store_id'	=>	['eq'	=>	Admin::store()->id]]);
		if($pro):
			$pro->delete();
		endif;
		_H(HOME . BACKEND . "promotion");
	}

}
?>