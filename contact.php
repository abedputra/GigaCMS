<?php
include "inc/init.php";

$page->title = "Contact to ". $set->site_name;
$page->description = "contact us $set->site_name";
$page->keyword = "contact us $set->site_name, get in touch $set->site_name";

$presets->setActive("contactus"); // we highlith the contact link


if($_POST && isset($_SESSION['token']) && ($_SESSION['token'] == $_POST['token'])) {

	  $email = $_POST['email'];
	  $message = $_POST['message'];

	  if(!$options->isValidMail($email)) 
	    $page->error = "Email address is not valid.";
	  else if(!isset($message[10]))
	    $page->error = "Message was too short !";
	  else {
            $from ="From: ".$email;
            $sub = "Contact Admin $set->site_name !";
            if($options->sendMail($email, $sub, $message, $from))
                $page->success = "Your message was sent !";

	  }
} else if($_POST)
    $page->error = "Invalid request !";


include 'header.php';

$_SESSION['token'] = sha1(rand()); // random token

echo "
<div style='padding-top:100px'>
<div class='container'>";


if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);

	echo "
	<div class='col-sm-offset-1 col-sm-10'>
	<form class='form-horizontal' action='#' method='post'>
		        <fieldset>
		            <legend>Contact Us</legend>
					
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Your Email</label>
						<div class='col-sm-10'>
		                <input type='text' name='email' class='form-control' value='".($user->islg() ? $user->filter->email : "")."'>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-sm-2 control-label'>Message</label>
						<div class='col-sm-10'>
		                <textarea name='message' rows='5' class='form-control'></textarea>
						</div>
					</div>

           			<input type='hidden' name='token' value='".$_SESSION['token']."'>
					
					<div class='form-group'>
						<div class='col-sm-offset-2 col-sm-10'>
		              <button type='submit' id='submit' class='btn btn-primary'>Send</button>
						</div>
					</div>

		          </fieldset>
		    </form>
		  </div>
		</div>
	</div><!-- /container -->";

include 'footer.php';
?>