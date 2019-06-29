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
	public $for_sale;
	public $enabled;
	public $in_stock;
	public $review_open;
	public $short_description;

	const _table = "product";

	static function _table(){
		return "product";
	}

	function __construct(){
		//parent::__construct();
	}

	function save($update = false){
		$same = Product::find(['sku'	=>	['eq'	=>	$this->sku]]);
		if($same && !$this->id && $update === true){
			$this->id = intval($same['id']);
		}
		return parent::save();
	}

	function getLink(){
		return HOME . "product?id=".$this->id;
	}

	function getTitle(){
		return $this->name;
	}

	function getShortdescription(){
		return $this->short_description;
	}

	function getPrice($qty = 1){

		return number_format($this->price * $qty, 2, '.', '');
	}

	function getTax($qty = 1){
		$taxrate = 0.08;
		return number_format($this->price * $taxrate * $qty, 2, '.', '');
	}
	
	function getDiscount($qty = 1){
		$discount = 0.5;
		return number_format($discount * $qty, 2, '.', '');
	}

	static function getCurrency(){
		return "$";
	}

	static function format_price($price){
		return number_format($price, 2, '.', '');
	}

	function getDescription(){
		return $this->description;
	}

	function getFeature(){		
		$feature = new Product_feature();
		return $feature->findAll(['product_id' => ['eq'	=>	$this->id]]);
	}


	function getAttributes(){		
		$Product_attribute = new Product_attribute();
		return $Product_attribute->findAll(['product_id' => ['eq'	=>	$this->id]]);
	}

	function getReview(){
		$ReflectionClass = new ReflectionClass("Product_Review");
		$data = $ReflectionClass
				->newInstanceWithoutConstructor()
				->findAll(['product_id'	=>	['eq'	=>	$this->id]], ["ORDER BY" => ["timestamp DESC", "parent_id ASC"]]);
		if($data){
			foreach ($data as $k => $v) {
				$r = $ReflectionClass
				->newInstanceWithoutConstructor()->build($v);
				$r->getUser();
				$reviews[] = $r;
			}
			return $reviews;
		}
		return false;
	}

	function getImages(){
		$product_image = new Product_Image();
		return $product_image->findAll(['product_id' => ['eq'	=>	$this->id]]);
	}

	function getThumbnail(){
		$product_image = new Product_Image();
		$res = $product_image->find(['product_id' => ['eq'	=>	$this->id]]);
		return $res?$res['url']: HOME . "imgs/default.jpg";
	}

	function deleteAttribute(){
		$_Model = new Product_attribute();
		$_Model->delete(['product_id'	=>	['eq'	=>	$this->id]]);
	}

	function deleteFeature(){
		$_Model = new Product_feature();
		$_Model->delete(['product_id'	=>	['eq'	=>	$this->id]]);
	}

	function deletePhoto(){
		$_Model = new Product_Image();
		$_Model->delete(['product_id'	=>	['eq'	=>	$this->id]]);
	}

	function default_img(){
		return HOME . "imgs/default.jpg";
	}

	function is_forsale(){
		return $this->for_sale == 1? true: false;
	}
}

class Product_Image extends _Model{
	public $id;
	public $product_id;
	public $url;
	const _table = "product_image";

	static function _table(){
		return "product_image";
	}

	function __construct(){
		
	}
}

class Product_attribute extends _Model{
	public $id;
	public $name;
	public $value;
	public $type;
	public $product_id;
	const _table = "product_attribute";

	static function _table(){
		return "product_attribute";
	}

	function __construct(){
		
	}
}

class Product_feature extends _Model{
	public $id;
	public $name;
	public $value;
	public $type;
	public $product_id;

	const _table = "product_feature";

	static function _table(){
		return "product_feature";
	}

	function __construct(){
		
	}
}
class Product_Review extends _Model{
	public $id;
	public $rate;
	public $parent_id;
	public $content;
	public $user_id;
	public $timestamp;
	public $product_id;
	const _table = "product_review";

	static function _table(){
		return "product_review";
	}

	function getUser(){
		$ReflectionClass = new ReflectionClass("User");
		$data = $ReflectionClass
				->newInstanceWithoutConstructor()
				->find(['id'	=>	['eq'	=>	$this->user_id]]);
		if($data){
			$this->user = $ReflectionClass
				->newInstanceWithoutConstructor()->build($data);
		}else{			
			$this->user = $ReflectionClass
				->newInstanceWithoutConstructor()->build([]);
		}
	}

	function getRate(){
		return $this->rate . ' star';
	}

	function getContent(){
		return $this->content;
	}

	function __construct(){
		
	}
}