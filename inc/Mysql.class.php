<?php
class Mysql extends PDO {
	private $db;
	public $count = 0;

	public function __construct($opts) {
		$defaults = array(
			'host'=>'',
			'port'=> '3306',
			'user'=>'',
			'pass'=>'',
			'db'=>''
		);
		$opts = array_merge($defaults, $opts);
		$connectionstring = 'mysql:host='.$opts['host'].':'.$opts['port'].';dbname='.$opts['db'];
		$this->db = $this->parent->__construct($connectionstring, $opts['user'], $opts['pass']);
	}

	public function query($str, $args, $options=array()) {
		try {
		    $sth = $this->prepare($sql, $options);
		    //// bindparam? http://www.php.net/manual/en/pdostatement.bindparam.php
		    //// 
		    // foreach ($args as $arg) {
		    // 	$sth->bindParam($arg, $args[$arg]);
		    // }
		    $sth->execute($args);
		    $data = $this->fetchAll();
		    $this->count = count($data);
		    return $data;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	public function insert($table, $args) {
		//// build sql here
		//// look into bindParam()
		$this->query($sql, $args);
	}

	public function update($table, $args, $where) {

	}

	public function delete($table, $where) {
		
	}	

	public function close() {
		$this->db = null;
	}


}
?>