<?php
class _Admin extends _Base{
	protected $_attr = ["id", "main_id", "product_ids", "user","created", "status", "updated"];
	protected $_table = "user";
	private $main_key = "id";
	public $template_dir = "user";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "User";
		$this->template_dir = APP_DIR . "view/".$name."/";
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	static function current($c){
		if(isset($_SESSION['admin'][$c])):
			return $_SESSION['admin'][$c];
		endif;
		return false;
	}

	static function isloggedin(){
		return @$_SESSION['admin']['loggedin'] == true ? true: false;
	}

	function login(){
		if($this->isloggedin()){
			_H(HOME . BACKEND ."dashboard");
		}
		switch (_R()) {
			case 'GET':
				$this->show([], $temp = "login");
				break;
			case 'POST':
				$admin = Admin::find(['uname'	=>	['eq'	=> _P("name")]]);
				if($admin):
					if(password_verify(_P("password"), $admin->upassword)):
						$_SESSION['admin']['loggedin'] = true;
						$_SESSION['admin']['id'] = $admin->id;

						$_SESSION['admin']['name'] = $admin->uname;
						$_SESSION['admin']['email'] = $admin->uemail;
						$_SESSION['admin']['status'] = $admin->status;
						$_SESSION['admin']['type'] = $admin->type;
						$_SESSION['admin']['permission'] = $admin->permission;

						_H(HOME . BACKEND ."dashboard");						
					endif;
					MSG::add("Wrong password");
				endif;
					MSG::add("Wrong username");
			default:
				$this->show([], $temp = "login");
				break;
		}

	}

	function logout(){
		unset($_SESSION['admin']);
		_H(HOME.BACKEND."login");
	}

	function dashboard(){
		$contents[] = $this->cache("dashboard");
		$this->show($contents);

	}

	function orders(){

	}

	function info(){

	}
	
	function address(){

	}

	function review(){

	}

	function newsletters(){

	}


	function new(){
		$this->display('form');
	}

	function _route(){
	}

	function list(){
		print_r($this->findAll());
	}

	function add(){
		$p = array(
			"title"	=>	"titl22222_dddee",
		);
		_MongoDB::init()->setDatabase('test52');
		$this->build($p);
		//print_r($this->model);
		//return;
		var_dump($this->save());

	}

}
?>