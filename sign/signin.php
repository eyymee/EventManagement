<?php
session_start();//session starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/em.png">
    <link rel="icon" type="image/png" href="../assets/img/em.png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Management</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<style>
body {
  background-color: #330033;
}
</style>
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
          echo "<script>window.open('../management/home.php','_self')</script>";

          $_SESSION['email']=$email;//here session is used and value of $user_email store in $_SESSION.

      }
      else
      {
        $error = "Sorry, your username or password is incorrect. Please try again.";
        //echo "<script>alert('Email or password is incorrect!')</script>";
      }
  }
?>
<body>
  <br />
  <br />
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                        <center><a href="../management/index.php" class="signup-image-link">Home</a></center>
                    </div>

                    <div class="signin-form">
                      <?php if($error != "") {
                        echo
                        '<br><div class="alert alert-danger alert-dismissible fade show">
                            <strong style="color:red;">Sign In Error!</strong> '. $error . '
                        </div>'; }?>
                        <h2 class="form-title">Participant</h2>
                        <form method="POST" class="register-form" id="login-form" action="signin.php" autocomplete="">
                            <div class="form-group">
                                <label for="login-username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input id="login-username" type="email" name="email" required data-msg="Please enter your email address" class="input-material" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <label for="login-password"><i class="zmdi zmdi-lock"></i></label>
                                <input id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="login" id="login" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
