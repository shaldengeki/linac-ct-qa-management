<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("Location: index.php");
}
session_destroy();
if (!isset($_SESSION['id'])) {
  redirect_to("index.php", "Logged out successfully.");
} else {
  redirect_to("main.php", "Could not log you out.");
}

?>