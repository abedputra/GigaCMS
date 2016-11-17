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


$color_theme= mysqli_real_escape_string($conn,$_POST['color_theme']);
$link_color= mysqli_real_escape_string($conn,$_POST['link_color']);
$body_color= mysqli_real_escape_string($conn,$_POST['body_color']);

$query  = "UPDATE `".MLS_PREFIX."color_theme` SET `color_theme`='$color_theme', `link_color`='$link_color', `body_color`='$body_color'";
mysqli_query($conn,$query)or die(mysqli_error()); 

header("location: theme.php");
?>