<?php

class Courses {

    private $conn;
    private $table_name = "courses";

    public $id;
    public $institution;
    public $coursename;
    public $startyear;
    public $endyear;
    public $startmonth;
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

    // Delete a course
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


    // Create a course
    public function createCourse() {
        $query = "INSERT INTO " . $this->table_name . 
        " SET institution=:institution, coursename=:coursename, startyear=:startyear, endyear=:endyear, startmonth=:startmonth, endmonth=:endmonth  ";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->institution=htmlspecialchars(strip_tags($this->institution));
        $this->coursename=htmlspecialchars(strip_tags($this->coursename));
        $this->startmonth=htmlspecialchars(strip_tags($this->startmonth));
        $this->endmonth=htmlspecialchars(strip_tags($this->endmonth));
        $this->startyear=htmlspecialchars(strip_tags($this->startyear));
        $this->endyear=htmlspecialchars(strip_tags($this->endyear));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":institution", $this->institution);
        $stmt->bindParam(":coursename", $this->coursename);
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

    // Update course
    public function updateCourse() {

        $query = "UPDATE " . $this->table_name . 
        " SET institution=:institution, coursename=:coursename, startyear=:startyear, endyear=:endyear, startmonth=:startmonth, endmonth=:endmonth
        WHERE 
        id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->institution=htmlspecialchars(strip_tags($this->institution));
        $this->coursename=htmlspecialchars(strip_tags($this->coursename));
        $this->startyear=htmlspecialchars(strip_tags($this->startyear));
        $this->endyear=htmlspecialchars(strip_tags($this->endyear));
        $this->startmonth=htmlspecialchars(strip_tags($this->startmonth));
        $this->endmonth=htmlspecialchars(strip_tags($this->endmonth));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":institution", $this->institution);
        $stmt->bindParam(":coursename", $this->coursename);
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