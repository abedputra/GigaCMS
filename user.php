<?php
include "inc/init.php";

if(!$user->islg()){
	header("Location: ".$set->url);
	exit;
}


if(isset($_GET['id']) && $user->group->canedit && $user->exists($_GET['id'])) {
	$uid = (int)$_GET['id'];
	$can_edit = 1;
}else{
	$uid = $user->data->userid;
	$can_edit = 0;
}
$u = $db->getRow("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` = ?i", $uid);

$presets->setActive("user");
$page->title = "Edit info of ". $options->html($u->username);
$page->description = "edit info of user";
$page->keyword = "";

if($_POST) {
	if(isset($_GET['password']) && ($user->data->userid == $u->userid)) {
		$opass = $_POST['oldpass'];
		$npass = $_POST['newpass'];
		$npass2 = $_POST['newpass2'];
		if($db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `userid` = ?i AND `password` = ?s", $u->userid, sha1($opass))) {

			if(!isset($npass[3]) || isset($npass[30]))
				$page->error = "Password too short or too long !";
			else if($npass != $npass2)
				$page->error = "New passwords don't match !";
			else
				if($db->query("UPDATE `".MLS_PREFIX."users` SET `password` = ?s WHERE `userid` = ?i", sha1($npass), $u->userid))
					$page->success = "Password updated successfully !";

		} else 
		  $page->error = 'Invalid password !';

	} else {
      
      	$email = $_POST['email'];
      	$display_name = $_POST['display_name'];


      	$extra = '';
      	if($can_edit) {
	      	$username = $_POST['username'];
	      	$password = $_POST['password'];
	      	if(isset($_POST['groupid']))
		      	$groupid = $_POST['groupid'];

	      	$extra = $db->parse(", `username` = ?s", $username);

	      	if($user->isAdmin())
	      		$extra .= $db->parse(", `groupid` = ?i", $groupid);

	      	if(!empty($password))
	      		$extra .= $db->parse(", `password` = ?s", sha1($password));

			if(!isset($username[3]) || isset($username[30]))
			    $page->error = "<div class='bg-danger' style='padding:15px'>Username too short or too long !</div>";

			if(!$options->validUsername($username))
				$page->error = "<div class='bg-danger' style='padding:15px'>Invalid username !</div>";

			if($user->isAdmin() && !$db->getRow("SELECT `groupid` FROM `".MLS_PREFIX."groups` WHERE `groupid` = ?i", $groupid))
				$page->error = "<div class='bg-danger' style='padding:15px'>The group is invalid !</div>";
		}


	  	if(!$options->isValidMail($email)) 
	    	$page->error = "Email address is not valid.";
	    
	    if(!isset($display_name[3]) || isset($display_name[50]))
		    $page->error = "Display name too short or too long !";	  

	  	if(!isset($page->error) && $db->query("UPDATE `".MLS_PREFIX."users` SET `email` = ?s, `display_name` = ?s ?p WHERE `userid` = ?i", $email, $display_name, $extra, $u->userid)) {
	  		$page->success = "Info was saved !";
	  		// we make sure we show updated data
			$u = $db->getRow("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` = ?i", $u->userid);
	  	}
	}
}

include 'admin/header.php';
include "admin/menu-side.php";

if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);


if(isset($_GET['password']) && ($user->data->userid == $u->userid)) { 
// we use this option only for personal profile
// because you need to know the old password
	echo "<form class='form-horizontal' action='#' method='post'>
	        <fieldset>
	            <legend>Change Password</legend>
				
				<div class='form-group'>
					<label class='col-sm-2 control-label'>Old Password</label>
					<div class='col-sm-10'>
	                <input type='password' name='oldpass' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label'>New Password</label>
					<div class='col-sm-10'>
	                <input type='password' name='newpass' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label'>New Password Again</label>
					<div class='col-sm-10'>
	                <input type='password' name='newpass2' class='form-control'>
					</div>
				</div>							
				<div class='form-group'>
					<div class='col-sm-offset-2 col-sm-10'>
	              <button type='submit' id='submit' class='btn btn-primary'>Save</button>
				  <a href='?' class='btn btn-default'>Edit Info</a>
					</div>
				</div>

	          </fieldset>
		    </form>";	

} else {

	echo "<form class='form-horizontal' action='#' method='post'>
		        <fieldset>
		            <legend>Edit info of ".$options->html($u->username)."</legend>";

if($can_edit) {

	$groups = $db->getAll("SELECT * FROM `".MLS_PREFIX."groups` ORDER BY `type`,`priority`");


	// get the groups available
	$show_groups = '';
	foreach($groups as $group)
		if($group->groupid != 1)
			if($group->groupid == $u->groupid)
				$show_groups .= "<option value='$group->groupid' selected='1'>".$group->name."</option>";
			else
				$show_groups .= "<option value='$group->groupid'>".$group->name."</option>";

	echo "
			<div class='form-group'>
				<label class='col-sm-2 control-label'>Username</label>
				<div class='col-sm-10'>
				<input type='text' name='username' class='form-control' value='".$options->html($u->username)."'>
			</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label'>Password</label>
				<div class='col-sm-10'>
	        <input type='text' name='password' class='form-control'><br/>
			<small>Leave blank if you don't want to change</small>
			</div>
			</div>

		<div class='form-group'>
		  <label class='col-sm-2 control-label' for='selectbasic'>Group: </label>
		  <div class='col-sm-10'>
		    <select id='selectbasic' name='groupid' class='form-control' ".($user->isAdmin() ? "" : "disabled='disabled'").">
				$show_groups	      
		    </select>
		  </div>
		</div> 
	";


}
echo "

	<div class='form-group'>
		<label class='col-sm-2 control-label'>Display name</label>
		<div class='col-sm-10'>
		<input type='text' name='display_name' class='form-control' value='".$options->html($u->display_name)."'>
	</div>
	</div>
	<div class='form-group'>
		<label class='col-sm-2 control-label'>Email</label>
		<div class='col-sm-10'>
		<input type='text' name='email' class='form-control' value='".$options->html($u->email)."'>
	</div>
	</div>
	<div class='form-group'>
		<div class='col-sm-offset-2 col-sm-10'>
		<button type='submit' id='submit' class='btn btn-primary'>Save</button>";
	  if(!$can_edit)
		echo " <a href='?password=1' class='btn btn-default'>Change Password</a>";
		echo"
		</div>
	</div>

		  
      </fieldset>
</form>";

}
include 'admin/admin-footer.php';
?>