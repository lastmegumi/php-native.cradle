<?php
class MSG{

	static function add($string){
		if(!$string){return;}
		$_SESSION['message'][] = $string;
	}

	static function get(){
		if(is_array($_SESSION['message']) && $_SESSION['message']){
			return array_pop($_SESSION['message']);
		}
		return false;
	}

	static function clear(){
		unset($_SESSION['message']);
	}
}
?>