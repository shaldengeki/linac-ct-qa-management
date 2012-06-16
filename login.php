<?php
include_once("global/includes.php");

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  header("Location: index.php?status=Please enter your username and password.");
}
// username and password sent from form 
$username=$_POST['username']; 
$password=$_POST['password'];

if (!$user->logIn($database, $username, $password)) {
  header("Location: index.php?status=Could not log in with the supplied credentials.");
} else {
  header("Location: main.php?status=Successfully logged in.");
}
?>