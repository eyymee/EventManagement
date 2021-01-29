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
      $username = addslashes($_POST['username']);
      $email = addslashes($_POST['email']);
      $password = addslashes($_POST['password']);
      $password2 = addslashes($_POST['password2']);

      $password = md5($password);
      $password2 = md5($password2);

      include 'dbconnect.php';

      $check = "SELECT username FROM organizer WHERE username='$username'";
      $haha = mysqli_query($conn,$check);
      $hahaha = mysqli_fetch_array($haha, MYSQLI_ASSOC);

      if(!$hahaha){
      	$check1 = "SELECT email FROM organizer WHERE email='$email'";
      	$huhu = mysqli_query($conn,$check1);
      	$huhuhu = mysqli_fetch_array($huhu, MYSQLI_ASSOC);

      	if(!$huhuhu){
      		if($password == $password2){
			      $query = "INSERT INTO organizer (username, email, password) VALUES
			        ('$username', '$email', '$password')";
			      $result = mysqli_query($conn,$query);

			      if ($result){
			        //echo "<script type='text/javascript'>alert('REGISTER SUCCESS')</script>";
			        //header("Location: listparticipant.php");
			        $message = "Organizer have been registered!";
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
			$error = "Username is not available";
    }
    ?>
<body>
  <br />
        <!-- Sign up form -->
        <section class="sign-up">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up as Organizer</h2>
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
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email Address"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="password2" id="password2" placeholder="Confirm Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="register" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin_organizer.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>


    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
