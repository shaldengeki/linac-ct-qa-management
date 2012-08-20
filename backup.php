<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  redirect_to('index.php', 'Please log in to manage backups.');
}

if (isset($_POST['backup'])) {
  // generate backup.
  $generateBackup = $database->generate_backup($user, $_POST['backup']);
  redirect_to($generateBackup['location'], $generateBackup['status']);
}

start_html($database, $user, "UCMC Radiation Oncology QA", "Generate Backup", $_REQUEST['status']);

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