<?php  
session_start();//session starts here  
?>
<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EZ SYSTEM</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.sea.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/ez-1.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <?php  
  
include("dbconnect.php");  

$error = "";  
if(isset($_POST['login']))  
{  
    $email=$_POST['email'];  
    $password=$_POST['password'];  

    $password=md5($password);
  
    $check_user="select * from participant WHERE email='$email'AND password='$password'";  
  
    $run=mysqli_query($conn,$check_user);  
  
    if(mysqli_num_rows($run))  
    {  
        echo "<script>window.open('homepage-participant.php','_self')</script>";  
  
        $_SESSION['email']=$email;//here session is used and value of $user_email store in $_SESSION.  
  
    }  
    else  
    {  
      $error = "Incorrect email or password.";
      //echo "<script>alert('Email or password is incorrect!')</script>";  
    }  
}  
?>
  <body>
    <div class="login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>PARTICIPANT</h1>
                  </div>
                  <p>Automated Conference Management System using NFC Technology</p>
                  <br><center><a href="index.php"><img src="img/ez-1.png" width="100px;"></a></center>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6">
              <div class="form d-flex align-items-center">
                <div class="content">
                      <?php if($error != "") {
                        echo
                        '<br><div class="alert alert-danger alert-dismissible fade show">
                            <strong>Oops!</strong> '. $error . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>'; }?>
                  <form method="post" class="form-validate mb-4" action="login-participant.php" autocomplete="">
                    <div class="form-group">
                      <input id="login-username" type="email" name="email" required data-msg="Please enter your email address" class="input-material">
                      <label for="login-username" class="label-material">Email Address</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                      <label for="login-password" class="label-material">Password</label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Login" name="login">
                  </form><a href="reset_pass1.php" class="forgot-pass">Forgot Password?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://youtube.com/c/mantoak/" class="external">Toak</a></p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>