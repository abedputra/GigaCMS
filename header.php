<?php
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
	
	$query  = "select * from `".MLS_PREFIX."slideshow` order by id desc limit 6";
	$res    = mysqli_query($conn,$query);
	$count  = mysqli_num_rows($res);
	$slides='';
	$Indicators='';
	$counter=0;

    while($row= mysqli_fetch_array ($res))
    {

        $title = $row['title'];
        $desc = $row['desc'];
        $image = $row['image'];
        if($counter == 0)
        {
            $Indicators .='<li data-target="#carousel-example-generic" data-slide-to="'.$counter.'" class="active"></li>';
            $slides .= '<div class="item active">
            <img src="upload/gallery/'.$image.'" alt="'.$title.'" />
            <div class="carousel-caption">
              <h3>'.$title.'</h3>
              <p>'.$desc.'.</p>         
            </div>
          </div>';

        }
        else
        {
            $Indicators .='<li data-target="#carousel-example-generic" data-slide-to="'.$counter.'"></li>';
            $slides .= '<div class="item">
            <img src="upload/gallery/'.$image.'" alt="'.$title.'"/>
            <div class="carousel-caption">
              <h3>'.$title.'</h3>
              <p>'.$desc.'</p>         
            </div>
          </div>';
        }
        $counter++;
    }
	
$query  = "select * from `".MLS_PREFIX."color`";
$res    = mysqli_query($conn,$query);
$count  = mysqli_num_rows($res);

while($row=mysqli_fetch_array($res))
    {
		$color  = $row['color_font'];
		$color_background  = $row['color_background'];
	}

$query  = "select * from `".MLS_PREFIX."color_theme`";
$res    = mysqli_query($conn,$query);
$count  = mysqli_num_rows($res);

while($row=mysqli_fetch_array($res))
    {
		$color_theme  = $row['color_theme'];
		$link_color = $row['link_color'];
		$body_color = $row['body_color'];
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
	<?php
	}		
	?>	
	
	<!-- include summernote css/js-->
	<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
	
	<!-- Google Webfonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
	<!-- favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
	<link rel="manifest" href="favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="theme/css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="theme/css/icomoon.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="theme/css/owl.carousel.min.css">
	<link rel="stylesheet" href="theme/css/owl.theme.default.min.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="theme/css/magnific-popup.css">
	<!-- Theme Style -->
	<link rel="stylesheet" href="theme/css/style.css">
	<!-- Modernizr JS -->
	<script src="theme/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="theme/js/respond.min.js"></script>
	<![endif]-->
	
	
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $set->url; ?>/bootstrap/css/style-front.css">
	<style type="text/css">
		img {border-width: 0}
			* {font-family:'Lucida Grande', sans-serif;}

		.carousel-caption {
			background-color: <?php echo $color_background;?>;
			position: absolute;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 10;
			padding: 0 0 0px 25px;
			color: <?php echo $color;?>;
			text-align: left;
		}
		@media only screen and (max-width: 480px) {
			h3 {
				font-size: 15px;
				margin-top:2px;
				margin-bottom: 2px;
			}
			p {
				font-size: 10px;
				margin-top:2px;
				margin-bottom: 2px;
			}
		}
		.fh5co-feature .fh5co-feature-icon i{
			color: <?php echo $color_theme;?>;
		}
		#fh5co-clients {
			background: <?php echo $color_theme;?>;
		}
		.color-social {
			color:<?php echo $color_theme;?>;
		}
		a {
			color:<?php echo $link_color;?>;
		}
		body {
			color:<?php echo $body;?>;
		}
	</style> 

	<!-- Javascript -->
	<script src="js/jquery.touchSwipe.min.js"></script>
	<script src="<?php echo $set->url; ?>/js/303ccf41dc.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body onload="changePagination('0','first')">		
<header id="fh5co-header" role="banner">
<nav class="navbar navbar-default" role="navigation">
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
				<a class="navbar-brand" href="<?php echo $set->url; ?>"><span><img alt="<?php echo $set->site_name; ?>" src="<?php echo $set->logo; ?>" width="25px"></span> <?php echo $set->site_name; ?></a>
			</div>
			

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<?php
					$query1 = "SELECT * FROM `".MLS_PREFIX."mainmenu` ORDER BY id ASC";
					$menu = mysqli_query ($conn, $query1);
					//if connect to menu error
					if (!$menu) {
						die(mysqli_error($conn));
					}
					while($dataMenu = mysqli_fetch_assoc($menu)){
						$menu_id = $dataMenu['id'];
						
						$query2 = "SELECT * FROM `".MLS_PREFIX."submenu` WHERE mainmenu_id='$menu_id' ORDER BY id ASC";
						$submenu = mysqli_query ($conn, $query2);
						//if connect to submenu error
						if (!$submenu) {
							die(mysqli_error($conn));
						}
						
						if(mysqli_num_rows($submenu) == 0){
							echo '<li><a href="'.$dataMenu['menu_link'].'">'.$dataMenu['menu'].'</a></li>';
						}else{
							echo '
							<li class="dropdown">
								<a href="'.$dataMenu['menu_link'].'" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown">'.$dataMenu['menu'].' <b class="caret"></b></a>
								<ul class="dropdown-menu">';
								while($dataSubmenu = mysqli_fetch_assoc($submenu)){
									echo '<li><a href="'.$dataSubmenu['submenu_link'].'">'.$dataSubmenu['submenu'].'</a></li>';
								}
							echo '
								</ul>
							</li>
							';
							
						}
					}
					
					if($user->islg()) { 
							echo'						
								<li style="background-color:#53B3E1">
								
								<a href="'.$set->url.'/admin/" style="color:#000">
								<i class="fa fa-tachometer" aria-hidden="true"></i> 
								Dasboard
								</a>
								
								</li>';
							}
					?>		
				</ul>					
				
			</div><!--/.nav-collapse -->
		</div>
	</div>
</nav>
</header>
<script type="text/javascript">
	$(document).ready(function () {
		var url = window.location;
		$('ul.nav a[href="'+ url +'"]').parent().addClass('active');
		$('ul.nav a').filter(function() {
			 return this.href == url;
		}).parent().addClass('active');
	});
</script> 
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
    $options->fError("<div style='padding-top:100px'><div class='alert alert-danger' role='alert'>Your account is not yet acctivated ! Please check your email !</div></div>");
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