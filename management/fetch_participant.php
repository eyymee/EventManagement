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
  SELECT a.*, b.* FROM register a, participant b
  WHERE (a.p_ic LIKE '%".$search."%'
  OR b.name LIKE '%".$search."%'
  OR b.id LIKE '%".$search."%')
  AND a.e_id='$id' AND a.p_ic=b.ic
 ";
}
else
{
 $organizer = $_SESSION['email'];
 $query = "
  SELECT a.*, b.* FROM register a, participant b WHERE a.e_id='$id' AND a.p_ic=b.ic
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
                        <th>VIEW</th>
                        <th>DELETE</th>
                      </tr>
					</thead>
 ';
 while($row = mysqli_fetch_array($result))
 {
	 $ic = $row['p_ic'];
   $rfid = $row['rfid'];
   $name = $row['name'];

  $output .= '
   <tr>
    <th>'.$bil.'</th>
    <td>'.$rfid.'</td>
    <td>'.$name.'</td>
    <td>'.$ic.'</td>
	<td><a href="info_participant.php?e_id='.$id.'&&ic='.$ic.'" class="material-icons text-success">visibility</a></td>
	<td><a href="" class="material-icons text-danger" data-action="delete" data-body-message="Are you sure to delete this data?" data-redirect-url="delete-participant.php?ic='.$ic.'">delete</a></td>
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
