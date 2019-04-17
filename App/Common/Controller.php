<?php
Class _Controller{
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

	function build($l = null){
		if(!empty($l)){
			foreach ($l as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	protected function is_allow(){
		if(_S('pid') > 3){$this->assign('err_msg', "You are not authorized to access this page"); $this->err("form.php"); return false;}
		return true;
	}


	function get_start($date = null){
		if(!$date){return "Not set";}
		return date("m/d/Y", $date);
	}

	function get_end($date = null){
		if(!$date){return "Not set";}
		return date("m/d/Y", $date);
	}

	protected function getBirthday(){
		return date('M d Y', $this->dateofbirth);
	}

	protected function getAge(){
		$d1 = new DateTime(date('Y-m-d', $this->dateofbirth));
		$d2 = new DateTime(date('Y-m-d'));
		$diff = $d2->diff($d1);
		return $diff->y;
	}

	protected function getAddress(){
		return $this->address . ', ' . $this->city . ', ' . $this->state . ', ' . $this->zipcode;
	}

	protected function getMailAddress(){
		return $this->mail_address . ', ' . $this->mail_city . ', ' . $this->mail_state . ', ' . $this->mail_zipcode;
	}

	function delete(){
		if(!$this->is_allow()){return;}
		$res = $this->find(_U(3));
		$this->build($res);
		$db = new _DB();
		$data = array('id' => $this->id);
		$sql = "DELETE FROM " . $this->table . " WHERE id = :id LIMIT 1";
		try{
			$db->delete($data, $sql);
			_H(HOME);
		}catch(Exception $e){
			echo $e->getMessage();
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

	function find($s){
		$db = new _DB();
		$data = array("id" => $s);
		$sql = "SELECT * FROM " . $this->table  . " WHERE id = :id";
		if(in_array($this->table, array("client"))){
			if(_S("gid")){$data['groups_id'] = _S('gid'); $sql .= " AND groups_id = :groups_id";}	
		}
		return $db->selectone($data, $sql);
	}

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


	protected function format_birthday($d = null){
		$d = @$this->dateofbirth? @$this->dateofbirth : $d;
		if($d){
			return date("m/d/Y", $d);
		}else{
			return date("m/d/Y", strtotime("now"));
		}
	}

	protected function format_phone($s = null){
		try {
			if(!empty($s) && @isset($s[9])){
				return  '(' . $s[0] . $s[1] . $s[2] . ')'. $s[3] . $s[4] . $s[5] . '-' .$s[6] . $s[7] . $s[8] . $s[9]; 
			}
		} catch (Exception $e) {
			
		}
	}

	protected function format_name($f = null, $l = null){
		return @$f . ' ' . @$l;
	}

	protected function format_address($address_arr){
		$str = array();
		$key = array("address", "apt", "city", "state", "zipcode");
		foreach($key as $k => $v):
			if(@$address_arr[$v]){$str[] = $address_arr[$v];}
		endforeach;
		return implode(', ', $str);
	}

	protected function format_SSN($s = null){
		if(!$s){$s = "000000000";}
		return 'xxx-xx-' . @$s[5]  . @$s[6] . @$s[7] . @$s[8]; 
	}

	protected function json_return(){
		header('Content-Type: application/json');
		$this->response['message'] = _L($this->response['message']);
		echo json_encode($this->response);
       	die();
	}

}?>