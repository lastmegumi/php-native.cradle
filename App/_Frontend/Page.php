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
		$this->template_dir = APP_DIR . "view/" . $name . '/';
	}

	public function __clone(){
        //throw error
        trigger_error("Can't clone object",E_USER_ERROR);
    }    

	//public static function getInstance()
	public static function init()
	{
		if (self::$instance == null)
		{
		  self::$instance = new _Page();
		}
		return self::$instance;
	}

	static function showPage($temp = null){
		$temp = !$temp? "page/index": $temp;
		$contents[] = self::init()->cache("slide");
		parent::show($contents, $temp);
	}

	static function Page_Not_Found(){
		parent::err_404();
	}
}
?>