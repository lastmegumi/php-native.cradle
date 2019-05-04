<?php
function rid($length = 4){
	return '_' . random($length);
}

function random($length = 4)
{
    return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
}

function getheader(){
    if(!defined("HEADER_LOADED")):
    define("HEADER_LOADED", true);
    endif;
    $f = GPATH ."/temp/header.php";
    if(file_exists($f)){
        include_once $f;
    }
}

function getnav(){
    if(!defined("HEADER_LOADED")){
        return;
    }
    $f = GPATH ."/temp/head_nav.php";
    if(file_exists($f)){
        include_once $f;
    }
}

function getfooter(){
    if(!defined("HEADER_LOADED") || !HEADER_LOADED){
        return;
    }
    $f = GPATH ."/temp/footer.php";
    if(file_exists($f)){
        include_once $f;
    }
}

function getfonts($fm = null){

$font_family = array(
	"黑体" 	=> "SimHei",
	"宋体" 	=> "SimSun",
	"新宋体" 	=> "NSimSun",
	"仿宋" 	=> "FangSong",
	"楷体" 	=> "KaiTi",
	"仿宋_GB2312" 	=> "FangSong_GB2312",
	"楷体_GB2312" 	=> "KaiTi_GB2312",
	"微软雅黑体" 	=> "Microsoft YaHei",

	"隶书" 	=> "LiSu",
	"幼圆" 	=> "YouYuan",
	"华文细黑" 	=> "STXihei",
	"华文楷体" 	=> "STKaiti",
	"华文宋体" 	=> "STSong",
	"华文中宋" 	=> "STZhongsong",
	"华文仿宋" 	=> "STFangsong",
	"方正舒体" 	=> "FZShuTi",
	"方正姚体" 	=> "FZYaoti",
	"华文彩云" 	=> "STCaiyun",
	"华文琥珀" 	=> "STHupo",
	"华文隶书" 	=> "STLiti",
	"华文行楷" 	=> "STXingkai",
	"华文新魏" 	=> "STXinwei",
	);

	$font_arr = array(array("name" => "Times New Roman", "value" => "Times New Roman"),
					  array("name" => "Arial" ,			 "value" =>  "Arial"));
	ob_start();
	foreach ($font_family as $k => $v) {
		echo $fm == $k && !is_null($fm)?'<option value="'.$v.'" selected>'.$k.'</option>':'<option value="'.$v.'">'.$k.'</option>' ;
		# code...
	}
	return ob_get_clean();
}

