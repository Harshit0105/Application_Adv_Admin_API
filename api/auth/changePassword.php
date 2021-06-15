<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->mobileNo) &&
    !empty($data->password) 
){
    $user->mobileNo=$data->mobileNo;
    $user->password=$data->password;    
    // query products
    $stmt = $user->changePassword();
    if($stmt){
        // set response code - 200 ok
         http_response_code(200);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "Password Change", "result"=>true)
        );
    }
    else{
        // set response code - 404 Not Ok
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "Unable to change password", "result"=>false)
        );
    }
}
else{
     // set response code - 404 Not found
     http_response_code(404);
    
     // tell the user no products found
     echo json_encode(
         array("message" => "Invalid Data", "result"=>false)
     );
}

  
