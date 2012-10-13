<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['machine_type'])) {
  if (!$user->loggedIn() || !$user->isAdmin()) {
    redirect_to(array('location' => 'main.php', 'status' => "You don't have permissions to modify machine types.", 'class' => 'error'));
  } elseif (!isset($_POST['machine_type']['name']) || !isset($_POST['machine_type']['description'])) {
    redirect_to(array('location' => 'machine_type.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.'));
  }
  try {
    $machineType = new MachineType($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'machine_type.php'.((isset($_REQUEST['id'])) ? "?action=show&id=".intval($_REQUEST['id']) : ""), 'status' => 'This machine type does not exist.', 'class' => 'error'));
  }

  $machineTypeID = $machineType->create_or_update($_POST['machine_type']);
  if ($machineTypeID) {
    redirect_to(array('location' => 'machine_type.php?action=view&id='.intval($machineTypeID), 'status' => 'Successfully '.(intval($_REQUEST['id']) == 0 ? 'created' : 'updated').' machine type.', 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'machine_type.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'An error occurred while '.(intval($_REQUEST['id']) == 0 ? 'creating' : 'updating').' this machine type. Please try again.', 'class' => 'error'));
  }
}

start_html($user, "UC Medicine QA", "Manage Machine Types", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to add machine types.");
      break;
    }
    echo "<h1>Add a machine type</h1>\n";
    display_machine_type_edit_form($user);
    break;
  case 'edit':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to modify machine types.");
      break;
    }
    echo "<h1>Modify a machine type</h1>\n";
    display_machine_type_edit_form($user, intval($_REQUEST['id']));
    break;
  case 'show':
    $machineTypeName = $database->queryFirstValue("SELECT `name` FROM `machine_types` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$machineTypeName) {
      echo "This machine type was not found. Please select another machine type and try again.";
    } else {
      echo "<h1>".escape_output($machineTypeName)." - History <small>(<a href='machine_type.php?action=edit&id=".intval($_REQUEST['id'])."'>edit</a>)</small></h1>\n";
      display_machine_type_info($user, intval($_REQUEST['id']));
    }
    break;
  default:  
  case 'index':
    echo "<h1>Machine Types</h1>\n";
    display_machine_types($user);
    echo "<a href='machine_type.php?action=new'>Add a new machine type</a><br />\n";
    break;
}
display_footer();
?>