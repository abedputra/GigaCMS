<?php
include "inc/init.php";
include 'lib/captcha/captcha.php';

if($user->islg()) { // if it's alreadt logged in redirect to the main page
  header("Location: $set->url");
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
    } else{
      $page->error = "There was an error ! Please try again !";
    }
  }

} else if($_POST)
  if(!$captcha)
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Invalid captcha code !</p></div>";
  else
    $page->error = "<div class='container'><p style='padding: 10px;' class='bg-danger'>Invalid request !</p></div>";


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
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<!-- SEO -->
	<title><?php echo $page->title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo $page->description; ?>">
	<meta name="keywords" content="<?php echo $page->keyword; ?>">        
	
	
	<?php
	// get results from database
	$result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."seo` WHERE `id`='1'") 
		or die(mysqli_error());  	

	// loop through results of database query, displaying them in the table
	while($row = mysqli_fetch_array( $result )) {
	?>
		
	<meta name="google-site-verification" content="<?php echo $row['google_webmaster']; ?>" />
	<meta name="msvalidate.01" content="<?php echo $row['bing_webmaster']; ?>" />
	<meta name="alexaVerifyID" content="<?php echo $row['alexa']; ?>" />
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', '<?php echo $row['google_analytic']; ?>', 'auto');
	  ga('send', 'pageview');

	</script>
	<meta name="revisit-after" content="<?php echo $row['revisit_after']; ?>">
	<meta name="robots" content="<?php echo $row['robots']; ?>">
	
	<!-- SEO -->			
	<?php
	}		
	?>			
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/bootstrap.min.css">
	
	<!-- Javascript -->
	<script src="js/jquery.min.js"></script>
	<script src="<?php echo $set->url; ?>/js/303ccf41dc.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
</head>
<body>
<br>
<?php

if(!$set->register) // we check if the registration is enabled
  $options->fError("We are sorry registration is blocked momentarily please try again leater !");


$_SESSION['token'] = sha1(rand()); // random token

if($set->captcha)
  $_SESSION['captcha'] = captcha();


$extra_content = ''; // holds success or error message

if(isset($page->error))
  $extra_content = $options->error($page->error);

if(isset($page->success)) {

  echo "<div class='container'>
    <h1>Congratulations !</h1>";
    $options->success("<p><strong>Your account was successfully registered !</strong></p>");
    echo " <a class='btn btn-primary' href='$set->url'>Start exploring</a>
  </div>";


} else {


if($set->captcha)
$captcha =  "
	<div class='form-group'>
		<label class='col-md-4 control-label' for='captcha'>Enter the code:</label>
		<div class='col-md-8'>
      <img src='".$_SESSION['captcha']['image_src']."'><br/><br>
      <input type='text' class='form-control' name='captcha' id='captcha'>
		</div>
	</div>";
else
  $captcha = '';

  echo "
  <div class='container'>
  <div class='col-md-8 col-md-offset-1'>
	<div id='signupbox' style='margin-top:50px' class='mainbox col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2'>
		<div class='panel panel-info'>
			<div class='panel-heading'>
				<div class='panel-title'>Sign Up</div>
				<div style='float:right; font-size: 85%; position: relative; top:-10px'><a href='login.php'>Sign In</a></div>
			</div>  
			<div class='panel-body' >
			".$extra_content."
				<form action='#' id='contact-form' class='form-horizontal' method='post'>
					
					<div id='signupalert' style='display:none' class='alert alert-danger'>
						<p>Error:</p>
						<span></span>
					</div>				
					  
					<div class='form-group'>
						<label for='email' class='col-md-4 control-label'>Email</label>
						<div class='col-md-8'>
							<input type='text' class='form-control' name='email' id='email' required>
						</div>
					</div>
						
					<div class='form-group'>
						<label for='firstname' class='col-md-4 control-label'>User Name</label>
						<div class='col-md-8'>
							<input type='text' class='form-control' name='name' id='name' required>
						</div>
					</div>
					<div class='form-group'>
						<label for='lastname' class='col-md-4 control-label'>Display Name</label>
						<div class='col-md-8'>
							<input type='text' class='form-control' name='display_name' id='display_name' required>
						</div>
					</div>
					<div class='form-group'>
						<label for='password' class='col-md-4 control-label'>Password</label>
						<div class='col-md-8'>
							<input type='password' class='form-control' name='password' id='password' required>
						</div>
					</div>
						
					<div class='form-group'>
						<label for='icode' class='col-md-4 control-label'>Confirm Password</label>
						<div class='col-md-8'>
							<input id='confirm_password' type='password' value='' class='form-control' required>
						</div>
					</div>
					
					<input type='hidden' name='token' value='".$_SESSION['token']."'>
					$captcha

					<div class='form-group'>
						<!-- Button -->                                        
						<div class='col-md-offset-4 col-md-8'>
							<button type='submit' class='btn btn-primary btn-large'>Register</button> <button type='reset' class='btn'>Reset</button>
						</div>
					</div>                            
					
				</form>
			 </div>
		</div>                             
	</div> 
</div>";
}

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


<script src="<?php echo $set->url;?>/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $set->url;?>/js/jquery-1.11.3.min.js"><\/script>')</script>
<script src="<?php echo $set->url;?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Validate Plugin -->
<script src="<?php echo $set->url;?>/js/vendor/jquery.validate.min.js"></script>
<script src="<?php echo $set->url;?>/js/main.js"></script>
</body>
</html>
	
