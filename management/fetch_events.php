<?php
//fetch.php
session_start();
include 'dbconnect.php';
$output = '';

if(isset($_POST["query"]))
{
$organizer = $_SESSION['email'];
 $search = mysqli_real_escape_string($conn, $_POST["query"]);
 $query = "
  SELECT * FROM event
  WHERE (date LIKE '%".$search."%'
  OR venue LIKE '%".$search."%'
  OR name LIKE '%".$search."%')
  AND email='$organizer'
 ";
}
else
{
$organizer = $_SESSION['email'];
 $query = "
  SELECT * FROM event WHERE email='$organizer' ORDER BY date
 ";
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
                  <a href="events_organizer.php?id='.$id.'" class="user-title">
                    <h3 class="h5">'.$title.'</h3><span>'.$venue.'</span></a>
                    <div class="contributions">'.$test.'</div>
                    <br><div class="contributions">'.$masa.' - '.$habis.'</div>
                    <div class="details d-flex">
                    <div class="item"><a href="" class="fas fa-trash-alt delete"  data-action="delete" data-body-message="Are you sure to delete this data?" data-redirect-url="delete-eventt.php?id='.$id.'"></a></div>
                  </div>
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
