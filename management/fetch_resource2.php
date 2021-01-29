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
 $query = "SELECT * FROM resource
  WHERE (title LIKE '%".$search."%'
  OR type LIKE '%".$search."%')
  AND e_id='$id'
 ";
}
else
{
  $organizer = $_SESSION['email'];
 $query = "SELECT * FROM resource WHERE e_id='$id' ORDER BY title
 ";
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
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>SIZE</th>
                        <th>VIEW</th>
                        <th>REQUEST</th>
                      </tr>
					</thead>
 ';
 $bil=1;
 while($row = mysqli_fetch_array($result))
 {
	 $name = $row['title'];
	 $type = $row['type'];
   $id1 = $row['id'];
   $size = $row['size'];
   $file = $row['file'];

  $output .= '
   <tr>
    <th>'.$bil.'</th>
    <td>'.$name.'</td>
    <td>'.$type.'</td>
    <td>'.$size.' KB</td>
    <td><a class="material-icons text-success" href="resources/'.$file.'" target="_blank">visibility</a></td>
    <!--<td><a class="btn btn-info btn-sm" href="edit-resources.php?id='.$id1.'">Edit</a></td>-->
    <td><a class="material-icons text-info" href="request-resources.php?id='.$id1.'&&event='.$id.'">get_app</a></td>
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
