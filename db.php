<?php 
    class Database {
        private $host = "sql6.freemysqlhosting.net";
        private $database_name = "sql6475556";
        private $username = "sql6475556";
        private $password = "uVumfq3JPy";
        public $conn;
        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
?>