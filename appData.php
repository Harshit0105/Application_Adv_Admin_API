<?php 
session_start();
if(!$_SESSION['username']){
    header('Location: login.php');
} 
if(isset($_GET['id'])){
    $appId=$_GET['id'];        
}
else{
    header('location: apps.php');
}
if(isset($_GET['update'])){
    $isUpdate=true;
}
else{
    $isUpdate=false;
}
include("includes/header.php");
include("includes/navibar.php");
include("includes/functions.php");
include('database/dbconfig.php');
require("includes/language.php");

if(isset($_POST['delete_apk_submit'])){
    $appId=$_POST['appId'];     
    $refId=$_POST['appRefId'];
    $app_query = "DELETE  FROM apks WHERE Id='$appId' ";    
    $stmt=$connection->prepare($app_query);
    $stmt->execute();
    $_SESSION['msg']="12";
    echo("<script>location.href = '".BASEPATH."/appData.php?id=".$refId."';</script>");
}

//Application Details Update
if(isset($_POST['app_details_submit']))
{
    $appName=$_POST['appName'];
	$packages = $_POST['packages'];
    $status = isset($_POST['status'])? 1 : 0;
    $url=$_POST['url'];
    if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE){
        // echo "File not selected";
        $data = array(                         
            'appName'  =>  $appName,
            'packageName'  =>  $packages,            
            'url'  =>  $url,
            'status'  =>  $status, 
        );
    }
    else{        
        // echo "File selected....";
        $imagepath_name = $_FILES['image']['name'];
        $imagepath = "AppImages/".str_replace(" ","_",$appName)."_".time().".jpg";
        unlink($_POST['app_logo']); 
        move_uploaded_file($_FILES['image']['tmp_name'],$imagepath);	
        $data = array(                         
            'appName'  =>  $appName,
            'packageName'  =>  $packages,
            'image'  =>  $imagepath,
            'url'  =>  $url,
            'status'  =>  $status, 
        );
    }        
    $where="WHERE Id=".$_POST['appId'];
    $settings_edit=UpdateAppDetails($connection,'apps', $data, $where);
    if ($settings_edit > 0)
    {        
        // echo "App Updated Succ...";
        $_SESSION['msg']="11";
        if(isset($_POST['isApk'])){
            echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appReferenceId']."';</script>");    
        }
        else{
            echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appId']."';</script>");
        }
        
         exit;
    }    
     
}

if(isset($_POST['apk_details_edit']))
{
    $appName=$_POST['appName'];
	$packages = $_POST['packages'];
    $status = isset($_POST['status'])? 1 : 0;
    $url=$_POST['url'];
    if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE){
        // echo "File not selected";
        $data = array(                         
            'appName'  =>  $appName,
            'packageName'  =>  $packages,            
            'url'  =>  $url,
            'status'  =>  $status, 
        );
    }
    else{        
        // echo "File selected....";
        $imagepath_name = $_FILES['image']['name'];
        $imagepath = "AppImages/".str_replace(" ","_",$appName)."_".time().".jpg";
        unlink($_POST['app_logo']); 
        move_uploaded_file($_FILES['image']['tmp_name'],$imagepath);	
        $data = array(                         
            'appName'  =>  $appName,
            'packageName'  =>  $packages,
            'image'  =>  $imagepath,
            'url'  =>  $url,
            'status'  =>  $status, 
        );
    }        
    $where="WHERE Id=".$_POST['appId'];
    $settings_edit=UpdateAppDetails($connection,'apks', $data, $where);
    if ($settings_edit > 0)
    {        
        // echo "App Updated Succ...";
        $_SESSION['msg']="11";
        if(isset($_POST['isApk'])){
            echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appReferenceId']."';</script>");    
        }
        else{
            echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appId']."';</script>");
        }
        
         exit;
    }    
     
}

