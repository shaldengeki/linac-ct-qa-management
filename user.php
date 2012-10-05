<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['user'])) {
  $createUser = $database->create_or_update_user($user, $_POST['user']);
  redirect_to($createUser);
} elseif ($_REQUEST['action'] == 'delete' && isset($_REQUEST['id'])) {
  $deleteUser = $database->delete_user($user, intval($_REQUEST['id']));
  redirect_to($deleteUser);
}

start_html($user, "UC Medicine QA", "Manage Users", $_REQUEST['status'], $_REQUEST['class']);

switch($_REQUEST['action']) {
  case 'new':
    if (!$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You must be an administrator to register users.");
      break;
    }
    echo "<h1>Create a user</h1>
";
    display_user_edit_form($user);
    break;
  case 'edit':
    if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
      display_error("Error: Invalid user ID", "Please check your ID and try again.");
      break;
    }
    //ensure that user has sufficient privileges to modify this machine.
    if (intval($_REQUEST['id']) != $user->id && !$user->isAdmin()) {
      display_error("Error: Insufficient privileges", "You do not have privileges to modify this user.");
      break;
    }
    if ($user->isAdmin()) {
      $facility_id = $database->queryFirstValue("SELECT `facility_id` FROM `users` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
      if (!$facility_id) {
        display_error("Error: Invalid user ID", "Please check your ID and try again.");
        break;
      } elseif (intval($facility_id) != $user->facility['id']) {
        display_error("Error: Insufficient privileges", "You may only view your own facility's users.");
        break;
      }
    }
    echo "<h1>Modify a user</h1>
";
    display_user_edit_form($user, intval($_REQUEST['id']));
    break;
  case 'show':
    $userName = $database->queryFirstValue("SELECT `name` FROM `users` WHERE `id` = ".intval($_REQUEST['id'])." LIMIT 1");
    if (!$userName) {
      echo "This user was not found. Please select another user and try again.";
    } else {
      echo "<h1>".escape_output($userName)."</h1>
";
      display_user_profile($user, intval($_REQUEST['id']));
    }
    break;
  default:
  case 'index':
    echo "<h1>Users</h1>
";
    display_users($user);
    echo "<a href='user.php?action=new'>Add a new user</a><br />
";
    break;
}
display_footer();
?>