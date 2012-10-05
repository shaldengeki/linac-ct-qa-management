<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['form_entry'])) {
  $createFormEntry = $database->create_or_update_form_entry($user, $_POST['form_entry']);
  redirect_to($createFormEntry);
} elseif ($_REQUEST['action'] == 'approve') {
  $approveFormEntry = $database->approve_form_entry($user, intval($_REQUEST['id']), 1);
  redirect_to($approveFormEntry);
} elseif ($_REQUEST['action'] == 'unapprove') {
  $approveFormEntry = $database->approve_form_entry($user, intval($_REQUEST['id']), 0);
  redirect_to($approveFormEntry);
}

start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Submit a record</h1>
";
    display_form_entry_edit_form($user, false, intval($_REQUEST['form_id']));
    break;
  case 'edit':
    //ensure that id is set.
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid entry ID", "Please check the ID and try again.");
      break;
    }
    //ensure that this user has permissions to edit this form entry.
    $facility_id = intval($database->queryFirstValue("SELECT `machines`.`facility_id` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` WHERE `form_entries`.`id` = ".intval($_REQUEST['id'])." LIMIT 1"));
    if (!$facility_id) {
      display_error("Error: Invalid entry ID", "Please check the ID and try again.");
      break;
    } elseif (intval($facility_id) != $user->facility['id']) {
      display_error("Error: Insufficient privileges", "You may only view and edit forms belonging to your facility.");
      break;
    }
    echo "<h1>QA Record</h1>
";
    display_form_entry_edit_form($user, intval($_REQUEST['id']), false);
    break;
  default:
  case 'index':
    $form_name = $database->queryFirstValue("SELECT `name` FROM `forms` WHERE `id` = ".intval($_REQUEST['form_id'])." LIMIT 1");
    if (!$form_name) {
      display_error("Error: Invalid form ID", "That form ID is invalid. Please go back and try again.");
      break;
    }
    echo "<h1>History for: ".escape_output($form_name)."</h1>
";
    display_form_entries($user, intval($_REQUEST['form_id']));
    echo "<a href='form_entry.php?action=new&form_id=".intval($_REQUEST['form_id'])."'>Submit a record</a><br />
";
    break;
}
display_footer();
?>