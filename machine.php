<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['machine'])) {
  if (!$user->loggedIn() || !$user->isAdmin() || (intval($_POST['machine']['facility_id']) != $user->facility['id'])) {
    redirect_to(array('location' => 'main.php', 'status' => 'You are not an administrator of this facility and cannot add machines to it.'));
  } elseif (!isset($_POST['machine']['name']) || !isset($_POST['machine']['machine_type_id']) || !isset($_POST['machine']['facility_id'])) {
    redirect_to(array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.'));
  }
  //ensure that this facility exists.
  try {
    $facility = new Facility($database, $_POST['machine']['facility_id']);
  } catch (Exception $e) {
    redirect_to(array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This facility does not exist.', 'class' => 'error'));
  }
  //ensure that this machine type exists.
  try {
    $machineType = new MachineType($database, $_POST['machine']['machine_type_id']);
  } catch (Exception $e) {
    redirect_to(array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This machine type does not exist.', 'class' => 'error'));
  }
  try {
    $machine = new Machine($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This machine does not exist.', 'class' => 'error'));
  }
  $machineID = $machine->create_or_update($_POST['machine']);
  if ($machineID) {
    redirect_to(array('location' => 'machine.php?action=view&id='.intval($machineID), 'status' => 'Successfully '.(intval($_REQUEST['id']) == 0 ? 'created' : 'updated').' machine.', 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'An error occurred while '.(intval($_REQUEST['id']) == 0 ? 'creating' : 'updating').' this machine. Please try again.', 'class' => 'error'));
  }
} elseif ($_REQUEST['action'] == 'get_parameters' && isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
  // return a js response instantiating all the parameters and values for this machine.
  $machineParameters = $database->stdQuery("SELECT `machine_type_attributes`.`name`, `machine_parameters`.`value` FROM `machine_type_attributes` LEFT OUTER JOIN `machine_parameters` ON `machine_type_attributes`.`id` = `machine_parameters`.`machine_type_attribute_id` WHERE `machine_parameters`.`machine_id` = ".intval($_REQUEST['id']));
  $parametersOutput = array();
  while ($parameter = mysqli_fetch_assoc($machineParameters)) {
    @$value = unserialize($parameter['value']);
    if (!$value) {
      $value = $parameter['value'];
    } else {
      $value = json_encode($value);
    }
    $parametersOutput[] = $parameter['name']." = ".$value.";";
  }
  echo implode("\n", $parametersOutput);
  exit;
}

start_html($user, "UC Medicine QA", "Manage Machines", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add machines.");
      break;
    }
    echo "<h1>Add a machine</h1>
";
    display_machine_edit_form($user);
    break;
  case 'edit':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid machine ID", "Please check your ID and try again.");
      break;
    }
    //ensure that user has sufficient privileges to modify this machine.
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to modify machines.");
      break;
    }
    $facility_id = $database->queryFirstValue("SELECT `facility_id` FROM `machines` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$facility_id) {
      display_error("Error: Invalid machine ID", "Please check your ID and try again.");
      break;    
    } elseif (intval($facility_id) != $user->facility['id']) {
      display_error("Error: Insufficient privileges", "You may only modify your own facility's machines.");
      break;
    }
    echo "<h1>Modify a machine</h1>
";
    display_machine_edit_form($user, intval($_REQUEST['id']));
    break;
  case 'show':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid machine ID", "Please check your ID and try again.");
      break;
    }
    //ensure that user has sufficient privileges to view this machine.
    $machineObject = $database->queryFirstRow("SELECT * FROM `machines` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$machineObject) {
      display_error("Error: Invalid machine ID", "Please check your ID and try again.");
      break;    
    } elseif (intval($machineObject['facility_id']) != $user->facility['id']) {
      display_error("Error: Insufficient privileges", "You may only view your own facility's machines.");
      break;
    }
    echo "<h1>".escape_output($machineObject['name'])." - History <small>(<a href='machine.php?action=edit&id=".intval($_REQUEST['id'])."'>edit</a>)</small></h1>
";
    display_machine_info($user, intval($_REQUEST['id']));
    break;
  default:
  case 'index':
    echo "<h1>Machines</h1>
";
    display_machines($user);
    echo "<a href='machine.php?action=new'>Add a new machine</a><br />
";
    break;
}
display_footer();
?>