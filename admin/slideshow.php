<?php
ini_set("display_errors",1);

include "../inc/init.php";

$page->title = "Slideshow";
$presets->setActive("slideshow");

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

//Selecting the data from table but with limit
$query = "select * from `".MLS_PREFIX."slideshow`";
$result = mysqli_query ($conn, $query);
if (!$result) {
    die(mysqli_error($conn));
}

?>
<legend>Images Slideshow</legend>
<table class="table table-striped table-hover" style="width:90%; margin: 0 auto;">
    <tr><th>Title</th><th>Description</th><th>Time</th><th>Edit</th></tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
        <td><?php echo $row['title']; ?></td>
		<td><?php echo $row['desc']; ?></td>
		<td><?php echo $row['date']; ?></td>
		        
        <td><a href="<?php echo '../admin/slideshow-edit.php?id=' . $row['id'] . ''?>"><button class="btn btn-primary"> Edit</button></a> <a href="<?php echo 'slideshow-delete.php?id=' . $row['id'] . ''?>"><button class="btn btn-warning">Delete</button></a></td>
        
        </tr>
    <?php
    };
    ?>
</table>

<br><br><br><br>
	<div class="row">	
		<div class="col-md-6">
		<legend>Add New Image</legend>
			<form action="process-upload.php" class="form-horizontal" method="post" enctype="multipart/form-data" id="UploadForm">		
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="sitename">File</label>
				  <div class="col-sm-9">
					<input class="btn btn-default btn-file" name="ImageFile" type="file" />
				  </div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-9">
					<input class="btn btn-primary" type="submit"  id="SubmitButton" value="Upload" />
				  </div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
		<?php
		$query  = "select * from `".MLS_PREFIX."color`";
		$res    = mysqli_query($conn,$query);
		$count  = mysqli_num_rows($res);

		while($row=mysqli_fetch_array($res))
			{
				$color  = $row['color_font'];
				$color_background  = $row['color_background'];
			}
			echo '
			<legend>Change Color Caption</legend>
			<form action="color-progress.php" class="form-horizontal" method="post" enctype="multipart/form-data" id="UploadForm">		
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="sitename">Color</label>
				  <div class="col-sm-9">
					<input type="text" class="form-control" name="color_font" value="'.$color.'"/>
					<p class="text-info">Color Font, Ex: #fff.</p>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="sitename">Background Color</label>
				  <div class="col-sm-9">
					<input type="text" class="form-control" name="color_background" value="'.$color_background.'"/>
					<p class="text-info">Background Color (Must be Transparent), Ex: rgba(0,0,0,0.6).</p>
				  </div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-9">
					<input class="btn btn-primary" type="submit" name="submit" value="Save" />
				  </div>
				</div>
			</form>
			';?>
		</div>	
	</div><!-- End Row -->
	
<?php	
include "admin-footer.php";
?>
