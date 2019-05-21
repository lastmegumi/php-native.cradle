<?php
if(_U(1) === "admin"){
	define("APP_DIR" , APP. "_Backend/");
	$directory = APP_DIR;
	$_u = 2;
}else{
	define("APP_DIR" , APP. "_Frontend/");
	$directory = APP_DIR;
	$_u = 1;
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
	require GPATH . "/page/index.php";
	die();
}

if(class_exists("_"._U($_u))){
	$n = "_"._U($_u);
	$con = new $n();
	if(@method_exists($con,_U($_u + 1))){
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
?>