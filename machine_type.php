<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['machine_type'])) {
  $createMachineType = $database->create_or_update_machine_type($user, $_POST['machine_type']);
  header("Location: ".$createMachineType['location']."&status=".$createMachineType['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Manage Machine Types", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Add a machine type</h1>
";
    display_machine_type_edit_form($database);
    break;
  case 'edit':
    echo "<h1>Modify a machine type</h1>
";
    display_machine_type_edit_form($database, intval($_REQUEST['id']));
    break;
  default:
  case 'index':
    display_machine_types($database);
    echo "<a href='machine_type.php?action=new'>Add a new machine type</a><br />
";
    break;
}
display_footer();
?>