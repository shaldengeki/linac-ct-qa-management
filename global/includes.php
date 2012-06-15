<?php
include_once("database.php");
include_once("display.php");
include_once("user.php");
include_once("config.php");

$database = new DbConn(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
session_start();
?>