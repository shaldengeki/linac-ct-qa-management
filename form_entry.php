<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['form_entry'])) {
  $createFormEntry = $database->create_or_update_form_entry($user, $_POST['form_entry']);
  header("Location: ".$createFormEntry['location']."?status=".$createFormEntry['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Manage Form Entries", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Create a form entry</h1>
";
    display_form_entry_edit_form($database, false, intval($_REQUEST['form_id']));
    break;
  case 'edit':
    echo "<h1>Modify a form entry</h1>
";
    display_form_entry_edit_form($database, intval($_REQUEST['id']), false);
    break;
  default:
  case 'index':
    echo "<h1>Form Entries</h1>
";
    display_form_entries($database);
    echo "<a href='form_entry.php?action=new'>Add a new form entry</a><br />
";
    break;
}
display_footer();
?>