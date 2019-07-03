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
	$directory = APP . "_Backend/";
}else{
	define("APP_DIR" , APP . "View/Frontend/");
	$directory = APP . "_Frontend/";
}

$cons = glob($directory . "*.php");
foreach($cons as $c)
{
  require_once($c);
}


// if(!in_array(_U($_u), ALLOWED_CON) && ROUTE_CONTROL){
// 	//_Page::Page_Not_Found();
// 	die();
// }


Route::staticPage();

Route::route(BACKEND."/dashboard", "_User.dashboard");
Route::route(BACKEND."/product/list", "_Product.list");
Route::route(BACKEND."/product/edit", "_Product.edit");
Route::route(BACKEND."/product/save", "_Product.save");
Route::route(BACKEND."/product/delete", "_Product.delete");
Route::route(BACKEND."/product/upload_image", "_Product.upload_image");
Route::route(BACKEND."/product/deletePhoto", "_Product.deletePhoto");
Route::route(BACKEND."/product/backend_image_block", "_Product.backend_image_block");


Route::route(BACKEND."/order/", "_order._route");
Route::route(BACKEND."/order/list", "_Order.list");
Route::route(BACKEND."/order/shipped", "_Order.shipped");
Route::route(BACKEND."/order/delivered", "_Order.delivered");
Route::route(BACKEND."/order/refund", "_Order.refund");
Route::route(BACKEND."/order/cancel", "_Order.cancel");

Route::route(BACKEND."/shipping/", "_Shipping._route");
Route::route(BACKEND."/invoice/", "_Invoice._route");
Route::route(BACKEND."/invoice/sendemail", "_Invoice.sendemail");



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
		print_r(self::$routed);
		if(self::$routed){return;}
		//_Page::Page_Not_Found();
	}
}
?>