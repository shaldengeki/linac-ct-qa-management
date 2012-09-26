<?php
include_once("./global/config.php");
include_once("./global/database.php");
include_once("./global/bcrypt.php");
include_once("./global/user.php");
include_once("./global/display.php");
include_once("./global/misc.php");

$database = new DbConn(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
session_start();
if (isset($_SESSION['id'])) {
  $user = new User($database, $_SESSION['id']);
} else {
  $user = new User($database, 0);
}
if (!isset($_REQUEST['status'])) {
  $_REQUEST['status'] = "";
}
if (!isset($_REQUEST['action'])) {
  $_REQUEST['action'] = 'index';
}

//print_r($_FILES);
//exit;
?>