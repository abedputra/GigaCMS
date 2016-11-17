<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Page Setting";
$presets->setActive("pagesettings");
include "header.php";
include "menu-side.php";

// Establish Connection to the Database

 // connect to the database
 	$servername = "$set->db_host";
	$username = "$set->db_user";
	$password = "$set->db_pass";
	$dbname = "$set->db_name";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

//Pagination
$limit = 5;  
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

$sql = "select * from `".MLS_PREFIX."page` ORDER BY id ASC LIMIT $start_from, $limit";  
$rs_result = mysqli_query($conn, $sql); 
//..Pagination
?>
<legend>Page List</legend>

<table class="table table-striped table-hover">
    <tr><th>Title</th><th>Time</th><th>View</th><th>Edit</th></tr>
    <?php
    while ($row = mysqli_fetch_assoc($rs_result)) {
    ?>
        <tr>
        <td><?php echo $row['title']; ?></td>
		<td><?php echo $row['time']; ?></td>
		
		<td><a href="<?php echo ''.$set->url.'/' . $row['link'] . ''?>" target="_blank"><button class="btn btn-primary"> View</button></a></td>
        
        <td><a href="<?php echo '../admin/page-edit.php?id=' . $row['id'] . ''?>"><button class="btn btn-primary"> Edit</button></a> <a href="<?php echo 'page-delete.php?id=' . $row['id'] . ''?>"><button class="btn btn-warning">Delete</button></a></td>
        
        </tr>
    <?php
    };
    ?>
</table>

 <?php  
//Pagination
	$sql = "select COUNT(id) from `".MLS_PREFIX."page`";  
	$rs_result = mysqli_query($conn, $sql);  
	$row = mysqli_fetch_row($rs_result);  
	$total_records = $row[0];  
	$total_pages = ceil($total_records / $limit);  
	$pagLink = "<nav><ul class='pagination'>";  
	for ($i=1; $i<=$total_pages; $i++) {  
				 $pagLink .= "<li><a href='page-admin.php?page=".$i."'>".$i."</a></li>";  
	};  
	echo $pagLink . "</ul></nav>";  
//..Pagination
	
include "admin-footer.php";
?>