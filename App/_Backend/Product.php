<?php
class _Product extends _Base{
	protected $_attr = ["id", "name", "description", "sku", "price", "for_sale","short_description", "enabled", "in_stock", "category_ids", "stock", "seller", "bundle", "related", "updated"];
	protected $_table = "product";
	private $main_key = "id";
	public $template_dir = "product";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		parent::__construct();
		$name = "Product";
		$this->template_dir = APP_DIR . "view/".$name."/";
		$this->model = new Product();
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$category = new Category();
		$c =  Category::findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category",$c);
		$product = new Product();
		$this->assign("data", $product);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}


	function edit(){
		$c =  Category::findAll(['status'	=>	["eq" => 0]]);
		$this->assign("category",$c);
		$d = Product::find(['id'	=>	["eq" => _G('id')]]);
		$this->assign("data", $d);
		$contents[] = $this->cache('form');
		$this->show($contents);
	}

	function _route(){
	}

	function list(){
		$page_size = 20;
		$page_index = _G("page") && is_numeric(_G("page")) ? _G("page") - 1 : 0;
		$options = ['class'	=>	true, 
					'order by'	=>	['id DESC'], 
					'limit'	=>	$page_index * $page_size . ',' . $page_size];

		$data = Product::findAll([], $options);
		$total = Product::total();

		$contents[] = $this->cache("action_bar");
		$this->assign("data", $data);
		$contents[] = $this->cache("table");


		$pages	=	intval(($total + $page_size - 1) / $page_size );

		$this->assign("index", $page_index + 1);
		$this->assign("pages", $pages);
		$this->assign("total", $total);
		$contents[] = $this->cache("pages");
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
			if($product->id){
				$id = $product->id;
			}else{
				$this->response['url']	=	"edit?id=". $id;				
			}

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

			$feature = new Product_feature();
			$features = $_POST['feature'];
			if(true):
				$feature->deleteAll(['product_id' => ['eq'	=>	$product->id]]);
				foreach ($features as $k => $v) {				
					if(!_F($v['name'])){continue;}
					$feature->build(array("product_id"	=>	$id,
											   "name"		=>	_F($v['name']),
											   "value"		=>	_F($v['value']),
											   "type"		=>	"text",
												));
					$feature->save();
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
			$this->response['status']	=	1;
			$this->response['message']	=	"success";
			$this->json_return();
		}catch(Exception $e){			
			_DB::init()->conn->rollBack();
			$this->json_return($e->getMessage());
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

	function deletePhoto(){
		$id = $this->_DELETE["data_id"];
		$img = new Product_Image();
		$res = Product_Image::find(["id"	=>	['eq'	=>	$id]]);
		if($res){ $img->build($res);}
		$img->delete(["id"	=>	['eq'	=>	$img->id]]);
		_Image::remove(str_replace(HOME, "", $img->url));
	}

	function delete(){
		$id = $this->_DELETE["data_id"];
		$product = new Product();
		$res = Product::find(['id'	=>	['eq'	=>	$id]]);
		if(!$res){return;}
		$product->build($res);

		try{
			_DB::init()->conn->beginTransaction();
			$product->deleteAttribute();
			$product->deleteFeature();
			$product->deletePhoto();
			$res = $product->delete();	
			_DB::init()->conn->commit();

			$this->response['url']	=	HOME . "admin/product/list";
			$this->response['status']	=	1;
			$this->json_return();
		}catch(Exception $e){
			_DB::init()->conn->rollBack();
			$this->json_return("Error on delete product");
		}
	}

	function backend_image_block($images){		
		$this->assign("data", $images);
		echo $this->cache("backend_image");
	}
}
?>
