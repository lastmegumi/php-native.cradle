<?php
class Store extends _Model{
	public $id;
	public $name;
	public $logo;
	public $logo_small;
	public $description;
	public $status;
	public $type;
	public $created;
	public $updated;
	public $owner;

	const _table = "store";

	function __construct(){
		
	}

	static function _table(){
		return "store";
	}

	function small_logo(){
		return $this->logo_small? $this->logo_small:"";
	}

	function Name(){
		return $this->name? $this->name:"";
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


class Platform{

	static function Name(){
		return "tempest-freezer";
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