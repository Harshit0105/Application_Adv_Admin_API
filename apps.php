<?php 
session_start();
if(!$_SESSION['username']){
    header('Location: login.php');
} 
include("includes/header.php");
include("includes/navibar.php");
include("includes/language.php");
?>


<!-- Begin Page Content -->
<div class="container-fluid" style="padding-top:25px">

<!-- Page Heading -->

<?php
        $query="select * from apps where reference_app=-1";
        $stmt=$connection->prepare($query);
        $stmt->execute();        
?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <h6 class="m-0 col-md font-weight-bold text-primary">Applications</h6>
            <a class="col-md-2 btn btn-sm btn-primary" type="button" href="addApplication.php">Add Application</a>
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
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Name</th>
                        <th>Packages</th>                        
                        <th>Logo</th>
                        <th></th>     
                                          
                    </tr>
                </thead>                
                <tbody>
                    <?php
                     if($stmt->rowCount()>0){
                        $i=1;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){                            
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $row['appName'];?></td>
                                <td><?php echo $row['packageName'];?></td>                                          
                                <td><img src="<?php echo $row['image'];?>" style="max-width:200px;max-height:200px;" alt="Application Logo" class="img-responsive img-thumbnail"></td>
                                <td>   
                                <div class="col-md-12">     
                                <?php                                    
                                    echo '<a type="button" style="margin-right:2px;margin-bottom:2px;" onclick="javascript:confirmationDelete($(this));return false;" name="deleteLabButton" class="btn btn-outline-danger waves-effect" href="deleteApplication.php?Id='.$row['Id'].'">Delete</a>';                                    
                                    echo '<a type="button" style="margin-right:2px;margin-bottom:2px;" name="patientsButton" class="btn btn-outline-primary waves-effect" href="appData.php?id='.$row['Id'].'">Details</a>';
                                    echo '<a type="button" style="margin:1px" name="sendNotificationButton" class="btn btn-outline-success waves-effect px-3" href="send_notification.php?id='.$row['Id'].'"><i class="fas fa-paper-plane" aria-hidden="true"></i></a>';                                    
                                ?>
                                </div>
                                </td>                                                  
                            </tr>     
                    <?php
                            $i=$i+1;                                               
                        }
                     }                     
                    ?>                                
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmationDelete(anchor)
    {
        var conf = confirm('Are you sure want to delete?');
        if(conf)
            window.location=anchor.attr("href");
    }
</script>
<!-- /.container-fluid -->
<?php 

include("includes/scripts.php");
include("includes/footer.php");
?>