function checkRemoteFile($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);
    if($result !== FALSE)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function ReURL($url = null, $domain = null){
    if(!$url && !$domain){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}

// function  mycar(){
//     if($_SESSION['currentcar']['set']){
//         return $_SESSION['currentcar']['year'] . ' ' . $_SESSION['currentcar']['make'] . ' ' . $_SESSION['currentcar']['model'] . ' ' . $_SESSION['currentcar']['trim'];
//     }
//     return false;
// }

function check_phone($phone = null){
       $reg = '/^(?:1(?:\D)?)?(?:\((?=\d{3}\)))?(?P<p1>[0-9]\d{2})(?:(?<=\(\d{3})\))?(\D{1,2})?(?:(?<=\d{2})\D)?(?P<p2>[0-9]\d{2})\D?(?P<p3>\d{4})/';
       $is_match = preg_match($reg, $phone, $matches);
           if($is_match){
                return $matches['p1'] . $matches['p2']. $matches['p3'];
           }
       return false;
    }

function check_ssn($str = null){
       $reg = '/^(?P<s1>[0-9]{3})\-?(?P<s2>[0-9]{2})\-?(?P<s3>[0-9]{4})$/';
       $is_match = preg_match($reg, $str, $matches);
           if($is_match){
                return $matches['s1'] . $matches['s2']. $matches['s3'];
           }
       return false;
    }

function _P($v = null){
    if(isset($_POST[$v])){
        
        return htmlspecialchars(trim($_POST[$v]), ENT_QUOTES);
    }else{
        return null;
    }
    return null;
}

function _G($v = null){
    if(isset($_GET[$v])){
        
        return htmlspecialchars(trim($_GET[$v]), ENT_QUOTES);
    }else{
        return null;
    }
    return null;
}

function _F($v = null){
    if(isset($v)){
        
        return htmlspecialchars(trim($v), ENT_QUOTES);
    }else{
        return null;
    }
    return null;
}

function _U($i = 0){
    $s = array_filter(explode('/', $_SERVER["REQUEST_URI"]));
    if($s){
        $s[count($s)] = @explode("?", $s[count($s)])[0];
    }
    if(!$i){return $s;}
    if($s){return @$s[$i];}
    else return false;
}

function _H($url){
    header("Location:" . $url);
    exit;
}

if(_G('lan')){
    switch (_G('lan')) {
        case 'US-en':
        case "ZH-cn":
            define("LAN", _G('lan'));
            $_SESSION['lan'] = LAN;
        default:
            break;
    }
}elseif (isset($_SESSION['lan'])) {
    define("LAN", $_SESSION['lan']);
}else{
    define("LAN", 'US-en');
}

if(defined('LAN') && file_exists(GPATH . "/lib/locale/" . LAN . ".php")){
    require_once GPATH . "/lib/locale/" . LAN . ".php";
}
function _L($str){
    if(defined('LAN') && defined('TRANS')){        
        if(isset(TRANS[strtolower($str)])){
            return TRANS[strtolower($str)];
        }
    }
    return $str;
}

function _R(){
    switch($_SERVER['REQUEST_METHOD']){
        case "POST":
        case "GET":
        case "PUT":
        case "DELETE":
            return $_SERVER['REQUEST_METHOD'];break;
        default:
            break;
    }
    return false;
}

function _C($str = null){
    if(!$_SESSION['login']){return false;}
    switch ($str) {
        case 'uid':
        case 'username':
        case 'groups':
        case 'permission':
        case 'status':
        case 'sid':
        case "pid":
        case 'gid':
        case 'avatar':
        case 'agreement_checked':
            return $_SESSION['login'][$str];
            break;
        case "name":
            return $_SESSION['login']['first_name'] . ' ' . $_SESSION['login']['last_name'];
            break;
        default:    return '';
            break;
    }
}

function _S($str = null){
    return _C($str);
}

function _REF($i = null){
    if(!$i){return false;}
    $url = $_SERVER["HTTP_REFERER"];
    $urlp = parse_url($url);
    $parameterstr = @$urlp['query'];
    if(is_numeric($i)){return explode('/', $urlp['path'])[$i];}

    $paras = explode("&", $parameterstr);
    $urlq = array();
    foreach($paras as $p){
        ##array_push($urlq, array('k' => explode("=", $p)[0] , "v" => explode("=", $p)[1]));
        $urlq[explode("=", $p)[0]] = explode("=", $p)[1];
    }
}

/*
替换 url 标签
c_url_p = change url parameter
curPageURL = current url without parameter
@p 标签名
@v 标签值
*/
function c_url_p($p, $v){
    $query = $_GET;
    // replace parameter(s)
    $query[$p] = $v;
    // rebuild url
    $query_result = http_build_query($query);
    // new link
    return curPageURL() . '?' . $query_result;
}

function curPageURL() {
    $pageURL = 'http';
    if (@$_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" .
            $_SERVER["SERVER_PORT"] . str_replace( @$_SERVER['REQUEST_QUERY'], '', $_SERVER['REQUEST_URI'] );
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . str_replace( @$_SERVER['REQUEST_QUERY'], '', $_SERVER['REQUEST_URI'] );
    }
    return strtok($_SERVER["REQUEST_URI"],'?');
}

function _IP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return "#" . random_color_part() . random_color_part() . random_color_part();
}