<?php
/**
 * Presets class
 * generates some presets for different portions of the site.
 */
 
class presets {
  
	var $active = '';

		function GenerateNavbar() {
			global $set, $user;
			$var = array();
			
			if($user->group->type == 2)
			   $var[] = array("item",
					array("href" => $set->url."/admin/",
						"name" => "<i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i> Dashboard",
						"class" => $this->isActive("dashboard")),
						"id" => "dashboard");									if($user->group->type == 3)			   $var[] = array("item",					array("href" => $set->url."/admin/",						"name" => "<i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i> Dashboard",						"class" => $this->isActive("dashboard")),						"id" => "dashboard");
			
			if($user->group->type == 3)									$var[] = array("dropdown",					array(  array("href" => $set->url."/admin/gallery.php",								   "name" => "Gallery",								   "class" => 0),							array("href" => $set->url."/admin/upload-gallery.php",								   "name" => "Upload & Delete",								   "class" => 0),							  ),					"class" => 0,					"style" => 0,					"name" => "<i class=\"fa fa-picture-o\" aria-hidden=\"true\"></i> Gallery Media",					"id" => "gallery");								if($user->group->type == 2)			   $var[] = array("dropdown",					array(  array("href" => $set->url."/admin/gallery.php",								   "name" => "Gallery",								   "class" => 0),							array("href" => $set->url."/admin/upload-gallery.php",								   "name" => "Upload & Delete",								   "class" => 0),							  ),					"class" => 0,					"style" => 0,					"name" => "<i class=\"fa fa-picture-o\" aria-hidden=\"true\"></i> Gallery Media",					"id" => "gallery");
					
			//edit page user //
			if($user->group->type == 3) 
			$var[] = array("dropdown",					array(  array("href" => $set->url."/admin/page-admin.php",								   "name" => "Page",								   "class" => 0),							array("href" => $set->url."/admin/page-new.php",								   "name" => "Add New",								   "class" => 0),							  ),					"class" => 0,					"style" => 0,					"name" => "<i class=\"glyphicon glyphicon-file\"></i> Page Settings",					"id" => "pagesettings");

			if($user->group->type == 2)									$var[] = array("dropdown",					array(  array("href" => $set->url."/admin/page-admin.php",								   "name" => "Page",								   "class" => 0),							array("href" => $set->url."/admin/page-new.php",								   "name" => "Add New",								   "class" => 0),							  ),					"class" => 0,					"style" => 0,					"name" => "<i class=\"glyphicon glyphicon-file\"></i> Page Settings",					"id" => "pagesettings");						
			//--End-- edit page user //									if($user->group->type == 3) // we make it visible for admins only										$var[] = array("dropdown",					array(  array("href" => $set->url."/users_list.php",								   "name" => "User List",								   "class" => 0),							array("href" => $set->url."/admin/register.php",								   "name" => "New User",								   "class" => 0),								array("href" => $set->url."/admin/groups.php",								  "name" => "Groups Rule",								  "class" => 0),						  ),					"class" => 0,					"style" => 0,					"name" => "<i class=\"fa fa-users\" aria-hidden=\"true\"></i> User",					"id" => "userslist");															
			if($user->group->type == 3)
			   $var[] = array("item",
					array("href" => $set->url."/admin/seo.php?id=1",
						"name" => "<i class=\"fa fa-bar-chart\" aria-hidden=\"true\"></i> SEO Tool",
						"class" => $this->isActive("seosettings")),
					"id" => "seosettings");					if($user->group->type == 3)			   $var[] = array("item",					array("href" => $set->url."/admin/slideshow.php",						"name" => "<i class=\"glyphicon glyphicon-expand\" aria-hidden=\"true\"></i> Slideshow",						"class" => $this->isActive("slideshow")),					"id" => "slideshow");						if($user->group->type == 2)			   $var[] = array("item",					array("href" => $set->url."/admin/slideshow.php",						"name" => "<i class=\"glyphicon glyphicon-expand\" aria-hidden=\"true\"></i> Slideshow",						"class" => $this->isActive("slideshow")),					"id" => "slideshow");	
					
			if($user->group->type == 3) // we make it visible for admins only						
			$var[] = array("dropdown",
				array(  array("href" => $set->url."/admin/theme.php",
							   "name" => "Theme",
							   "class" => 0),					  
					  array("href" => $set->url."/admin/home-settings.php?id=1",
							   "name" => "Home Settings",
							   "class" => 0),	
					  array("href" => $set->url."/admin/footer-settings.php?id=1",
							   "name" => "Footer Settings",
							   "class" => 0),	
							   
				  ),
				"class" => 0,
				"style" => 0,
				"name" => "<i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> Theme Settings",
				"id" => "theme");								if($user->group->type == 3) // we make it visible for admins only									$var[] = array("dropdown",				array(  array("href" => $set->url."/admin/admin-panel.php",							   "name" => "General Settings",							   "class" => 0),					  					  array("href" => $set->url."/admin/navigation.php",							   "name" => "Navbar",							   "class" => 0),					  array("href" => $set->url."/admin/menu-add.php",							   "name" => "Add New Navbar",							   "class" => 0),							   				  ),				"class" => 0,				"style" => 0,				"name" => "<i class=\"fa fa-cogs\" aria-hidden=\"true\"></i> Settings & Navbar",				"id" => "adminpanel");				
		  // keep this always the last one
			$var[] = array("dropdown",
				array(  array("href" => $set->url."/profile.php?u=".$user->data->userid,
							   "name" => "My Profile",
							   "class" => 0),
					  array("href" => $set->url."/user.php",
							   "name" => "Account settings",
							   "class" => 0),
					  array("href" => $set->url."/privacy.php",
							   "name" => "Privacy settings",
							   "class" => 0),

					  array("href" => $set->url."/logout.php",
								 "name" => "Logout",
								 "class" => 0),
				  ),
				"class" => 0,
				"style" => 0,
				"name" => "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i> Hello, " .$user->filter->username,
				"id" => "user");

		  return $var;
		} 

	function setActive($id) {
	$this->active = $id;
	}

	function isActive($id) {
	if($id == $this->active)
	  return "active";
	return 0;
	}

}
