<?php
include "../inc/init.php";

if(!$user->isAdmin()) {
    header("Location: $set->url/login.php");
    exit;
}


$page->title = "Admin Panel";

$presets->setActive("adminpanel");


if($_POST) {

  $data = $db->getRow("SELECT * FROM `".MLS_PREFIX."settings` LIMIT 1");
  $columns = get_object_vars($data);
  
  $sql = "UPDATE `".MLS_PREFIX."settings` SET ";
  
  foreach ($columns as $k => $v)
    if($k != 'userid') 
      $sql .= $db->parse(" ?n = ?s,", $k, $_POST[$k]);

  $sql = trim($sql, ",")." LIMIT 1";

  if($db->query(" ?p ", $sql))
    $page->success = "Settings saved !";
  else
    $page->error = "Some error camed up !";

}

// we grab the settings and we merge them into $set
$set = (object)array_merge((array)$set,(array)$db->getRow("SELECT * FROM `".MLS_PREFIX."settings` LIMIT 1"));

include "header.php";

include "menu-side.php";



// we make sure we get the leatest data
$data = $db->getRow("SELECT * FROM `".MLS_PREFIX."settings` LIMIT 1");

$columns = get_object_vars($data);



if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);




echo "
  <form class='form-horizontal' action='#' method='post'>
      <legend>General Settings</legend>";


foreach ($columns as $key => $value) {
  $safe_name = $options->html($key);
  $safe_val = $options->html($value);

  // we try to guess why type of input to show
  // if you don't like this approch you can always use the classic one
  // but i beleive this is more time saving in development and it will work better

  if(in_array($key, array("register", "email_validation", "captcha"))) // add in this array columns that you want to have enabled/disabled select menu
  echo "
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='$safe_name'>".$options->prettyPrint($safe_name)."</label>
        <div class='col-sm-9'>
          <select id='$safe_name' name='$safe_name' class='form-control'>
            <option value='1' ".($value == 1 ? "selected='1'" : "").">Enabled</option>
            <option value='0' ".($value == 0 ? "selected='1'" : "").">Disabled</option>
          </select>
        </div>
      </div>";
  else if(strpos($value, "\n") !== FALSE)
  echo "
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='$safe_name'>".$options->prettyPrint($safe_name)."</label>
        <div class='col-sm-9'>
          <textarea id='$safe_name' name='$safe_name' class='form-control'>$safe_val</textarea>
        </div>
      </div>";
  else
  echo "
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='$safe_name'>".$options->prettyPrint($safe_name)."</label>
        <div class='col-sm-9'>
          <input id='$safe_name' name='$safe_name' type='text' value='$safe_val' class='form-control'>
        </div>
      </div>";
}

echo "<div class='form-group'>
        <div class='col-sm-offset-2 col-sm-9'>
          <button class='btn btn-primary'>Save</button>
        </div>
      </div>
  </form>";

include 'admin-footer.php';
?>