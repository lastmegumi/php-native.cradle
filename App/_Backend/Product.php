<?php
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
		$product = new Product();
		$this->assign("data", $product);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}


	function edit(){
		$category = new _Category();
		$c =  $category->findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category",$c);
		$product = new Product();		
		$d = $product->find(['id'	=>	["eq" => _G('id')]]);
		$this->assign("data", $product->build($d));
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
			$id = $product->build($data)->save();
			$id = $product->id?  $product->id:$id;
			$product_attr = new Product_attribute();
			$product_attrs = $_POST['attributes'];
			if($product_attrs):
				$product_attr->deleteAll(['product_id' => ['eq'	=>	$product->id]]);
				foreach ($product_attrs as $k => $v) {				
					if(!_F($v['name'])){continue;}
					$product_attr->build(array("product_id"	=>	$id,
											   "name"		=>	_F($v['name']),
											   "value"		=>	_F($v['value']),
											   "type"		=>	"text",
												));
					$product_attr->save();
				}
			endif;
			_DB::init()->conn->commit();

			if(@$_POST['images']):
				$ori= new Product_Image();
				$ori->deleteAll(['product_id' => ['eq'	=>	$product->id]]);
			foreach ($_POST['images'] as $k => $v) {
				$pi = new Product_Image();
				$pi->build(array("product_id" => $id, "url"	=> $v));
				$pi->save();
			}
			endif;

			if(@$data['images']):
			foreach ($data['images'] as $k => $v) {
				$fn = _Image::Save_From_URL($v);
				$pi = new Product_Image();
				$pi->build(array("product_id" => $id, "url"	=> HOME . "uploads/" . $fn));
				$pi->save();
			}
			endif;
		}catch(Exception $e){			
			_DB::init()->conn->rollBack();
			echo $e->getMessage();
		}
	}

	function import($datalist = []){
		foreach ($variable as $key => $value) {
			$this->save($value);
		}
	}

	function upload_image(){
		$images = _Image::save_from_upload();
		$this->backend_image_block($images);
	}

	function backend_image_block($images){		
		$this->assign("data", $images);
		echo $this->cache("backend_image");
	}
}
?>
