<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
  header("Location: index.php");
}

if (isset($_POST['user'])) {
  $createUser = $database->create_or_update_user($user, $_POST['user']);
  redirect_to($createUser['location'], $createUser['status']);
}

start_html($database, $user, "UCMC Radiation Oncology QA", "Manage Users", $_REQUEST['status']);

switch($_REQUEST['action']) {
  case 'new':
    echo "<h1>Create a user</h1>
";
    display_user_edit_form($database, $user);
    break;
  case 'edit':
    echo "<h1>Modify a user</h1>
";
    display_user_edit_form($database, $user, intval($_REQUEST['id']));
    break;
  case 'show':
    $userName = $database->queryFirstValue("SELECT `name` FROM `users` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$userName) {
      echo "This user was not found. Please select another user and try again.";
    } else {
      echo "<h1>".escape_output($userName)."</h1>
";
      display_user_profile($database, $user, intval($_REQUEST['id']));
    }
    break;
  default:
  case 'index':
    echo "<h1>Users</h1>
";
    display_users($database, $user);
    echo "<a href='user.php?action=new'>Add a new user</a><br />
";
    break;
}
display_footer();
?>