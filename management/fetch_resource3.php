<?php
//fetch.php
session_start();
include 'dbconnect.php';
$output = '';

if(isset($_POST["query"]))
{
 $organizer = $_SESSION['email'];
 $search = mysqli_real_escape_string($conn, $_POST["query"]);
 $query = "SELECT * FROM resource
  WHERE (name LIKE '%".$search."%'
  OR type LIKE '%".$search."%')
  AND e_id='$id'
 ";
}
else
{
  $organizer = $_SESSION['email'];

  $query3 = "SELECT * FROM participant where email = '$organizer'";
  $result3 = mysqli_query($conn,$query3) or die('SQL error participant');
  $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);

  $hhh = $row3['ic'];

$query = "SELECT a.*,b.*,c.name FROM resource a, register b, event c WHERE a.e_id = b.e_id AND c.id=a.e_id AND (b.p_ic = '$hhh') ORDER BY c.date";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
 <div class="card-body">
   <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>NO.</th>
                        <th>EVENT</th>
                        <th>NAME</th>
                        <th>TYPE</th>
                      </tr>
					</thead>
 ';
 $bil=1;
 while($row = mysqli_fetch_array($result))
 {
	 $name = $row['title'];
	 $type = $row['type'];
   $event = $row['name'];

  $output .= '
   <tr>
    <th>'.$bil.'</th>
    <td>'.$event.'</td>
    <td>'.$name.'</td>
    <td>'.$type.'</td>
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
