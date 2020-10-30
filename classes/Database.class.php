<?php

class Database {

    /* DB-settings */
    //private $host = "localhost";
    //private $db_name = "dt173g_projekt";
    //private $username = "dt173g_projekt";
    //private $password = "password";

    private $host = "studentmysql.miun.se";
    private $db_name = "nipa1902";
    private $username = "nipa1902";
    private $password = "yv76n718";
    public $conn;


    /* Connect function */
    public function connect() {

        // Reset connection first
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        // Catch error
        catch(PDOException $e) {
            echo "Connection error. " . $e->getMessage();
        }
        return $this->conn;
    }

    public function close() {
        $this->conn = null;
    }
}

?>