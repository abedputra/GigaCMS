<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url/login.php");
    exit;
}


$page->title = "Admin Panel";

$presets->setActive("adminpanel");

include "header.php";
include "menu-side.php";

 function renderForm($id,$title,$content,$description,$keyword,$error)
 {

 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 

 <form action="" method="post" class="form-horizontal">
 
 <input type="hidden" name="id" value="<?php echo $id; ?>"/>

 <div class="form-group">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" name="title" style="max-width:100%;width:100%" class="form-control"><?php echo $content;?>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-9">
        <textarea rows="20" class="summernote" name="content"><?php echo $content; ?></textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Description</label>
      <div class="col-sm-9">
        <textarea  style="max-width:100%;width:100%" rows="5" class="form-control" name="description"><?php echo $description; ?></textarea>
      </div>
    </div>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Keyword</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="keyword" value="<?php echo $keyword; ?>">
		<p class="text-info">Sparate keyword with comma such as (hello world, web design), max 5 keyword.</p>
      </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-9">
	 	<input type="submit" class="btn btn-primary" name="submit" value="Save">
		</div>
	</div>

 </form> 

 <?php
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
 
 function string_limit_words($string, $word_limit) {
   $words = explode(' ', $string);
   return implode(' ', array_slice($words, 0, $word_limit));
}


 
 
 // check if the form has been submitted. If it has, process the form and save it to the database
 if (isset($_POST['submit']))
 { 
 // get form data, making sure it is valid
 	$id = $_POST['id'];
	$title= mysqli_real_escape_string($conn,$_POST['title']);
	$title=htmlentities($title);
	$content = mysqli_real_escape_string($conn,$_POST['content']);
	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);
	
	$newtitle=string_limit_words($title, 6);
	$urltitle=preg_replace('/[^a-z0-9]/i',' ', $newtitle);

	$newurltitle=str_replace(" ","-",$newtitle);
	$url= $newurltitle.'.html';

 
 // check that firstname/lastname fields are both filled in
 if ($title == '' || $content == '' || $description == '' || $keyword == '' )
 {
 // generate error message
 $error = 'ERROR: Please fill in all required fields!';
 
 //error, display form
 renderForm($id,$title,$content,$description,$keyword,$error);
 }
 else
 {
 // save the data to the database
 $insert = "INSERT ".MLS_PREFIX."page SET `title`='$title',`content`='$content',`description`='$description', `keyword`='$keyword', `link`='$url'";
 mysqli_query($conn, $insert)
 or die(mysqli_error($conn)); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("page-admin.php");</script>
 <?php
 }
 }
 else
 // if the form hasn't been submitted, display the form
 {
 renderForm('','','','','','');
 }
 include "admin-footer.php";
?>