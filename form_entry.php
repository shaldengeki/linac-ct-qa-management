<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['form_entry'])) {
  $createFormEntry = $database->create_or_update_form_entry($user, $_POST['form_entry']);
  redirect_to($createFormEntry['location'], $createFormEntry['status']);
} elseif ($_REQUEST['action'] == 'approve') {
  $approveFormEntry = $database->approve_form_entry($user, intval($_REQUEST['id']), 1);
  redirect_to($approveFormEntry['location'], $approveFormEntry['status']);
} elseif ($_REQUEST['action'] == 'unapprove') {
  $approveFormEntry = $database->approve_form_entry($user, intval($_REQUEST['id']), 0);
  redirect_to($approveFormEntry['location'], $approveFormEntry['status']);
}

start_html($database, $user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Submit a record</h1>
";
    display_form_entry_edit_form($database, $user, false, intval($_REQUEST['form_id']));
    break;
  case 'edit':
    echo "<h1>Modify a record</h1>
";
    display_form_entry_edit_form($database, $user, intval($_REQUEST['id']), false);
    break;
  default:
  case 'index':
    $form_name = $database->queryFirstValue("SELECT `name` FROM `forms` WHERE `id` = ".intval($_REQUEST['form_id'])." LIMIT 1");
    if (!$form_name) {
      echo "<h1>Form Entries</h1>
<p>That form ID is invalid. Please go back and try again.</p>
";
    } else {
      echo "<h1>History for: ".escape_output($form_name)."</h1>
";
      display_form_entries($database, $user, intval($_REQUEST['form_id']));
      echo "<a href='form_entry.php?action=new&form_id=".intval($_REQUEST['form_id'])."'>Submit a record</a><br />
";
    }
    break;
}
display_footer();
?>