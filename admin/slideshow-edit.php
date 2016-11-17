<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url");
    exit;
}


$page->title = "Slideshow";
$presets->setActive("slideshow");

include "header.php";
include "menu-side.php";


 function renderForm($id,$title,$desc,$image,$error)
 {

 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div class="container">
		 <div class="alert alert-danger" role="alert">
		 '.$error.'
		 </div>
		</div>';
 }
echo '
 <br>
 <form action="" method="post" class="form-horizontal" style="width: 100%;">
 <legend>Edit Page</legend>
 
 <input type="hidden" name="id" value="'.$id.'"/>	
 
   <div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Image</label>
      <div class="col-sm-9">
        <img src="../upload/gallery/'.$image.'" class="img-responsive">
      </div>
    </div> 
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="title" value="'.$title.'"/>
      </div>
    </div>
		
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Description</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%;width:100%" class="form-control" rows="5" name="desc" style="min-width: 100%">'.$desc.'</textarea>
      </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-9">
	 	<input class="btn btn-primary" type="submit" name="submit" value="Submit">
		</div>
	</div>
 </form> ';
 }
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

	 
 // check if the form has been submitted. If it has, process the form and save it to the database
 if (isset($_POST['submit']))
 { 
 // confirm that the 'id' value is a valid integer before getting the form data
 if (is_numeric($_POST['id']))
 {
 // get form data, making sure it is valid
 	$id = $_POST['id'];
	$title= mysqli_real_escape_string($conn,$_POST['title']);
	$desc = mysqli_real_escape_string($conn,$_POST['desc']);

 
 // check that firstname/lastname fields are both filled in
 if ($title == '' || $desc == '' )
 {
 // generate error message
 $error = '<div class="container"><div class="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> Please fill in all required fields!
    </div></div>';
 
 //error, display form
 renderForm($id,$title,$desc,$error);
 }
 else
 {
 // save the data to the database
 $insert = "UPDATE `".MLS_PREFIX."slideshow` SET `title`='$title',`desc`='$desc' WHERE `id`='$id'";
 mysqli_query($conn, $insert)
 or die(mysqli_error()); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("slideshow.php");</script>
 <?php 

 }
 }
 else
 {
 // if the 'id' isn't valid, display an error
 echo '<div class="container">
		 <div class="alert alert-danger" role="alert">
		 Error the id in the URL isnt valid!
		 </div>
		</div>';
}
 }
 else
 // if the form hasn't been submitted, get the data from the db and display the form
 {
 
 // get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)
 if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
 {
 // query db
 $id = $_GET['id'];
 $result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."slideshow` WHERE id=$id") 
		or die(mysqli_error($conn)); 
 $row = mysqli_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
$title=$row['title'];
$desc=$row['desc'];
$image=$row['image'];

 
 // show form
 renderForm($id,$title,$desc,$image, '');
 }
 else
 // if no match, display result
 {
 echo "No results!";
 }
 }
 else
 // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
 {
 echo '<div class="container">
		 <div class="alert alert-danger" role="alert">
		 Error the id in the URL isnt valid, or there is no id value!
		 </div>
		</div>';
 }
 }
?>