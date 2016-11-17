<?php
include "inc/init.php";


if(!$user->islg()) {
	header("Location: $set->url");
	exit;
}
$presets->setActive("user");
$page->title = "Privacy Settings";
$page->description = "privacy settings at $set->site_name";
$page->keyword = "";


if($_POST) {

	$data = $db->getRow("SELECT * FROM `".MLS_PREFIX."privacy` WHERE `userid` = ?i", $user->data->userid);

	$columns = get_object_vars($data);
	
	$sql = "UPDATE `".MLS_PREFIX."privacy` SET ";
	foreach ($columns as $k => $v)
		if(($k != 'userid') && in_array($_POST[$k], array(1,0))) // we make sure the received value is 0 or 1
			$sql .= $db->parse(" ?n = ?s,", $k, $_POST[$k]);

	$sql = trim($sql,",").$db->parse(" WHERE `userid` = ?i", $user->data->userid);

	if($db->query(" ?p",$sql))
		$page->success = "Settings saved !";
	else
		$page->error = "Some error camed up ! ";

}

include 'admin/header.php';
include "admin/menu-side.php";


echo "<form class='form-horizontal' method='post' action='?'>
<fieldset>

<legend>Privacy Settings</legend>";

if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);


$data = $db->getRow("SELECT * FROM `".MLS_PREFIX."privacy` WHERE `userid` = ?i", $user->data->userid);

$columns = get_object_vars($data);

foreach($columns as $k => $v)
	if($k != 'userid')
		echo "<div class='form-group'>
		  <label class='col-sm-2 control-label' for='".$options->html($k)."'>".$options->prettyPrint($options->html($k))."</label>
		  <div class='col-sm-10'>
		    <select id='".$options->html($k)."' name='".$options->html($k)."' class='form-control'>
		      <option value='0' ".($v == 0 ? "selected='1'" : "").">Private</option>
		      <option value='1' ".($v == 1 ? "selected='1'" : "").">Public</option>
		    </select>
		  </div>
		</div>";

echo "
				<div class='form-group'>
					<div class='col-sm-offset-2 col-sm-10'>
						<button type='submit' class='btn btn-primary'>Save</button>
					</div>
				</div>



</fieldset>
</form>";

include 'admin/admin-footer.php';
?>