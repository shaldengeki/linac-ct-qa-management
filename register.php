<?php
include_once("global/includes.php");
if (!$user->isAdmin()) {
  header("Location: index.php?status=Registration is closed to non-administrator users. Please contact your facility admin.");
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])) {
  $registerUser = $user->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation'], $_POST['facility_id']);
  redirect_to($registerUser);
} else {
  start_html($database, $user, "UC Medicine QA", "", $_REQUEST['status']);
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