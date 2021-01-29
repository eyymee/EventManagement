<?php
session_start();

if(!$_SESSION['email'])
{

    header("Location: ../sign/signin.php");//redirect to the login page to secure the welcome page without login access.
}
?>
<?php
        //to retrived data
        if (isset($_GET['id']))
            $id = $_GET['id'];
        else
            $id = 0;

        $email = $_SESSION['email'];

        include 'dbconnect.php';
        $query = "SELECT * FROM event where id = '$id'";
        $result = mysqli_query($conn,$query) or die('SQL error event ');
        $row2 = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $query1 = "SELECT * FROM participant where email = '$email'";
        $result1 = mysqli_query($conn,$query1) or die('SQL error event ');
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    ?>

    <?php
        $error="";
        $message="";
        include "dbconnect.php";

        if (isset($_POST['register'])) {
        //$id = $_POST['id'];
        //$e_id = addslashes($_POST['e_id']);
        $rfid = $row1['id'];
        $p_ic = $row1['ic'];
        //$email = $_SESSION['email'];

        $a = "SELECT * FROM register WHERE p_ic = '$p_ic' AND e_id = '$id'";
        $aa = mysqli_query($conn,$a) or die('SQL error register ');
        $aaa = mysqli_fetch_array($aa, MYSQLI_ASSOC);

        if(!$aaa)
        {
          $update = "INSERT INTO register (e_id,rfid,p_ic) VALUES('$id','$rfid','$p_ic')";

          $result0 = mysqli_query($conn,$update) or die ('register sql');
            if ($result0){
              //echo "<script type='text/javascript'>alert('REGISTER SUCCESS')</script>";
              header("Location: events.php");
              $message = "Register success!";

              }
            else
              $error = "Failed to register!";
        }
        else
          $error = "You have already registered!";

        }
        ?>
