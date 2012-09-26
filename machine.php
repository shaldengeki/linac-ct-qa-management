<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['machine'])) {
  $createMachine = $database->create_or_update_machine($user, $_POST['machine']);
  redirect_to($createmachine);
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

start_html($database, $user, "UC Medicine QA", "Manage Machines", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add machines.");
      break;
    }
    echo "<h1>Add a machine</h1>
";
    display_machine_edit_form($database, $user);
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
    } elseif (intval($facility_id) != $user->facility_id) {
      display_error("Error: Insufficient privileges", "You may only modify your own facility's machines.");
      break;
    }
    echo "<h1>Modify a machine</h1>
";
    display_machine_edit_form($database, $user, intval($_REQUEST['id']));
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
    } elseif (intval($machineObject['facility_id']) != $user->facility_id) {
      display_error("Error: Insufficient privileges", "You may only view your own facility's machines.");
      break;
    }
    echo "<h1>".escape_output($machineObject['name'])." - History</h1> (<a href='machine.php?action=edit&id=".intval($_REQUEST['id'])."'>edit</a>)
";
    display_machine_info($database, $user, intval($_REQUEST['id']));
    break;
  default:
  case 'index':
    echo "<h1>Machines</h1>
";
    display_machines($database, $user);
    echo "<a href='machine.php?action=new'>Add a new machine</a><br />
";
    break;
}
display_footer();
?>