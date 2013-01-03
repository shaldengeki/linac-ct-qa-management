<?php
include_once("./global/config.php");
include_once("./global/database.php");
include_once("./global/bcrypt.php");
include_once("./global/facility.php");
include_once("./global/machine_type.php");
include_once("./global/machine.php");
include_once("./global/machine_parameter.php");
include_once("./global/equipment.php");
include_once("./global/form_type.php");
include_once("./global/form.php");
include_once("./global/form_entry.php");
include_once("./global/form_value.php");
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
?>