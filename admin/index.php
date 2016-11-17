<?php
include "../inc/init.php";
include '../lib/pagination.class.php';

if(!$user->islg()) {
    header("Location: $set->url/login.php");
    exit;
}

$page->title = "Dashboard";

$presets->setActive("dashboard");

include "header.php";
include "menu-side.php";

echo '
<legend>Dasboard</legend>
<div class="jumbotron">';
?>

<h1 style="text-transform: capitalize;">Hello <?php echo $user->filter->username; ?>, 
<script language="JavaScript"> 
var myDate = new Date(); 
  
  
/* hour is before noon */
if ( myDate.getHours() < 12 )  
{ 
    document.write("Good Morning!"); 
} 
else  /* Hour is from noon to 5pm (actually to 5:59 pm) */
if ( myDate.getHours() >= 12 && myDate.getHours() <= 17 ) 
{ 
    document.write("Good Afternoon!"); 
} 
else  /* the hour is after 5pm, so it is between 6pm and midnight */
if ( myDate.getHours() > 17 && myDate.getHours() <= 24 ) 
{ 
    document.write("Good Evening!"); 
} 
else  /* the hour is not between 0 and 24, so something is wrong */
{ 
    document.write("I'm not sure what time it is!"); 
} 
</script> 
</h1>
<?php
echo'
<p>Welcome to '.$set->site_name.' Dasboard!<hr> <br>How are You '.$user->filter->username.'? This is Your Admin Side.</p>
</div>';
?>

<?php
include "admin-footer.php";
?>

