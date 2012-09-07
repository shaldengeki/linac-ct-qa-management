<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['facility'])) {
  $createFacility = $database->create_or_update_facility($user, $_POST['facility']);
  redirect_to($createFacility);
}

start_html($database, $user, "UC Medicine QA", "Manage Facilities", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    //ensure that user has sufficient privileges to add a facility.
    if (!$user->isAdmin($database)) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add facilities.");
      break;
    }
    echo "<h1>Add a facility</h1>
";
    display_facility_edit_form($database, $user);
    break;
  case 'edit':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid facility ID", "Please check the facility ID and try again.");
      break;
    }
    if (intval($_REQUEST['id']) != $user->facility_id || !$user->isAdmin($database)) {
      display_error("Error: Insufficient privileges", "You are not allowed to modify this facility.");
      break;
    }
    echo "<h1>Modify a facility</h1>
";
    display_facility_edit_form($database, $user, intval($_REQUEST['id']));
    break;
  default:
  case 'index':
    echo "<h1>Facilities</h1>
";
    display_facilities($database, $user);
    echo "<a href='facility.php?action=new'>Add a new facility</a><br />
";
    break;
}
display_footer();
?>