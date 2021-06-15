<?php
session_start();
if(!$_SESSION['username']){
    header('Location: login.php');
} 
include('security.php');
include("includes/header.php");
include("includes/navibar.php");
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid" style="padding-top:25px">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Admins Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Applications</div>                                        
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                            $apps_count_query="select id from apps where reference_app=-1 order by id";
                                            $apps_stmt=$connection->prepare($apps_count_query);
                                            $apps_stmt->execute();
                                            $appsCount=$apps_stmt->rowCount();
                                            echo "$appsCount";                                    
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fab fa-android fa-2x text-gray-300"></i>
                                    <!-- <i class="fa fa-android fa-2x text-gray-300"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Apks</div>                                        
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php
                                            $apps_count_query="select id from apks where reference_app!=-1 order by id";
                                            $apps_stmt=$connection->prepare($apps_count_query);
                                            $apps_stmt->execute();
                                            $appsCount=$apps_stmt->rowCount();
                                            echo "$appsCount";                                    
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fab fa-android fa-2x text-gray-300"></i>
                                    <!-- <i class="fa fa-android fa-2x text-gray-300"></i> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                
            </div>

        </div>
        <!-- /.container-fluid -->        

    </div>
    <!-- End of Main Content -->



<?php 
include("includes/scripts.php");
include("includes/footer.php");
?>