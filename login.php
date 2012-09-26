<?php
include_once("global/includes.php");

if (!isset($_POST['username']) || !isset($_POST['password'])) {
  redirect_to(array('location' => "index.php", 'status' => "Please enter your username and password."));
}
// username and password sent from form 
$username=$_POST['username']; 
$password=$_POST['password'];

$loginResult = $user->logIn($username, $password);
redirect_to($loginResult);
?>