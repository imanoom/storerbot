<?php


/*
* Mysql database class - only one connection alowed
*/
class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host = "";
	private $_username = "";
	private $_password = "";
	private $_database = "";
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {
	
		$this->_host = '127.0.0.1';
		$this->_username = 'root';
		$this->_password = '';
		$this->_database = 'storer';
	
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
		mysqli_set_charset($this->_connection, "utf8");
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}
?>