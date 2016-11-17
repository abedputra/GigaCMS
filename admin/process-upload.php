<?php
ini_set("display_errors",1);

include "../inc/init.php";

$page->title = "Add Slideshow";
$presets->setActive("addslideshow");

include "header.php";
include "menu-side.php";


if(isset($_POST))
{
    $Destination = '../upload/gallery';
    if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name']))
    {
        die('<div class="alert alert-warning" role="alert">Something went wrong with Upload!</div>');
    }
    $allowedExts = array("jpg", "jpeg", "gif", "png");

    $RandomNum   = rand(0, 9999999999);
    
    $ImageName      = str_replace(' ','-',strtolower($_FILES['ImageFile']['name']));
    $ImageType      = $_FILES['ImageFile']['type']; //"image/png", image/jpeg etc.

    $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
    $ImageExt = str_replace('.','',$ImageExt);
    if(!in_array($ImageExt, $allowedExts))
    {
        die('<div class="alert alert-warning" role="alert">Invalid file format only <b>"jpg", "jpeg", "gif", "png"</b> allowed.</div>');
    }
    $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);

    //Create new image name (with random number added).
    $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
    
    move_uploaded_file($_FILES['ImageFile']['tmp_name'], "$Destination/$NewImageName");
    echo '
	<form method="POST" action="insert-image.php" class="form-horizontal">		
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Image</label>
		  <div class="col-sm-9">
			<img src="../upload/gallery/'.$NewImageName.'" class="img-responsive"><input type="hidden" value="'.$NewImageName.'" name="image"/>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Title</label>
		  <div class="col-sm-9">
			<input type="text" name="title" class="form-control" required/>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-2 control-label" for="sitename">Description</label>
		  <div class="col-sm-9">
			<textarea name="desc" class="form-control" row="10" required></textarea>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-sm-offset-2 col-sm-9">
			<input class="btn btn-primary" type="submit" name="submit" value="Save" />
		  </div>
		</div>
	</form>';
}