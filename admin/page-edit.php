<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url");
    exit;
}


$page->title = "Edit Page";

$presets->setActive("pagesettings");

include "header.php";
include "menu-side.php";

 function renderForm($id,$title,$content,$description,$keyword,$error)
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
 <form action="" method="post" class="form-horizontal" style="width: 100%;">
 <legend>Edit Page</legend>
 
 <input type="hidden" name="id" value="'.$id.'"/>	
 
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="title" value="'.$title.'"/>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Content</label>
      <div class="col-sm-9">
        <textarea class="summernote" name="content">'.$content.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Description</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%;width:100%" class="form-control" rows="5" name="description" style="min-width: 100%">'.$description.'</textarea>
      </div>
    </div>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Keyword</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="keyword" value="'.$keyword.'">
		<p class="text-info">Sparate keyword with comma such as (hello world, web design), max 5 keyword.</p>
      </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-9">
	 	<input class="btn btn-primary" type="submit" name="submit" value="Submit"> <a href="page-admin.php"><input class="btn btn-default" type="button" value="Cancle"></a>
		</div>
	</div>
 </form> 
';
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
	$content = mysqli_real_escape_string($conn,$_POST['content']);
	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);

 
 // check that firstname/lastname fields are both filled in
 if ($title == '' || $content == '' || $description == '' || $keyword == '' )
 {
 // generate error message
 $error = '<div class="container"><div class="alert">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> Please fill in all required fields!
    </div></div>';
 
 //error, display form
 renderForm($id,$title,$content,$description,$keyword,$error);
 }
 else
 {
 // save the data to the database
 $insert = "UPDATE `".MLS_PREFIX."page` SET `title`='$title',`content`='$content',`description`='$description',`keyword`='$keyword' WHERE `id`='$id'";
 mysqli_query($conn, $insert)
 or die(mysqli_error()); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("page-admin.php");</script>
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
 $result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."page` WHERE id=$id") 
		or die(mysqli_error()); 
 $row = mysqli_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
$title=$row['title'];
$content=$row['content'];
$description=$row['description'];
$keyword=$row['keyword'];
 
 // show form
 renderForm($id,$title,$content,$description,$keyword, '');
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
 
 include "admin-footer.php";
?>