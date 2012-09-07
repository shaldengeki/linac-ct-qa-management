<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("Location: index.php");
}
session_destroy();
if (!isset($_SESSION['id'])) {
  redirect_to(array('location' => "index.php", 'status' => "Logged out successfully."));
} else {
  redirect_to(array('location' => "main.php", 'status' => "Could not log you out."));
}

?>