<?php
include "inc/init.php";

if($user->islg()) { // if it's alreadt logged in redirect to the main page 
  header("Location: $set->url");
  exit;
}

$page->title = "Login to ". $set->site_name;
$page->description = "login to $set->site_name";
$page->keyword = "";


if($_POST && isset($_SESSION['token']) && ($_SESSION['token'] == $_POST['token'])) {
    // we validate the data
    if(isset($_GET['forget'])) {
    
        $email = $_POST['email'];
        
        if(!$options->isValidMail($email)) 
            $page->error = "Email address is not valid.";   
        
        if(!isset($page->error) && !($usr = $db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `email` = ?s", $email)))
            $page->error = "This email address doesn't exist in our database !";


        if(!isset($page->error)) {
            $key = sha1(rand());
           
            $db->query("UPDATE `".MLS_PREFIX."users` SET `key` = ?s WHERE `userid` = ?i", $key, $usr->userid);
           
            $link = $set->url."/login.php?key=".$key."&userid=".$usr->userid;

            $from ="From: not.reply@".$set->url;
            $sub = "New Password !";
            $msg = "Hello,<br> You requested for a new password. To confirm <a href='$link'>click here</a>.<br>If you can't access copy this to your browser<br/>$link  <br><br>Regards<br><small>Note: Dont reply to this email. If you got this email by mistake then ignore this email.</small>";
            if($options->sendMail($email, $sub, $msg, $from))
                $page->success = "An email with instructions was sent !";
        }

    } else if(isset($_GET['key'])) {
        if($_GET['key'] == '0') {
            header("Location: $set->url");
            exit;
        }
        if($usr = $db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `key` = ?s", $_GET['key'])) {
            if($db->query("UPDATE `".MLS_PREFIX."users` SET `password` = ?s WHERE `userid` = ?i", sha1($_POST['password']), $usr->userid)) {
                $db->query("UPDATE `".MLS_PREFIX."users` SET `key` = '0' WHERE `userid` = ?i", $usr->userid);
                $page->success = "Password was updated !";
            }

        }

    } else {
        $name = $_POST['name'];
        $password = $_POST['password'];


        if(!($usr = $db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `username` = ?s AND `password` = ?s", $name, sha1($password))))
            $page->error = "<div class='col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2'><div id='login-alert' class='alert alert-danger'>Username or password are wrong !</div></div>";
        else {
            if($_POST['r'] == 1){
                $path_info = parse_url($set->url);
                setcookie("user", $name, time() + 3600 * 24 * 30, $path_info['path']); // set
                setcookie("pass", sha1($password), time() + 3600 * 24 * 30, $path_info['path']); // set
            }
            $_SESSION['user'] = $usr->userid;
            header("Location: $set->url/admin");// link to if success
            exit;
        }
    }
} else if($_POST)
    $page->error = "Invalid request !";


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
	<script src="<?php echo $set->url; ?>/tinymce/tinymce.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>

	  <script>
	  tinymce.init({
		selector : "textarea#textareas_edit",
		theme: 'modern',
		skin: 'lightgray',
		height: 300,
	  // ===========================================
	  // INCLUDE THE PLUGIN
	  // ===========================================
		plugins: [
		'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
		'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		'save table contextmenu directionality emoticons template paste textcolor'														
		],
	  // ===========================================
	  // PUT PLUGIN'S BUTTON on the toolbar
	  // ===========================================
		toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
		
	  // ===========================================
	  // SET RELATIVE_URLS to FALSE (This is required for images to display properly)
	  // ===========================================
		content_css: 'css/content.css'
		
	  });
	  </script>

</head>
<body>
<br>
<?php


if($user->data->banned) {
  
// we delete the expired banned
$_unban = $db->getAll("SELECT `userid` FROM `".MLS_PREFIX."banned` WHERE `until` < ".time());
if($_unban) 
    foreach ($_unban as $_usr) {
        $db->query("DELETE FROM `".MLS_PREFIX."banned` WHERE `userid` = ?i", $_usr->userid);
        $db->query("UPDATE `".MLS_PREFIX."users` SET `banned` = '0' WHERE `userid` = ?i", $_usr->userid);             
    }


$_banned = $user->getBan();
if($_banned)
$options->error("You were banned by <a href='$set->url/profile.php?u=$_banned->by'>".$user->showName($_banned->by)."</a> for `<i>".$options->html($_banned->reason)."</i>`.
    Your ban will expire in ".$options->tsince($_banned->until, "from now.")."
    ");
}

if($user->islg() && $set->email_validation && ($user->data->validated != 1)) {
    $options->fError("Your account is not yet acctivated ! Please check your email !");
}

if(file_exists('install.php')) {
    $options->fError("You have to delete the install.php file before you start using this app.");
}

if(isset($_SESSION['success'])){
    $options->success($_SESSION['success']);
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    $options->error($_SESSION['error']);
    unset($_SESSION['error']);
}
flush(); // we flush the content so the browser can start the download of css/js

$_SESSION['token'] = sha1(rand()); // random token

  echo "<div class='container'>
  <div class='col-md-9 col-md-offset-1'>
  <div class='row'>";

if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);


if(isset($_GET['forget'])) {
    
    echo "  
        <div id='loginbox' style='margin-top:50px;' class='mainbox col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2'>                    
            <div class='panel panel-info'>
			<div class='panel-heading'>
				<div class='panel-title'>Recover</div>				
			</div>
			<div style='padding-top:30px' class='panel-body' >

			<div style='display:none' id='login-alert' class='alert alert-danger col-sm-12'></div>
				
		<form class='form-horizontal' action='#' method='post'>
            <div class='form-group'>
                <label class='col-md-2 control-label'>Email</label>
              <div class='col-md-9'>
                <input type='text' placeholder='john.doe@domain.com' name='email' class='form-control'>
              </div>
            </div>            
            <input type='hidden' name='token' value='".$_SESSION['token']."'>

            <div class='form-group'>
              <div class='col-md-offset-2 col-md-9'>
              <button type='submit' id='submit' class='btn btn-primary'>Recover </button> <a href='login.php' class='btn btn-default'> Login</a>
			</div>";

} else if(isset($_GET['key']) && !isset($page->success)) { 
    if($_GET['key'] == '0') {
        echo "<div class=\"alert alert-error\">Error !</div>";
        exit;
    }
    if($usr = $db->getRow("SELECT `userid` FROM `".MLS_PREFIX."users` WHERE `key` = ?s AND `userid` = ?i", $_GET['key'], $_GET['userid'])) {
    echo "
	<form class='form-horizontal' action='#' method='post'>
        <fieldset>
            <legend>Reset</legend>
			
            <div class='form-group'>
                <label class='col-sm-2 control-label'>New password</label>
              <div class='col-sm-10'>
                <input type='password' name='password' class='form-control'>
              </div>
            </div>

            <input type='hidden' name='token' value='".$_SESSION['token']."'>

            <div class='form-group'>
              <div class='col-sm-10'>
              <button type='submit' id='submit' class='btn btn-primary'>Save</button>
              </div>
            </div>
          </fieldset>";


    } else {
        echo "<div class=\"alert alert-error\">Error bad key !</div>";
    }

}else {
    echo "  
        <div id='loginbox' style='margin-top:50px;' class='mainbox col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2'>                    
            <div class='panel panel-info'>
			<div class='panel-heading'>
				<div class='panel-title'>Sign In</div>
				<div style='float:right; font-size: 80%; position: relative; top:-10px'><a href='?forget=1'>Forgot Password</a></div>
			</div>
			<div style='padding-top:30px' class='panel-body' >	
					
				<form class='form-horizontal' action='?' method='post'>
							
					<div style='margin-bottom: 25px' class='input-group'>
								<span class='input-group-addon'><i class=\"fa fa-user\" aria-hidden=\"true\"></i></span>
								<input type='text' placeholder='User Name' name='name' class='form-control'>                                    
							</div>						
					<div style='margin-bottom: 25px' class='input-group'>
								<span class='input-group-addon'><i class=\"fa fa-key\" aria-hidden=\"true\"></i></span>
								<input type='password' placeholder='Your Password' name='password' class='form-control'>
							</div>			
					<div class='input-group'>
							  <div class='checkbox'>
								<label>
								  <input type='checkbox' name='r' value='1' id='r'> Remember me
								</label>
							  </div>
							</div>

						 <input type='hidden' name='token' value='".$_SESSION['token']."'>
						 
						<div style='margin-top:10px' class='form-group'>
							<div class='col-sm-12 controls'>
							  <button type='submit' id='submit' class='btn btn-primary'>Login  </button> <a href='index.php' class='btn btn-primary'> Back to Site  </a>                       
							</div>
						</div>


						<div class='form-group'>
							<div class='col-md-12 control'>
								<div style='border-top: 1px solid#888; padding-top:15px; font-size:85%' >
									Don't have an account! 
								<a href='register.php'>
									Sign Up Here
								</a>
								</div>
							</div>
						</div> 
					</form>   
				</div>                     
			</div>  
        </div>";
}          
echo "  
      </div>";

?>
<script src="<?php echo $set->url;?>/js/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $set->url;?>/js/jquery-1.11.3.min.js"><\/script>')</script>
<script src="<?php echo $set->url;?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Validate Plugin -->
<script src="<?php echo $set->url;?>/js/vendor/jquery.validate.min.js"></script>
<script src="<?php echo $set->url;?>/js/main.js"></script>
</body>
</html>