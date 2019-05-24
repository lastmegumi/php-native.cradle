<?php
class Cart extends _Model{
	public $product_id;
	public $user_id;
	public $session_id;
	public $updated;
	public $qty;

	protected function _table(){
		return "cart";
	}

	function __construct(){
		
	}
}