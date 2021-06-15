<?php
include("database/dbconfig.php");

if(isset($_POST['appName']) && isset($_POST['packages']) && isset($_FILES['image'])){
	   
      $errors= array();
      $imagepath_name = $_FILES['image']['name'];	  
	//   $videotitle =   str_replace(".zip","",$videopzip_name);   /*$_POST['videotitle'];*/
      $appName=$_POST['appName'];
	$packages = $_POST['packages'];
      $reference =isset($_POST['reference']) ? $_POST['reference'] : -1;
      $status = isset($_POST['status'])? 1 : 0;
      $url=$_POST['url'];
      $imagepath = "AppImages/".str_replace(" ","_",$appName)."_".time().".jpg"; 
           

       move_uploaded_file($_FILES['image']['tmp_name'],$imagepath);	       	         	   		
       $query = "INSERT INTO apps (appName,packageName,image,status,url,reference_app) VALUES ( :appName, :pName,:image,:status,:url,:reference)";
       $stmt=$connection->prepare($query);
       if($stmt->execute(['appName'=>$appName,'pName'=>$packages,'image'=>$imagepath,'status'=>$status,'url'=>$url,"reference"=>$reference])){
            $id=$connection->lastInsertId();
            $enable = isset($_POST['adv_enable'])? 1 : 0;
            $adMobBannerId=$_POST['adMobBannerId'];
            $adMobInterstitialId=$_POST['adMobInterstitialId'];
            $adMobNativeId=$_POST['adMobNativeId'];
            $faceBannerId=$_POST['faceBannerId'];
            $faceInterstitialId=$_POST['faceInterstitialId'];
            $faceNativeId=$_POST['faceNativeId'];
            $onesignalAppId=$_POST['onesignalAppId'];
            $onesignalRestKey=$_POST['onesignalRestKey'];
            $appOpenId=$_POST['appOpenId'];
            $query_adv = "INSERT INTO ads_id (ads_enabled,adMobBannerId,adMobInterstitialId,adMobNativeId,appOpenId,app_id,fb_ad_banner,fb_ad_inter,fb_ad_native,onesignal_app_id,onesignal_rest_key) VALUES ( :enable, :banner,:interstitial,:native,:open,:app,:fbbanner,:fbinter,:fbnative,:oneAppId,:oneRestKey)";
            $stmt_adv=$connection->prepare($query_adv);       
            $stmt_adv->execute(['enable'=>$enable,'banner'=>$adMobBannerId,'interstitial'=>$adMobInterstitialId,'native'=>$adMobNativeId,'open'=>$appOpenId,'app'=>$id,'fbbanner'=>$faceBannerId,'fbinter'=>$faceInterstitialId,'fbnative'=>$faceNativeId,'oneAppId'=>$onesignalAppId,'oneRestKey'=>$onesignalRestKey]);
       }
       $_SESSION['msg']="10";
       header('Location: apps.php');
} 
?>