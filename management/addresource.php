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
            $id = $_GET['id'];
        else
            $id = 0;

        include 'dbconnect.php';
        $query = "SELECT * FROM event where id = '$id'";
        $result = mysqli_query($conn,$query) or die('SQL error event ');
        $row2 = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $event_id = $id;

    ?>

    <?php
    $message="";
    $error="";
    include_once 'dbconnect.php';
    if(isset($_POST['upload']))
    {
     $valid_extensions = array('jpeg','jpg','png','ppt','pptx','doc','docx','pdf','mov','mp4','zip','rar');
     $file = $_FILES['file']['name'];
     $file_loc = $_FILES['file']['tmp_name'];
     $file_size = $_FILES['file']['size'];
     $file_type = $_FILES['file']['type'];
     $folder="resources/";
     $organizer = $_SESSION['email'];
     //$type = addslashes($_POST['type']);

     /* new file size in KB */
     $new_size = $file_size/1024;
     /* new file size in KB */

     /* make file name in lower case */
     $new_file_name = strtolower($file);
     /* make file name in lower case */

     /* verify file extension available or not */
     $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
     /* verify file extension available or not */

     $final_file=str_replace(' ','-',$new_file_name);

     if(in_array($ext, $valid_extensions)){
       if($new_size < 10000){
           if(move_uploaded_file($file_loc,$folder.$final_file))
           {
            $sql="INSERT INTO resource (e_id,title,type,file,size) VALUES('$id','$new_file_name','$file_type','$final_file','$new_size')";
            mysqli_query($conn,$sql);

            $message = "File sucessfully upload";

           }
           else
           {

           $error = "Error. Please try again";

              }
            }
            else
              $error = "Error. File must be less than 10MB!";
          }
          else
            $error = "Error. Type of file is not supported! Only jpeg, jpg, png, ppt, pptx, doc, docx, pdf, mov, mp4, zip, rar";
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
          <li class="nav-item active">
            <a class="nav-link" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">event</i>
              <p>Events <i class="material-icons float-right">arrow_drop_down</i></p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item text-dark" href="./listevents_organizer.php">List Events</a>
              <a class="dropdown-item text-dark" href="./listparticipant.php?id=<?php echo $row2['id'] ?>">Participants</a>
              <a class="dropdown-item text-dark" href="./checkin.php?id=<?php echo $row2['id'] ?>">Check In</a>
              <a class="dropdown-item text-dark" href="./checkout.php?id=<?php echo $row2['id'] ?>">Check Out</a>
              <a class="dropdown-item text-dark" href="./listresource.php?id=<?php echo $row2['id'] ?>">Resources</a>
              <a class="dropdown-item text-dark" href="./report_organizer.php?id=<?php echo $row2['id'] ?>">Report</a>
            </div>
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
            <a class="navbar-brand" href="javascript:void(0)">Resources</a>
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
                  <h4 class="card-title">Add Resource</h4>
                  <p class="card-category">Please make sure that your file is in the correct format as the type that you chose</p>
                </div>
                <?php if($message != "") {
                      echo
                        '<center><br /><div class="alert alert-success col-md-8">
                            <strong>Success!</strong> ' . $message . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div></center>'; }?>
                        <?php if($error != "") {
                      echo
                        '<center><br /><div class="alert alert-danger col-md-8">
                            <strong>Oops!</strong> '. $error . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div></center>'; }?>
                <div class="card-body">
                  <table class="table">
                        <tbody>
                  <form action="" method="post" enctype="multipart/form-data">
                    <tr>
                        <th>TYPE</th>
                        <td><input list="type" class="form-control" name="type" required>
                            <datalist id="type">
                              <option value="JPG/JPEG/PNG">
                              <option value="MP4/MOV">
                              <option value="PDF">
                              <option value="DOC">
                              <option value="PPT">
                              <option value="ZIP/RAR">
                            </datalist>
                        </td>
                        </tr>
                        <tr>
                        <th>Upload File</th>
                        <td>
                          <input class="form-control" type="file" id="file" name="file" required>
                        </td>
                        </tr>
                      </tbody>
                    </table>
                    <br />
                    <center>
                      <input type="submit" name="upload" class="btn btn-primary float-center" value="Add Resource">
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
