<?php
include_once("global/includes.php");

$selected=$_POST['user_selection'];
// username and password sent from form 
$username=$_POST['username']; 
$password=$_POST['password'];

// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
//echo $selected;
if($selected=="user"){
	$sql="SELECT * FROM $tbl_name WHERE user_name='$username' and user_password='$password'";
	$result=$database->stdQuery($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);
	// If result matched $myusername and $mypassword, table row must be 1 row

	if($count==1){
	// Register $myusername, $mypassword and redirect to file "main.php"
	//session_start();
	$_SESSION['username']=$username;
	$_SESSION['password']=$password; 
	header("location:index.php");
	}
	else {
	echo "Wrong Username or Password";
	}
}
if($selected=="admin"){

	$sql="SELECT * FROM $tb2_name WHERE admin_name='$username' and admin_password='$password'";
	$result2=$database->stdQuery($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result2);
	// If result matched $myusername and $mypassword, table row must be 1 row

	if($count==1){
	// Register $myusername, $mypassword and redirect to file "login_success.php"
	
	$_SESSION['username']=$username;
	$_SESSION['password']=$password;  
	header("location:index.php");
	}
	else {
	echo "Wrong Username or Password";
	}
}

?>