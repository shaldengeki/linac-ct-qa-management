<?php
include_once("config.php");
include_once("database.php");
include_once("bcrypt.php");
include_once("user.php");
include_once("display.php");

$database = new DbConn(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
session_start();
if (isset($_SESSION['id'])) {
  $user = new User($_SESSION);
} else {
  $user = new User(array("id" => 0, "name" => "Guest"));
}
?>