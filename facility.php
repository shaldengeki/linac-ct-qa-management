<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['facility'])) {
  $createfacility = $database->create_or_update_facility($user, $_POST['facility']);
  redirect_to($createfacility['location'], $createfacility['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Manage Facilities", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Add a facility</h1>
";
    display_facility_edit_form($database, $user);
    break;
  case 'edit':
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