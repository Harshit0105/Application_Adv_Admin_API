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
$adv = new Adv($db);
$app = new Apps($db);

// set ID property of record to read
$app->packageName = isset($_GET['p']) ? $_GET['p'] : die();
// query products
$stmtApp = $app->getAppByPackage();
$numApp = $stmtApp->rowCount();
  
// check if more than 0 record found
if($numApp>0){
    $rowApp = $stmtApp->fetch(PDO::FETCH_ASSOC);
    $adv->app_id=$rowApp['Id'];
    $stmt = $adv->getAdvIdByApp();
    $num = $stmt->rowCount();
    if($num>0){
            // adv array
            $adx_array=array();
            $facebook_array=array();
          
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){        
                extract($row);    
                $adx=array(            
                    "status"=>$ads_enabled==1?true:false,
                    "banner"=>$adMobBannerId,
                    "inter"=>$adMobInterstitialId,
                    "native"=>$adMobNativeId,
                    "openapp"=>$appOpenId,            
                );
                $fb=array(
                    "status"=>$ads_enabled==1?true:false,
                    "banner"=>$fb_ad_banner,
                    "native"=>$fb_ad_native,
                    "inter"=>$fb_ad_inter,
                );
          
                array_push($adx_array, $adx);
                array_push($facebook_array, $fb);
            }
          
            // set response code - 200 OK
            http_response_code(200);
          
            // show apps data in json format
            echo json_encode(array("adx"=>$adx_array,"facebook"=>$facebook_array,"result"=>true));    
    }
    else{
        // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No adv found.","result"=>false)
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
  
