<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['equipment'])) {
  if (!$user->loggedIn() || !$user->isAdmin() || (intval($_POST['equipment']['facility_id']) != $user->facility['id'])) {
    redirect_to(array('location' => 'main.php', 'status' => 'You are not an administrator of this facility and cannot add machines to it.'));
  } elseif (!isset($_POST['equipment']['name']) || !isset($_POST['equipment']['machine_id']) || !isset($_POST['equipment']['facility_id'])) {
    redirect_to(array('location' => 'equipment.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.'));
  }
  //ensure that this facility exists.
  try {
    $facility = new Facility($database, $_POST['equipment']['facility_id']);
  } catch (Exception $e) {
    redirect_to(array('location' => 'equipment.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This facility does not exist.', 'class' => 'error'));
  }
  //ensure that this machine type exists.
  try {
    $machineType = new Machine($database, $_POST['equipment']['machine_id']);
  } catch (Exception $e) {
    redirect_to(array('location' => 'equipment.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This machine does not exist.', 'class' => 'error'));
  }
  try {
    $equipment = new Equipment($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'equipment.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This equipment does not exist.', 'class' => 'error'));
  }
  $equipmentID = $equipment->create_or_update($_POST['equipment']);
  if ($equipmentID) {
    redirect_to(array('location' => 'equipment.php?action=view&id='.intval($equipmentID), 'status' => 'Successfully '.(intval($_REQUEST['id']) == 0 ? 'created' : 'updated').' equipment.', 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'equipment.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'An error occurred while '.(intval($_REQUEST['id']) == 0 ? 'creating' : 'updating').' this equipment. Please try again.', 'class' => 'error'));
  }
} elseif ($_REQUEST['action'] == 'get_parameters' && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
  // return a js response instantiating all the parameters and values for this equipment.
  try {
    $equipment = new Equipment($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    echo json_encode(array());
    exit;
  }
  echo json_encode($equipment->parameters);
  exit;
}

start_html($user, "UC Medicine QA", "Manage Equipment", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add equipment.");
      break;
    }
    echo "<h1>Add equipment</h1>
";
    display_equipment_edit_form($user);
    break;
  case 'edit':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid equipment ID", "Please check your ID and try again.");
      break;
    }
    //ensure that user has sufficient privileges to modify this equipment.
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to modify equipment.");
      break;
    }
    $facility_id = $database->queryFirstValue("SELECT `facility_id` FROM `equipment` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$facility_id) {
      display_error("Error: Invalid facility ID", "Please check your ID and try again.");
      break;    
    } elseif (intval($facility_id) != $user->facility['id']) {
      display_error("Error: Insufficient privileges", "You may only modify your own facility's equipment.");
      break;
    }
    echo "<h1>Modify equipment</h1>
";
    display_equipment_edit_form($user, intval($_REQUEST['id']));
    break;
  case 'show':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid equipment ID", "Please check your ID and try again.");
      break;
    }
    //ensure that user has sufficient privileges to view this equipment.
    $equipmentObject = $database->queryFirstRow("SELECT * FROM `equipment` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$equipmentObject) {
      display_error("Error: Invalid equipment ID", "Please check your ID and try again.");
      break;    
    } elseif (intval($equipmentObject['facility_id']) != $user->facility['id']) {
      display_error("Error: Insufficient privileges", "You may only view your own facility's equipment.");
      break;
    }
    echo "<h1>".escape_output($equipmentObject['name'])." - History <small>(<a href='equipment.php?action=edit&id=".intval($_REQUEST['id'])."'>edit</a>)</small></h1>
";
    display_equipment_info($user, intval($_REQUEST['id']));
    break;
  default:
  case 'index':
    echo "<h1>Equipment</h1>
";
    display_equipment($user);
    echo "<a href='equipment.php?action=new'>Add new equipment</a><br />
";
    break;
}
display_footer();
?>