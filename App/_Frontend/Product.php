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
	}

	function _route(){
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
		$page_size = 12;
		$page_index = _G("page") && is_numeric(_G("page")) ? _G("page") - 1 : 0;

		$filter = ['enabled'	=>	['eq'	=>	1]];
		//$filter = [];
		$options = ['limit'	=> $page_index * $page_size . ',' . $page_size,
					'class'	=>	true];
		$data = Product::findAll($filter, $options);

		$options['field']	=	['id'];
		$total = Product::total($filter, ['filed'	=>	['id']]);

		foreach ($data as $k => $c) {
			$table_data[] = array("id"		=>	intval($c->id),
								  "name"	=>	$c->name,
								  "price"	=> 	array("currency"	=>	$c->getCurrency(),
								  					  "amount"	=>	$c->getPrice()),
								  "url"		=>	HOME . "product?id=" . $c->id,
								  "seller"	=>	["name"	=>	$c->getSeller()->Name(), "url"	=>	$c->getSeller()->getLink()],
								  "forsale"	=>	$c->for_sale?true:false,
								  "thumbnail"	=> $c->getThumbnail(),
								);
		}
		$this->response['items']	=	$table_data;
		$this->response['page_index']	=	$page_index + 1;
		$this->response['pages']	=	intval(($total + $page_size - 1) / $page_size );
		$this->response['total']	=	$total;

		$this->json_return();
	}

	function list(){
		$breadcamp[] = array("title"	=>	"Home",	"url"	=>	HOME);
		$breadcamp[] = array("title"	=>	"Product",	"url"	=> "/product/list");
		_Page::init()->assign("breadcamp", $breadcamp);
		$contents[] = _Page::init()->cache("block/breadcamp");
		$contents[] = $this->cache("action_bar");
		$contents[] = $this->cache("grid_view");
		$this->show($contents);
	}
}
?>