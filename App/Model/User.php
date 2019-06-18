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
	public $token;

	const _table = "user";
	function __construct(){
	}
	static function _table(){
		return "user";
	}

	function open_info($uid = 0){
		$user = $this->find(['id'	=>	$uid]);
		if($user){
			$this->build($user);
			return $this;
		}
		return $this;
	}

	function getName(){
		return $this->uname;
	}
}