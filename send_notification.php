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
include("includes/header.php");
include("includes/navibar.php");
include("includes/functions.php");
include('database/dbconfig.php');
require("includes/language.php");

if(isset($_POST['notification_send']))
  {

    if($_POST['external_link']!="")
     {
        $external_link = $_POST['external_link'];
     }
     else
     {
        $external_link = false;
     }

    if($_FILES['big_picture']['name']!="")
    {   

        $big_picture=time()."_".$_FILES['big_picture']['name'];        
        $tpath2="AppImages/".$big_picture;
        move_uploaded_file($_FILES["big_picture"]["tmp_name"], $tpath2);

        $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI'])."/AppImages/".$big_picture;
          
        $content = array(
                         "en" => $_POST['notification_msg']                                                 
                         );

        $fields = array(
                        'app_id' => $_POST['onesignalAppId'],
                        'included_segments' => array('All'),                                            
                        'data' => array("foo" => "bar","external_link"=>$external_link),
                        'headings'=> array("en" => $_POST['notification_title']),
                        'contents' => $content,
                        'small_icon' => 'logo',
                        'big_picture' =>$file_path                    
                        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$_POST['onesignalRestKey']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        
    }
    else
    {

 
        $content = array(
                         "en" => $_POST['notification_msg']
                          );

        $fields = array(
                'app_id' => $_POST['onesignalAppId'],
                'included_segments' => array('All'), 
                'small_icon' => 'logo',
                'data' => array("foo" => "bar","external_link"=>$external_link),
                'headings'=> array("en" => $_POST['notification_title']),
                'contents' => $content,
                 'priority' => 10
          );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'Authorization: Basic '.$_POST['onesignalRestKey']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);


    }
        
        $_SESSION['msg']="17";
     
        echo("<script>location.href = '".BASEPATH."/send_notification.php?id=".$appId."';</script>");
        exit; 
     
     
  }



?>  
<!-- Begin Page Content -->
<div class="container-fluid" style="padding-top:25px">
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
            <h6 class="m-0 col-md font-weight-bold text-primary">Send Notification<?php if(isset($rowApp['appName'])){ echo " -> ".$rowApp['appName'];}?></h6>        
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
        <?php if(!isset($rowApp['appName'])){?>
                <h3 style="margin: auto; padding:auto;">Can't send notification to unknown application</h3>
            <?php }else{?>
        <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="onesignalRestKey" value="<?php echo $rowAdv['onesignal_rest_key']?>"/>
            <input type="hidden" name="onesignalAppId" value="<?php echo $rowAdv['onesignal_app_id']?>"/>
            <div class="section">
                <div class="section-body">
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Title :-</label>
                        <div class="col-md-6">
                            <input type="text" name="notification_title" id="notification_title" class="form-control" value="" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Message :-</label>
                        <div class="col-md-6">
                            <textarea name="notification_msg" id="notification_msg" class="form-control" required></textarea>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Image :-<br/>(Optional)</label>
                        <div class="col-md-6">
                        <div class="fileupload_block">
                            <input type="file" name="big_picture" value="" id="fileupload">
                            <!-- <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>     -->
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label text-dark">Other Link :-<br/>(Optional)</label>
                        <div class="col-md-6">
                            <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://www.example.com">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="notification_send" class="btn btn-primary">Send Notification</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php }?>
    </div>
</div>    

<?php 
include("includes/scripts.php");
include("includes/footer.php");
?>