<?php
class _Category extends _Base{
	protected $_attr = ["id", "name", "image", "created", "updated", "parent"];
	protected $_table = "category";
	private $main_key = "id";
	public $template_dir = "Category";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Category";
		$this->template_dir = APP_DIR . "view/".$name."/";
	}

	function new(){
		$category = new _Category();
		$c =  $category->findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category", $c);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}


	function edit(){
		$c =  Category::findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category",$c);
		$d = Category::find(['id'	=>	["eq" => _G('id')]]);
		$this->assign("data", $d);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}

	function _route(){
	}

	function list(){
		$data = Category::findAll();
		$this->assign("data", $data);
		$contents[] = $this->cache("table");
		$this->show($contents);
	}

	function save($data = array()){
		$category = Category::find(['id'	=>['eq'	=>	_P("id")]]);
		$category = $category? $category: new Category;
		$category->name = _P("name");
		$category->image = _P("image");
		$category->updated = strtotime('now');
		$category->parent = _P("parent_id")? _P("parent_id"):0;
		try{
			$category->save();
			$this->response['status'] = 1;
			$this->response['message']	= "Success";
			$this->json_return();
		}catch(Exception $e){
			$this->json_return($e->getMessage());
		}
	}

}
?>