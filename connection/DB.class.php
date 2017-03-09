<?php

/*
* Mysql database class - only one connection alowed
*/

class Database {
	
	private $_connection;
	private static $_configFile;
	private static $_instance; //The single instance
	private $_host;
	private $_username;
	private $_password;
	private $_database;
	/*
	Get an instance of the Database
	@return Instance
	*/
	private function initialize($configFile) {
		
		$this->_host = $configFile['db_servername'];
		$this->_username = $configFile['db_username'];
		$this->_password = $configFile['db_password'];
		$this->_database = $configFile['db_database'];
	
	}

	public static function getInstance($configFile) {

		self::$_configFile = $configFile;
		
		if(!self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
	// Constructor
	private function __construct() {

		$this->initialize(self::$_configFile);
		
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