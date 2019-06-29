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

	const _table = "order_shipping";

	function __construct(){
		
	}

	static function _table(){
		return "order_shipping";
	}

	function getCost(){
		return Product::format_price($this->cost);
	}

	function getCareer(){
		switch ($this->career_id) {
			case 1:
				return "Default Delivery";
				break;
			default:
				return "N/A";
				break;
		}
	}

	function getTracking(){
		return $this->tracking;
	}

	function getMailed(){
		switch ($this->is_mailed) {
			default:
				return "pending";
				break;
		}
	}

}