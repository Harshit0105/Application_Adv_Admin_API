<?php
session_start();
include('includes/header.php');
?>
<div class="container">        
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="./img/loginPic.svg" style="padding-top:15px; padding-bottom:15px;" class="col-lg-12 d-none d-lg-block"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                        <?php
                                         if(isset($_SESSION['status']) && $_SESSION['status']!=''){
                                            echo '<h5 class="text-danger">'.$_SESSION['status'].'</h5>';
                                            unset($_SESSION['status']);
                                         }
                                        ?>
                                    </div>

                                    <form class="user" action="loginCheck.php" method="post">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputUsername" aria-describedby="usernameHelp"
                                                placeholder="Enter Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="pass" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" required>
                                        </div>                                        
                                        <button trpe="submit" name="login_btn" class="btn btn-primary btn-user btn-block">Login</button>                                        
                                    </form>
                                    <hr>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>        

    

<?php 
include("includes/scripts.php");
// include("includes/footer.php");
?>