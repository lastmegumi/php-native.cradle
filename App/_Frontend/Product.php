<?php
class _Product extends _Base{
	protected $_attr = ["id", "name", "description", "sku", "price", "for_sale", "category_ids", "stock", "seller", "bundle", "related", "updated"];
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

	function _route(){
		// $category = new _Category();
		// $c =  $category->findAll(['status'	=>	["eq" => 0]]);
		// $this->assign("category",$c);
		$product = new Product();
		$id = _G("id");
		$d = $product->find(['id'	=>	["eq" => $id]]);
		if(!$d){$this->err_404();return;}
		$product->build($d);

		$breadcamp[] = array("title"	=>	"Home",	"url"	=>	HOME);
		$breadcamp[] = array("title"	=>	"Product",	"url"	=> "/product/list");
		$breadcamp[] = array("title"	=>	$product->name);
		_Page::init()->assign("breadcamp", $breadcamp);
		$contents[] = _Page::init()->cache("block/breadcamp");

		$this->assign("product", $product);
		$contents[] = $this->cache('view');
		$this->show($contents);
	}

	function product(){
		$data = Product::findAll();
		$arr = [];
		$ReflectionClass = new ReflectionClass("Product");
		$filter = ['enabled'	=>	['eq'	=>	1]];
		//$filter = [];
		$data = $ReflectionClass
				->newInstanceWithoutConstructor()
				->findAll($filter);

		foreach ($data as $k => $v) {
			$c = $ReflectionClass->newInstanceWithoutConstructor()->build($v);
			$table_data[] = array("id"		=>	intval($c->id),
								  "name"	=>	$c->name,
								  "price"	=> 	array("currency"	=>	$c->getCurrency(),
								  				"amount"	=>	floatval($c->price)),
								  "url"		=>	HOME . "product?id=" . $c->id,
								  "forsale"	=>	$c->for_sale?true:false,
								  "thumbnail"	=> $c->getThumbnail(),
								);
		}
		$this->response['items']	=	$table_data;
		$this->json_return();
	}

	function list(){
		$ReflectionClass = new ReflectionClass("Product");
		$data = $ReflectionClass
				->newInstanceWithoutConstructor()
				->findAll(['enabled'	=>	['eq'	=>	1]]);


		foreach ($data as $k => $v) {
			$c = $ReflectionClass->newInstanceWithoutConstructor()->build($v);
			$c->getThumbnail();
			$table_data[] = $c;
		}


		$breadcamp[] = array("title"	=>	"Home",	"url"	=>	HOME);
		$breadcamp[] = array("title"	=>	"Product",	"url"	=> "/product/list");
		_Page::init()->assign("breadcamp", $breadcamp);
		$contents[] = _Page::init()->cache("block/breadcamp");

		$contents[] = $this->cache("action_bar");		
		$this->assign("data", $table_data);
		$contents[] = $this->cache("grid_view");
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