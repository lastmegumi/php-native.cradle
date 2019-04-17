<?php
require "../lib/config.php";
$uri = strtok($_SERVER["REQUEST_URI"],'?');
$_SESSION['u'] = array_filter(explode("/",$uri));

if(_G("form") == "agreement_front"):
    else:
if(!@$_SESSION['login']['uid']){
	$user = new _User();
	if(_R() == "POST"){
		$user->login();die();}
	$user->render("login.php");
	die();
}
endif;

if(!$_SESSION['u']){
	require GPATH . "/page/index.php";
	die();
}
switch ($_SESSION['u'][1]) {
	case 'api':
		require_once GPATH . "/Api/index.php";
		echo '123';
		die();
		# code...
		break;	
	default:
		# code...
		break;
}
if(class_exists("_".$_SESSION['u'][1])){
	$n = "_".$_SESSION['u'][1];
	$con = new $n();
	if(@method_exists($con,$_SESSION['u'][2])){
		$func = $_SESSION['u'][2];
		$con->$func();
		if(_R() == "GET" && !isset($_GET['form'])):
			getfooter();
		endif;
		die();
	}elseif(method_exists($con,"_route")){
		$con->_route(@urldecode($_SESSION['u'][2]));
		if(_R() == "GET" && !isset($_GET['form'])):
			getfooter();
		endif;
		die();
	}
}
if(file_exists(GPATH . "/page/" . $_SESSION['u'][1] .".php")){
	require GPATH . "/page/" . $_SESSION['u'][1] . ".php";
	die();
}
$con = new _controller;
$con->display("404.php");
die();
?>
