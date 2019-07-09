<?php
define("ALLOWED_CON",['product', 'cart', 'reviews', 'mail']);
define("ALLOWED_ALL",true);
define("ROUTE_CONTROL", false);
define("SALE_ENABLED", 1);
define("ALLOWED_BACKEND", 1);

// if(file_exists(GPATH . "/page/" . $_SESSION['u'][1] .".php")){
// 	require GPATH . "/page/" . $_SESSION['u'][1] . ".php";
// 	die();
// }

define("BACKEND", "admin/");

$cons = glob(APP . "Model/" . "*.php");
foreach($cons as $c)
{
  require_once($c);
}

$cons = glob(APP . "Controller/" . "*.php");
foreach($cons as $c)
{
  require_once($c);
}
$cons = glob(PLUGIN . "*.php");
foreach($cons as $c)
{

  require_once($c);
}


if(_U(1) === "admin" && ALLOWED_BACKEND){
	define("APP_DIR" , APP . "View/Backend/");
	define("BACKEND_ACCESS", true);
	$directory = APP . "_Backend/";
}else{
	define("APP_DIR" , APP . "View/Frontend/");
	define("BACKEND_ACCESS", false);
	$directory = APP . "_Frontend/";
}

$cons = glob($directory . "*.php");
foreach($cons as $c)
{
  require_once($c);
}

Route::staticPage();

Route::route(BACKEND."/login", "_Admin.login");
Route::route(BACKEND."/logout", "_Admin.logout");
Route::verify()::route(BACKEND."/dashboard", "_Admin.dashboard");
Route::verify()::route(BACKEND."/product/list", "_Product.list");
Route::verify()::route(BACKEND."/product/edit", "_Product.edit");
Route::verify()::route(BACKEND."/product/save", "_Product.save");
Route::verify()::route(BACKEND."/product/delete", "_Product.delete");
Route::verify()::route(BACKEND."/product/upload_image", "_Product.upload_image");
Route::verify()::route(BACKEND."/product/deletePhoto", "_Product.deletePhoto");
Route::verify()::route(BACKEND."/product/backend_image_block", "_Product.backend_image_block");


Route::verify()::route(BACKEND."/category/list", "_Category.list");
Route::verify()::route(BACKEND."/category/edit", "_Category.edit");
Route::verify()::route(BACKEND."/category/save", "_Category.save");


Route::verify()::route(BACKEND."/promotion/", "_Promotion._route");
Route::verify()::route(BACKEND."/promotion/new/simple", "_Promotion.simpleform");
Route::verify()::route(BACKEND."/promotion/new/category", "_Promotion.categoryform");
Route::verify()::route(BACKEND."/promotion/new/store", "_Promotion.storeform");
Route::verify()::route(BACKEND."/promotion/edit", "_Promotion.edit");
Route::verify()::route(BACKEND."/promotion/save", "_Promotion.save");
Route::verify()::route(BACKEND."/promotion/delete", "_Promotion.delete");


Route::verify()::route(BACKEND."/order/", "_Order._route");
Route::verify()::route(BACKEND."/order/list", "_Order.list");
Route::verify()::route(BACKEND."/order/shipped", "_Order.shipped");
Route::verify()::route(BACKEND."/order/delivered", "_Order.delivered");
Route::verify()::route(BACKEND."/order/refund", "_Order.refund");
Route::verify()::route(BACKEND."/order/cancel", "_Order.cancel");

Route::verify()::route(BACKEND."/shipping/", "_Shipping._route");
Route::verify()::route(BACKEND."/invoice/", "_Invoice._route");
Route::verify()::route(BACKEND."/invoice/sendemail", "_Invoice.sendemail");

Route::verify()::route(BACKEND."/store/setting", "_Store.setting");
Route::verify()::route(BACKEND."/store/save", "_Store.save");



Route::route("/product/", "_Product._route");
Route::route("/product/list", "_Product.list");
Route::route("/product/product", "_Product.product");

Route::route("/reviews/", "_Reviews._route");
Route::route("/cart/add", "_Cart.add");
Route::route("/cart/remove", "_Cart.remove");
Route::route("/cart/mycart", "_Cart.mycart");
Route::route("/cart/get", "_Cart.get");
Route::route("/cart/reload", "_Cart.reload");

