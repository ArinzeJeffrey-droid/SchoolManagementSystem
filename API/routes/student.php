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
    //fetch student query
    $query = "SELECT * FROM student";
    $send_student_query = mysqli_query($db, $query);
    //get the number of rows in the query set
    $num_of_rows = mysqli_num_rows($send_student_query);
    //check if theres any data in the result set
    if($num_of_rows > 0){
        while($result = mysqli_fetch_assoc($send_student_query)){
            extract($result);
            $student_data = array(
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
            array_push($students, $student_data);
    }
        http_response_code(200);
        echo json_encode($students);
    }else{
        //if no students found
        echo json_encode(array("Message" => "No Students In The Database"));
    }
}
else if(isset($_GET['s_id'])){
    $student_id = $_GET['s_id'];
    $fetch_student_query = "SELECT * FROM student WHERE student_id = $s_id ";
    $send_query = mysqli_query($db, $fetch_student_query);
    $num_of_rows = mysqli_num_rows($fetch_student_query);
    if($num_of_rows > 0){
        $result = mysqli_fetch_assoc($send_query);
        http_response_code(200);
        json_encode($result);
    }else{
        http_response_code(404);
        echo json_encode(array("Message" => "Student With That ID doesn't exists"));
    }
}
else{
    //if request method isn't valid
    http_response_code(400);
    echo json_encode(array("Message" => "Method Not Allowed"));
}

