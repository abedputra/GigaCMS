<?php

include "../inc/init.php";

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Edit Menu";
$page->description = "Edit Menu";
$page->keyword = "";

$presets->setActive("adminpanel");

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
	
	if(isset($_POST['add_mainmenu']))
	{
		$menu = mysqli_real_escape_string($conn,$_POST['menu']);
		$menu_link = mysqli_real_escape_string($conn,$_POST['menu_link']);
		$sql_mainmenu=$conn->query("INSERT INTO `".MLS_PREFIX."mainmenu` (menu,menu_link) VALUES('$menu','$menu_link')");

		//info success or error
		if($sql_mainmenu) {
			?>
			<script>window.location.replace("navigation.php");</script>
			<?php
		} else {
			echo '<div class="container"><p style="padding:15px" class="bg-danger"> Error, Cant Save!' . mysqli_error($conn) . '</p></div>';
		}
	}
	if(isset($_POST['add_sub_menu']))
	{
		$parent = mysqli_real_escape_string($conn,$_POST['parent']);
		$submenu = mysqli_real_escape_string($conn,$_POST['submenu']);
		$submenu_link = mysqli_real_escape_string($conn,$_POST['submenu_link']);
		
		$sql_submenu=$conn->query("INSERT INTO `".MLS_PREFIX."submenu` (mainmenu_id,submenu,submenu_link) VALUES('$parent','$submenu','$submenu_link')");
				
		//info success or error
		if($sql_submenu) {
			?>
			<script>window.location.replace("navigation.php");</script>
			<?php
		} else {
			echo '<div class="container"><p style="padding:15px" class="bg-danger"> Error, Cant Save!' . mysqli_error($conn) . '</p></div>';
		}
			 
	}


?>
	

<legend>Add Main Menu</legend>

<div class="row">
	<div class="col-md-6">
		<form method="post" class="form-horizontal">
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Menu Name</label>
			  <div class="col-sm-7">
				<select required name="menu" class="form-control">
					<option value="">Please Select...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."page`");
					
					while($row1=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row1['title']; ?>" required><?php echo $row1['title']; ?></option>
						<?php
					}
					?>
				</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Menu Link</label>
			  <div class="col-sm-7">
				<select required name="menu_link" class="form-control">
					<option value="">Please Select...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."page`");
					
					while($row1=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row1['link']; ?>" required><?php echo $row1['title']; ?></option>
						<?php
					}
					?>
				</select>
				<p class="text-info">Menu Link Must be Same as Menu Name.</p>
			  </div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				<button class="btn btn-primary" type="submit" name="add_mainmenu">Add main menu</button> <a href="navigation.php"><button type="button" class="btn btn-default">Cancel</button></a>
				</div>
			</div>	
		</form>
	</div>
	<div class="col-md-6">
		<form method="post" class="form-horizontal">
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Menu Name</label>
			  <div class="col-sm-7">
				<input type="text" class="form-control" placeholder="Menu Name" name="menu" required/>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Link External</label>
			  <div class="col-sm-7">
				<input type="text" class="form-control" placeholder="Menu Link" name="menu_link" required/>
			  </div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-9">
				<button class="btn btn-primary" type="submit" name="add_mainmenu">Add main menu</button> <a href="navigation.php"><button type="button" class="btn btn-default">Cancel</button></a>
				</div>
			</div>	
		</form>
	</div>
</div><!--row-->
<br />
<legend>Add Submenu</legend>
<div class="row">
	<div class="col-md-6">
		<form method="post" class="form-horizontal">
		<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Select Parent Menu</label>
			  <div class="col-sm-7">
				<select name="parent" class="form-control" required>
					<option value="">Please Select...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."mainmenu`");
					while($row=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row['id']; ?>" required><?php echo $row['menu']; ?></option>
						<?php
					}
					?>
				</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Submenu Name</label>
			  <div class="col-sm-7">
				<select name="submenu" class="form-control" required>
					<option value="">Please Select...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."page`");
					
					while($row1=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row1['title']; ?>" required><?php echo $row1['title']; ?></option>
						<?php
					}
					?>
				</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Submenu Link</label>
			  <div class="col-sm-7">
				<select name="submenu_link" class="form-control" required>
					<option value="">Please Select...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."page`");
					
					while($row1=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row1['link']; ?>" required><?php echo $row1['title']; ?></option>
						<?php
					}
					?>
				</select>
				<p class="text-info">Submenu Link Must be Same as Submenu.</p>
			  </div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				<button type="submit" class="btn btn-primary" name="add_sub_menu">Add sub menu</button> <a href="navigation.php"><button type="button" class="btn btn-default">Cancel</button></a>
				</div>
			</div>	

		</form>
	</div>
	<div class="col-md-6">
		<form method="post" class="form-horizontal">
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Select Parent Menu</label>
			  <div class="col-sm-7">
				<select name="parent" class="form-control" required>
					<option value="">Please Select Parent ...</option>
					<?php
					$res=$conn->query("SELECT * FROM `".MLS_PREFIX."mainmenu`");
					while($row=$res->fetch_array())
					{
						?>
						<option value="<?php echo $row['id']; ?>" required><?php echo $row['menu']; ?></option>
						<?php
					}
					?>
				</select>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Submenu Name</label>
			  <div class="col-sm-7">
				<input type="text" class="form-control" placeholder="Menu Name" name="submenu" required/>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-4 control-label" for="sitename">Submenu Link External</label>
			  <div class="col-sm-7">
				<input type="text" class="form-control" placeholder="Submenu Link" name="submenu_link" required/>
			  </div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-7">
				<button type="submit" class="btn btn-primary" name="add_sub_menu">Add sub menu</button> <a href="navigation.php"><button type="button" class="btn btn-default">Cancel</button></a>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="pull-right">
</div>


<?php
include 'admin-footer.php';
?>