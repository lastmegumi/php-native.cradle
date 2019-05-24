<?php
class Shipping extends _Model{
	public $id;
	public $order_id;
	public $cost;
	public $career_id;
	public $tracking;
	public $notes;
	public $is_mailed;
	public $status;
	public $updated;

	function __construct(){
		
	}

	protected function _table(){
		return "order_shipping";
	}

}