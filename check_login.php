<?php
session_start();
?>
<?php
$host="cspp53001.cs.uchicago.edu"; // Host name 
$hostusername="xiaobing"; // Mysql username 
$password="123"; // Mysql password 
$db_name="xiaobingDB"; // Database name 
$tbl_name="CT_user"; // Table name
$tb2_name="CT_admin";// Table Name

// Connect to server and select databse.
mysql_connect("$host", "$hostusername", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");
//echo "what's up!";

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
	$result=mysql_query($sql);

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
	$result2=mysql_query($sql);

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