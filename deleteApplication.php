<?php
session_start();
if(!$_SESSION['username']){
    header('Location: login.php');
} 
include('security.php');
if(isset($_GET['Id'])){
    $Id = $_GET['Id'];   
    $queryApp="select * from apps where Id=".$Id;
    $stmt=$connection->prepare($queryApp);
    $stmt->execute();
    $rowApp = $stmt->fetch(PDO::FETCH_ASSOC); 
    if($rowApp['appName']!=null){
        unlink($rowApp['image']); 
        $app_query = "DELETE  FROM apps WHERE Id='$Id' ";    
        $stmt=$connection->prepare($app_query);
        $stmt->execute();
    }
    $_SESSION['msg']="12";
    header('location: apps.php');
}
?>