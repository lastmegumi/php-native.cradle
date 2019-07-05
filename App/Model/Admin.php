<?php
class Admin extends _Model{
	public $id;
	public $uname;
	public $uemail;
	public $upassword;
	public $type;
	public $status;
	public $created;
	public $updated;
	public $token;

	const _table = "owner";
	function __construct(){
	}

	function open_info($uid = 0){
		$user = $this->find(['id'	=>	$uid]);
		if($user){
			$this->build($user);
			return $this;
		}
		return $this;
	}

	static function getStoreID(){
		return 1;
	}

	static function store(){
		return store::find(['owner'	=>	['eq'	=>	_Admin::current('id')]]);
	}

	function getName(){
		return $this->uname;
	}

	function getUsername(){
		return $this->uname;
	}

	function getEmail(){
		return $this->uemail;
	}
}