<?php
	class DbConnect {
		private $host = 'my-php-app_db_1:3306';
		private $dbName = 'test';
		private $user = 'root';
		private $pass = 'example';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch( PDOException $e) {
				echo 'Database Error: ' . $e->getMessage() . '</br>';
			}
		}
	}
 ?>
