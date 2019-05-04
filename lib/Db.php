<?php
class _DB {
	private static $instance = null;
	public $conn = null;
	public $stmt = null;
	
	public static function Open() {	
		#self::gi()->openConnection();
	}
	
	public function Close(){
		#self::gi()->closeConnection();
		$conn = null;
		$this->stmt = null;
	}


	public function __clone(){
        //throw error
        trigger_error("Can't clone object",E_USER_ERROR);
    }    

	//public static function getInstance()
	public static function init()
	{
		if (self::$instance == null)
		{
		  self::$instance = new _DB();
		}
		return self::$instance;
	}

	function __construct(){
		$servername = "localhost";
		$dbname = "ume";
		$username = "root";
		$password = "root";
		$port = 3636;
		
		$str1 = "mysql:host=$servername;port=$port;dbname=$dbname";		
		$servername = "localhost";
		$dbname = "ume";
		$username = "root";
		$password = "";

		$str1 = "mysql:host=$servername;dbname=$dbname";
		
		try{
		    $this->conn = new PDO($str1, $username, $password);
		    #exit();
			// set the PDO error mode to exception
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    #die(json_encode(array('outcome' => true)));
		}
		catch(PDOException $ex){
		    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
		}
	}

	function find($table, $k, $v){
		$stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE {$k}=?");
		$stmt->execute([$v]); 
		return $stmt->fetch();
	}

	function findall($table, $k, $v, $order = null){
		$sql = "SELECT * FROM {$table} WHERE {$k}=?";
		if(!$order){
			$sql .= " ORDER BY {$k} ASC";
		}else{
			$sql .= " ORDER BY {$order}";
		}
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$v]); 
		return $stmt->fetchall();
	}

	function selectone($data = array(), $sql = null){
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($data); 
		return $stmt->fetch();
	}

	function select($data = array(), $sql = null){
		$redis= new Redis();
		$redis->connect('localhost',6379);
		//接收查询参数
		if($data){
			$id = implode('||', $data) . $sql;
			//设置在Redis中存储的KEY
		}else{
			$id = $sql;
		}
		$MY_NODE_KEY_ = 'TEST_PDO_REDIS_ID_';
		//拼接KEY和查询ID，读取Redis，
		$cache = $redis->get($MY_NODE_KEY_.$id);
		$date = date("Y-m-d H:i:s");
		if($cache && false){
			//Redis缓存存在则直接输出

			//并记录log
			error_log($date."---read from redis \r\n", 3, './debug.txt');
			return json_decode($cache,true);
		}else{
			$stmt = $this->conn->prepare($sql);
			$stmt->execute($data); 
			$rs = $stmt->fetchall();
			if (is_array($rs)) {
				    	//查询完成，以json格式写入Redis中。
						$redis->set($MY_NODE_KEY_.$id,json_encode($rs));
						//print_r($rs);
						//error_log($date."read from mysql \r\n", 3, './debug.txt');
				    }
			return $rs;
		}

	}

	function delete($data, $sql = null){
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($data);
		return $stmt->rowCount();
	}

	function update($data, $sql = null){
		$stmt = $this->conn->prepare($sql);
		$stmt->execute($data);
		return $stmt->rowCount();
	}

	function doDB($data,$sql){
		$this->stmt = $this->conn->prepare($sql);
		#$this->stmt->bindValue(':style', $style);
		$this->stmt->execute($data);
		return $this->conn->lastInsertId();
	}

	function insert($data,$sql){
		$this->stmt = $this->conn->prepare($sql);
		#$this->stmt->bindValue(':style', $style);
		$this->stmt->execute($data);
		return $this->conn->lastInsertId();
	}

	function pdo_debugStrParams($stmt) {
	  ob_start();
	  $stmt->debugDumpParams();
	  $r = ob_get_contents();
	  ob_end_clean();
	  return $r;
	}


}