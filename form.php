<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['form'])) {
  $createForm = $database->create_or_update_form($user, $_POST['form']);
  redirect_to($createForm['location'], $createForm['status']);
}

start_html($user, $database, "UCMC Radiation Oncology QA", "Manage Forms", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Create a form</h1>
";
    display_form_edit_form($database, $user);
    break;
  case 'edit':
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
    display_forms($database);
    echo "<a href='form.php?action=new'>Add a new form</a><br />
";
    break;
}
display_footer();
?>