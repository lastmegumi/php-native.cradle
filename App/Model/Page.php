<?php
class Page extends _Model{
	public $id;
	public $title;
	public $url;
	public $updated;
	public $sort;
	

	protected function _table(){
		return "cms";
	}

}
