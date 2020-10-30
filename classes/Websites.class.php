<?php

class Websites {

    private $conn;
    private $table_name = "websites";

    public $id;
    public $title;
    public $url;
    public $description;
    public $imagelink;

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

    // Delete a website
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


    // Create a website
    public function createWebsite() {
        $query = "INSERT INTO " . $this->table_name . 
        " SET title=:title, url=:url, description=:description, imagelink=:imagelink ";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->imagelink=htmlspecialchars(strip_tags($this->imagelink));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":imagelink", $this->imagelink);

        // Try to execute
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update website
    public function updateWebsite() {

        $query = "UPDATE " . $this->table_name . 
        " SET title=:title, url=:url, description=:description, imagelink=:imagelink  
        WHERE 
        id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->imagelink=htmlspecialchars(strip_tags($this->imagelink));

        // Bind sanitised inputs to prepared statement
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":imagelink", $this->imagelink);
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