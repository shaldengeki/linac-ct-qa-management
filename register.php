<?php
include_once("global/includes.php");
if ($user->loggedIn($database)) {
  header("Location: main.php");
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {
  $register_user = $user->register($database, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation']);
  header("Location: ".$register_user['location']."?status=".$register_user['status']);
} else {
  start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<!--<h1>Linac And CT Management</h1>
<ul>
<li><a href="#">LINAC</a></li>
<li><a href="CT_Br.php">CT Brilliance</a></li>
<li><a href="CT_Ac.php">CT AcQSim</a></li>
<li><a href="working_history.php">HISTORY RECORD</a></li>
<li><a href="#">HELP</a></li>
<li><a href="#">Contact us</a></li>
<li><a href="index.php">HOME</a></li>
</ul>-->
<div class="row">
  <div class="span4">&nbsp;</div>
  <div class="span4">
<?php
  display_register_form("register.php");
?>
  </div>
  <div class="span4">&nbsp;</div>
</div>
<?php
  display_footer();
}
?>