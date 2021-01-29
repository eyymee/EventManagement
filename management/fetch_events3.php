<?php
session_start();

if(!$_SESSION['email'])
{

    header("Location: ../sign/signin.php");//redirect to the login page to secure the welcome page without login access.
}
?>
<?php
  include 'dbconnect.php';

        $email = $_SESSION['email'];

        $query1 = "SELECT * FROM participant where email = '$email'";
        $result1 = mysqli_query($conn,$query1) or die('SQL error event ');
        $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

        $p_ic = $row1['ic'];
    ?>
<?php
//fetch.php
include 'dbconnect.php';
$output = '';

if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($conn, $_POST["query"]);
 $query = "
  SELECT a.*,b.* FROM event a, register b
  WHERE (date LIKE '%".$search."%'
  OR venue LIKE '%".$search."%'
  OR name LIKE '%".$search."%')
  AND b.p_ic='$p_ic'
  AND a.id=b.e_id
 ";
}
else
{
 $query = "SELECT a.*,b.* FROM event a, register b WHERE a.id=b.e_id AND b.p_ic='$p_ic' ORDER BY date";
}
$result = mysqli_query($conn, $query);
$bil=1;
if(mysqli_num_rows($result) > 0)
{
 $output .= '
  <div class="row">
 ';
 while($row = mysqli_fetch_array($result))
 {
	 $title = $row['name'];
   $id = $row['id'];
	 $date = date_create($row['date']);
   $test = date_format($date,"M d, Y (D)");
   $time = date_create($row['time']);
   $masa= date_format($time,"h:i a");
   $end = date_create($row['end']);
   $habis= date_format($end,"h:i a");
   $venue = $row['venue'];

  $output .= '
  <div class="col-md-4">
    <div class="card card-profile">
                <div class="card-body text-center">
                  <a href="javascript:void(0)" class="user-title">
                    <h3 class="h5">'.$title.'</h3><span>'.$venue.'</span></a>
                    <div class="contributions">'.$test.'</div>
                    <br><div class="contributions">'.$masa.' - '.$habis.'</div><br />
                </div>
              </div>
              </div>
  ';
  $bil++;
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}
?>

<!--untuk guna onclidk function -->
<script type="text/javascript">
function confirmDelete(){
return confirm('Are you sure you want to delete this?');
}
</script>

<script src="js/delete.js"></script>
