<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/slider.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$slider = new Sliders($db);

// set ID property of record to read
$slider->id = isset($_GET['id']) ? $_GET['id'] : die();
// query products
$stmt = $slider->getSlider();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    $image_array=array();
          
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
        extract($row);    
        $image=array(
            "Id"=>$id,
            "image"=>$image,                                
        );                          
        array_push($image_array, $image);                
    }
    
    // set response code - 200 OK
    http_response_code(200);
    
    // show apps data in json format
    echo json_encode(array("data"=>$image_array,"result"=>true));    

}
else{  // no apps found will be here
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No banners found.","result"=>false)
    );
}
  
