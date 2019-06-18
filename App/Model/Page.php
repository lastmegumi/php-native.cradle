<?php
class Page extends _Model{
	public $id;
	public $title;
	public $url;
	public $updated;
	public $sort;

	const _table = "cms";
	

	static function _table(){
		return "cms";
	}

}
