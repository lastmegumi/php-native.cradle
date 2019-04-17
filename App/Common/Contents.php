<?php
Class _Contents{
	protected $_PUT;
	protected $_DELETE;
	public $template_dir = "view/";
	public $common_view_folder = APP . "Common/view/";
	public $response = array("status" => 0,
							"status_code" => 401,
							"data" => null,
							"message" => null);

	function __construct()	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ('PUT' === $method) {
		    parse_str(file_get_contents('php://input'), $this->_PUT);
		}
		if ('DELETE' === $method) {
		    parse_str(file_get_contents('php://input'), $this->_DELETE);
		}
	}

	function assign($k, $v){
		$this->var[$k] = $v;
	}

	function render($temp, $design = null){
		if(@$this->var):
		foreach($this->var as $k => $v){
			$i = $k;
			$$i = $v;
		}
		endif;
		if(file_exists($this->template_dir . $temp)){
			include $this->template_dir . $temp;}
		else{
		
		}
	}

	function display($temp, $design = null){
		if(@$this->var):
		foreach($this->var as $k => $v){
			$i = $k;
			$$i = $v;
		}
		endif;
		if(!$design && !_G('form')){getheader();getnav();}
		if(file_exists($this->template_dir . $temp)){
			include $this->template_dir . $temp;}
		else{
			$this->err_404();}
		if(!$design && !_G('form')){}
	}

	protected function find($s){
		$db = new _DB();
		$data = array("id" => $s);
		$sql = "SELECT * FROM " . $this->table  . " WHERE id = :id";
		return $db->selectone($data, $sql);
	}

	protected function err_404(){
		include $this->common_view_folder . "404.php";
	}

	protected function err(){
		if(@$this->var):
		foreach($this->var as $k => $v){
			$i = $k;
			$$i = $v;
		}
		endif;
		include $this->common_view_folder . "err.php";
	}
}?>