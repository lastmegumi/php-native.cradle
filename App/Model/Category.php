<?php
class Category extends _Model{
	public $id;
	public $name;
	public $iamge;
	public $created;
	public $updated;
	public $parent;

	const _table = "category";

	static function _table(){
		return "category";
	}

	function getName(){
		return $this->name;
	}

	function __construct(){
		
	}
}