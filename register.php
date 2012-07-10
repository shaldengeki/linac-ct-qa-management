<?php
include_once("global/includes.php");
if (!$user->isAdmin($database)) {
  header("Location: index.php?status=Registration is closed to non-administrator users. Please contact your facility admin.");
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {
  $register_user = $user->register($database, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation'], $_POST['facility_id']);
  header("Location: ".$register_user['location']."?status=".$register_user['status']);
} else {
  start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<div class="row">
  <div class="span4">&nbsp;</div>
  <div class="span4">
<?php
  display_register_form($database, "register.php");
?>
  </div>
  <div class="span4">&nbsp;</div>
</div>
<?php
  display_footer();
}
?>