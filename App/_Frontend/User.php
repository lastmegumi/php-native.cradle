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
			$_SESSION['user']['uname']	=	$user->uname;
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
			$user->token	=	random("128");
			$user->upassword = $this->make_password(_P("password"));
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

	private function make_password($string){		
			$options = [
			    'cost' => 12 // the default cost is 10
			];
			return password_hash($string, PASSWORD_DEFAULT, $options);
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
			//echo $e->getMessage();
			_PAGE::Page_Not_Found();
		}
	}

	protected function orders(){
		$order = new Order();
		if(_G("id")):
			$id = _G("id");
			$order = Order::find(['user_id'	=>	['eq'	=>	self::current("id")],
								  "id"	=>	['eq'	=>	$id]],['class'	=>	true]);
			$sub = Order::findAll(['user_id'	=>	['eq'	=>	self::current("id")],
								  "parent"	=>	['eq'	=>	$id]],['class'	=>	true]);

			$contents[] = $this->cache("status");
			$user = User::find(['id'	=>	["eq" => $order->user_id]]);
			//$contents[]	= $this->cache("order/basic_card");
			$this->assign("data", clone($order));
			$contents[]	= $this->cache("order/buyer_card");

			$payment = Payment::find(['order_id'	=>	["eq" => $order->id]],['class'	=>	true]);
			$this->assign("payment", $payment);
			$contents[]	= $this->cache("order/payment_card");
			$contents[]	= $this->cache("order/status_card");

			$billing = Order_Address::find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "billing"]],['class'	=>	true]);
			$shipping = Order_Address::find(['order_id'	=>	["eq" => $order->id],'type'	=>	["eq" => "shipping"]],['class'	=>	true]);
			$this->assign("billing", $billing);
			$this->assign("shipping", $shipping);
			$contents[]	= $this->cache("order/billing_shipping");

			foreach ($sub as $key => $value) {
				$shipping = Shipping::find(['order_id'	=>	["eq" => $value->id]],['class'	=>	true]);
				$this->assign("shipping", $shipping);			
				$contents[]	= $this->cache("order/shipping_card");
			}

			$products = Order_Product::findAll(['order_id'	=>	["eq" => $order->id]],['class'	=>	true]);
			$this->assign("data", $products);			
			$contents[]	= $this->cache("order/products");
			$this->assign("order",	$order);
			$contents[] = $this->cache("order/action_bar");
			//$this->show($contents, $temp = "user_backend");
		else:			
			$data = Order::findAll(['user_id'	=>	['eq'	=>	self::current("id")],
									'parent'	=>	['eq'	=>	0],
									],
									['order by'	=>['created DESC'], 'class'	=>	true]);
			$this->assign("data", @$data);
			$contents[] = $this->cache("orders");		
		endif;
			self::show($contents, $temp = "user_backend");
	}

	public function invoice(){
		$invoice = new _Invoice();
		$invoice->_route();
	}

	protected function profile(){
		$user = User::find(["id"	=>	['eq'	=>	self::current("id")]],['class'	=>	true]);
		$this->assign('data', $user);
		$contents[] = $this->cache("profile");
		self::show($contents, $temp = "user_backend");
	}

	protected function changepassword(){
		if(_R() == "POST"):
			$user = User::find(['id'	=>	['eq'	=> self::current("id")]],['class'	=>	true]);
			if(!password_verify(_P("cur_password"), $user->upassword)){
				$_SESSION['message'][]	=	"Wrong Password";
				header("Location: " . $_SERVER['HTTP_REFERER']);
				return;
			}
			if(_P("password") !== _P("rep_password")){
				$_SESSION['message'][]	=	"Password not match on repeat";
				header("Location: " . $_SERVER['HTTP_REFERER']);
				return;
			}

			$user->upassword = $this->make_password(_P("password"));
			$user->save();
			$_SESSION['message'][]	=	"Password changed";
		endif;

		$contents[] = $this->cache("newpassword");
		self::show($contents, $temp = "user_backend");
	}
	
	
	function address(){

	}

	function reviews(){
		if(!_G("id")):
			$data = Product_Review::findAll(["user_id"	=>	['eq'	=>	self::current("id")]],['class'	=>	true]);
			$this->assign('data', $data);
			$contents[] = $this->cache("reviews");
		else:
			$data = Product_Review::find(["user_id"	=>	['eq'	=>	self::current("id")],
										 'id'	=>	['eq'	=> _G("id")]],['class'	=>	true]);
			$product = Product::find(["id"	=>	['eq'	=>	$data->product_id]],['class'	=>	true]);
			$this->assign('data', $data);
			$this->assign("product", $product);
			$contents[] = $this->cache("review/review_detail");
		endif;
		self::show($contents, $temp = "user_backend");
	}

	function newsletters(){

	}

	function new(){

		$this->display('form');
	}

	function _route(){
	}

	function list(){
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