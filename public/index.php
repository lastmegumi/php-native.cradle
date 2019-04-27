<?php
require "../lib/config.php";
$uri = strtok($_SERVER["REQUEST_URI"],'?');
$_SESSION['u'] = array_filter(explode("/",$uri));

require_once APP . "route.php";
$con = new _controller;
$con->display("404.php");
die();
?>
