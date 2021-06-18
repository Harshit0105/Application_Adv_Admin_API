<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/apps.php';
include_once '../objects/slider.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$app = new Apps($db);
$slider=new Sliders($db);

// set ID property of record to read
$app->packageName = isset($_GET['p']) ? $_GET['p'] : die();
// query products
$stmtApp = $app->getAppByPackage();
$numApp = $stmtApp->rowCount();
  
// check if more than 0 record found
if($numApp>0){
    $rowApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
    $slider->app_id=$rowApp['Id'];
    $stmt = $slider->getSliderByApp();
    $num = $stmt->rowCount();
    if($num>0){
            // adv array            
            $image_array=array();
          
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
                extract($row);    
                $image=array(
                    "image"=>$image,                                
                );                          
                array_push($image_array, $image);                
            }
          
            // set response code - 200 OK
            http_response_code(200);
          
            // show apps data in json format
            echo json_encode(array("data"=>$image_array,"result"=>true));    
    }
    else{
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No banner found.","result"=>false)
        );
    }
}
else{  // no apps found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No app found.","result"=>false)
    );
}
  
