<?php 
session_start();
if(!$_SESSION['username']){
    header('Location: login.php');
} 
include("includes/header.php");
include("includes/navibar.php");	
 
$query="select * from apps where reference_app=-1";
$stmt=$connection->prepare($query);
$stmt->execute();  
?>
 
 <!-- Begin Page Content -->
<div class="container-fluid" style="padding-top:25px">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <h6 class="m-0 col-md font-weight-bold text-dark">Add Application</h6>            
        </div>
    </div>    
    <div class="card-body">
    <div class="row">
      <div class="col-md-12">                
          <div class="clearfix"></div>          
            <form class="form form-horizontal" action="addApplication_db.php" method="post" enctype="multipart/form-data">
              <div class="section">                            
                  <div class="form">
                  <div class="form-group">
                      <label class="control-label font-weight-bold text-primary">Application Details </label>
                      <hr>
                  </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label font-weight-bold text-dark">Application Name :-</label>
                    <div class="col-md-9">                      
                          <input type="text" name="appName" class="form-control" placeholder="Enter Application Name" style="height:50px; width:100%;" required>                   
                    </div>
                  </div>                
                <div class="section-body">
                                                        
                <div class="form-group">
                      <label class="col-md-3 control-label font-weight-bold text-dark">Packages :-</label>
                    <div class="col-md-9">                       
                          <input type="text" name="packages" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                   
                    </div>
                  </div>
                  <!-- <div class="form-group">
                      <label class="col-md-3 control-label font-weight-bold text-dark">Refernce Application :-</label>
                    <div class="col-md-9">                       
                          <select class="form-select" name="reference">
                            <option value="-1">No Reference</option>
                            <?php
                                if($stmt->rowCount()>0){
                                  $i=1;
                                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){   
                                    echo "<option value=".$row['Id'].">".$row['appName']."</option>";                         
                                  }
                                }
                            ?>
                          </select>                          
                    </div>
                  </div> -->

                  <div class="form-group">
                      <label class="col-md-1 control-label font-weight-bold text-dark">Status</label>                    
                        <input type="checkbox" value="1" name="status" class="col-md-1 form-control-checkbox" placeholder="" >                                       
                  </div>
                  <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Url :-</label>
                        <div class="col-md-6">
                            <input type="text" name="url" id="url" class="form-control">
                        </div>                        
                    </div>

                  <div class="form-group">
                    <label class="col-md-3 control-label font-weight-bold text-dark">Image :-
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="image" required>                       
                      </div>
                    </div>
                  </div>

                    <hr>                                                 
                 <div class="form-group">
                      <label class="control-label font-weight-bold text-primary">AdMob Details </label>
                      <hr>
                  </div>
                    <div class="form-group ">
                        <label class="col-md-2 control-label font-weight-bold text-dark">Adv Enable</label>                    
                        <input type="checkbox" value="1" name="adv_enable" class="col-md-1 form-control-checkbox" placeholder="" >                                       
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Banner AD ID :-</label>
                        <div class="col-md-9">                                                
                        <input type="text" name="adMobBannerId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                                                   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Interstitial AD ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="adMobInterstitialId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Native AD ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="adMobNativeId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">App Open ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="appOpenId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                      <label class="control-label font-weight-bold text-primary">Facebook Adv Details </label>
                      <hr>
                  </div>
                  <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Facebook Banner AD ID :-</label>
                        <div class="col-md-9">                                                
                        <input type="text" name="faceBannerId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                                                   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Facebook Interstitial AD ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="faceInterstitialId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Facebook Native AD ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="faceNativeId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                      <label class="control-label font-weight-bold text-primary">Notification Details </label>
                      <hr>
                  </div>
                  <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Onesignal App ID :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="onesignalAppId" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label font-weight-bold text-dark">Onesignal Rest Key :-</label>
                        <div class="col-md-9">                        
                        <input type="text" name="onesignalRestKey" class="form-control" placeholder="Enter Packages" style="height:50px; width:100%;" required>                                           
                        </div>
                    </div>

                  <div class="form-group">&nbsp;</div>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="addApp" class="btn btn-primary">Upload</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </form>                  
      </div>
    </div> 
    </div>
</div>


                 
                 
        
<?php
include("includes/scripts.php"); 
include("includes/footer.php");
?>       
