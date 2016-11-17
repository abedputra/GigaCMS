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




error_reporting( error_reporting() & ~E_NOTICE ); 

if (ISSET($_POST['mysubmit'])) {
	
	if (($_FILES["img_upload"]["type"] == "image/jpeg" || $_FILES["img_upload"]["type"] == "image/pjpeg" || $_FILES["img_upload"]["type"] == "image/jpg" || $_FILES["img_upload"]["type"] == "image/pjpg" || $_FILES["img_upload"]["type"] == "image/gif" || $_FILES["img_upload"]["type"] == "image/x-png") && ($_FILES["img_upload"]["size"] < 100000000))
	{  
		$max_upload_width = 2592;
		$max_upload_height = 1944;
		  
		if(isset($_REQUEST['max_img_width']) and $_REQUEST['max_img_width']!='' and $_REQUEST['max_img_width']<=$max_upload_width){
			$max_upload_width = $_REQUEST['max_img_width'];
			
		}    
		if(isset($_REQUEST['max_img_height']) and $_REQUEST['max_img_height']!='' and $_REQUEST['max_img_height']<=$max_upload_height){
			$max_upload_height = $_REQUEST['max_img_height'];
		}	
		
		if($_FILES["img_upload"]["type"] == "image/jpeg" || $_FILES["img_upload"]["type"] == "image/pjpeg" || $_FILES["img_upload"]["type"] == "image/jpg" || $_FILES["img_upload"]["type"] == "image/pjpg"){	
			$image_source = imagecreatefromjpeg($_FILES["img_upload"]["tmp_name"]);
			
		}		
		
		if($_FILES["img_upload"]["type"] == "image/gif"){	
			$image_source = imagecreatefromgif($_FILES["img_upload"]["tmp_name"]);
			
		}	
	
		if($_FILES["img_upload"]["type"] == "image/x-png"){
			$image_source = imagecreatefrompng($_FILES["img_upload"]["tmp_name"]);
			
		}
		
		$upload_original = move_uploaded_file($_FILES["img_upload"]['tmp_name'], "../upload/gallery/image-".$_FILES["img_upload"]["name"]);
		
		if ($upload_original)
		{
		echo "Upload Successful!<br/>";
		}
		
		
		imagedestroy($image_source);		
	}
	else{
		
	}
	}	

?>
<legend>Manage Photos</legend>
	
<form class="well" name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" enctype="multipart/form-data">

	  <input name="img_upload" class="btn btn-primary" style="margin:0 auto;display:block" accept="image/png, image/jpeg, image/jpg" type="file" id="img_upload" size="40" />
	  
	  <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />	     
	  
	  <input style="display:none;" name="max_img_width" type="visible" value="" size="4">          
	  
	  <input style="display:none;" name="max_img_height" type="visible" value="" size="4">  
	  
	  <input name="tmp_name" type="hidden" value="myfile.jpg" >   	  
	<br>
	  <input type="submit" class="btn btn-primary" style="margin:0 auto;display:block;width:120px" name="mysubmit" value="Upload">
<br>
<br>
<br>
	  <div class="form-group" style="margin: 0 auto;display: block;text-align: center;">
		<label for="exampleInputName2">
		*Note<br>
		Maximum 100 MB. Accepted Formats: jpg, gif and png.
		</label>
	</div>

</form>

<br>
<br>
<hr>
<div class="row">
<?php 
$dir = "../upload/gallery";
if ($_POST['mysubmit2']) {
foreach ($_POST["filenames"] as $filename) {
echo $filename;

$newdir = "..\upload\gallery\\".$filename;
if($newdir)
unlink($newdir);
}
}	
?>

<form name="mydelete" method="post" action="<?php echo $_SERVER['PHP_SELF'] ; ?>" >		

<?php

$files1 = scandir($dir);
foreach($files1 as $file){
if(strlen($file) >=3){

$foil = $file;

if ($foil==true){

echo '
<div class="col-xs-6 col-md-3">
	<div class="thumbnail">
<img style="width:200px;height:150px;" class="img-responsive" src="../upload/gallery/'.$file.'" /><br/>

<div class="checkbox" style="margin-left: 12px;">
    <label>
      <input class="checkbox" type="checkbox" name="filenames[]" value="'.$foil.'" />Check for Delete <br>
    </label>
  </div>
  
  </div></div>';

}
}
}?>

<div class="col-md-12">
<br>
<br>
<br>
<input type="submit" style="margin:0 auto;display:block;width:200px" class="btn btn-primary" name="mysubmit2" value="Delete">
</div>
</form>
</div>
<?php include "admin-footer.php";?>
