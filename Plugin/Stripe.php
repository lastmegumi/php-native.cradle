<?php
  	require PLUGIN . '/stripe/init.php';
class stripe{
	private static $instance = null;
	static public $response = array("message" 	=> "",
									 "status"	=>	0,
									 "data"		=> null,
									);
	// static private $_test_key = "sk_test_aaaaaaaaaaaaaaaaaaaaaaaa";	# your test key
	// static private $_live_key = "sk_live_bbbbbbbbbbbbbbbbbbbbbbbb";	# your live key

	static private $_test_key = "sk_test_CCk5xhyLuNiGlPhK67iV28wO";	# your test key
	static private $_live_key = "sk_live_bbbbbbbbbbbbbbbbbbbbbbbb";	# your live key

	static private $test_mode = true;
	static public $_min_pay = 1;

	function __construct(){
		try{
			if(self::$test_mode):
				\Stripe\Stripe::setApiKey(self::$_test_key);
			else:
				\Stripe\Stripe::setApiKey(self::$_live_key);
			endif;
		}catch(Exception $e){
			self::$response['message'] = $e->getMessage();
			return self::$response;
		}
	}

		//public static function getInstance()
	public static function init()
	{
		if (self::$instance == null)
		{
		  self::$instance = new stripe();
		}
		return self::$instance;
	}


	static function currency_mark($currency = null){
		switch ($currency) {
			case 'usd':
				return "$";
				break;
			default:
				return "$";	#default currency dolor
				# code...
				break;
		}return null;
	}

	static function charge($token = null, $amount = 0, $description = null){
		// Token is created using Checkout or Elements!
		// Get the payment token ID submitted by the form:
		//$token = $_POST['stripeToken'];
		try {
			$charge = \Stripe\Charge::create([
			    'amount' => $amount,
			    'currency' => 'usd',
			    'description' => $description,
			    'source' => $token,
			]);
			self::$response['status'] 	= 1;
			self::$response['message']	= "SUCCESS";
			self::$response['data']	=	$charge;
		} catch (Exception $e) {
			self::$response['message'] = $e->getMessage();
		}
		return self::$response;
	}

	static function refund($charge_id, $amount = false){
		try{
			if(!$amount):
				$refund = \Stripe\Refund::create([
				    'charge' => $charge_id,
				]);
			else:
				$refund = \Stripe\Refund::create([
				    'charge' => $charge_id,
				    'amount' => $amount,
				]);
			endif;
			$this->response['status'] 	= 1;
			$this->response['message']	= "SUCCESS";
			$this->response['data']	=	$refund;
		}catch(Exception $e){
			$this->response['message'] = $e->getMessage();
		}
		return $this->response;
	}

	static function card_token($obj){
		print_r($obj);
		try {
			$token = \Stripe\Token::create([
			  "card" => [
			    "number"		=> @$obj['number'],
			    "exp_month" 	=> @$obj['exp_month'],
			    "exp_year" 		=> @$obj['exp_year'],
			    "cvc" 			=> @$obj['cvc'],
			    "name"			=> @$obj['name'],
			    "address_line1"	=> @$obj['address_line1'],
			    "address_line2"	=> @$obj['address_line2'],
			    "address_city"	=> @$obj['address_city'],
			    "address_state"	=> @$obj['address_state'],
			    "address_zip"	=> @$obj['address_zip'],
			    //"address_line1"	=> $obj['address_line1'],
			  ]
			]);
			self::$response['status'] 	= 1;
			self::$response['message']	= "SUCCESS";
			self::$response['data']	=	$token;
		} catch (Exception $e) {
			self::$response['message'] = $e->getMessage();
		}
		return self::$response;

	}

	static function receive_charge($charge_id = null){
		if($charge_id):
			try{
				$data = \Stripe\Charge::retrieve($charge_id);
				$this->response['status'] 	= 1;
				$this->response['message']	= "SUCCESS";
				$this->response['data']	=	$data;
			} catch (Exception $e) {
				$this->response['message'] = $e->getMessage();
			}
		else:
			try {
				$data = \Stripe\Charge::all(["limit" => 3]);
				$this->response['status'] 	= 1;
				$this->response['message']	= "SUCCESS";
				$this->response['data']	=	$data;
			} catch (Exception $e) {
				$this->response['message'] = $e->getMessage();
			}
		endif;
		return $this->response;
	}

	static function _render($func = null){
		if(method_exists($this, $func)){
			return $this->$func();
		}
		return false;
	}
}