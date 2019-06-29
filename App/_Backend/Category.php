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
		$this->assign("category",$c);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}


	function edit(){
		$category = new _Category();
		$c =  $category->findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category",$c);
		$d = $this->find(['id'	=>	["eq" => _G('id')]]);
		$this->build($d);
		$this->assign("data", $this->model);
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
		foreach ($this->_attr as $k => $v) {
			if(!_P($v)){continue;}
			$data[$v] = _P($v);
		}
		$category = new category();
		$category->build($data)->save();
	}

}
?>