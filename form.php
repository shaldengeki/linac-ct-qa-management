<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['form'])) {
  if (!isset($_POST['form']['name']) || !isset($_POST['form']['description']) || !isset($_POST['form']['machine_type_id'])) {
    redirect_to(array('location' => 'form.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.'));
  }
  try {
    $form = new Form($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'form.php'.((isset($_REQUEST['id'])) ? "?action=show&id=".intval($_REQUEST['id']) : ""), 'status' => 'This form does not exist.', 'class' => 'error'));
  }
  if (!$form->allow($user, '')) {
    redirect_to(array('location' => 'form.php'.((isset($_REQUEST['id'])) ? "?action=show&id=".intval($_REQUEST['id']) : ""), 'status' => 'You are not authorized to create or update forms.', 'class' => 'error'));
  }
  $formID = $form->create_or_update($_POST['form']);
  if ($formID) {
    redirect_to(array('location' => 'form.php?action=view&id='.intval($formID), 'status' => 'Successfully '.(intval($_REQUEST['id']) == 0 ? 'created' : 'updated').' form.', 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'form.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'An error occurred while '.(intval($_REQUEST['id']) == 0 ? 'creating' : 'updating').' this form. Please try again.', 'class' => 'error'));
  }
}

start_html($user, "UC Medicine QA", "Manage Forms", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to create forms.");
      break;
    }
    echo "<h1>Create a form</h1>
";
    display_form_edit_form($user);
    break;
  case 'edit':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to modify forms.");
      break;
    }
    echo "<h1>Modify a form</h1>
";
    display_form_edit_form($user, intval($_REQUEST['id']));
    break;
  case 'show':
    $formTitle = $database->queryFirstValue("SELECT `name` FROM `forms` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$formTitle) {
      echo "This form was not found. Please select another form and try again.";
    } else {
      echo "<h1>".escape_output($formTitle)." - History</h1>
";
      display_form_history($user, intval($_REQUEST['id']));
    }
    break;
  default:
  case 'index':
    echo "<h1>Forms</h1>
";
    display_forms($user);
    echo "<a href='form.php?action=new'>Add a new form</a><br />
";
    break;
}
display_footer();
?>