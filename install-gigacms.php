<?php
include 'lib/mysql.class.php';
include 'lib/options.class.php';
$options = new Options;
$page = new stdClass();

if($_POST) {
	// we first check the settings file
	if(!is_writable('inc/settings.php'))
	chmod('inc/settings.php', 0666);


	// we make the db connection
	$db = new SafeMySQL(array(
	'host'  => $_POST['dbhost'], 
	'user'  => $_POST['dbuser'], 
	'pass'  => $_POST['dbpass'], 
	'db'    => $_POST['dbname']));


	// once that is done we write the details in the settings file
	$host = str_replace("'", "\'", $_POST['dbhost']);
	$user = str_replace("'", "\'", $_POST['dbuser']);
	$pass = str_replace("'", "\'", $_POST['dbpass']);
	$name = str_replace("'", "\'", $_POST['dbname']);
	$prefix = str_replace("'", "\'", $_POST['tbprefix']);

$data =<<<EEE
<?php

// database details
\$set->db_host = '$host'; // database host
\$set->db_user = '$user'; // database user
\$set->db_pass = '$pass'; // database password
\$set->db_name = '$name'; // database name

define('MLS_PREFIX', '$prefix');  

EEE;

  // add the data to the file
  if(!file_put_contents('inc/settings.php', $data))
    $page->error = "There is an error with inc/settings.php make sure it is writable.";


	// banned
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."banned` (
	  `userid` int(11) NOT NULL,
	  `until` int(11) NOT NULL,
	  `by` int(11) NOT NULL,
	  `reason` varchar(255) NOT NULL,
	  UNIQUE KEY `userid` (`userid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	// groups
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."groups` (
	  `groupid` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) NOT NULL,
	  `type` int(11) NOT NULL,
	  `priority` int(11) NOT NULL,
	  `color` varchar(50) NOT NULL,
	  `canban` int(11) NOT NULL,
	  `canhideavt` int(11) NOT NULL,
	  `canedit` int(11) NOT NULL,
	  PRIMARY KEY (`groupid`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."groups` (`groupid`, `name`, `type`, `priority`, `color`, `canban`, `canhideavt`, `canedit`) VALUES
	(1, 'Guest', 0, 1, '', 0, 0, 0),
	(2, 'Member', 1, 1, '#08c', 0, 0, 0),
	(3, 'Moderator', 2, 1, 'green', 1, 1, 0),
	(4, 'Administrator', 3, 1, '#F0A02D', 1, 1, 1);";

	// privacy
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."privacy` (
	  `userid` int(11) NOT NULL,
	  `email` int(11) NOT NULL,
	  UNIQUE KEY `userid` (`userid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."privacy` (`userid`, `email`) VALUES (1, 0);";
  
	// settings
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."settings` (
	  `site_name` varchar(255) NOT NULL DEFAULT 'My Site',
	  `url` varchar(300) NOT NULL,
	  `logo` varchar(50) NOT NULL,
	  `admin_email` varchar(255) NOT NULL,
	  `max_ban_period` int(11) NOT NULL DEFAULT '10',
	  `register` int(11) NOT NULL DEFAULT '1',
	  `email_validation` int(11) NOT NULL DEFAULT '0',
	  `captcha` int(11) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

	  $sqls[] = $db->parse("
	  INSERT INTO `".$prefix."settings` (`site_name`, `url`, `logo`, `admin_email`, `max_ban_period`, `register`, `email_validation`, `captcha`) VALUES
	(?s, ?s,'upload/GigaCMS.png', 'nor.reply@gmail.com', 10, 1, 0, 1);", $_POST['sitename'], $_POST['siteurl']);

	// users
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."users` (
	  `userid` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(50) NOT NULL,
	  `display_name` varchar(255) NOT NULL,
	  `password` varchar(50) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `key` varchar(50) NOT NULL,
	  `validated` varchar(100) NOT NULL,
	  `groupid` int(11) NOT NULL DEFAULT '2',
	  `lastactive` int(11) NOT NULL,
	  `showavt` int(11) NOT NULL DEFAULT '1',
	  `banned` int(11) NOT NULL,
	  `regtime` int(11) NOT NULL,
	  PRIMARY KEY (`userid`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

		$username = $_POST['username'];
		$pass = $_POST['password'];
		$email = $_POST['email'];
		$passsha1= sha1($pass);

	  $sqls[] = "
	  INSERT INTO `".$prefix."users` (`userid`, `username`, `display_name`, `password`, `email`, `key`, `validated`, `groupid`, `lastactive`, `showavt`, `banned`, `regtime`) VALUES
	(1, '$username', '$username', '$passsha1', '$email', '', '1', 4, ".time().", 1, 0, ".time().");";


	// home
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."home` (
	  `id` int(11) NOT NULL,
	  `title` text CHARACTER SET utf8 NOT NULL,
	  `title_features` text CHARACTER SET utf8 NOT NULL,
	  `glyphicons_1` text NOT NULL,
	  `features_content_1` text NOT NULL,
	  `glyphicons_2` text NOT NULL,
	  `features_content_2` text NOT NULL,
	  `glyphicons_3` text NOT NULL,
	  `features_content_3` text NOT NULL,
	  `glyphicons_4` text NOT NULL,
	  `features_content_4` text NOT NULL,
	  `title_products` text NOT NULL,
	  `products_1` text NOT NULL,
	  `products_2` text NOT NULL,
	  `products_3` text NOT NULL,
	  `products_4` text NOT NULL,
	  `clients_1` tinytext NOT NULL,
	  `clients_2` text NOT NULL,
	  `clients_3` text NOT NULL,
	  `clients_4` text NOT NULL,
	  `testimonials` text NOT NULL,
	  `description` text CHARACTER SET utf8 NOT NULL,
	  `keyword` tinytext NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."home` (`id`, `title`, `title_features`, `glyphicons_1`, `features_content_1`, `glyphicons_2`, `features_content_2`, `glyphicons_3`, `features_content_3`, `glyphicons_4`, `features_content_4`, `title_products`, `products_1`, `products_2`, `products_3`, `products_4`, `clients_1`, `clients_2`, `clients_3`, `clients_4`, `testimonials`, `description`, `keyword`) VALUES
	(1, 'Home', '<h2 class=\"fh5co-section-lead\">Features</h2>\r\n<h3 class=\"fh5co-section-sub-lead\">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h3>', 'fa fa-camera', '<p>Far far away, behind the word mountains, far from the countries Vokalia.</p><p><a href=\"#\">Read more</a></p>', 'fa fa-cart-plus', '<p>Far far away, behind the word mountains, far from the countries Vokalia.</p><p><a href=\"#\">Read more</a></p>', 'fa fa-check-circle', '<p>Far far away, behind the word mountains, far from the countries Vokalia.</p><p><a href=\"#\">Read more</a></p>', 'fa fa-bolt', '<p>Far far away, behind the word mountains, far from the countries Vokalia.</p><p><a href=\"#\">Read more</a></p>', '<h2 class=\"fh5co-section-lead\">Products</h2><h3 class=\"fh5co-section-sub-lead\">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</h3>', '<img src=\"theme/images/slide_1.jpg\" alt=\"FREEHTML5.co Free HTML5 Template Bootstrap\" class=\"img-responsive\"><h4>Lorem ipsum</h4><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p><p><a href=\"#\">Read more</a></p>', '<img src=\"theme/images/slide_1.jpg\" alt=\"FREEHTML5.co Free HTML5 Template Bootstrap\" class=\"img-responsive\"><h4>Lorem ipsum</h4><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p><p><a href=\"#\">Read more</a></p>', '<img src=\"theme/images/slide_1.jpg\" alt=\"FREEHTML5.co Free HTML5 Template Bootstrap\" class=\"img-responsive\"><h4>Lorem ipsum</h4><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p><p><a href=\"#\">Read more</a></p>', '<img src=\"theme/images/slide_1.jpg\" alt=\"FREEHTML5.co Free HTML5 Template Bootstrap\" class=\"img-responsive\"><h4>Lorem ipsum</h4><p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p><p><a href=\"#\">Read more</a></p>', 'theme/images/client_1.png', 'theme/images/client_2.png', 'theme/images/client_3.png', 'theme/images/client_4.png', '<h1>\"Design is not just what it looks like and feels like. Design is how it works. \"</h1><br><br>\r\n <h4>-Steve Jobs</h4>', 'Welcome to GigaCMS', 'visit,cms,tourism spot');";
	
	// main menu 
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."mainmenu` (
	   `id` int(11) NOT NULL AUTO_INCREMENT,
	   `menu` varchar(20) NOT NULL,
	   `menu_link` varchar(200) NOT NULL,
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."mainmenu` (`id`, `menu`, `menu_link`) VALUES
	(1, 'Home', 'index.php'),
	(2, 'Contact Us', 'contact.php');";
	
	// slideshow
	$sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."slideshow` (
	   `id` int(10) NOT NULL,
	   `title` text NOT NULL,
	   `desc` text NOT NULL,
	   `image` text NOT NULL,
	   `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."slideshow` (`id`, `title`, `desc`, `image`, `date`) VALUES
	(1, 'The sand', 'The sand on the beach and Sunset.', '1-.jpg', '".time()."'),
	(2, 'The beach', 'A beach is a landform along the coast of an ocean or sea.', '2-.jpg', '".time()."');";
	
	// slideshow color caption
	$sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."color` (
	   `color_font` varchar(50) NOT NULL,
	   `color_background` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	  $sqls[] = "
	  INSERT INTO `".$prefix."color` (`color_font`, `color_background`) VALUES
	('#fff', 'rgba(0,0,0,0.6)');";
	
	// slideshow color caption
	$sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."color_theme` (
	   `color_theme` varchar(50) NOT NULL,
	   `link_color` varchar(50) NOT NULL,
	   `body_color` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

	  $sqls[] = "
	  INSERT INTO `".$prefix."color_theme` (`color_theme`, `link_color`, `body_color`) VALUES
('#18A0E1', '#18A0E1', '#000');";
	
	// sub menu 
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."submenu` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `mainmenu_id` int(11) NOT NULL,
	  `submenu` varchar(20) NOT NULL,
	  `submenu_link` varchar(200) NOT NULL,
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	// page
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."page` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `title` text CHARACTER SET utf8 NOT NULL,
	  `content` longtext CHARACTER SET utf8 NOT NULL,
	  `description` text CHARACTER SET utf8 NOT NULL,
	  `keyword` tinytext NOT NULL,
	  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `link` text CHARACTER SET utf8 NOT NULL,
	   PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	$sqls[] = "
	  INSERT INTO `".$prefix."page` (`id`, `title`, `content`, `description`, `keyword`, `time`, `link`) VALUES
	(1, 'Hello World', '<p>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore quis et recusandae atque, quos, dolore, rem, obcaecati ratione nesciunt similique accusamus? Esse ullam laboriosam error temporibus saepe totam asperiores hic at, eius officiis expedita ex corporis iusto deleniti ratione, possimus perspiciatis sunt consequatur, unde assumenda, nisi odit facilis quis ut! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero laudantium totam sunt! Officiis quasi ipsam perspiciatis tenetur ipsum quibusdam eveniet eaque nihil dolorem doloremque nostrum fugiat optio asperiores ut non, pariatur! Culpa animi cumque corrupti laborum nulla. Tenetur, doloribus sint unde porro. Minus, ipsam iste quos totam unde vero dolore. Odio saepe minima totam quos illum, excepturi. Perferendis, tempore, non. Quidem animi enim est labore pariatur inventore beatae, et repellat eius nihil numquam quae explicabo quod dolorem earum doloribus voluptatem molestiae qui placeat tempore aperiam odit. Aperiam laudantium architecto, voluptatum dolorem pariatur consectetur, fugit repellendus, dolore placeat a soluta at.</p>\r\n<div>\r\n<div><a href=\"images/slide_1.jpg\" target=\"_blank\"><img class=\"img-responsive img-rounded\" src=\"../theme/images/slide_1.jpg\" border=\"0\" width=\"1170\" height=\"780\"></a></div>\r\n<div><a href=\"images/slide_2.jpg\" target=\"_blank\"><img class=\"img-responsive img-rounded\" src=\"../theme/images/slide_1.jpg\" border=\"0\" width=\"1170\" height=\"780\"></a></div>\r\n</div>\r\n<div>&nbsp;</div>\r\n<div>\r\n<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore accusantium, totam earum amet dolorum ut fuga, tempora veniam numquam dicta.Lorem ipsum dolor sit.Nostrum eveniet animi sint.Dolore eligendi, porro ipsam.Repudiandae voluptate dolorem voluptas.Voluptate cupiditate, est laborum?</div>\r\n<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore accusantium, totam earum amet dolorum ut fuga, tempora veniam numquam dicta.Lorem ipsum dolor sit amet, consectetur.Architecto eius aut culpa nihil quibusdam!Quasi sit, error vitae unde ipsa.Nobis voluptas, explicabo reiciendis voluptatum cum.Dicta magnam dignissimos, facilis? Cumque, repellendus.Sapiente expedita repellendus debitis culpa modi!Aliquid cupiditate ad, fugit qui quo.</div>\r\n</div>', 'Hello World', 'hello world,my web', ".time().", 'hellow-world.html');";
  
	
	// footer 
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."footer_settings` (
	  `id` int(11) NOT NULL,
	  `title` text CHARACTER SET utf8 NOT NULL,
	  `about_company` text CHARACTER SET utf8 NOT NULL,
	  `facebook` text NOT NULL,
	  `twitter` text NOT NULL,
	  `instagram` text NOT NULL,
	  `linkedin` text NOT NULL,
	  `youtube` text NOT NULL,
	  `menu_footer_1` text NOT NULL,
	  `menu_footer_2` text NOT NULL,
	  `menu_footer_3` text NOT NULL,
	  `copyright` text NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."footer_settings` (`id`, `title`, `about_company`, `facebook`, `twitter`, `instagram`, `linkedin`, `youtube`, `menu_footer_1`, `menu_footer_2`, `menu_footer_3`, `copyright`) VALUES
	(1, 'Footer', '<h2 class=\"fh5co-footer-logo\">Booster</h2>\n<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>', '', '', '', '', '', '<h4 class=\"fh5co-footer-lead \">Company</h4><ul><li><a href=\"#\">About</a></li><li><a href=\"#\">Contact</a></li><li><a href=\"#\">News</a></li> 				<li><a href=\"#\">Support</a></li><li><a href=\"#\">Career</a></li></ul>', '<h4 class=\"fh5co-footer-lead\">Features</h4><ul class=\"fh5co-list-check\"> 	<li><a href=\"#\">Lorem ipsum dolor.</a></li><li><a href=\"#\">Ipsum mollitia dolore.</a></li><li><a href=\"#\">Eius similique in.</a></li><li><a href=\"#\">Aspernatur similique nesciunt.</a></li><li><a href=\"#\">Laboriosam ad commodi.</a></li></ul>', '<h4 class=\"fh5co-footer-lead \">Products</h4><ul class=\"fh5co-list-check\"><li><a href=\"#\">Lorem ipsum dolor.</a></li><li><a href=\"#\">Ipsum mollitia dolore.</a></li><li><a href=\"#\">Eius similique in.</a></li><li><a href=\"#\">Aspernatur similique nesciunt.</a></li><li><a href=\"#\">Laboriosam ad commodi.</a></li></ul>', '<i class=\"fa fa-copyright\" aria-hidden=\"true\"></i> GigaCMS - with SEO, Design by abed putra');";

	// seo 
	  $sqls[] = "
	  CREATE TABLE IF NOT EXISTS `".$prefix."seo` (
	  `id` int(11) NOT NULL,
	  `google_webmaster` text CHARACTER SET utf8 NOT NULL,
	  `bing_webmaster` text CHARACTER SET utf8 NOT NULL,
	  `alexa` text CHARACTER SET utf8 NOT NULL,
	  `google_analytic` text CHARACTER SET utf32 NOT NULL,
	  `revisit_after` text CHARACTER SET utf8 NOT NULL,
	  `robots` text CHARACTER SET utf8 NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	  $sqls[] = "
	  INSERT INTO `".$prefix."seo` (`id`, `google_webmaster`, `bing_webmaster`, `alexa`, `google_analytic`, `revisit_after`, `robots`) VALUES
	(1, 'Google Webmaster', 'Bing Webmaster', 'Alexa', 'Google Analytic', '3 days', 'noindex');";
	

  foreach($sqls as $sql)
    if(!isset($page->error) && (!$db->query("?p",$sql)))
      $page->error = "There was a problem while executing <code>$sql</code>";



  if(!isset($page->error)) {
    $page->success ="<p style='font-size: 20px;text-align: center;text-transform: capitalize;'>The installation was successful ! <br />Congratulation and thanks use it  we hope you enjoy! Have fun ! </p><br/><br/>
	<legend style='text-align: center;'>Info Your Admin</legend>
    <h4 style='text-align: center;color: rgb(219, 94, 94);'>User: $username  <br/>Pass: <i>Your Password</i> <br/>Email: $email</h4>
    <br/><br/>

    <a class='btn btn-success' href='./index.php' style='margin: 0 auto; display: block; width:20%;'>Start exploring the Web</a>";
  }

}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="install new website">
        <meta name="viewport" content="width=device-width">
		
		<title>Installer</title>

        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
		
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]--> 

        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <nav class="navbar navbar-default">
		<div class="container">
		  <div class="container-fluid">		  
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                    <a class="navbar-brand" href="?">Welcome to Installer!</a>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</nav>

<div class="container">
        

<?php

if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success)) {
  $options->success($page->success);
  exit;
}

?>

    <div class='span3 hidden-phone'></div>



<form class="form-horizontal" action="?" method="post">
<fieldset>

    <legend style="text-align:center">Install Form</legend>
	<div class="col-md-6 col-md-offset-3">


    <div class="form-group">
      <label class="col-sm-3 control-label" for="sitename">Site Name</label>
      <div class="col-sm-9">
        <input id="sitename" name="sitename" type="text" value="Demo Site" class="form-control" required>
        <p class="text-info">The name of the site.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="siteurl">Site Url</label>
      <div class="col-sm-9">
        <input id="siteurl" name="siteurl" type="text" value="http://<?php echo $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);?>" class="form-control" required>
        <p class="text-info">The url of your site.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="dbhost">Database Host</label>
      <div class="col-sm-9">
        <input id="dbhost" name="dbhost" type="text" value="localhost" class="form-control" required>
		<p class="text-info">Name Your Database Host.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="dbuser">Database Username</label>
      <div class="col-sm-9">
        <input id="dbuser" name="dbuser" type="text" value="root" class="form-control" required>
		<p class="text-info">Name Your Database User.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="dbpass">Database Password</label>
      <div class="col-sm-9">
        <input id="dbpass" name="dbpass" type="password" value="" class="form-control">
		<p class="text-info">Password Your Database.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="dbname">Database Name</label>
      <div class="col-sm-9">
        <input id="dbname" name="dbname" type="text" value="" class="form-control" required>
		<p class="text-info">Name Your Database.</p>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" for="tbprefix">Tables Prefix</label>
      <div class="col-sm-9">
        <input id="tbprefix" name="tbprefix" type="text" value="mls_" class="form-control" required>
		<p class="text-info">Name Your Tables Prefix.</p>
      </div>
    </div>
	<br>
	<br>
	<br>
	</div>
	
	<legend style="text-align:center">Admin Information</legend>
	<div class="col-md-6 col-md-offset-3">
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="dbpass">User Name</label>
      <div class="col-sm-9">
        <input id="username" name="username" type="text" value="" class="form-control" required>
		<p class="text-info">User Name.</p>
      </div>
    </div>
	
	<div class="form-group">
      <label class="col-sm-3 control-label" for="dbpass">Password</label>
      <div class="col-sm-9">
        <input id="password" name="password" type="password" value="" class="form-control" required>
		<p class="text-info">Password User.</p>
      </div>
    </div>
	<div class="form-group">
      <label class="col-sm-3 control-label" for="dbpass">Confirm Password</label>
      <div class="col-sm-9">
        <input id="confirm_password" type="password" value="" class="form-control" required>
		<p class="text-info">Confirm Password.</p>
      </div>
    </div>
	
	
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

	<div class="form-group">
      <label class="col-sm-3 control-label" for="dbpass">Email</label>
      <div class="col-sm-9">
        <input id="Email" name="email" type="text" placeholder="example@example.com" class="form-control" required>
		<p class="text-info">Email User.</p>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-9">
        <input type='submit' value='Install' class='btn btn-success'>
      </div>
    </div>
	</div>
</fieldset>
</form>

</div> <!-- /container -->
<hr>
<div class="container">
	<div class="pull-right" style="padding-bottom:20px">
		GigaCMS, Copyright @abedputra 2016
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $set->url;?>/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script src="<?php echo $set->url;?>/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>