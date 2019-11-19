<?php
	class Connection {

		public $url;
		public $user;
		public $password;
		public $db;
		public $con;
		
		public function __construct() {
			$this->url = "localhost:3306";
			$this->user = "root";
			$this->password = "";
			$this->db = "adoo";
			$this->con = new mysqli($this->url, $this->user, $this->password, $this->db);
			$this->con->set_charset("utf8");
			if ($this->con->connect_error) {
			    die("Connection failed: " . $this->con->connect_error);
			} 
		}

		public function getConnection() {
			return $this->con;
		}

		public function __toString() {
			return "Connection {\n\turl: " . $this->url . "\n\tuser: " . $this->user . "\n\tpassword: " . $this->password . "\n\tdb: " . $this->db . "\n}";
		}

	}
?>