Route::route("/checkout/", "_Checkout._route");
Route::route("/checkout/placeorder", "_Checkout.placeorder");

Route::route("/login", "_User.login");
Route::route("/logout", "_User.logout");
Route::route("/user/verify", "_User.verify");
Route::route("/register", "_User.register");
Route::route("/register_new", "_User.register_new");

Route::route("/store/", "_Store._route");

Route::route("/user/dashboard/", "_User.dashboard");
Route::route("/user/dashboard/orders", "_User.dashboard");
Route::route("/user/dashboard/reviews", "_User.dashboard");
Route::route("/user/dashboard/profile", "_User.dashboard");
Route::route("/user/dashboard/invoice", "_User.dashboard");
Route::route("/user/dashboard/changepassword", "_User.dashboard");

Route::not_found();

class Route{
	static $routed = false;

	private function __construct(){
		if(self::routed){
			return;
		}
	}

	static function Request(){
		return _U(1);
	}

	function __toString(){

	}

	static function verify(){
		if(self::$routed){
			return @Route;}
		if(BACKEND_ACCESS && !_Admin::isloggedin()){
			//self::view("_Admin.login");
			_H(HOME . "admin/login");
		}
		return @Route;
	}

	static function view($str, $arg = null){
		$c = explode('.', $str)[0];
		$con = new $c();
		$met = explode('.', $str)[1];
		$con->$met();
	}

	static function staticPage(){		
		$uri_arr = array_values(array_filter(explode('/', strtok($_SERVER["REQUEST_URI"],'?'))));
		if(@$uri_arr[0]){
			$page = Page::find(['url'	=>	['eq'	=>	$uri_arr[0]]]);
			if($page){
				_Page::showPage($page);
				unset($page);
				self::$routed = true;
				die();
			}
		}else{
			_Page::showPage();
				self::$routed = true;
			die();
		}
	}

	static function route($uri, $str = null){
		if(self::$routed){return;}
		$uri_arr = array_values(array_filter(explode('/', strtok($_SERVER["REQUEST_URI"],'?'))));
		$route_arr = array_values(array_filter(explode('/', $uri)));
		if($uri_arr != $route_arr){return;}

		$arr = explode('.', $str);
		$_c = $arr[0];
		$_m = @$arr[1] === '*'? $uri_arr[count($uri_arr) - 1] : $arr[1];

		if(class_exists($_c)){
			$con = new $_c();
			if(@method_exists($con, $_m)){

				$reflection = new ReflectionMethod($con, $_m);
			    if (!$reflection->isPublic()) {
			       //_Page::Page_Not_Found();
			       die();
			    }

				$con->$_m();
				if(_R() == "GET" && !isset($_GET['form'])):
					getfooter();
				endif;
				die();
			}elseif(method_exists($con,"_route")){
				$con->_route(@urldecode($_m()));
				if(_R() == "GET" && !isset($_GET['form'])):
					getfooter();
				endif;
				die();
			}
			self::$routed = true;
		}

	}

	static function basic(){
		if(!_U()){
			_Page::showPage();
			die();
		}

		if(!defined("BACKEND")):
			
		endif;

		if(class_exists("_"._U($_u))){
			$n = "_"._U($_u);
			$con = new $n();
			if(@method_exists($con,_U($_u + 1))){

				$reflection = new ReflectionMethod($con, _U($_u + 1));
			    if (!$reflection->isPublic()) {
			       //_Page::Page_Not_Found();
			       die();
			    }

				$func = _U()[$_u + 1];
				$con->$func();
				if(_R() == "GET" && !isset($_GET['form'])):
					getfooter();
				endif;
				die();
			}elseif(method_exists($con,"_route")){
				$con->_route(@urldecode(_U($_u + 1)));
				if(_R() == "GET" && !isset($_GET['form'])):
					getfooter();
				endif;
				die();
			}
			self::$routed = true;
		}
	}

	static function not_found(){
		if(self::$routed){return;}
		//_Page::Page_Not_Found();
	}
}
?>