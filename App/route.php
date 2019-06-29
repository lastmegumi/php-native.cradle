<?php
define("ALLOWED_CON",['product', 'cart', 'reviews', 'mail']);
define("ALLOWED_ALL",true);
define("ROUTE_CONTROL", false);
define("SALE_ENABLED", 1);
define("ALLOWED_BACKEND", 1);

if(_U(1) === "admin" && ALLOWED_BACKEND){
	define("BACKEND", "admin/");
	define("APP_DIR" , APP. "_Backend/");
	$directory = APP_DIR;
	$_u = 2;
}else{
	define("APP_DIR" , APP. "_Frontend/");
	$directory = APP_DIR;
	$_u = 1;
}


$cons = glob(APP . "Model/" . "*.php");
foreach($cons as $c)
{
  require_once($c);
}

$cons = glob($directory . "*.php");
foreach($cons as $c)
{
  require_once($c);
}
$cons = glob(PLUGIN . "*.php");
foreach($cons as $c)
{

  require_once($c);
}

if(!_U()){
	_Page::showPage();
	die();
}

if(!defined("BACKEND")):
if(_U(1)){
	$p = new Page();
	$page = $p->find(['url'	=>	['eq'	=>	_U(1)]]);
	if($page){
		$p->build($page);
		_Page::showPage($p);
		unset($p);
		die();
	}
}

if(!in_array(_U($_u), ALLOWED_CON) && ROUTE_CONTROL){
	_Page::Page_Not_Found();
	die();
}
endif;


if(class_exists("_"._U($_u))){
	$n = "_"._U($_u);
	$con = new $n();
	if(@method_exists($con,_U($_u + 1))){

		$reflection = new ReflectionMethod($con, _U($_u + 1));
	    if (!$reflection->isPublic()) {
	       _Page::Page_Not_Found();
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
}

// if(file_exists(GPATH . "/page/" . $_SESSION['u'][1] .".php")){
// 	require GPATH . "/page/" . $_SESSION['u'][1] . ".php";
// 	die();
// }

class Route{

	private function __construct(){

	}

	static function Request(){
		return strtolower(_U(1));
	}

	function __toString(){

	}
}
?>