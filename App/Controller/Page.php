<?php
class _Page extends _Base{
	protected $_attr = ["id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "Cart";
	private $main_key = "id";
	public $template_dir = "Cart";
	public $title;
	public $imgs;
	public $price;


	private static $instance = null;

	function __construct(){
		$name = "Page";
		@$this->template_dir = APP_DIR . "view/" . $name . '/';
	}

	public function __clone(){
        //throw error
        trigger_error("Can't clone object",E_USER_ERROR);
    }    
    
	public static function init()
	{
		if (self::$instance == null)
		{
		  self::$instance = new _Page();
		}
		return self::$instance;
	}

	static function showPage($page = null){
		if(!$page){
			$temp = "Page/index";
			$contents[] = self::init()->cache("index/slide");
			$contents[] = self::init()->cache("index/new_arrival");
			parent::show($contents, $temp);
		}else{
			$breadcamp[] = array("title"	=>	"Home",	"url"	=>	HOME);
			$breadcamp[] = array("title"	=>	$page->title,	"url"	=> $page->url);
			self::init()->assign("breadcamp", $breadcamp);
			$contents [] = self::init()->cache("block/breadcamp");
			$contents[] = self::init()->cache($page->url);
			parent::show($contents);
		}
	}

	static function Block($block = null, $arguments = null){
		if(!$block){
		}else{
			echo self::init()->cache($block);
		}
	}

	static function Page_Not_Found(){
		parent::err_404();
	}

	static function Page_Not_Authorized(){
		parent::error(401);
	}
}
?>