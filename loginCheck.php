<?php 
    session_start();
    include('database/dbconfig.php');
    if(isset($_POST['login_btn']))
    {
        $username=$_POST['username'];
        $pass=$_POST['pass'];
        // $hashPass=password_hash($pass,PASSWORD_BCRYPT);

        $query="select * from users where username=:username and password=:pass";
        $stmt=$connection->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pass", $pass);        
        if($stmt->execute()){
            if($stmt->rowCount()>0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);                             
                $_SESSION['username']=$row['username'];
                echo $_SESSION['username'];
                header('Location: index.php');
            }    
            else{
                $_SESSION['status']="Mobile No or password is invalid!";
                echo $_SESSION['status'];
                header('Location: login.php');   
            }
        }
        else{
            $_SESSION['status']="Please try again after some time!!";
            echo $_SESSION['status'];
            header('Location: login.php');   
        }
    }
?>