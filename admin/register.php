<?php
include "../inc/init.php";
include '../lib/captcha/captcha.php';

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Register to ". $set->site_name;
$page->description = "register to $set->site_name";
$page->keyword = "";

// determine if captcha code is correct
$captcha = ((!$set->captcha) || ($set->captcha && isset($_SESSION['captcha']) && isset($_POST['captcha']) && ($_SESSION['captcha']['code'] === $_POST['captcha'])));

if($_POST && isset($_SESSION['token']) && ($_SESSION['token'] == $_POST['token']) && $set->register && $captcha) {

  // we validate the data

  $name = $_POST['name'];
  $display_name = $_POST['display_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];


  if(!isset($name[3]) || isset($name[30]))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Username too short or too long !</p></div>";

  if(!$options->validUsername($name))
    $page->error = "<p style='padding: 10px;' class='bg-danger'>Invalid username !</p>";

  if(!isset($display_name[3]) || isset($display_name[50]))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Display name too short or too long !</p></div>";

  if(!isset($password[3]) || isset($password[30]))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Password too short or too long !</p></div>";

  if(!$options->isValidMail($email))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Email address is not valid.</p></div>";

  if($db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `username` = ?s", $name))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Username already in use !</p></div>";

  if($db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `email` = ?s", $email))
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Email already in use !</p></div>";

  if(!isset($page->error)){
    $user_data = array(
      "username" => $name,
      "display_name" => $display_name,
      "password" => sha1($password),
      "email" => $email,
      "lastactive" => time(),
      "regtime" => time(),
      "validated" => 1
      );

    if($set->email_validation == 1) {

      $user_data["validated"] = $key = sha1(rand());

      $link = $set->url."/validate.php?key=".$key."&username=".urlencode($name);

      $url_info = parse_url($set->url);
      $from ="From: not.reply@".$url_info['host'];
      $sub = "Activate your account !";
      $msg = "Hello ".$options->html($name).",<br> Thank you for choosing to be a member of out community.<br/><br/> To confirm your account <a href='$link'>click here</a>.<br>If you can't access copy this to your browser<br/>$link  <br><br>Regards<br><small>Note: Dont reply to this email. If you got this email by mistake then ignore this email.</small>";
      if(!$options->sendMail($email, $sub, $msg, $from))
        // if we can't send the mail by some reason we automatically activate the account
          $user_data["validated"] = 1;
    }

    if(($db->query("INSERT INTO `".MLS_PREFIX."users` SET ?u", $user_data)) && ($id = $db->insertId()) && $db->query("INSERT INTO `".MLS_PREFIX."privacy` SET `userid` = ?i", $id)) {
      $page->success = 1;
      $_SESSION['user'] = $id; // we automatically login the user
      $user = new User($db);
    } else
      $page->error = "There was an error ! Please try again !";

  }

} else if($_POST)
  if(!$captcha)
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Invalid captcha code !</p></div>";
  else
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Invalid request !</p></div>";

include 'header.php';
include "menu-side.php";

if(!$set->register) // we check if the registration is enabled
  $options->fError("We are sorry registration is blocked momentarily please try again leater !");


$_SESSION['token'] = sha1(rand()); // random token

if($set->captcha)
  $_SESSION['captcha'] = captcha();


$extra_content = ''; // holds success or error message

if(isset($page->error))
  $extra_content = $options->error($page->error);

if(isset($page->success)) {

  echo "
    <div class='well'>
    <h1>Congratulations !</h1>";
    $options->success("<p><strong>New account was successfully registered !</strong></p>");
    echo "
    </div>
  </div>";


} else {


if($set->captcha)
$captcha =  "
	<div class='form-group'>
		<label class='col-sm-2 control-label' for='captcha'>Enter the code:</label>
		<div class='col-sm-10'>
      <img src='".$_SESSION['captcha']['image_src']."'><br/><br>
      <input type='text' class='form-control' name='captcha' id='captcha'>
		</div>
	</div>";
else
  $captcha = '';

  echo "
       ".$extra_content."

      <form action='#' id='contact-form' class='form-horizontal' method='post'>
        <fieldset>
          <legend>Register New User </legend>
		  
		  <div class='form-group'>
				<label class='col-sm-2 control-label' for='name'>Username</label>
				<div class='col-sm-10'>
				<input type='text' class='form-control' name='name' id='name' required>
				</div>
			</div>	
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='display_name'>Display name</label>
				<div class='col-sm-10'>
				<input type='text' class='form-control' name='display_name' id='display_name' required>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='email'>Email Address</label>
				<div class='col-sm-10'>
				<input type='text' class='form-control' name='email' id='email' required>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='password'>Password</label>
				<div class='col-sm-10'>
              <input type='password' class='form-control' name='password' id='password' required>
				</div>
			</div>
			<div class='form-group'>
			  <label class='col-sm-2 control-label' for='dbpass'>Confirm Password</label>
			  <div class='col-sm-10'>
				<input id='confirm_password' type='password' value='' class='form-control' required>
			  </div>
			</div>
				  
          <input type='hidden' name='token' value='".$_SESSION['token']."'>
          $captcha
		  
		  <div class='form-group'>
				<div class='col-sm-offset-2 col-sm-10'>
				  <button type='submit' class='btn btn-primary btn-large'>Register</button>
				  <button type='reset' class='btn'>Reset</button>
				</div>
			</div>

        </fieldset>
      </form>";
}

include "admin-footer.php";

?>
<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
	confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
	confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>