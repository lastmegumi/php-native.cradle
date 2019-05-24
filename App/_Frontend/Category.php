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
		$this->model = new Product();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
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
		$sql = "SELECT {$this->_table}.* FROM {$this->_table}
				WHERE 1";
		$data = array();
		$data = _DB::init()->select($data, $sql);
		$header = $this->_attr;
		foreach ($data as $k => $v) {
			$c = [];
			foreach ($header as $k2 => $v2) {
				$c[$v2]	=	@$v[$v2];
			}
			$table_data[] = $c;
		}
		$contents[] = $this->cache("action_bar");
		
		$this->assign("header", $header);
		$this->assign("data", $table_data);
		$this->assign("name", $this->_table);
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