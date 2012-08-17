<?php
include_once("global/includes.php");
if (!$user->isAdmin($database)) {
  header("Location: main.php");
}

if (isset($_POST['backup'])) {
  // generate backup.
  $generateBackup = $database->generate_backup($user, $_POST['backup']);
  redirect_to($generateBackup['location'], $generateBackup['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Generate Backup", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'create':
    echo "<h1>Generate a Backup</h1>
";
    display_backup_form($database);
    break;

  default:
  case 'index':
    echo "<h1>Backups</h1>
";
    display_backups($database, $user);
    break;
}
display_footer();
?>