<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['machine_type'])) {
  $createMachineType = $database->create_or_update_machine_type($user, $_POST['machine_type']);
  redirect_to($createMachineType);
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