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
    try {
      $formEntry = new FormEntry($database, intval($_POST['form_entry']['id']));
    } catch (Exception $e) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'This form entry does not exist.', 'class' => 'error'));
    }

    // check to ensure that the user is authed to modify this form entry.
    if (intval($_POST['form_entry']['id']) == 0) {
      $formEntry->machine = array('id' => intval($_POST['form_entry']['machine_id']), 'name' => '');
      $formEntry->user = array('id' => intval($_POST['form_entry']['user_id']), 'name' => '');
    }
    if (!$formEntry->allow($user, $_REQUEST['action'])) {
      redirect_to(array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'You do not have permissions to do this.', 'class' => 'error'));
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
  if ($targetEntry->approvedOn != '') {
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

switch($_REQUEST['action']) {
  case 'print':
    //ensure that id is set.
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid entry ID", "Please check the ID and try again.");
      break;
    }
    if (intval($_REQUEST['id']) != 0) {
      $entryID = intval($_REQUEST['id']);
      //ensure that this user has permissions to edit this form entry.
      $facility_id = intval($database->queryFirstValue("SELECT `machines`.`facility_id` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` WHERE `form_entries`.`id` = ".$entryID." LIMIT 1"));
      if (!$facility_id) {
        display_error("Error: Invalid entry ID", "Please check the ID and try again.");
        break;
      } elseif (intval($facility_id) != $user->facility['id']) {
        display_error("Error: Insufficient privileges", "You may only view and edit forms belonging to your facility.");
        break;
      }
    } else {
      $entryID = false;
    }
    ob_start();
    start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);
    echo "<div class='row-fluid'>
      <div class='span12'>
        <h1>QA Record</h1>
      </div>\n</div>\n";
    display_form_entry_edit_form($user, $entryID, intval($_REQUEST['form_id']));
    display_footer();

    $html = ob_get_contents();
    ob_end_clean();

    $tmpHTMLName = "/tmp/ucmcqa-".time().rand().".html";
    $tmpHTML = file_put_contents($tmpHTMLName, $html);

    $tmpPDFName = "/tmp/ucmcqa-".time().rand().".pdf";
    chdir("/var/www/linac-ct-qa-management");
    exec("wkhtmltopdf --print-media-type --page-size A4 ".$tmpHTMLName." ".$tmpPDFName." 2>&1", $tmpPDF, $err);

    $rmTmpHTML = unlink($tmpHTMLName);

    header("Content-type: application/pdf");
    readfile($tmpPDFName);
    $rmTmpPDF = unlink($tmpPDFName);
    exit;
  case 'new':
    start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);
    echo "<div class='row-fluid'>
  <div class='span12'>
    <h1>Submit a record<a href='form_entry.php?action=print&form_id=".intval($_REQUEST['form_id'])."&id=".intval($_REQUEST['id'])."' class='btn btn-info pull-right'>Print to PDF</a></h1>
  </div>\n</div>\n";
    display_form_entry_edit_form($user, false, intval($_REQUEST['form_id']));
    break;
  case 'edit':
    start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);
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
    <h1>QA Record<a href='form_entry.php?action=print&form_id=".intval($_REQUEST['form_id'])."&id=".intval($_REQUEST['id'])."' class='btn btn-info pull-right'>Print to PDF</a></h1>
  </div>\n</div>\n";
    display_form_entry_edit_form($user, intval($_REQUEST['id']), false);
    break;
  default:
  case 'index':
    start_html($user, "UC Medicine QA", "Manage Form Entries", $_REQUEST['status'], $_REQUEST['class']);
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