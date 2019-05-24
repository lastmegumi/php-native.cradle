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

	function getTitle(){
		return $this->name;
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

	function getCurrency(){
		return "$";
	}

	function getDescription(){
		return $this->description;
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

	function default_img(){
		return HOME . "imgs/default.jpg";
	}
}

class Product_Image extends _Model{
	public $id;
	public $product_id;
	public $url;

	protected function _table(){
		return "product_image";
	}

	function __construct(){
		
	}
}