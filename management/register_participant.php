<!--
=========================================================
* Material Dashboard Dark Edition - v2.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard-dark
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
session_start();

if(!$_SESSION['email'])
{

    header("Location: ../sign/signin_organizer.php");//redirect to the login page to secure the welcome page without login access.
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/em.png">
  <link rel="icon" type="image/png" href="../assets/img/em.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Event Management
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>
<?php
        //to retrived data
        if (isset($_GET['id']))
            $id2 = $_GET['id'];
        else
            $id2 = 0;

        include 'dbconnect.php';
        $query1 = "SELECT * FROM event  where id = '$id2'";
        $result1 = mysqli_query($conn,$query1) or die('SQL error retrieve resource ');
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    ?>
    <?php
      $message = "";
      $error = "";
      $error1 = "";

        //TO ADD DATA
      if (isset($_GET['email']))
                $username = $_GET['email'];
            else
                $username = 0;

        if (isset($_POST['register'])) {
          $name = addslashes($_POST['name']);
          $ic = addslashes($_POST['ic']);
          $email = addslashes($_POST['email']);
          $userrfid = addslashes($_POST["rfid"]);

          //$pass = md5($password);

          include 'dbconnect.php';

          $id = $userrfid;
          $pass = md5($ic);

          $check = "SELECT ic FROM participant WHERE ic ='$ic'";
          $aa = mysqli_query($conn,$check) or die ("sql error check ic exist");
          $aaa = mysqli_fetch_array($aa, MYSQLI_ASSOC);
          if(!$aaa){
            $haih = "SELECT email FROM participant WHERE email ='$email'";
            $bb = mysqli_query($conn,$haih) or die ("sql error check email exist");
            $bbb = mysqli_fetch_array($bb, MYSQLI_ASSOC);
            if(!$bbb){
                $query = "INSERT INTO participant (name, ic, email, password) VALUES
                  ('$id', '$name','$ic', '$email', '$pass')";
                $result = mysqli_query($conn,$query) or die ("sql error kat insert data");

                if ($result){
                  $halah = "INSERT INTO register (e_id, rfid, p_ic) VALUES
                    ('$id2', '$id','$ic')";
                  $huh = mysqli_query($conn,$halah) or die ("sql error check email exist");
                  $heh = mysqli_fetch_array($huh, MYSQLI_ASSOC);

                  $message = "You have been registered! Your IC is your temporary password";
                }
                else
                  echo "<script type='text/javascript'>alert('FAILED')</script>";
              }
              else
                $error = "This email already registered as participant";
            }
            else
              $error1 = "This IC number already registered as participant";
        }
        ?>
<body class="dark-edition">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="./home_organizer.php" class="simple-text logo-normal">
          Event Management
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item  ">
            <a class="nav-link" href="./home_organizer.php">
              <i class="material-icons">home</i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item  ">
            <a class="nav-link" href="./listparticipant?id=<?php echo $row1['id'] ?>.php">
              <i class="material-icons">keyboard_backspace</i>
              <p>Back</p>
            </a>
          </li>
          <!-- <li class="nav-item active-pro ">
                <a class="nav-link" href="./upgrade.html">
                    <i class="material-icons">unarchive</i>
                    <p>Upgrade to PRO</p>
                </a>
            </li> -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">Participant</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0) id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="./user_organizer.php">User Profile</a>
                  <a class="dropdown-item" href="./logout.php">Log Out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Add Participant</h4>
                </div>
                <?php if($message != "") {
                      echo
                        '<br><div class="alert alert-success alert-dismissible fade show">
                            <strong>Success!</strong> '. $message . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>'; }?>
                        <?php if($error != "") {
                      echo
                        '<br><div class="alert alert-danger alert-dismissible fade show">
                            <strong>Oops!</strong> '. $error . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>'; }?>
                        <?php if($error1 != "") {
                      echo
                        '<br><div class="alert alert-danger alert-dismissible fade show">
                            <strong>Oops!</strong> '. $error1 . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>'; }?>
                <div class="card-body">
                  <table class="table">
                        <tbody>
                  <form action="" method="post">
                    <tr>
                        <th>Event</th>
                        <td>
                          <label class="bmd-label-floating"><?php echo $row1['name']; ?></label>
                        </tr>
                        <tr>
                        <th>Full Name</th>
                        <td><input class="form-control" type="text" name="name" required></td>
                        </tr>
                        <tr>
                        <th>IC Number</th>
                        <td><input class="form-control" type="text" name="ic" required></td>
                        </tr>
                        <tr>
                        <th>Email Address</th>
                        <td><input class="form-control" type="email" name="email" required></td>
                        </tr>
                        <tr>
                        <th>Scan RFID</th>
                        <td><input type="text" name="rfid" class="form-control" required></td>
                        </tr>
                      </tbody>
                    </table>
                    <br />
                    <center>
                      <input type="submit" name="register" class="btn btn-primary float-center" value="Add Participant">
                    </center>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right" id="date">
            , made with <i class="material-icons">favorite</i> by
            <a href="https://www.instagram.com/aimi.pdf/" target="_blank">eyymee</a>
          </div>
        </div>
      </footer>
      <script>
        const x = new Date().getFullYear();
        let date = document.getElementById('date');
        date.innerHTML = '&copy; ' + x + date.innerHTML;
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://unpkg.com/default-passive-events"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.js?v=2.1.0"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
</body>

</html>
