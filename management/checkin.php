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
        include 'dbconnect.php';

        $message = "";
        $error = "";
        $exist = "";

        if (isset($_POST['hantar']))
        {
          $organizer = $_SESSION['email'];
          //$event_id= addslashes($_POST['event_id']);
          $participant_id= addslashes($_POST['rfid']);
          //$p_ic= addslashes($_POST['ic']);
          //$attend_status = addslashes($_POST['status']);

              $apa = mysqli_query($conn, "SELECT * FROM register WHERE rfid = '$participant_id' AND e_id='$id'");
              //$apo = mysqli_fetch_assoc($apa);
              $apo = mysqli_fetch_array($apa, MYSQLI_ASSOC);

              //if (!$apo) {
              //$sql = mysqli_query($conn,"SELECT a.*, b.* FROM attendance a, participant b WHERE (a.rfid='" . $participant_id . "') && a.event_id = '" . $event_id . "' && a.ic=b.ic")or die ("test") ;
              //$row = mysqli_fetch_assoc($sql);

              //CANA NAK KELUARKAN ERROR KALAU ENTER RFID TAK WUJUD!!!!!!!!

              if($apo)
              {

              $zzz = mysqli_query($conn,"SELECT * FROM attendance WHERE rfid='" . $participant_id . "' && event_id='" . $event_id . "'") or die ("test2");
              $adoi = mysqli_fetch_assoc($zzz);

                if(!$adoi){

                $p_ic=$apo['p_ic'];

                $attend_status='1';
                $updatesql = mysqli_query($conn,"INSERT INTO attendance (event_id, rfid, ic, status) VALUES
                ('$id', '$participant_id', '$p_ic', '$attend_status')") or die ("test3");

                if($updatesql){
                  $query = "SELECT * FROM event where id = '$id'";
                  $result = mysqli_query($conn,$query) or die('SQL error display live seat ');
                  $row2 = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $message = "Thank You for Attending!";}
                }
                else
                  $exist = "This user already attend this event";
              }
              else
                $error = "This RFID has not registered for this event!";
            //}
            //else
              //$error = "This RFID has not registered for this event!";

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
            <a class="navbar-brand" href="javascript:void(0)">Attendance Check In</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" name="search_text" id="search_text" placeholder="Search by ID, name, or IC" class="form-control" />
                <button type="submit" class="btn btn-default btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
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
            <center>
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title">SCAN RFID</h4>
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
                        <?php if($exist != "") {
                      echo
                        '<center><br /><div class="alert alert-danger col-md-8">
                            <strong>Oops!</strong> '. $exist . '
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div></center>'; }?>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input class="form-control text-center text-info h5" type='text' placeholder='Scan here' name='rfid'>
                        </div>
                      </div>
                    </div>

                    <br />
                    <input type="submit" name="hantar" class="btn btn-primary pull-center" hidden value="Update RFID">
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </center>
          <br />
          <br />
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Attended Participant</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <div id="result"></div>
                    </table>
                  </div>
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

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetch_attendance.php?id=<?php echo $row2['id'] ?>",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script>
