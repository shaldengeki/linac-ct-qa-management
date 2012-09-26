<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['form'])) {
  $createForm = $database->create_or_update_form($user, $_POST['form']);
  redirect_to($createForm);
}

start_html($database, $user, "UC Medicine QA", "Manage Forms", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to create forms.");
      break;
    }
    echo "<h1>Create a form</h1>
";
    display_form_edit_form($database, $user);
    break;
  case 'edit':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to modify forms.");
      break;
    }
    echo "<h1>Modify a form</h1>
";
    display_form_edit_form($database, $user, intval($_REQUEST['id']));
    break;
  case 'show':
    $formTitle = $database->queryFirstValue("SELECT `name` FROM `forms` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$formTitle) {
      echo "This form was not found. Please select another form and try again.";
    } else {
      echo "<h1>".escape_output($formTitle)." - History</h1>
";
      display_form_history($database, $user, intval($_REQUEST['id']));
    }
    break;
  default:
  case 'index':
    echo "<h1>Forms</h1>
";
    display_forms($database, $user);
    echo "<a href='form.php?action=new'>Add a new form</a><br />
";
    break;
}
display_footer();
?>