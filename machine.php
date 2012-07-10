<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['machine'])) {
  $createmachine = $database->create_or_update_machine($user, $_POST['machine']);
  header("Location: ".$createmachine['location']."&status=".$createmachine['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Manage Machines", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Add a machine</h1>
";
    display_machine_edit_form($database, $user);
    break;
  case 'edit':
    echo "<h1>Modify a machine</h1>
";
    display_machine_edit_form($database, $user, intval($_REQUEST['id']));
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