<?php
class Category extends _Model{
	public $id;
	public $name;
	public $iamge;
	public $created;
	public $updated;
	public $parent;

	protected function _table(){
		return "category";
	}

	function __construct(){
		
	}
}