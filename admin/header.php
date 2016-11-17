<?php

// we generate the navbar components in case they weren't before
if($page->navbar == array())
    $page->navbar = $presets->GenerateNavbar();

if(!$user->islg()) // if it's not logged in we hide the user menu
    unset($page->navbar[count($page->navbar)-1]);
	
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
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="system admin">
		<meta name="keywords" content="">

        <title><?php echo $page->title; ?></title>
		
		<!-- CSS -->
        <link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/style.css">
		<link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/jasny-bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $set->url; ?>/shadowbox/shadowbox.css">
		
		
		
		<!-- Javascript -->
		<script src="<?php echo $set->url; ?>/js/303ccf41dc.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="<?php echo $set->url; ?>/shadowbox/shadowbox.js"></script>

		<!-- include summernote css/js-->
		<script src="<?php echo $set->url; ?>/js/jquery.js"></script> 
		<link href="<?php echo $set->url; ?>/dist/summernote.css" rel="stylesheet">
		<script src="<?php echo $set->url; ?>/dist/summernote.js"></script>
		
    </head>
    <body>
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
include "menu-side.php";
include "admin-footer.php";
    $options->fError("<div class='alert alert-danger' role='alert'>Your account is not yet acctivated ! Please check your email !</div>");
    
}

if(file_exists('install.php')) {
    $options->fError("<div class='alert alert-danger' role='alert' style='padding-top:100px'>You have to delete the install.php file before you start using this app.</div>");
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

?>