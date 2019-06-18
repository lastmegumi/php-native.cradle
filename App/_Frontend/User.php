<?php
class _User extends _Base{
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

	function register(){
		$contents[]	= $this->cache("register");
		$this->show($contents);
	}

	static function is_logged(){
		$user = new user();
		$res = $user->find(["token" =>	["eq"	=>	@$_SESSION['user']['token']]]);
		if(!$res){return false;}
		return true;
	}

	static function current($c){
		if(isset($_SESSION['user'][$c])):
			return $_SESSION['user'][$c];
		endif;
		return false;
	}

	static function open_data($uid){
		$user = new User();
		$data = $user->find(['id'	=>	['eq'	=>	$uid]]);
		if($data){
			$user->build($data);
			return array("uid"	=>	intval($uid),
						 "name"	=>	$user->uname);
		}else{
			return array("uid"=>	-1, "name"	=>	"Guest");
		}

	}

	function login(){
		$contents[]	= $this->cache("login");
		$this->show($contents);
	}

	function logout(){
		unset($_SESSION['user']);
		_H(HOME);
	}

	private function setLogin($user){		
			$_SESSION['user']['id']	=		$user->id;
			$_SESSION['user']['uname']	=		$user->uname;
			$_SESSION['user']['email']	=	$user->uemail;
			$_SESSION['user']['token']	=	$user->token;

			try{
				_DB::init()->update(array("user_id"	=>	$user->id, "session_id"	=>	session_id()),"UPDATE cart SET user_id = :user_id WHERE session_id = :session_id");
			}catch(Exception $e){
			}
	}

	function verify(){
		$user = new User();
		$user->uname = _P("username");
		$user->upassword = _P("password");
		$res = $user->find(['uname'	=>	['eq'	=>	$user->uname]
							]);
		if($res){
			$user->build($res);
			if(!password_verify(_P("password"), $user->upassword)){
				$this->json_return("wrong password");
				return;
			}
			$this->response = array("status" => 1,
							 "status_code" => 200,
							 "url" => HOME,
							 "message" => "success");
			$this->setLogin($user);
		}else{
			$this->response = array("status" => 0,
							 "status_code" => 200,
							 "message" => "Faled");
		}
		$this->json_return();
	}

	function register_new(){
		$data = array("uname"	=>	_P("username"),
					  "upassword"	=>	_P("password"),
					  "uemail"	=>	_P("email"),
					  "created"	=>	strtotime("now"),
					  "updated"	=>	strtotime("now"),
					  "type"	=>	1,
					  "status"	=>	1,
					  );

		if(strlen(_P("username")) < 8){$this->json_return("username has to be longer than 8");return;}
		if(!$this->check_email_is_available($data['uemail'])){$this->json_return("this email is used");return;}
		if(!filter_var(_P("email"), FILTER_VALIDATE_EMAIL)){$this->json_return("wrong email format");return;}
		if(_P("password") !== _P("password_repeat")){$this->json_return('password differernt');return;}
		if(strlen(_P("password")) < 6 ){$this->json_return('pasword lenth has to be longer than 6');return;}

		try{
			$user = new User();
			$options = [
			    'cost' => 12 // the default cost is 10
			];
			$data['upassword'] = password_hash($data['upassword'], PASSWORD_DEFAULT, $options);
			$data['token']	=	random("128");

			$user->build($data);
			$user->save();
			$user->create_token();
			$this->json_return('ok');
		}catch(Exception $e){
			$this->json_return($e->getMessage());
		}
	}

	protected function check_email_is_available($email = null){
		$user = new User();
		$res = $user->find(['uemail'	=>	['eq'	=>	$email]]);
		if($res){return false;}
		return true;
	}

	function cart(){
		
	}

	function dashboard(){
		if(!$this->is_logged()){_H(HOME . "user/login");}

		if(!_U(3)):
		$contents[]	= $this->cache("dashboard");
		$this->show($contents, $temp = "user_backend");
		return;
		endif;
		$func = _U(3);
		try{
			if(method_exists($this, $func)):
			$this->$func();
			else:
				throw new Exception("Error Processing Request", 1);
			endif;				
		}catch(Exception $e){
			_PAGE::Page_Not_Found();
		}
	}

	protected function orders(){
		$order = new Order();

		if(_G("id")):
			$id = _G("id");
			$res = $order->find(['user_id'	=>	['eq'	=>	self::current("id")],
									"id"	=>	['eq'	=>	$id]]);
			if($res):
				$order->build($res);
				//$contents[] = $this->cache("user_order");
			endif;
			$contents[] = $this->cache("status");
			$user = new User();
			$udata = $user->find(['id'	=>	["eq" => $order->user_id]]);
			$user->build($udata);
			$contents[]	= $this->cache("order/basic_card");

			$this->assign("data", $user);
			$contents[]	= $this->cache("order/buyer_card");

			$payment = new Payment();
			$udata = $payment->find(['order_id'	=>	["eq" => $order->id]]);
			$payment->build($udata);
			$this->assign("payment", $payment);
			$contents[]	= $this->cache("order/payment_card");
			$contents[]	= $this->cache("order/status_card");

			$billing = new order_address();
			$billing->build($billing->find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "billing"]]));
			$shipping = new order_address();
			$shipping->build($shipping->find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "shipping"]]));
			$this->assign("billing", $billing);
			$this->assign("shipping", $shipping);
			$contents[]	= $this->cache("order/billing_shipping");

			$shipping = new Shipping();
			$udata = $shipping->find(['order_id'	=>	["eq" => $order->id]]);
			$shipping->build($udata);
			$this->assign("shipping", $shipping);			
			$contents[]	= $this->cache("order/shipping_card");

			$Order_Product = new Order_Product();
			$ReflectionClass = new ReflectionClass("Order_Product");
			$udata = $Order_Product->findAll(['order_id'	=>	["eq" => $order->id]]);
			foreach ($udata as $k => $v) {
				$products[] = $ReflectionClass->newInstanceWithoutConstructor()->build($v);	
			}
			$this->assign("data", $products);			
			$contents[]	= $this->cache("order/products");
			//$this->show($contents, $temp = "user_backend");
		else:			
			$res = $order->findAll(['user_id'	=>	['eq'	=>	self::current("id")]]);
			$ReflectionClass = new ReflectionClass("Order");
			foreach ($res as $k => $v) {
				$c = $ReflectionClass->newInstanceWithoutConstructor()->build($v);
				$data[]	=	$c;
			}
			$this->assign("data", @$data);
			$contents[] = $this->cache("orders");		
		endif;
			$this->show($contents, $temp = "user_backend");

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