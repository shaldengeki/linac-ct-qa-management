<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  redirect_to('index.php', 'Please log in to plot history.');
}

switch($_REQUEST['action']) {
  case 'json':
    display_history_json($database, $user, $_REQUEST['form_id']);
    exit;
    break;
  
  default:
  case 'show':
    start_html($database, $user, "UCMC Radiation Oncology QA", "Plot History", $_REQUEST['status']);
    echo "<h1>Plot History</h1>
";
    display_history_plot($database, $user, $_REQUEST['form_id']);
    break;

  default:
}
display_footer();
?>