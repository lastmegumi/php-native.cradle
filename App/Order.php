<?php
class Order extends _Model{
	public $id;
	public $buyer_email;
	public $buyer_name;
	public $buyer_phone;
	public $token;
	public $amount_base;
	public $amount_discount;
	public $amount_paid;
	public $amount_tax;
	public $description;
	public $message;
	public $payment_method;
	public $status;
	public $updated;
	protected function _table(){
		return "order";
	}
}

class _Order extends _Base{
	protected $_attr = ["id",  "buyer_name", "buyer_email", "buyer_phone", "token", "amount_base", "amount_tax", "amount_discount", "amount_paid", "description", "message", "payment_method", "status", "updated"];
	protected $_table = "order";
	private $main_key = "id";
	public $template_dir = "order";
	public $title;
	public $imgs;
	public $price;

	function __construct(){
		$name = "Order";
		$this->template_dir = APP . "view/".$name."/";
		//print_r($this->build(array("title" => "abcde", "price" => 1.22)));
		//print_r($this->save());
		//print_r($this->deleteAll());
	}

	function new(){
		$this->display('form');
	}

	function _route(){
		if(_G('id')){
			$order = new Order();
			$data = $order->find(['id'	=>	['eq'	=>	12]]);
			$contents[] = $data;
			$this->show($contents);
			print_r($data);
		}
	}

	function list(){		
		$sql = "SELECT `{$this->_table}`.* FROM `{$this->_table}`
				WHERE 1";
		$data = array();
		$data = _DB::init()->select($data, $sql);
		$header = $this->_attr;
		foreach ($data as $k => $v) {
			$c = [];
			foreach ($header as $k2 => $v2) {
				$c[$v2]	=	@$v[$v2];
			}
			$table_data[] = $c;
		}
		$this->assign("header", $header);
		$this->assign("data", $table_data);
		$this->assign("name", $this->_table);
		$contents[] = $this->cache("action_bar");
		$contents[] = $this->cache("table");
		$this->show($contents);
	}

	function add(){
		$data = array(
				'id'	=>	'',
				'buyer_email'	=>	'lastmegumi@gmail.com',
				'buyer_name'	=>	'yan_ren',
				'buyer_phone'	=>	'9292453662',
				'token'	=>	rid('128'),
				'amount_base'	=>	55,
				'amount_discount'	=>	10,
				'amount_paid'	=>	55,
				'amount_tax'	=>	10,
				'description'	=>	'第一单',
				'message'	=>	'烧腊',
				'payment_method'	=>	'credit_stripe',
				'status'	=>	1,
				'updated'	=>	strtotime("now"),
			);
		$order = new Order();
		$order->build($data)->save();
	}

}
?>