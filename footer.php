<?php

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

	// get results from database
	$result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."footer_settings` WHERE `id`='1'") 
		or die(mysqli_error());  
		
	// display data in table
	
	// loop through results of database query, displaying them in the table
	while($row = mysqli_fetch_array( $result )) {
 
?>
<footer id="fh5co-footer">
		
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class="fh5co-footer-widget">
						<?php echo $row['about_company']; ?>
					</div>
					<div class="fh5co-footer-widget">
						<ul class="fh5co-social">
							<li><a href="<?php echo $row['facebook']; ?>"><i class="icon-facebook color-social"></i></a></li>
							<li><a href="<?php echo $row['twitter']; ?>"><i class="icon-twitter color-social"></i></a></li>
							<li><a href="<?php echo $row['instagram']; ?>"><i class="icon-instagram color-social"></i></a></li>
							<li><a href="<?php echo $row['linkedin']; ?>"><i class="icon-linkedin color-social"></i></a></li>
							<li><a href="<?php echo $row['youtube']; ?>"><i class="icon-youtube color-social"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="col-md-2 col-sm-6">
					<div class="fh5co-footer-widget top-level">
						<?php echo $row['menu_footer_1']; ?>
					</div>
				</div>
				
				<div class="visible-sm-block clearfix"></div>

				<div class="col-md-2 col-sm-6">
					<div class="fh5co-footer-widget top-level">
						<?php echo $row['menu_footer_2']; ?>
					</div>
				</div>
				<div class="col-md-2 col-sm-6">
					<div class="fh5co-footer-widget top-level">
						<?php echo $row['menu_footer_3']; ?>
					</div>
				</div>
			</div>

			<div class="row fh5co-row-padded fh5co-copyright">
				<div class="col-md-5">
					<p><small><?php echo $row['copyright']; ?></small></p>
				</div>
			</div>
		</div>

	</footer>
<?php
}
?>
<!-- jQuery Easing -->
<script src="<?php echo $set->url;?>/theme/js/jquery.easing.1.3.js"></script>
<!-- Owl carousel -->
<script src="<?php echo $set->url;?>/theme/js/owl.carousel.min.js"></script>
<!-- Waypoints -->
<script src="<?php echo $set->url;?>/theme/js/jquery.waypoints.min.js"></script>
<!-- Magnific Popup -->
<script src="<?php echo $set->url;?>/theme/js/jquery.magnific-popup.min.js"></script>
<!-- Main JS -->
<script src="<?php echo $set->url;?>/theme/js/main.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="<?php echo $set->url;?>/js/jquery.min.js"></script>
<script src="<?php echo $set->url;?>/js/jquery-1.10.2.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo $set->url;?>/js/jquery-1.11.3.min.js"><\/script>')</script>
<script src="<?php echo $set->url;?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Validate Plugin -->
<script src="<?php echo $set->url;?>/js/vendor/jquery.validate.min.js"></script>
<script src="<?php echo $set->url;?>/js/main.js"></script>
</body>
</html>