<?php 
	
	class DbConnect {
		private $server = 'bpuu4cfaeaupafgrjfei-mysql.services.clever-cloud.com';
		private $dbname = 'bpuu4cfaeaupafgrjfei';
		private $user = 'uzmijqzm6odnbvmy';
		private $pass = 'i1GkE2tufIatdAoKor7L';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				echo "Database Error: " . $e->getMessage();
			}
		}
	}
 ?>


