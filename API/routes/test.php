<?php
//set up headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//include the database connection
include("../config/db.php");
//students data array
$students = array();
//validate specific request method
if($_SERVER['REQUEST_METHOD'] == "GET"){
    // $student_id = $_GET['s_id'];
    // echo $student_id . "This is the ID";
    $fetch_student_query = "SELECT * FROM student WHERE student_id = 4 ";
    $send_query = mysqli_query($db, $fetch_student_query);
    $num_of_rows = mysqli_num_rows($send_query);
    if($num_of_rows > 0){
        $result = mysqli_fetch_assoc($send_query);
        extract($result);
        $data = array(
            "id" => $student_id,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "address" => $address,
            "photo" => $photo,
            "about" => $about,
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "date_of_creation" => $date_of_creation
        );
        http_response_code(200);
        json_encode($data);
    }else{
        http_response_code(404);
        echo json_encode(array("Message" => "Student With That ID doesn't exists"));
    }
}


