<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/apps.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$app = new Apps($db);

// set ID property of record to read
$app->id = isset($_GET['id']) ? $_GET['id'] : die();
// query products
$stmt = $app->getApp();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // admins array
    $apps_arr=array();
    $apps_arr["apps"]=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        extract($row);
  
        $app=array(
            "id"=>$Id,
            "appName"=>$appName,
            "packageName"=>$packageName,
            "image"=>$image,
            "status"=>$status,
            "url"=>$url,
            "reference_app"=>$reference_app,           
        );
  
        array_push($apps_arr["apps"], $app);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show apps data in json format
    echo json_encode(array("data"=>$apps_arr,"result"=>true));    
}
else{  // no apps found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No app found.","result"=>false)
    );
}
  
