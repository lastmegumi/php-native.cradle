<?php
class Payment extends _Model{
	public $id;
	public $order_id;
	public $type;
	public $amount;
	public $status;
	public $updated;
	public $track_back;

	const _table = "order_payment";

	function __construct(){
		
	}

	static function _table(){
		return "order_payment";
	}

	function refund(){
		$data = stripe::init()->refund($this->tb_obj()->id);
		if($data['status']):
				$p = new Payment();
				$p->order_id = $this->order_id;
				$p->type = "credit_stripe_refund";
				$p->amount = $this->amount;
				$p->status = 2;
				$p->track_back = serialize($data['data']);
				$p->updated = strtotime('now');
				$p->save();
				return true;
		endif;
		return false;
	}



	function tb_obj(){
		return unserialize($this->track_back);
	}

}