if(isset($_POST['apk_details_submit']))
{
    $errors= array();
    $imagepath_name = $_FILES['image']['name'];	  
	//   $videotitle =   str_replace(".zip","",$videopzip_name);   /*$_POST['videotitle'];*/
    $appName=$_POST['appName'];
	$packages = $_POST['packages'];
    $reference =isset($_POST['appReferenceId']) ? $_POST['appReferenceId'] : -1;
    $status = isset($_POST['status'])? 1 : 0;
    $url=$_POST['url'];
    $imagepath = "AppImages/".str_replace(" ","_",$appName)."_".time().".jpg"; 
           

    move_uploaded_file($_FILES['image']['tmp_name'],$imagepath);	       	         	   		
    $query = "INSERT INTO apks (appName,packageName,image,status,url,reference_app) VALUES ( :appName, :pName,:image,:status,:url,:reference)";
    $stmt=$connection->prepare($query);
    $stmt->execute(['appName'=>$appName,'pName'=>$packages,'image'=>$imagepath,'status'=>$status,'url'=>$url,"reference"=>$reference]);
            // echo "App Updated Succ...";
    $_SESSION['msg']="10";
    echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appReferenceId']."';</script>");
    exit;    
     
}

//Notification Details Update
if(isset($_POST['notification_submit']))
{
    $onesignalAppId=$_POST['onesignalAppId'];
	$onesignalRestKey = $_POST['onesignalRestKey'];        
    $data = array(                         
        'onesignal_app_id'  =>  $onesignalAppId,
        'onesignal_rest_key'  =>  $onesignalRestKey,                    
    );                
    $where="WHERE app_id=".$_POST['appId'];
    $settings_edit=UpdateAppDetails($connection,'ads_id', $data, $where);
    if ($settings_edit > 0)
    {        
        // echo "App Updated Succ...";
        $_SESSION['msg']="11";
        echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appId']."';</script>");   	    
        exit;
    }              
}

if(isset($_POST['adMob_submit']))
{
    $enable = isset($_POST['adv_enable'])? 1 : 0;
    $adMobBannerId=$_POST['adMobBannerId'];
    $adMobInterstitialId=$_POST['adMobInterstitialId'];
    $adMobNativeId=$_POST['adMobNativeId'];
    $appOpenId=$_POST['appOpenId'];      
    $data = array(                         
        'ads_enabled'  =>  $enable,
        'adMobBannerId'  =>  $adMobBannerId,
        'adMobInterstitialId'  =>  $adMobInterstitialId,            
        'adMobNativeId'  =>  $adMobNativeId,        
        'appOpenId'  =>  $appOpenId, 
    );                 
    $where="WHERE app_id=".$_POST['appId'];
    $settings_edit=UpdateAppDetails($connection,'ads_id', $data, $where);
    if ($settings_edit > 0)
    {        
        // echo "App Updated Succ...";
        $_SESSION['msg']="11";
        echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appId']."';</script>");
         exit;
    }    
     
}

if(isset($_POST['facebook_submit']))
{
    $faceBannerId=$_POST['faceBannerId'];
    $faceInterstitialId=$_POST['faceInterstitialId'];
    $faceNativeId=$_POST['faceNativeId'];    
    $data = array(           
        'fb_ad_banner'  =>  $faceBannerId,
        'fb_ad_inter'  =>  $faceInterstitialId,            
        'fb_ad_native'  =>  $faceNativeId,                
    );                 
    $where="WHERE app_id=".$_POST['appId'];
    $settings_edit=UpdateAppDetails($connection,'ads_id', $data, $where);
    if ($settings_edit > 0)
    {        
        // echo "App Updated Succ...";
        $_SESSION['msg']="11";
        echo("<script>location.href = '".BASEPATH."/appData.php?id=".$_POST['appId']."';</script>");
         exit;
    }    
     
}

?>

<!-- Begin Page Content -->
<div class="container-fluid" style="padding-top:25px">

