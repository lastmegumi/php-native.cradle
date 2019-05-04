<?php
#basic controller
Class _Base{
	protected $_PUT;
	protected $_DELETE;
	protected $_attr = [];
	protected $model;
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

	function build($l = null){
		// if(!empty($l)){
		// 	foreach ($l as $key => $value) {
		// 		$this->$key = $value;
		// 	}
		// }
		if($this->_attr):
			foreach ($this->_attr as $key => $value):
				$this->model->$value = isset($l[$value])?$l[$value]:null;
			endforeach;
		endif;
		if(isset($l["_id"])){
			$this->model->_id = $l['_id'];
		}
	}

	// function delete(){
	// 	if(!$this->is_allow()){return;}
	// 	$res = $this->find(_U(3));
	// 	$this->build($res);
	// 	$db = new _DB();
	// 	$data = array('id' => $this->id);
	// 	$sql = "DELETE FROM " . $this->table . " WHERE id = :id LIMIT 1";
	// 	try{
	// 		$db->delete($data, $sql);
	// 		_H(HOME);
	// 	}catch(Exception $e){
	// 		echo $e->getMessage();
	// 	}
	// }

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


	function cache($temp){
		if(@$this->var):
		foreach($this->var as $k => $v){
			$i = $k;
			$$i = $v;
		}
		endif;
		ob_start();
		if(file_exists($this->template_dir . $temp)){
			include $this->template_dir . $temp;}
		elseif(file_exists($this->template_dir . $temp . '.php')){
			include $this->template_dir . $temp . ".php";}
		else{
		
		}
		return ob_get_clean();
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
		elseif(file_exists($this->template_dir . $temp . '.php')){
			include $this->template_dir . $temp . ".php";}
		else{
			$this->err_404();}
		if(!$design && !_G('form')){}
	}

	function show($contents = [], $temp = "tp1"){
		if(file_exists(APP. 'template/' . $temp)){
			include APP. 'template/' . $temp;}
		elseif(file_exists(APP. 'template/' . $temp . '.php')){
			include APP. 'template/' . $temp . ".php";}
		else{
			$this->err_404();}
	}

	// Mongoddb

	protected function save($data = array()){
		$sql = "INSERT INTO " . $this->_table . " (" . implode(', ', array_keys($data)). ") VALUES (:" . implode(', :', array_keys($data)) .")";
		$sql .= " ON DUPLICATE KEY UPDATE ";
		$arr = array();
		foreach ($data as $key => $value) {
			$arr[] .= $key . ' = :' . $key;
		}
		$sql .= implode(', ', $arr);
		_DB::init()->insert($data, $sql);
	}

	protected function find($filter = [], $options = ["limit", 1]){
		$res = $this->findAll($filter, $options);
		return $res? $res[0] :null;
	}

	protected function findAll($filter = [], $options = []){
		$sql = "SELECT * FROM " . $this->_table ." WHERE 1";
		//$data = array("tablestr"	=>	$this->_table);
		if($filter):
		foreach($filter as $k => $v){
			$sql .= " AND " . $k;
			foreach ($v as $k2 => $v2) {
				$mark = array("eq"	=>	"=", "gt"	=>	">=", "st"	=>	"<=", "lk"	=>	"LIKE");
				$sql .= " " . $mark[strtolower($k2)] . " :" . $k;
				$data[$k] = $v2;
			}
		}
		endif;
		return _DB::init()->select($data, $sql);
	}

	protected function delete($filter = [], $options = ['limit' => 1]){
		$db = new _MongoDB();
		$db->setTable($this->_table);
		return $db->delete($filter, $options);
	}

	protected function deleteAll($filter = [], $options = ['limit' => 0]){
		$db = new _MongoDB();
		$db->setTable($this->_table);
		return $db->delete($filter, $options);
	}

	// function find($s){
	// 	$db = new _DB();
	// 	$data = array("main_key" => $s);
	// 	$main_key = $this->main_key? $this->main_key : "id";
	// 	$sql = "SELECT * FROM " . $this->table  . " WHERE " . $main_key ." = :main_key";
	// 	return $db->selectone($data, $sql);
	// }

	protected function err_404(){
		include $this->common_view_folder . "404.php";
	}

	protected function err($err_code = 0){
		if(@$this->var):
		foreach($this->var as $k => $v){
			$i = $k;
			$$i = $v;
		}
		endif;
		switch ($err_code) {
			case 1:
				$err_msg = "You have no authoriztion to visit this page.";
				break;			
			default:
				break;
		}
		include $this->common_view_folder . "err.php";
	}

	protected function json_return(){
		header('Content-Type: application/json');
		$this->response['message'] = _L($this->response['message']);
		echo json_encode($this->response);
       	die();
	}
}?>