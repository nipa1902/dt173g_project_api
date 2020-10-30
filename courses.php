<?php

/* DB Structure 
--------------------------------------------------------------------------------------------------------------------------------------
ID (int, AI, primary key) | institution (varchar(255)) | coursename (varchar(255)) | 
startyear (int(11)) | endyear (int(11)) | startmonth (int(11)) | endmonth (int(11)) |
--------------------------------------------------------------------------------------------------------------------------------------

Put requests here once they are made:

*/

// Class autoloader
require 'loader.php';

// Cross Origin Request Permissions
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
header("Access-Control-Methods: POST, GET, DELETE, PUT");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
 }

$method = $_SERVER['REQUEST_METHOD'];

// Check for URL ID 
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$database = new Database();
$db = $database->connect();

$courses = new Courses($db);

// Switch method to run code on requests

switch($method) {

    // GET CASE
    case 'GET':
        if(isset($id)) {
            $result = $courses->getOne($id);
        } else {
            $result = $courses->getAll();
        }

        $numRows = $result->rowCount();
        // If 1+ rows are returned
        if($numRows > 0){
  
        // Make an array
        $arr=array();

            // Fetch result as associative array
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){

        // Extract so we can use simpler variable names
        extract($row);

        // Define the array that actually stores the course data
            $course_item=array(
                "id" => $id,
                "institution" => $institution,
                "coursename" => $coursename,
                "startyear" => $startyear,
                "endyear" => $endyear,
                "startmonth" => $startmonth,
                "endmonth" => $endmonth,
            );
  
            
            // Push the course data into our array
            array_push($arr, $course_item);
        }
  
    // Good result, return array as result
    http_response_code(200); // OK code
    $result = $arr;
    }     
    // Bad result
    else {
    http_response_code(404); // Not Found code
    $result = array("message" => "No course found by that ID.");
    } break;

    // DELETE CASE
    case 'DELETE':
        // If no ID is set, give error
        if(!isset($id)) {
            http_response_code(510); // "NOT EXTENDED" aka you didn't supply the ID
            $result = array("message" => "Make sure to include an ID to delete.");
        } else {
            // You set an ID, now let's see if the request works
            // Happy result first
            if ($courses->deleteOne($id)) {
                http_response_code(200); // OK code
                $result = array("message" => "Course with ID " . $id . " has been deleted.");
            } 
            // Sad result
            else {
                http_response_code(503); // Server error code
                $result = array("message" => "No such course found. Please check ID again.");
            }
        }
    break;

    case 'POST': 

        $data = json_decode(file_get_contents("php://input"));

        // If zero fields are empty
        if(
            !empty($data->institution) &&
            !empty($data->coursename) &&
            !empty($data->startyear) &&
            !empty($data->endyear) &&
            !empty($data->startmonth) &&
            !empty($data->endmonth) 
        )   {

            // Store variables for input
            $courses->institution = $data->institution;
            $courses->coursename = $data->coursename;
            $courses->startyear = $data->startyear;
            $courses->endyear = $data->endyear;
            $courses->startmonth = $data->startmonth;
            $courses->endmonth = $data->endmonth;

            // Attempt post
            if ($courses->createCourse()) {
                http_response_code(201); // Success!
                $result = array("message" => "Added course.");
            } else {
                http_response_code(503); // Server error code
                $result = array("message" => "Could not add course.");
            }
        } else {
            http_response_code(400); // Bad request code
            $result = array("message" => "Could not add course. Please check all fields are filled in.");
        }
    break;

    case 'PUT': 
        $data = json_decode(file_get_contents("php://input"));

        // If zero fields are empty
        if(
            !empty($data->institution) &&
            !empty($data->coursename) &&
            !empty($data->startyear) &&
            !empty($data->endyear) &&
            !empty($data->startmonth) &&
            !empty($data->endmonth) 
        )   {

            // Grab the URL ID and store as update selector
            $courses->id = $id;

            // Check that the ID actually exists
            if(!$courses->getOne($id)->rowCount() > 0 ) {
                $result = array("message" => "This ID does not exist.");
            } else {

            // Body parameter variables
            $courses->institution = $data->institution;
            $courses->coursename = $data->coursename;
            $courses->startyear = $data->startyear;
            $courses->endyear = $data->endyear;
            $courses->startmonth = $data->startmonth;
            $courses->endmonth = $data->endmonth;

            // Attempt update
            if ($courses->updateCourse()) {
                http_response_code(201); // Success!
                $result = array("message" => "Updated course.");
            } else {
                http_response_code(503); // Server error code
                $result = array("message" => "Could not add course.");
            }
        }} else {
            http_response_code(400); // Bad request code
            $result = array("message" => "Could not update course. Please check all fields are filled in.");
        }
break;


// End of switch method
}

// Return result of query. Actual result will vary based on switch case.
echo json_encode($result, JSON_PRETTY_PRINT);

// Close the DB connection
$db = $database->close();


?>