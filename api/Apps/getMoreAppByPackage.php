<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/adv.php';
include_once '../objects/apps.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$app2 = new Apps($db);
$app = new Apps($db);

// set ID property of record to read
$app->packageName = isset($_GET['p']) ? $_GET['p'] : die();
// query products
$stmtApp = $app->getAppByPackage();
$numApp = $stmtApp->rowCount();
  
// check if more than 0 record found
if($numApp>0){
    $rowApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
    $app2->reference=$rowApp['Id'];
    $stmt = $app2->getMoreAppByReference();
    $num = $stmt->rowCount();
    if($num>0){
            // adv array
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
    else{
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No reference apps found.","result"=>false)
        );
    }    
}
else{  // no apps found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No apps found with this package name!!.","result"=>false)
    );
}
  
