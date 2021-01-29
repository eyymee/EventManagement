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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
body {
  background-color: #330033;
}
</style>
<?php
  $message = "";
  $error = "";
    //TO ADD DATA
    if (isset($_POST['register'])) {
      $username = addslashes($_POST['name']);
      $ic = addslashes($_POST['ic']);
      $email = addslashes($_POST['email']);
      $password = addslashes($_POST['password']);
      $password2 = addslashes($_POST['password2']);

      $password = md5($password);
      $password2 = md5($password2);

      include 'dbconnect.php';

      $check = "SELECT ic FROM participant WHERE ic='$ic'";
      $haha = mysqli_query($conn,$check);
      $hahaha = mysqli_fetch_array($haha, MYSQLI_ASSOC);

      if(!$hahaha){
      	$check1 = "SELECT email FROM participant WHERE email='$email'";
      	$huhu = mysqli_query($conn,$check1);
      	$huhuhu = mysqli_fetch_array($huhu, MYSQLI_ASSOC);

      	if(!$huhuhu){
      		if($password == $password2){
            $username = strtoupper($username);
			      $query = "INSERT INTO participant (name, ic, email, password) VALUES
			        ('$username','$ic', '$email', '$password')";
			      $result = mysqli_query($conn,$query);

			      if ($result){
			        //echo "<script type='text/javascript'>alert('REGISTER SUCCESS')</script>";
			        //header("Location: listparticipant.php");
			        $message = "Participant have been registered!";
            }
			      else
			        echo "<script type='text/javascript'>alert('FAILED')</script>";
				}
				else
					$error = "Password do not match!";
			}
			else
				$error = "Email is already exist";
		}
		else
			$error = "IC number is already exist";
    }
    ?>
<body>
        <!-- Sign up form -->
        <section class="sign-up">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up as Participant</h2>
                        <?php if($message != "") {
                          echo
                            '
                                <strong style="color:green;">Success!</strong> '. $message . '
                            '; }?>
                            <?php if($error != "") {
                          echo
                            '
                                <strong style="color:red;">Oops!</strong> '. $error . '
                            '; }
                          ?>
                        <form method="POST" class="register-form" id="register-form" action="" autocomplete="off">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" class="form-control" name="ic" id="ic" placeholder="IC Number" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" class="form-control" name="password" id="pass" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" class="form-control" name="password2" id="passwoord2" placeholder="Confirm Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service" data-toggle="modal" data-target="#myModal">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="register" id="register" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal-->
        <!--
                    <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                      <div role="document" class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Terms of service</strong>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                          </div>
                          <?php include "termsofservice.php" ?>
                      </div>
                    </div>
                </div>
        -->
        <!-- end modal -->
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/front.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
