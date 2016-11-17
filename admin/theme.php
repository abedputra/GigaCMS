<?php
ini_set("display_errors",1);

include "../inc/init.php";

$page->title = "Theme";
$presets->setActive("theme");

include "header.php";
include "menu-side.php";

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
?>
<legend>Theme</legend>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Your Current Theme</h3>
  </div>
  <div class="panel-body">
    <img src="../theme/images/booster_featured_img.png" style="margin: 0 auto;display:block;">
  </div>
</div>
<br>
<br>
<?php
$query  = "select * from `".MLS_PREFIX."color_theme`";
$res    = mysqli_query($conn,$query);
$count  = mysqli_num_rows($res);

while($row=mysqli_fetch_array($res))
	{
		$color  = $row['color_theme'];
		$link_color  = $row['link_color'];
		$body_color  = $row['body_color'];
	}
	echo '
	<form action="color-progress-theme.php" class="form-horizontal" method="post" enctype="multipart/form-data" id="UploadForm">		
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Change Color Theme</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" name="color_theme" value="'.$color.'"/>
			<p class="text-info">Color Font, Ex: #fff.</p>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Link Color Theme</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" name="link_color" value="'.$link_color.'"/>
			<p class="text-info">Color Font, Ex: #fff.</p>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Body Color Theme</label>
		  <div class="col-sm-10">
			<input type="text" class="form-control" name="body_color" value="'.$body_color.'"/>
			<p class="text-info">Color Font, Ex: #fff.</p>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-2 col-sm-10">
			<input class="btn btn-primary" type="submit" name="submit" value="Save" />
		  </div>
		</div>
	</form>
	';
	include "admin-footer.php";
	?>