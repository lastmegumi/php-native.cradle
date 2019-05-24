<?php
class User extends _Model{
	public $id;
	public $uname;
	public $uemail;
	public $upassword;
	public $type;
	public $status;
	public $created;
	public $updated;
	function __construct(){
	}
	protected function _table(){
		return "user";
	}
}