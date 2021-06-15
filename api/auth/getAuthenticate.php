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
    // query products
    $stmt = $user->readUsers();
    $num = $stmt->rowCount();
    
    // check if more than 0 record found
    if($num>0){        
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
            extract($row);                                    
            $tryPass=password_verify($data->password,$row['password']);                                    
            if($tryPass){
                $user_data=array(
                    "id" =>  $Id,
                    "name" => $username,
                    "mobileNo" => $mobileNo,        
                    "role"=>$role,
                );
                // set response code - 200 OK
                http_response_code(200);
                $user_json=json_encode($user_data);
                // show admins data in json format
                echo json_encode(array("user"=>$user_data,"auth"=>true));         
            }
            else{
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user no products found
                echo json_encode(
                    array("message" => "No users found.", "auth"=>false)
                );
            }   
        }
    }
    else{  // no admins found will be here
    
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No users found.", "auth"=>false)
        );
    }
}
else{
     // set response code - 404 Not found
     http_response_code(404);
    
     // tell the user no products found
     echo json_encode(
         array("message" => "Invalid Data", "auth"=>false)
     );
}

  
