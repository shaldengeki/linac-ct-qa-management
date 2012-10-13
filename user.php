<?php
include_once("global/includes.php");
if (!$user->loggedIn()) {
  header("Location: index.php");
}

if (isset($_POST['user'])) {
  //check to see if we have permissions to insert/update this user.
  if (!$user->loggedIn()) {
    redirect_to(array('location' => 'main.php', 'status' => 'You are not allowed to modify or create users without first logging in.', 'class' => 'error'));
  }
  //check to ensure that email and password are well-formed and valid.
  $email_regex = "/[0-9A-Za-z\\+\\-\\%\\.]+@[0-9A-Za-z\\.\\-]+\\.[A-Za-z]{2,4}/";
  if (!preg_match($email_regex, $_POST['user']['email'])) {
    redirect_to(array("location" => "user.php", "status" => "The email address you have entered is malformed. Please check it and try again."));
  }
  if ($_POST['user']['password'] != $_POST['user']['password_confirmation']) {
    redirect_to(array("location" => "user.php", "status" => "The passwords you have entered do not match. Please check them and try again."));
  }
  // ensure that this user has proper privs to modify / register users.
  if (!isset($_REQUEST['id']) && !$user->isAdmin()) {
    redirect_to(array('location' => 'user.php', 'status' => 'Only administrators are allowed to register new users. Please contact your facility administrator.', 'class' => 'error'));
  }
  if (isset($_REQUEST['id']) && intval($_REQUEST['id']) != $user->id && !$user->isAdmin()) {
    redirect_to(array('location' => 'user.php', 'status' => 'You are not allowed to modify another user.', 'class' => 'error'));
  }

  // ensure that this user is not modifying another facility's user.
  try {
    $newUser = new User($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'user.php'.((isset($_REQUEST['id'])) ? "?action=show&id=".intval($_REQUEST['id']) : ""), 'status' => 'This user does not exist.', 'class' => 'error'));
  }
  if (intval($_POST['user']['facility_id']) != $user->facility['id']) {
    redirect_to(array('location' => 'user.php', 'status' => 'You may only modify users from your own facility.', 'class' => 'error'));
  }

  // if changing userlevel, ensure that they are setting it less than their current userlevel.
  if (isset($_POST['user']['usermask']) && !$user->isAdmin() && intval(@array_sum($_POST['user']['usermask'])) >= $user->usermask) {
    redirect_to(array('location' => 'user.php', 'status' => 'You are not allowed to set userlevels beyond your current userlevel.', 'class' => 'error'));
  }
  // if changing facility, ensure that they are an administrator.
  if (isset($_POST['user']['facility_id']) && !$user->isAdmin()) {
    redirect_to(array('location' => 'user.php', 'status' => 'You are not allowed to change a user\'s facility. Please contact a facility administrator.', 'class' => 'error'));
  }

  $updateUser = $newUser->create_or_update($_POST['user']);
  if ($updateUser) {
    redirect_to(array('location' => 'user.php?action=show&id='.intval($updateUser), 'status' => "Successfully ".(isset($_REQUEST['id']) ? "updated" : "created")." this user.", 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'user.php'.(isset($_REQUEST['id']) ? "?action=edit&id=".intval($_REQUEST['id']) : "?action=new"), 'status' => "An error occurred while ".(isset($_REQUEST['id']) ? "updating" : "creating")." this user.", 'class' => 'error'));
  }
} elseif ($_REQUEST['action'] == 'delete' && isset($_REQUEST['id'])) {
  // ensure that this user is an admin.
  if (!$user->loggedIn() || !$user->isAdmin()) {
    redirect_to(array('location' => 'user.php', 'status' => 'Only facility administrators are allowed to delete users.', 'class' => 'error'));
  }
  // get this user entry.
  try {
    $targetUser = new User($database, intval($_REQUEST['id']));
  } catch (Exception $e) {
    redirect_to(array('location' => 'user.php', 'status' => 'The requested user was not found. Please try again.', 'class' => 'error'));
  }
  // ensure that this user is an admin of the facility that the requested user belongs to.
  if ($targetUser->facility['id'] != $user->facility['id']) {
    redirect_to(array('location' => 'user.php', 'status' => 'You may only delete users from your administrated facility.', 'class' => 'error'));
  }
  $deleteUser = $targetUser->delete();
  if ($deleteUser) {
    redirect_to(array('location' => 'user.php', 'status' => 'Successfully deleted user.', 'class' => 'success'));
  } else {
    redirect_to(array('location' => 'user.php', 'status' => 'An error occurred when deleting this user. Please try again.', 'class' => 'error'));
  }
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