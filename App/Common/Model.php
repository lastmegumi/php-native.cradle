<?php
#basic controller
Class _Model{
	const _table = "null";

	function __construct()	{
	}

	static function _table(){

	}

	function build($data = null){
		if(!$data){return $this;}
		foreach ($data as $k => $v) {
			if(property_exists($this, $k)){
				$this->$k = $v;
			}
		}
		return $this;
	}

	function save($data = array()){
		$data = $data?  $data:get_object_vars($this);
		if(!$data || !array_filter($data)){
        	throw new Exception("Can't not save empty object");
		}

		$sql = "INSERT INTO `" . $this->_table() . "` (" . implode(", ",  array_keys($data)) . ") VALUES (:" . implode(', :', array_keys($data)) .")";
		if(isset($this->id) && $this->id):
			$sql .= " ON DUPLICATE KEY UPDATE ";
			$arr = array();
			foreach ($data as $key => $value) {
				$arr[] .= $key  . ' = :' . $key;
			}
			$sql .= implode(', ', $arr);
		endif;
		$res = _DB::init()->insert($data, $sql);

		//if(!$res){throw new Exception("Error on save object");}

		if(isset($this->id) && $this->id){
		}else{
			$this->id = $res;
		}
		return $this;
		//return this::find(['id'	=>	['eq'	=>	$this->id]);
		//return _DB::init()->insert($data, $sql);
	}

	static function find($filter = [], $options = ["limit" => 1]){
		$res = self::findAll($filter, $options);
		return $res? $res[0] :null;
	}

	static function total($filter = [], $options = []){
		$options['count']	=	true;
		$total = self::findAll($filter, $options);
		return intval($total[0][0]);
	}

	static function findAll($filter = [], $options = []){
		if(isset($options['field'])){
			$field = implode(',', $options['field']);
		}else{
			$field = '*';
		}
		if(isset($options['count'])	&& $options['count'] === true){
			$field = 'COUNT(' . $field . ')';
		}
		$sql = "SELECT {$field} FROM `" . static::_table ."` WHERE 1";
		//$data = array("tablestr"	=>	$this->_table);
		if(is_array($filter)):
		foreach($filter as $k => $v){
			$sql .= " AND " . $k;
			foreach ($v as $k2 => $v2) {
				$mark = array("eq"	=>	"=", "gt"	=>	">=", "st"	=>	"<=", "lk"	=>	"LIKE", 'in'	=>	"IN", 'notin'	=>	"NOT IN");
				switch ($k2) {
					case 'eq':
					case 'gt':
					case 'st':
					case 'lk':
						$sql .= " " . $mark[strtolower($k2)] . " :" . $k;
						$data[$k] = $v2;
						break;
					case 'in':
					case 'notin':
						$sql  .= " " . $mark[strtolower($k2)] . " (" . implode(",", $v2) . ")";

						// $data[$k] = implode("','", $v2);
						break;
					default:
						# code...
						break;
				}
			}
		}
		endif;
		if(array_filter($options)):
		foreach(array_filter($options) as $k => $v){
			switch(strtolower($k)){
				case 'group by':
					$sql .= " GROUP BY ";
					$sql .= implode(' , ', $v);
					break;
				case 'order by':
					$sql .= " ORDER BY ";
					$sql .= implode(' , ', $v);
					break;
				case "limit":
					$sql .= " " . $k . " " . $v;
					break;
				default:
					break;
			}
		}
		endif;
		if(isset($options['class']) && $options['class'] === true){
			return _DB::init()->select(@$data, $sql, get_called_class());
		}else{
			return _DB::init()->select(@$data, $sql);
		}
	}

	function delete($filter = [], $options = ['limit' => 1]){
		if(!$filter){
			$filter = ['id'	=>	["eq"	=>	$this->id]];
		}

		$res = $this->deleteAll($filter, $options);
		return $res? $res :0;
	}

	function deleteAll($filter = [], $options = ['limit' => 0]){
		$sql = "DELETE FROM `" . $this->_table() ."` WHERE 1";
		//$data = array("tablestr"	=>	$this->_table);
		if(is_array($filter)):
		foreach($filter as $k => $v){
			$sql .= " AND " . $k;
			if(is_array($v)):
				foreach ($v as $k2 => $v2) {
					$mark = array("eq"	=>	"=", "gt"	=>	">=", "st"	=>	"<=", "lk"	=>	"LIKE");
					$sql .= " " . $mark[strtolower($k2)] . " :" . $k;
					$data[$k] = $v2;
				}
			endif;
		}
		endif;
		return _DB::init()->delete(@$data, $sql);
	}

	function __Call($method, $args){
		return false;
	}

	function __get($prop){
		return null;
	}

}?>