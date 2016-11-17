<?php
include "../inc/init.php";

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}


$page->title = "Footer Settings";
$presets->setActive("theme");

include "header.php";

include "menu-side.php";

 function renderForm($id,$title,$about_company,$facebook,$twitter,$instagram,$linkedin,$youtube,$menu_footer_1,$menu_footer_2,$menu_footer_3,$copyright,$error)
 {

 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div class="container">'.$error.'</div>';
 }
echo '
 <form action="" method="post" class="form-horizontal">
 <legend>Footer Settings</legend>
 
 <input type="hidden" name="id" value="1"/>	
 
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Title</label>
      <div class="col-sm-9">
        <span name="title" style="max-width:100%;width:100%" class="form-control" id="disabledInput" disabled>'.$title.'</span>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">About Your Company</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="about_company">'.$about_company.'</textarea>
      </div>
    </div>
	<br>
	<br>
	<hr>
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-4 control-label" for="sitename">Facebook Link</label>
      <div class="col-sm-7">
        <input type="text" name="facebook" style="max-width:100%;width:100%" class="form-control" value="'.$facebook.'">
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-4 control-label" for="sitename">Twitter Link</label>
      <div class="col-sm-7">
        <input type="text" name="twitter" style="max-width:100%;width:100%" class="form-control" value="'.$twitter.'">
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-4 control-label" for="sitename">Instagram Link</label>
      <div class="col-sm-7">
        <input type="text" name="instagram" style="max-width:100%;width:100%" class="form-control" value="'.$instagram.'">
      </div>
    </div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Linkedin Link</label>
      <div class="col-sm-7">
        <input type="text" name="linkedin" style="max-width:100%;width:100%" class="form-control" value="'.$linkedin.'">
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Youtube Link</label>
      <div class="col-sm-7">
        <input type="text" name="youtube" style="max-width:100%;width:100%" class="form-control" value="'.$youtube.'">
      </div>
    </div>
	</div>
	</div>
	<hr>
	<br>
	<br>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Menu 1</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="5" class="summernote" name="menu_footer_1">'.$menu_footer_1.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Menu 2</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="5" class="summernote" name="menu_footer_2">'.$menu_footer_2.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Menu 3</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="5" class="summernote" name="menu_footer_3">'.$menu_footer_3.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Copyright</label>
      <div class="col-sm-9">
        <input type="text" name="copyright" style="max-width:100%;width:100%" class="form-control" value="'.$copyright.'">
      </div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-9">
	 	<input class="btn btn-primary" type="submit" name="submit" value="Submit">
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
	$about_company = mysqli_real_escape_string($conn,$_POST['about_company']);
	$facebook = mysqli_real_escape_string($conn,$_POST['facebook']);
	$twitter = mysqli_real_escape_string($conn,$_POST['twitter']);
	$instagram = mysqli_real_escape_string($conn,$_POST['instagram']);
	$linkedin = mysqli_real_escape_string($conn,$_POST['linkedin']);
	$youtube = mysqli_real_escape_string($conn,$_POST['youtube']);
	$menu_footer_1 = mysqli_real_escape_string($conn,$_POST['menu_footer_1']);
	$menu_footer_2 = mysqli_real_escape_string($conn,$_POST['menu_footer_2']);
	$menu_footer_3 = mysqli_real_escape_string($conn,$_POST['menu_footer_3']);
	$copyright = mysqli_real_escape_string($conn,$_POST['copyright']);

 
 // save the data to the database
 $insert = "UPDATE `".MLS_PREFIX."footer_settings` SET `about_company`='$about_company', `facebook`='$facebook',`twitter`='$twitter',`instagram`='$instagram',`linkedin`='$linkedin',`youtube`='$youtube',`menu_footer_1`='$menu_footer_1',`menu_footer_2`='$menu_footer_2',`menu_footer_3`='$menu_footer_3',`copyright`='$copyright' WHERE id='$id'";
 mysqli_query($conn, $insert)
 or die(mysqli_error($conn)); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("footer-settings.php?id=1");</script>
 <?php 


 }
 else
 {
 // if the 'id' isn't valid, display an error
 echo 'Error!';
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
 $result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."footer_settings` ") 
		or die(mysqli_error()); 
 $row = mysqli_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
$title=$row['title'];
$about_company=$row['about_company'];
$facebook=$row['facebook'];
$twitter=$row['twitter'];
$instagram=$row['instagram'];
$linkedin=$row['linkedin'];
$youtube=$row['youtube'];
$menu_footer_1=$row['menu_footer_1'];
$menu_footer_2=$row['menu_footer_2'];
$menu_footer_3=$row['menu_footer_3'];
$copyright=$row['copyright'];
 
 // show form
 renderForm($id,$title,$about_company,$facebook,$twitter,$instagram,$linkedin,$youtube,$menu_footer_1,$menu_footer_2,$menu_footer_3,$copyright, '');
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
 echo 'Error!';
 }
 }


include 'admin-footer.php';
?>