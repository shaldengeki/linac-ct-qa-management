<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("Location: index.php");
}
session_destroy();
if (!isset($_SESSION['id'])) {
  header("Location: index.php?status=Logged out successfully.");
} else {
  header("Location: main.php?status=Could not log you out.");
}

?>