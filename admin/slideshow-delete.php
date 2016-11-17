<?php

include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url");
    exit;
}
$page->title = "Slideshow";
$presets->setActive("slideshow");

include "header.php";

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

	// check if the 'id' variable is set in URL, and check that it is valid
	if (isset($_GET['id']) && is_numeric($_GET['id']))
	{
	// get id value
	$id = $_GET['id'];

	// delete the entry
	$query = "DELETE FROM `".MLS_PREFIX."slideshow` WHERE id=$id";
	$result = mysqli_query ($conn, $query);
	if (!$result) {
	die(mysqli_error($conn));
	}

//redirect back to the view page
 ?> 
	<script>window.location.replace("slideshow.php");</script>
 <?php
	 }
	 else
	 // if id isn't set, or isn't valid, redirect back to view page
	 {
?>
	<script>window.location.replace("slideshow.php");</script>
 <?php
 }
 ?>