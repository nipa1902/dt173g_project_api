<?php

class Jobs {

    private $conn;
    private $table_name = "jobs";

    public $id;
    public $workplace;
    public $title;
    public $startyear;
    public $startmonth;
    public $endyear;
    public $endmonth;

    function __construct($db) {
        $this->conn = $db;
    }

    // Get all posts
    public function getAll() {

        $query = "SELECT * FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get one post by ID
    public function getOne($id) {

        $query = "SELECT * FROM " . $this->table_name . " where ID=$id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Delete a job
    public function deleteOne($id) {
        $query = "DELETE FROM " . $this->table_name . " where ID=$id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Check for affected rows and return accordingly
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    // Create a job
    public function createJob() {
        $query = "INSERT INTO " . $this->table_name . 
        " SET workplace=:workplace, title=:title, startyear=:startyear, endyear=:endyear, startmonth=:startmonth, endmonth=:endmonth  ";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->workplace=htmlspecialchars(strip_tags($this->workplace));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->startmonth=htmlspecialchars(strip_tags($this->startmonth));
        $this->endmonth=htmlspecialchars(strip_tags($this->endmonth));
        $this->startyear=htmlspecialchars(strip_tags($this->startyear));
        $this->endyear=htmlspecialchars(strip_tags($this->endyear));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":workplace", $this->workplace);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":startyear", $this->startyear);
        $stmt->bindParam(":endyear", $this->endyear);
        $stmt->bindParam(":startmonth", $this->startmonth);
        $stmt->bindParam(":endmonth", $this->endmonth);

        // Try to execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update job
    public function updatejob() {

        $query = "UPDATE " . $this->table_name . 
        " SET workplace=:workplace, title=:title, startyear=:startyear, endyear=:endyear, startmonth=:startmonth, endmonth=:endmonth
        WHERE 
        id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->workplace=htmlspecialchars(strip_tags($this->workplace));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->startyear=htmlspecialchars(strip_tags($this->startyear));
        $this->endyear=htmlspecialchars(strip_tags($this->endyear));
        $this->startmonth=htmlspecialchars(strip_tags($this->startmonth));
        $this->endmonth=htmlspecialchars(strip_tags($this->endmonth));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":workplace", $this->workplace);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":startyear", $this->startyear);
        $stmt->bindParam(":endyear", $this->endyear);
        $stmt->bindParam(":startmonth", $this->startmonth);
        $stmt->bindParam(":endmonth", $this->endmonth);
        $stmt->bindParam(":id", $this->id);

        // Try to execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }



}

?>