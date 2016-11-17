<?php
include "../inc/init.php";

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


$color_font= mysqli_real_escape_string($conn,$_POST['color_font']);
$color_background= mysqli_real_escape_string($conn,$_POST['color_background']);

$query  = "UPDATE `".MLS_PREFIX."color` SET `color_font`='$color_font', `color_background`='$color_background'";
mysqli_query($conn,$query)or die(mysqli_error()); 

header("location: slideshow.php");
?>