<?php
class Payment extends _Model{
	public $id;
	public $order_id;
	public $type;
	public $amount;
	public $status;
	public $updated;

	function __construct(){
		
	}

	protected function _table(){
		return "order_payment";
	}

}
