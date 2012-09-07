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

switch($_REQUEST['action']) {
  case 'download':
    //download a specific backup.
    if (!isset($_REQUEST['id']) || intval($_REQUEST['id']) == 0) {
      redirect_to('backup.php?action=index', 'Please specify a valid backup ID.');
    }
    //fetch this backup entry.
    $backup_path = $database->queryFirstValue("SELECT `path` FROM `backups` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$backup_path) {
      redirect_to('backup.php?action=index', 'Please specify a valid backup ID.');
    }
    
    //otherwise, start piping this file to the user.
    stream_large_file($backup_path, 'application/x-gtar', 1024*1024, False);
    break;
  case 'create':
    start_html($database, $user, "UC Medicine QA", "Generate Backup", $_REQUEST['status']);
    echo "<h1>Generate a Backup</h1>
";
    display_backup_form($database);
    display_footer();
    break;

  default:
  case 'index':
    start_html($database, $user, "UC Medicine QA", "Generate Backup", $_REQUEST['status']);
    echo "<h1>Backups</h1>
";
    display_backups($database, $user);
    display_footer();
    break;
}
?>