<?php
include "../inc/init.php";

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}


$page->title = "SEO Panel";
$presets->setActive("seosettings");

include "header.php";
include "menu-side.php";

 function renderForm($id,$google_webmaster,$bing_webmaster,$alexa,$google_analytic,$revisit_after,$robots,$error)
 {

 // if there are any errors, display them
 if ($error != '')
 {
 echo '.$error.';
 }
echo '
 <form action="" method="post" class="form-horizontal">
 <legend>SEO Settings</legend> 
 <input type="hidden" name="id" value="1"/>	
 
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Google Webmaster</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="google_webmaster" style="max-width:100%;width:100%" class="form-control" value="'.$google_webmaster.'">
		<p class="text-info" style="padding-top:5px">More Information visit <a href="https://www.google.com/webmasters">Google Webmaster</a></p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Bing Webmaster</label>
      <div class="col-sm-9">
        <input style="max-width:100%" rows="20" class="form-control" name="bing_webmaster" value="'.$bing_webmaster.'">
		<p class="text-info" style="padding-top:5px">More Information visit <a href="http://www.bing.com/toolbox/webmaster">Bing Webmaster</a></p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Alexa</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="alexa" value="'.$alexa.'">
		<p class="text-info" style="padding-top:5px">More Information visit <a href="https://www.alexa.com">Alexa</a></p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Google Analytic</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="google_analytic" value="'.$google_analytic.'">
		<p class="text-info" style="padding-top:5px">More Information visit <a href="https://www.google.com/analytics">Google Analytics</a></p>
      </div>
    </div>
	<br>
	<br>
	<legend>More Tool SEO</legend>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Revisit After</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="revisit_after" value="'.$revisit_after.'">
		<p class="text-info" style="padding-top:5px">Options, use 3 days or 7 days</p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Robots</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="robots" value="'.$robots.'">
		<p class="text-info" style="padding-top:5px">Options, Use all,index,follow or noindex</p>
      </div>
    </div>
	
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-9">
	 	<input class="btn btn-primary" type="submit" name="submit" value="Save">
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
	$google_webmaster = mysqli_real_escape_string($conn,$_POST['google_webmaster']);
	$bing_webmaster = mysqli_real_escape_string($conn,$_POST['bing_webmaster']);
	$alexa = mysqli_real_escape_string($conn,$_POST['alexa']);
	$google_analytic = mysqli_real_escape_string($conn,$_POST['google_analytic']);
	$revisit_after = mysqli_real_escape_string($conn,$_POST['revisit_after']);
	$robots = mysqli_real_escape_string($conn,$_POST['robots']);

 

 // save the data to the database
 $insert = "UPDATE `".MLS_PREFIX."seo` SET `google_webmaster`='$google_webmaster',`bing_webmaster`='$bing_webmaster', `alexa`='$alexa', `google_analytic`='$google_analytic', `revisit_after`='$revisit_after',`robots`='$robots' WHERE id='$id'";
 mysqli_query($conn, $insert)
 or die(mysqli_error()); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("seo.php?id=1");</script>
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
 $result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."seo` ") 
		or die(mysqli_error()); 
 $row = mysqli_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
$google_webmaster=$row['google_webmaster'];
$bing_webmaster=$row['bing_webmaster'];
$alexa=$row['alexa'];
$google_analytic=$row['google_analytic'];
$revisit_after=$row['revisit_after'];
$robots=$row['robots'];
 
 // show form
 renderForm($id,$google_webmaster,$bing_webmaster,$alexa,$google_analytic,$revisit_after,$robots, '');
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

?>

<?php
include 'admin-footer.php';
?>