<?php
define("GPATH", dirname(dirname(__FILE__)));
define("APP", GPATH . "/App/");
define("HELPER", GPATH . "/Helper/");
define('HHVM_VERSION', false); 
define("IMGSERVER" , "imageserver");
#require GPATH . "/vendor/autoload.php";
$h1 =  "host1";
$h2 = "host2";
$h3 = "http://nativephp.test/";
define("HOME" , $h3);
define("UPLOAD", "uploads");
session_start();
header("Content-Type: text/html;charset=utf-8");

require_once APP . "Common/Controller.php";
require_once APP . "Common/Contents.php";
//require_once GPATH . "/lib/Db.php";
require_once GPATH . "/lib/mongodb.php";
require "function.php";

ini_set('display_errors', 'On');
error_reporting(E_ALL);
