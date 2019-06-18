<?php
class _Reviews extends _Base{
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
	}

	function _route(){

		if(_R() == "GET"):
			$product_id = _G("product_id");
			$reviews = new Product_Review();
			$data = $reviews->findAll(['product_id'	=>	['eq'	=>	$product_id]]);
			$this->response['status']	=	1;
			$this->response['message']	=	"successful";

			$ReflectionClass = new ReflectionClass("Product_Review");
			$data = $ReflectionClass
					->newInstanceWithoutConstructor()
					->findAll(['product_id'	=>	['eq'	=>	$product_id]]);


			foreach ($data as $k => $v) {
				$c = $ReflectionClass->newInstanceWithoutConstructor()->build($v);		
				$this->response['data'][]	=	$this->Build_Json($c);
			}
				$this->response['product_id']	=	$product_id;
			$this->json_return();
		endif;

		if(_R() == "POST"):
			$review = new Product_Review();
			$review->content = _P("content");
			$review->product_id = _P("product_id");
			$review->rate = _P("rate")? intval(_P("rate")): 5;
			$review->parent_id = _P("parent_id")? intval(_P("parent_id")): 0;
			$review->user_id = _P("user_id")? intval(_P("user_id")): 0;
			$review->timestamp = strtotime("now");
			$review->save();
		endif;
	}
	

	function Build_Json($data){
		return array("id"	=>	intval($data->id),
					 "rate"	=>	intval($data->rate),
					 "date"	=>	date("Y-m-d H:i:s", $data->timestamp),
					 "user"	=>	_User::open_data($data->user_id),
					 "content"	=>	$data->content
			);
	}

}
?>