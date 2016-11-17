<div class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm" style="background-color:#18a0e1">
  <a class="navmenu-brand visible-md visible-lg" href="#" style="color:#fff;">Welcome to Dasboard!</a>  
  <hr>
  
	<ul class="nav navmenu-nav">		
		<?php
		// we generate a simple menu this may need to be adjusted depending on your needs
		// but it should be ok for most common items
		foreach ($page->navbar as $key => $v) {

			if ($v[0] == 'item') {
			
				echo "<li".($v[1]['class'] ? " class='".$v[1]['class']."'" : "").">
					<a href='".$v[1]['href']."'>".$v[1]['name']."</a></li>";
			
			} else if($v[0] == 'dropdown') {

				echo "<li class='dropdown".
					// extra classes 
					($v['class'] ? " ".$v['class'] : "")."'".
					// extra style
					($v['style'] ? " style='".$v['style']."'" : "").">
					
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$v['name']." <span class='caret'></span></a>
					<ul class='dropdown-menu navmenu-nav'>";
				foreach ($v[1] as $k => $v) 
					echo "<li".
						
						($v['class'] ? " class='".$v['class']."'" : "").">

						<a href='".$v['href']."'>".$v['name']."</a></li>";                                
				echo "</ul>
				</li>";
			}
		}
		?>
		<li><a href="<?php echo $set->url; ?>"><i class="fa fa-eye" aria-hidden="true"></i> View Site</a></li>
	</ul>
	<hr>
</div>
<div class="navbar navbar-default navbar-fixed-top hidden-md hidden-lg" style="background-color:#18a0e1;">
  <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu" style="background-color:#fff">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#" style="color:#fff">Welcome to Dasboard!</a>
</div>


<div class="container">