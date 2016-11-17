<?php
include "../inc/init.php";

if(!$user->isModerator()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Gallery";
$presets->setActive("gallery");

include "header.php";
include "menu-side.php";
?>
<script type="text/javascript">
Shadowbox.init();
</script>

<legend>Gallery Image</legend>
<div class="row">
											
<?php
		  
$files = glob("../upload/gallery/*.*");

for ($i=0; $i<count($files); $i++)
{
	$num = $files[$i];

	echo '<div class="col-xs-6 col-md-3">
	<div class="thumbnail">
			<a href="'.$num.'" rel="shadowbox"><img src="'.$num.'" class="img-responsive" style="width:200px;height:150px;"> </a>
			<br>
			<div class="caption">
			<p><input type="text" class="form-control" value="'. str_replace("..","$set->url","$num").' "></p>
			</div>
			
			</div>
			</div>';
}
?>	  
</div>		

<?php
include "admin-footer.php";
?>