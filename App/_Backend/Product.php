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
			$id = $product->build($data)->save();
			_DB::init()->conn->commit();
			foreach ($data['images'] as $k => $v) {
				$fn = _Image::Save_From_URL($v);
				$pi = new Product_Image();
				$pi->build(array("product_id" => $id, "url"	=> HOME . "uploads/" . $fn));
				$pi->save();
			}
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

}

class _Image{
	static function save_from_url($url){
		$path = UF ;
		if(!file_exists($path)):	//没有文件夹创建
			mkdir($path, 0755, true);
			chmod($path, 0755);
		endif;
		$fn = random(16);
		$fl = explode('.', basename($url));
		$ext = $fl[count($fl) - 1];

		while(file_exists($path . $fn . '.' . $ext)){
			$fn = random(16);
		}
		$ori = file_get_contents($url);

		// $ori = imagecreatefromwebp($url);

		// // Convert it to a jpeg file with 100% quality
		// $ori = imagejpeg($im, './example.jpeg', 100);

		file_put_contents($path . $fn . '.' . $ext, $ori);
		return $fn . '.' . $ext;
	}

	static function save_from_upload($file){

	}

}
?>
