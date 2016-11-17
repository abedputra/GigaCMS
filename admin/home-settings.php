<?php
include "../inc/init.php";

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}


$page->title = "Home Settings";
$presets->setActive("theme");

include "header.php";

include "menu-side.php";

 function renderForm($id,$description,$keyword,$title_features,$glyphicons_1,$glyphicons_2,$glyphicons_3,$glyphicons_4,$features_content_1,$features_content_2,$features_content_3,$features_content_4,$title_products,$products_1,$products_2,$products_3,$products_4,$clients_1,$clients_2,$clients_3,$clients_4,$testimonials,$error)
 {

 // if there are any errors, display them
 if ($error != '')
 {
 echo '<div class="container">'.$error.'</div>';
 }
echo '
 <form action="" method="post" class="form-horizontal">
 <legend>Home Settings</legend>
 
 <input type="hidden" name="id" value="1"/>
	<br>
	<br>
	<div class="well">
	<div class="alert alert-info" role="alert">Features</div>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Title Features</label>
      <div class="col-sm-10">
        <textarea style="max-width:100%" rows="20" class="summernote" name="title_features">'.$title_features.'</textarea>
      </div>
    </div>
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Glyphicons 1</label>
      <div class="col-sm-9">
        <input name="glyphicons_1" style="max-width:100%;width:100%" class="form-control" value="'.$glyphicons_1.'"></input>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Features 1</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="features_content_1">'.$features_content_1.'</textarea>
      </div>
    </div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Glyphicons 2</label>
      <div class="col-sm-9">
        <input name="glyphicons_2" style="max-width:100%;width:100%" class="form-control" value="'.$glyphicons_2.'"></input>
      </div>
    </div>
	
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Features 2</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="features_content_2">'.$features_content_2.'</textarea>
      </div>
    </div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Glyphicons 3</label>
      <div class="col-sm-9">
        <input name="glyphicons_3" style="max-width:100%;width:100%" class="form-control" value="'.$glyphicons_3.'"></input>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Features 3</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="features_content_3">'.$features_content_3.'</textarea>
      </div>
    </div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Glyphicons 4</label>
      <div class="col-sm-9">
        <input name="glyphicons_4" style="max-width:100%;width:100%" class="form-control" value="'.$glyphicons_4.'"></input>
      </div>
    </div>	
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Features 4</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="features_content_4">'.$features_content_4.'</textarea>
      </div>
    </div>
	</div>
	</div>
	</div>
	<br>
	<br>
	<div class="well">
	<div class="alert alert-info" role="alert">Products</div>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Title Products</label>
      <div class="col-sm-10">
        <textarea style="max-width:100%" rows="20" class="summernote" name="title_products">'.$title_products.'</textarea>
      </div>
    </div>
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Products 1</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="products_1">'.$products_1.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Products 2</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="products_2">'.$products_2.'</textarea>
      </div>
    </div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Products 3</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="products_3">'.$products_3.'</textarea>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Products 4</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%" rows="20" class="summernote" name="products_4">'.$products_4.'</textarea>
      </div>
    </div>
	</div>
	</div>
	</div>
	<br>
	<br>
	<div class="well">
	<div class="alert alert-info" role="alert">Clients</div>
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Clients 1</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="clients_1" value="'.$clients_1.'">
		<p class="text-info">Img Url</p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Clients 2</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="clients_2" value="'.$clients_2.'">
		<p class="text-info">Img Url</p>
      </div>
    </div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Clients 3</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="clients_3" value="'.$clients_3.'">
		<p class="text-info">Img Url</p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Clients 4</label>
      <div class="col-sm-9">
        <input type="text" style="max-width:100%;width:100%" rows="5" class="form-control" name="clients_4" value="'.$clients_4.'">
		<p class="text-info">Img Url</p>
      </div>
    </div>
	</div>
	</div>
	</div>
	<br>
	<br>
	<div class="well">
	<div class="alert alert-info" role="alert">Testimonials</div>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Testimonials</label>
      <div class="col-sm-10">
        <textarea style="max-width:100%" rows="20" class="summernote" name="testimonials">'.$testimonials.'</textarea>
      </div>
    </div>
	</div>
	<br>
	<br>
	<div class="form-group">
      <label class="col-sm-2 control-label" for="sitename">Description</label>
      <div class="col-sm-9">
        <textarea style="max-width:100%;width:100%" rows="5" class="form-control" name="description">'.$description.'</textarea>
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
	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$keyword = mysqli_real_escape_string($conn,$_POST['keyword']);
	$title_features = mysqli_real_escape_string($conn,$_POST['title_features']);
	$glyphicons_1 = mysqli_real_escape_string($conn,$_POST['glyphicons_1']);
	$glyphicons_2 = mysqli_real_escape_string($conn,$_POST['glyphicons_2']);
	$glyphicons_3 = mysqli_real_escape_string($conn,$_POST['glyphicons_3']);
	$glyphicons_4 = mysqli_real_escape_string($conn,$_POST['glyphicons_4']);
	$features_content_1 = mysqli_real_escape_string($conn,$_POST['features_content_1']);
	$features_content_2 = mysqli_real_escape_string($conn,$_POST['features_content_2']);
	$features_content_3 = mysqli_real_escape_string($conn,$_POST['features_content_3']);
	$features_content_4 = mysqli_real_escape_string($conn,$_POST['features_content_4']);
	$title_products = mysqli_real_escape_string($conn,$_POST['title_products']);
	$products_1 = mysqli_real_escape_string($conn,$_POST['products_1']);
	$products_2 = mysqli_real_escape_string($conn,$_POST['products_2']);
	$products_3 = mysqli_real_escape_string($conn,$_POST['products_3']);
	$products_4 = mysqli_real_escape_string($conn,$_POST['products_4']);
	$clients_1 = mysqli_real_escape_string($conn,$_POST['clients_1']);
	$clients_2 = mysqli_real_escape_string($conn,$_POST['clients_2']);
	$clients_3 = mysqli_real_escape_string($conn,$_POST['clients_3']);
	$clients_4 = mysqli_real_escape_string($conn,$_POST['clients_4']);
	$testimonials = mysqli_real_escape_string($conn,$_POST['testimonials']);

 // save the data to the database
 $insert = "UPDATE `".MLS_PREFIX."home` SET `description`='$description', `keyword`='$keyword', `title_features`='$title_features', `glyphicons_1`='$glyphicons_1', `glyphicons_2`='$glyphicons_2', `glyphicons_3`='$glyphicons_3', `glyphicons_4`='$glyphicons_4', `features_content_1`='$features_content_1', `features_content_2`='$features_content_2', `features_content_3`='$features_content_3', `features_content_4`='$features_content_4', `title_products`='$title_products', `products_1`='$products_1', `products_2`='$products_2', `products_3`='$products_3', `products_4`='$products_4', `clients_1`='$clients_1', `clients_2`='$clients_2', `clients_3`='$clients_3', `clients_4`='$clients_4', `testimonials`='$testimonials' WHERE id='$id'";
 mysqli_query($conn, $insert)
 or die(mysqli_error($conn)); 

 // once saved, redirect back to the view page
 ?>
 <script>window.location.replace("home-settings.php?id=1");</script>
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
 $result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."home` ") 
		or die(mysqli_error()); 
 $row = mysqli_fetch_array($result);
 
 // check that the 'id' matches up with a row in the databse
 if($row)
 {
 
 // get data from db
$title_features=$row['title_features'];
$description=$row['description'];
$keyword=$row['keyword'];
$glyphicons_1=$row['glyphicons_1'];
$glyphicons_2=$row['glyphicons_2'];
$glyphicons_3=$row['glyphicons_3'];
$glyphicons_4=$row['glyphicons_4'];
$features_content_1=$row['features_content_1'];
$features_content_2=$row['features_content_2'];
$features_content_3=$row['features_content_3'];
$features_content_4=$row['features_content_4'];
$title_products=$row['title_products'];
$products_1=$row['products_1'];
$products_2=$row['products_2'];
$products_3=$row['products_3'];
$products_4=$row['products_4'];
$clients_1=$row['clients_1'];
$clients_2=$row['clients_2'];
$clients_3=$row['clients_3'];
$clients_4=$row['clients_4'];
$testimonials=$row['testimonials'];
 
 // show form
 renderForm($id,$description,$keyword,$title_features,$glyphicons_1,$glyphicons_2,$glyphicons_3,$glyphicons_4,$features_content_1,$features_content_2,$features_content_3,$features_content_4,$title_products,$products_1,$products_2,$products_3,$products_4,$clients_1,$clients_2,$clients_3,$clients_4,$testimonials,'');
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