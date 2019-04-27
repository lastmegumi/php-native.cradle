<?php
$directory = APP;
$cons = glob($directory . "/*.php");

foreach($cons as $c)
{
  require_once($c);
}

if(!_U()){
	require GPATH . "/page/index.php";
	die();
}
if(class_exists("_"._U(1))){
	$n = "_".$_SESSION['u'][1];
	$con = new $n();
	if(@method_exists($con,_U(2))){
		$func = _U()[2];
		$con->$func();
		if(_R() == "GET" && !isset($_GET['form'])):
			getfooter();
		endif;
		die();
	}elseif(method_exists($con,"_route")){
		$con->_route(@urldecode(_U(2)));
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