<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Admins</h1> -->
<?php
    $queryApp="select * from apps where Id=".$appId;
    $stmt=$connection->prepare($queryApp);
    $stmt->execute();
    $rowApp = $stmt->fetch(PDO::FETCH_ASSOC);    
    $queryAdv="select * from ads_id where app_id=".$appId;
    $stmt=$connection->prepare($queryAdv);
    $stmt->execute();
    $rowAdv = $stmt->fetch(PDO::FETCH_ASSOC);    
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <a href="apps.php"><h6 class="m-0 col-md font-weight-bold text-primary">Application</h6>        </a>
        </div>
        <div class="row mrg-top">
            <div class="col-md-12">        
                <div class="col-md-12 col-sm-12">
                    <?php if(isset($_SESSION['msg'])){?> 
                        <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                    <?php unset($_SESSION['msg']);}?> 
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist" id="myTab">
            <li role="presentation" class="nav-item"><a class="nav-link active font-weight-bold text-dark" href="#application_details" id="application_details-tab" aria-controls="application_details" role="tab" data-toggle="tab">Application Details</a></li>            
            <li role="presentation" class="nav-item"><a class="nav-link font-weight-bold text-dark" href="#notification_settings" id="notification_settings-tab" aria-controls="notification_settings" role="tab" data-toggle="tab">Notification Settings</a></li>            
            <li role="presentation" class="nav-item"><a class="nav-link font-weight-bold text-dark" href="#admob_settings" id="admob_settings-tab" aria-controls="admob_settings" role="tab" data-toggle="tab">AdMob Settings</a></li>   
            <li role="presentation" class="nav-item"><a class="nav-link font-weight-bold text-dark" href="#facebook_settings" id="facebook_settings-tab" aria-controls="facebook_settings" role="tab" data-toggle="tab">Facebook Settings</a></li>   
            <li role="presentation" class="nav-item"><a class="nav-link font-weight-bold text-dark" href="#apk_settings" id="apk_settings-tab" aria-controls="apk_settings" role="tab" data-toggle="tab">Apks</a></li>   
        </ul>
        <div class="tab-content">
        <div class="tab-pane fade show active" id="application_details" role="tabpanel" aria-labelledby="application_details-tab">
            <?php if(!isset($rowApp['appName'])){?>
                <h3 style="margin: auto; padding:auto;">No data found!</h3>
            <?php }else{?>
            <form action="" name="app_details" method="post" class="form form-horizontal" enctype="multipart/form-data" id="app_details_form"> 
            <input type="hidden" name="appId" value="<?php echo $rowApp['Id'];?>"/>
            <input type="hidden" name="app_logo" value="<?php echo $rowApp['image'];?>"/>
            <input type="hidden" class="current_tab"   name="current_tab">
            <div class="section card">
                <div class="section-body card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Application Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="appName" id="appName" value="<?php echo  $rowApp['appName'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Package Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="packages" id="packages" value="<?php echo  $rowApp['packageName'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Status :-</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" id="status" name="status" class="form-control-checkbox" <?php if($rowApp['status']==1){echo "checked";}?>>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Current Logo :-</label>
                        <div class="col-md-6">
                          <img src="<?php echo $rowApp['image'];?>" style="max-width:300px;max-height:300px;" alt="Application Logo" class="img-thumbnail">
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Change Logo :-<label class="text-danger">(*Select only if you want to change it)</label></label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="image" >
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Url :-</label>
                        <div class="col-md-6">
                            <input type="text" name="url" id="url" value="<?php echo  $rowApp['url'];?>" class="form-control" required>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="app_details_submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php }?>
        </div>    
        <div class="tab-pane fade" id="notification_settings" role="tabpanel" aria-labelledby="notification_settings-tab">
            <?php if(!isset($rowApp['appName'])){?>
                <h3 style="margin: auto; padding:auto;">No data found!</h3>
            <?php }else{?>
            <form action="" name="notification_details" method="post" class="form form-horizontal" enctype="multipart/form-data" id="notification_form"> 
                <input type="hidden" name="appId" value="<?php echo $rowAdv['app_id'];?>"/>   
                <input type="hidden" class="current_tab"   name="current_tab">             
            <div class="section card">
                <div class="section-body card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Onesignal App ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="onesignalAppId" id="onesignalAppId" value="<?php echo  $rowAdv['onesignal_app_id'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Onesignal Rest Key :-</label>
                        <div class="col-md-6">
                            <input type="text" name="onesignalRestKey" id="onesignalRestKey" value="<?php echo  $rowAdv['onesignal_rest_key'];?>" class="form-control" required>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="notification_submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php }?>
        </div>
        <div class="tab-pane fade" id="admob_settings" role="tabpanel" aria-labelledby="admob_settings-tab">
            <?php if(!isset($rowApp['appName'])){?>
                <h3 style="margin: auto; padding:auto;">No data found!</h3>
            <?php }else{?>
            <form action="" name="adMob_details" method="post" class="form form-horizontal" enctype="multipart/form-data" id="adMob_form"> 
                <input type="hidden" name="appId" value="<?php echo $rowAdv['app_id'];?>"/>  
                <input type="hidden" class="current_tab"   name="current_tab">              
            <div class="section card">
                <div class="section-body card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Adv Enable :-</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" id="adv_enable" name="adv_enable" class="form-control-checkbox" <?php if($rowAdv['ads_enabled']==1){echo "checked";}?>>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Banner AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="adMobBannerId" id="adMobBannerId" value="<?php echo  $rowAdv['adMobBannerId'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Interstitial AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="adMobInterstitialId" id="adMobInterstitialId" value="<?php echo  $rowAdv['adMobInterstitialId'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Native AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="adMobNativeId" id="adMobNativeId" value="<?php echo  $rowAdv['adMobNativeId'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">App Open ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="appOpenId" id="appOpenId" value="<?php echo  $rowAdv['appOpenId'];?>" class="form-control" required>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="adMob_submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php }?>
        </div>
        <div class="tab-pane fade" id="facebook_settings" role="tabpanel" aria-labelledby="facebook_settings-tab">
            <?php if(!isset($rowApp['appName'])){?>
                <h3 style="margin: auto; padding:auto;">No data found!</h3>
            <?php }else{?>
            <form action="" name="facebook_details" method="post" class="form form-horizontal" enctype="multipart/form-data" id="facebook_form"> 
                <input type="hidden" name="appId" value="<?php echo $rowAdv['app_id'];?>"/>   
                <input type="hidden" class="current_tab"   name="current_tab">             
            <div class="section card">
                <div class="section-body card-body">                    
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Facebook Banner AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="faceBannerId" id="faceBannerId" value="<?php echo  $rowAdv['fb_ad_banner'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Facebook Interstitial AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="faceInterstitialId" id="faceInterstitialId" value="<?php echo  $rowAdv['fb_ad_inter'];?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Facebook Native AD ID :-</label>
                        <div class="col-md-6">
                            <input type="text" name="faceNativeId" id="faceNativeId" value="<?php echo  $rowAdv['fb_ad_native'];?>" class="form-control" required>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="facebook_submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php }?>
        </div>
        <div class="tab-pane fade" id="apk_settings" role="tabpanel" aria-labelledby="apk_settings-tab">
            <div class="row" style="margin:10px"><button class="col-12 btn btn-success" onclick="addApk(<?php echo $appId;?>)">Add Apk</button></div>
            <ul class="list-group">
            <?php
                $queryRef="select * from apks where reference_app=".$appId;
                $stmt=$connection->prepare($queryRef);
                $stmt->execute();                
                if($stmt->rowCount()>0){
                    $i=1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){   ?>    
                    <li class="list-group-item">                        
                        <div class="section card">
                            <div class="section-body card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label text-dark">Application Name :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="<?php echo  $row['appName'];?>" id="appName" value="<?php echo  $row['appName'];?>" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label text-dark">Package Name :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="<?php echo  $row['packageName'];?>" id="packages" value="<?php echo  $row['packageName'];?>" class="form-control" disabled required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label text-dark">Status :-</label>
                                    <div class="col-md-6">
                                        <input type="checkbox" value="1" id="status" name="<?php if($row['status']==1){echo "checked";}?>" class="form-control-checkbox" <?php if($row['status']==1){echo "checked";}?> disabled>
                                    </div>                        
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 control-label text-dark">Current Logo :-</label>
                                    <div class="col-md-6">
                                    <img src="<?php echo $row['image'];?>" alt="Application Logo" style="max-width:200px;max-height:200px;" class="img-thumbnail">
                                    </div>                        
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-md-3 control-label text-dark">Url :-</label>
                                    <div class="col-md-6">
                                        <input type="text" name="urlLabel" id="url" value="<?php echo  $row['url'];?>" class="form-control" required disabled>
                                    </div>                        
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 col-md-offset-3">
                                    <button class="btn btn-warning" onclick="editApk('<?php echo  $row['Id'];?>','<?php echo  $row['appName'];?>','<?php echo  $row['packageName'];?>','<?php echo  $row['status'];?>','<?php echo $row['image'];?>','<?php echo  $row['url'];?>','<?php echo  $row['reference_app'];?>')">Edit Apk</button>
                                    <button class="btn btn-danger"  onclick="deleteApk('<?php echo  $row['Id'];?>','<?php echo  $row['reference_app'];?>')">Delete Apk</button>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>                    
                   <?php }
                }
                else{
                   echo '<h3 style="margin: auto; padding:auto;">No data found!</h3>';
                }
            ?>                            
            </ul>                        
        </div> 
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addApkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Apk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" name="apk_details" method="post" class="form form-horizontal" enctype="multipart/form-data" id="apk_details_form"> 
            <input type="hidden" name="appReferenceId" id="appReferenceId"/>
            <!-- <input type="hidden" name="app_logo" id="apkLogo"/> -->
            <!-- <input type="hidden" class="current_tab" name="current_tab"> -->
            <div class="section card">
                <div class="section-body card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Application Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="appName" id="apkName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Package Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="packages" id="Apkpackages" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Status :-</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" id="Apkstatus" name="status" class="form-control-checkbox">
                        </div>                        
                    </div>                    
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Logo :-</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="image" >
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Url :-</label>
                        <div class="col-md-6">
                            <input type="text" name="url" id="Apkurl" class="form-control" required>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="apk_details_submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="editApkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Apk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" name="apk_details_edit" method="post" class="form form-horizontal" enctype="multipart/form-data" id="apk_details_edit_form"> 
            <input type="hidden" name="appReferenceId" id="appEditReferenceId"/>
            <input type="hidden" name="appId" id="appId"/>
            <input type="hidden" name="isApk" value="true">
            <!-- <input type="hidden" name="app_logo" id="apkLogo"/> -->
            <!-- <input type="hidden" class="current_tab" name="current_tab"> -->
            <div class="section card">
                <div class="section-body card-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Application Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="appName" id="apkEditName" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Package Name :-</label>
                        <div class="col-md-6">
                            <input type="text" name="packages" id="ApkEditPackages" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Status :-</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" id="ApkEditStatus" name="status" class="form-control-checkbox">
                        </div>                        
                    </div>     
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Current Logo :-</label>
                        <div class="col-md-6">
                            <img src="" id="ApkEditLogo" alt="Application Logo" style="max-width:200px;max-height:200px;" class="img-thumbnail">
                        </div>                        
                    </div>               
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Logo :-<label class="text-danger">(Select only if you want to change)</label></label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="image" >
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Url :-</label>
                        <div class="col-md-6">
                            <input type="text" name="url" id="ApkEditurl" class="form-control" required>
                        </div>                        
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="apk_details_edit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="deleteApkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Apk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        Are you ure you want to delete It!!
      </div>
      <div class="modal-footer">
      <form action="" name="apk_details_edit" method="post" class="form form-horizontal" enctype="multipart/form-data" id="apk_details_edit_form"> 
        <input type="hidden" name="appId" id="deleteAppId"/>
        <input type="hidden" name="appRefId" id="deleteAppRefId"/>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="delete_apk_submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 
include("includes/scripts.php");?>
<script type="text/javascript">    
function addApk(appId){
    $("#appReferenceId").val(appId);
    $("#addApkModal").modal("show");
}
function deleteApk(appId,refId){
    $("#deleteAppId").val(appId);
    $("#deleteAppRefId").val(refId);
    $("#deleteApkModal").modal("show");
}
function editApk(appId,name,package,status,image,url,reference){
    $("#appEditReferenceId").val(reference);
    $("#appId").val(appId);
    $("#apkEditName").val(name);
    $("#ApkEditPackages").val(package);
    $("#ApkEditLogo").attr("src",image);
    $("#ApkEditurl").val(url);
    if(status=='1'){
        $('#ApkEditStatus').prop('checked', true);        
    }
    else{
        $('#ApkEditStatus').prop('checked', false);        
    }
    $("#editApkModal").modal("show");
}
function confirmationDelete(anchor)
    {
        var conf = confirm('Are you sure want to delete?');
        if(conf)
            window.location=anchor.attr("href");
    }
</script>
<?php
include("includes/footer.php");
?>
