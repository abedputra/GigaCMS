<?php
include "inc/init.php";

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

$url_get=mysql_real_escape_string($_GET['url']);
$url=$url_get.'.html';
$result_title = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."page` WHERE `link`='$url'")  
or die(mysqli_error()); 

// loop through results of database query, displaying them in the table
		while($row = mysqli_fetch_array( $result_title )) {
		
		// echo out the contents of each row into a table
		$title = $row['title'];
		$description = $row['description'];
		$keyword = $row['keyword'];
		
	} 

$page->title = $title;	
$page->description = $description;
$page->keyword = $keyword;



include "header.php";


if($_GET['url'])
{

$url=mysql_real_escape_string($_GET['url']);
$url=$url.'.html';
$result_content = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."page` WHERE `link`='$url'") 
	or die(mysqli_error()); 
	
$count=mysqli_num_rows($result_content);
$row=mysqli_fetch_array($result_content);


$content = $row['content'];

}
else
{
echo '404 Not URL Available.';
}


if($count)
{
echo '
<div id="fh5co-main">
<div style="padding-top:100px">
<div class="container">
'.$content.'
</div>
</div>
<div class="fh5co-spacer fh5co-spacer-lg"></div>';

}
else
{
echo "<h1>Not URL Available 404.</h1>";
}


	
include "footer.php";
?>