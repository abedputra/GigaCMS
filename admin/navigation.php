<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Menu Navigation";
$presets->setActive("adminpanel");

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

include "menu-side.php";
?>
		
<div class="container">
<?php

//Now select all from table
$query = "select * from `".MLS_PREFIX."mainmenu`";
$result = mysqli_query($conn, $query);
if (!$result) {
    die(mysqli_error($conn));
}
?>
<legend>Main Menu</legend>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<table class="table table-striped table-hover">
    <tr><th>Menu Name</th><th>Link</th><th>Edit</th></tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
        <td><?php echo $row['menu']; ?></td>
		<td><?php echo $row['menu_link']; ?></td>
		        
        <td><a href="<?php echo '../admin/menu-edit.php?id=' . $row['id'] . ''?>"><button class="btn btn-primary"> Edit</button></a> <a href="<?php echo 'menu-delete.php?id=' . $row['id'] . ''?>"><button class="btn btn-warning">Delete</button></a></td>
        
        </tr>
    <?php
    };
    ?>
</table>
</div>
</div><!--/.row-->

<br>
<br>
<?php

//Now select all from table
$query = "select * from `".MLS_PREFIX."submenu`";
$result = mysqli_query($conn, $query);
if (!$result) {
    die(mysqli_error($conn));
}
?>
<legend>Submenu</legend>
<div class="col-md-8 col-md-offset-2">
<table class="table table-striped table-hover">
    <tr><th>Submenu Name</th><th>Link</th><th>Edit</th></tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
        <td><?php echo $row['submenu']; ?></td>
		<td><?php echo $row['submenu_link']; ?></td>
		        
        <td><a href="<?php echo '../admin/submenu-edit.php?id=' . $row['id'] . ''?>"><button class="btn btn-primary"> Edit</button></a> <a href="<?php echo 'submenu-delete.php?id=' . $row['id'] . ''?>"><button class="btn btn-warning">Delete</button></a></td>
        
        </tr>
    <?php
    };
    ?>
</table>
</div>
</div><!--/.container-->



<?php	
include "admin-footer.php";
?>