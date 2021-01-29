<?php
//fetch.php
session_start();
include 'dbconnect.php';
$output = '';

if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = 0;

if(isset($_POST["query"]))
{
 $organizer = $_SESSION['email'];
 $search = mysqli_real_escape_string($conn, $_POST["query"]);
 $query = "
  SELECT a.*, b.* FROM attendance a, participant b
  WHERE (a.ic LIKE '%".$search."%'
  OR b.name LIKE '%".$search."%'
  OR a.rfid LIKE '%".$search."%')
  AND a.event_id='$id' AND a.ic=b.ic
 ";
}
else
{
 $organizer = $_SESSION['email'];
 $query = "
  SELECT a.*, b.* FROM attendance a, participant b WHERE (a.event_id='$id') AND a.ic=b.ic
 ";
}
$result = mysqli_query($conn, $query);
$bil=1;
if(mysqli_num_rows($result) > 0)
{
 $output .= '
 <div class="card-body">
   <div class="table-responsive">
     <table class="table">
                    <thead>
                      <tr>
                        <th>NO.</th>
                        <th>RFID</th>
                        <th>NAME</th>
                        <th>IC</th>
                        <th>CHECK IN</th>
                      </tr>
					</thead>
 ';
 while($row = mysqli_fetch_array($result))
 {
	 $ic = $row['ic'];
   $rfid = $row['rfid'];
   $name = $row['name'];
   $in = $row['checkin'];
   $out = $row['checkout'];

  $output .= '
   <tr>
    <th>'.$bil.'</th>
    <td>'.$rfid.'</td>
    <td>'.$name.'</td>
    <td>'.$ic.'</td>
    <td>'.$in.'</td>
   </tr>
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

<!--untuk guna onclick function -->
<script type="text/javascript">
function confirmDelete(){
return confirm('Are you sure you want to delete this?');
}
</script>

<script src="js/delete.js"></script>
