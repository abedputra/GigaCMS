<?php
include "inc/init.php";

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

$result_title = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."home`") 
or die(mysqli_error()); 

// loop through results of database query, displaying them in the table
		while($row = mysqli_fetch_array( $result_title )) {
		
		// echo out the contents of each row into a table
		$description = $row['description'];
		$keyword = $row['keyword'];
		
	} 



$page->title = "Welcome to ". $set->site_name;
$page->description = $description;
$page->keyword = $keyword;

$presets->setActive("home"); // we highlith the home link


include 'header.php';

// get results from database
$result = mysqli_query($conn, "SELECT * FROM `".MLS_PREFIX."home` WHERE `id`='1'") 
	or die(mysqli_error());  	

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $result )) {


?>	
	<div class="container">
	  
	  <div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
		 <?php echo $Indicators; ?>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		<?php echo $slides; ?>  
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		  <span class="sr-only">Next</span>
		</a>
	  </div>
	  <!-- Swipe -->
	  <script>
	  $(".carousel").swipe({

		  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {

			if (direction == 'left') $(this).carousel('next');
			if (direction == 'right') $(this).carousel('prev');

		  },
		  allowPageScroll:"vertical"

		});
	  </script>
	  <!-- //End Swipe -->
	</div><!-- //End Container -->


	<div id="fh5co-main">
		<!-- Features -->
		<div id="fh5co-features">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-8 col-md-offset-2">
						<?php echo $row['title_features']; ?>
					</div>
					<div class="fh5co-spacer fh5co-spacer-md"></div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 fh5co-feature-border">
						<div class="fh5co-feature">
							<div class="fh5co-feature-icon to-animate bounceIn animated">
								<i class="<?php echo $row['glyphicons_1']; ?>"></i>
							</div>
							<div class="fh5co-feature-text">
								<?php echo $row['features_content_1']; ?>
							</div>
						</div>
						<div class="fh5co-feature no-border">
							<div class="fh5co-feature-icon to-animate bounceIn animated">
								<i class="<?php echo $row['glyphicons_2']; ?>"></i>
							</div>
							<div class="fh5co-feature-text">
								<?php echo $row['features_content_2']; ?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="fh5co-feature">
							<div class="fh5co-feature-icon to-animate bounceIn animated">
								<i class="<?php echo $row['glyphicons_3']; ?>"></i>
							</div>
							<div class="fh5co-feature-text">
								<?php echo $row['features_content_3']; ?>
							</div>
						</div>
						<div class="fh5co-feature no-border">
							<div class="fh5co-feature-icon to-animate bounceIn animated">
								<i class="<?php echo $row['glyphicons_4']; ?>"></i>
							</div>
							<div class="fh5co-feature-text">
								<?php echo $row['features_content_4']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Features -->


		<div class="fh5co-spacer fh5co-spacer-lg"></div>		
		<!-- Products -->
		<div class="container" id="fh5co-products">
			<div class="row text-left">
				<div class="col-md-8">
				<?php echo $row['title_products']; ?>					
				</div>
				<div class="fh5co-spacer fh5co-spacer-md"></div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-mb30">
					<div class="fh5co-product">
						<?php echo $row['products_1']; ?>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-mb30">
					<div class="fh5co-product">
						<?php echo $row['products_2']; ?>
					</div>
				</div>
				<div class="visible-sm-block visible-xs-block clearfix"></div>
				<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-mb30">
					<div class="fh5co-product">
						<?php echo $row['products_3']; ?>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-mb30">
					<div class="fh5co-product">
						<?php echo $row['products_4']; ?>
					</div>
				</div>
				
			</div>
		</div>
		<!-- Products -->
		<div class="fh5co-spacer fh5co-spacer-lg"></div>

		<div id="fh5co-clients">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-client-logo text-center"><img src="<?php echo $row['clients_1']; ?>" class="img-responsive"></div>
					<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-client-logo text-center"><img src="<?php echo $row['clients_2']; ?>" class="img-responsive"></div>
					<div class="visible-sm-block visible-xs-block clearfix"></div>
					<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-client-logo text-center"><img src="<?php echo $row['clients_3']; ?>" class="img-responsive"></div>
					<div class="col-md-3 col-sm-6 col-xs-6 col-xxs-12 fh5co-client-logo text-center"><img src="<?php echo $row['clients_4']; ?>" class="img-responsive"></div>
				</div>
			</div>
		</div>

		<div class="fh5co-bg-section" style="background-image: url(theme/images/slide_2.jpg); background-attachment: fixed;">
			<div class="fh5co-overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="fh5co-hero-wrap">
							<div class="fh5co-hero-intro text-center">
								<?php echo $row['testimonials']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
include 'footer.php';
?>