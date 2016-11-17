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

$image = mysqli_real_escape_string($conn,$_POST['image']);
$title = mysqli_real_escape_string($conn,$_POST['title']);
$desc = mysqli_real_escape_string($conn,$_POST['desc']);

$query  = "INSERT INTO `".MLS_PREFIX."slideshow`(`title`,`desc`,`image`) VALUES ('".$title."', '".$desc."', '".$image."')";
mysqli_query($conn,$query)or die(mysqli_error()); 

header("location: slideshow.php");
?>