<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['facility'])) {
  // check to ensure this user has auths to manage this facility.
  if (!$user->isAdmin() || (isset($_REQUEST['id']) && intval($_REQUEST['id']) != $user->facility['id'])) {
    redirect_to(array('location' => 'facility.php', 'status' => "You don't have permissions to modify this facility."));
  }
  if (!isset($_POST['facility']['name'])) {
    redirect_to(array('location' => 'facility.php'.(isset($_REQUEST['id']) ? "?action=edit&id=".intval($_REQUEST['id']) : "?action=new"), 'status' => "You don't have permissions to modify this facility.", 'class' => 'error'));
  }
  try {
    $facility = new Facility($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'facility.php'.((isset($_REQUEST['id'])) ? "?action=show&id=".intval($_REQUEST['id']) : ""), 'status' => 'This facility does not exist.', 'class' => 'error'));
  }

  $updateFacility = $facility->create_or_update($_POST['facility']);
  if ($updateFacility) {
    redirect_to(array('location' => 'facility.php?action=show&id='.intval($updateFacility), 'status' => "Successfully ".(isset($_REQUEST['id']) ? "updated" : "created")." this facility.", 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'facility.php'.(isset($_REQUEST['id']) ? "?action=edit&id=".intval($_REQUEST['id']) : "?action=new"), 'status' => "An error occurred while ".(isset($_REQUEST['id']) ? "updating" : "creating")." this facility.", 'class' => 'error'));
  }
}

if (!isset($_REQUEST['id'])) {
  $_REQUEST['id'] = 0;
}

start_html($user, "UC Medicine QA", "Manage Facilities", $_REQUEST['status'], $_REQUEST['class']);
try {
  $facility = new Facility($database, intval($_REQUEST['id']));
} catch (Exception $e) {
  display_error("Error: Invalid facility ID", "Please check the facility ID and try again.");
  display_footer();
  exit;
}

switch($_REQUEST['action']) {
  case 'new':
    //ensure that user has sufficient privileges to add a facility.
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add facilities.");
      break;
    }
    $facility->displayEditForm("Add a facility");
    break;
  case 'edit':
    if (intval($_REQUEST['id']) != $user->facility['id'] || !$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You are not allowed to modify this facility.");
      break;
    }
    $facility->displayEditForm("Modify a facility");
    break;
  case 'show':
    $facility->displayProfile($user);
    break;
  default:
  case 'index':
    echo "<h1>Facilities</h1>\n";
    display_facilities($user);
    echo "<a href='facility.php?action=new'>Add a new facility</a><br />\n";
    break;
}
display_footer();
?>