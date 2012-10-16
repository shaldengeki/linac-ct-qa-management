<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['form_entry'])) {
  // check if this is an autosave.
  if (isset($_REQUEST['autosave']) && isset($_POST['form_entry']) && is_array($_POST['form_entry'])) {
    // save this partial form for this user.
    // if entry ID is set, then check perms and update if appropriate.
    $targetEntry = new FormEntry($database, intval($_REQUEST['id']));
    if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {/*
      // check to see if this user has update permissions to this form entry.
      if ($targetEntry->user['id'] != $user->id && !$user->isPhysicist() && !$user->isAdmin()) {
        echo "0";
        exit;
      }
      try {
        $targetMachine = new Machine($database, intval($targetEntry->machine['id']));
      } catch (Exception $e) {
        echo "0";
        exit;
      }
      if (intval($targetMachine->facility['id']) != $user->facility['id']) {
        echo "0";
        exit;
      }
      // update this form entry.
      $finalStatus = $targetEntry->create_or_update($_POST['form_entry']);
    */} else {
      // otherwise, simply create or update a form entry autosave for this user.
      $finalStatus = $targetEntry->create_or_update_autosave($user, intval($_REQUEST['form_id']), $_POST['form_entry']);
    }
    echo intval($finalStatus);
    exit;
  } else {
    // regular ol' POST.
    // check if everything required is present.
    if (!isset($_POST['form_entry']['machine_id']) || !isset($_POST['form_entry']['form_id']) || !isset($_POST['form_entry']['created_at']) || intval($_POST['form_entry']['machine_id']) == 0 || intval($_POST['form_entry']['form_id']) == 0 || intval($_POST['form_entry']['created_at']) == 0) {
      redirect_to(array('location' => 'form_entry.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'Please specify a machine ID, form ID, and recording time and try again.'));
    }
    // check if this facility exists and is the user's facility.
    try {
      $machine = new Machine($database, intval($_POST['form_entry']['machine_id']));
      $facility = new Facility($database, intval($machine->facility['id']));
    } catch (Exception $e) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'This machine or facility does not exist.', 'class' => 'error'));
    }
    if ($facility->id != $user->facility['id']) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'This machine does not belong to your facility.', 'class' => 'error'));
    }
    try {
      $formEntry = new FormEntry($database, intval($_POST['form_entry']['id']));
    } catch (Exception $e) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'This form entry does not exist.', 'class' => 'error'));
    }

    // check to ensure that this user is allowed to modify this form entry.
    if ($formEntry->id != 0) {
      if (!$formEntry->user['id'] || ($user->id != $formEntry->user['id'] && !$user->isPhysicist() && !$user->isAdmin())) {
        redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => "You don't have permissions to update that entry.", 'class' => 'error'));
      }
      if ($formEntry->approvedOn != '') {
        redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => "This entry has already been approved and must be un-approved to make changes."));
      }
    }
    try {
      $targetUser = new User($database, intval($_POST['form_entry']['user_id']));
    } catch (Exception $e) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => "The provided user who performed the QA does not exist.", 'class' => 'error'));      
    }
    if (($targetUser->id != $user->id && !$user->isAdmin()) || $targetUser->facility['id'] != $user->facility['id']) {
      redirect_to(array('location' => 'form_entry.php?action=edit&id='.intval($formEntry->id), 'status' => "You aren't allowed to assign this form entry to that user."));
    }

    $createFormEntry = $formEntry->create_or_update($_POST['form_entry']);

    // clear autosave entries for this user.
    $targetForm = new Form($database, intval($_POST['form_entry']['form_id']));
    $targetForm->clearAutosaveEntries($user);
    redirect_to($createFormEntry);
  }
} elseif ($_REQUEST['action'] == 'approve' || $_REQUEST['action'] == 'unapprove') {
  if ($_REQUEST['action'] == 'approve') {
    $approvalVal = 1;
  } else {
    $approvalVal = 0;
  }
  $formEntry = new FormEntry($database, intval($_REQUEST['id']));
  if (!$formEntry->user['id'] || ($user->id != $formEntry->user['id'] && !$user->isPhysicist() && !$user->isAdmin())) {
    redirect_to(array('location' => 'form_entry.php?action=edit&id='.intval($formEntry->id), 'status' => "You don't have permissions to update that entry.", 'class' => 'error'));
  }
  if ($formEntry->setApproval($user, $approvalVal)) {
    redirect_to(array('location' => 'form_entry.php?action=index&form_id='.intval($formEntry->form['id']), 'status' => "Successfully ".$_REQUEST['action']."d entry.", 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'form_entry.php?action=edit&id='.intval($formEntry->id), 'status' => "An error occurred while un/approving this entry.", 'class' => 'error'));
  }
} elseif ($_REQUEST['action'] == 'delete' && isset($_REQUEST['id'])) {
  // check to see if this user has perms to delete.
  try {
    $targetEntry = new FormEntry($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    echo "0";
    exit;
  }
  if ($targetEntry->user['id'] != $user->id && !$user->isPhysicist() && !$user->isAdmin()) {
    echo "0";
    exit;
  }
  try {
    $targetMachine = new Machine($database, intval($targetEntry->machine['id']));
  } catch (Exception $e) {
    echo "0";
    exit;
  }
  if (intval($targetMachine->facility['id']) != $user->facility['id']) {
    echo "0";
    exit;
  }
  // otherwise, delete this entry.
  $deleteEntry = $targetEntry->delete();
  if ($deleteEntry) {
    echo "1";
    exit;
  } else {
    echo "0";
    exit;
  }
}

start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<div class='row-fluid'>
  <div class='span12'>
    <h1>Submit a record</h1>
  </div>\n</div>\n";
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
    echo "<div class='row-fluid'>
  <div class='span12'>
    <h1>QA Record</h1>
  </div>\n</div>\n";
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