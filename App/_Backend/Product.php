<?php
class Product extends _Model{
	public $id;
	public $name;
	public $description;
	public $sku;
	public $price;
	public $category_ids;
	public $stock;
	public $seller;
	public $bundle;
	public $related;
	public $updated;

	protected function _table(){
		return "product";
	}

	function __construct(){
		
	}

}

class _Product extends _Base{
	protected $_attr = ["id", "name", "description", "sku", "price", "category_ids", "stock", "seller", "bundle", "related", "updated"];
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
		if(@$_POST['categorys']){
			$data['category_ids'] = implode(',', @$_POST['categorys']);
		}
		try{
			_DB::init()->conn->beginTransaction();
			$product = new Product();
			$product->build($data)->save();
			_DB::init()->conn->commit();
		}catch(Exception $e){			
			_DB::init()->conn->rollBack();
			echo $e->getMessage();
		}
	}

}
?>