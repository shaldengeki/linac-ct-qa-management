<?php
include_once("global/includes.php");

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  redirect_to("index.php", "Please enter your username and password.");
}
// username and password sent from form 
$username=$_POST['username']; 
$password=$_POST['password'];

if (!$user->logIn($database, $username, $password)) {
  redirect_to("index.php", "Could not log in with the supplied credentials.");
} else {
  redirect_to("main.php", "Successfully logged in.");
}
?>