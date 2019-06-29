<?php
class Store extends _Model{
	public $id;
	public $name;
	public $phone1;
	public $phone2;
	public $email1;
	public $email2;

	const _table = "store";

	function __construct(){
		
	}

	static function _table(){
		return "store";
	}

	static function Name(){
		return "Tempest Freezer";
	}
	static function Email(){
		return "info@tempest-freezer.com";
	}
	static function Phone(){
		return "(800) 900-200-333";
	}
	static function Address(){
		return "117 Industrial Avenue Hasbrouck Heights NJ 07604";
	}

}
