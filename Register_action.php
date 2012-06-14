<?PHP   

  // register_action.php  
  	include("dbconnect.php");
  // username and password sent from form 
	$errors = "";  
  if ($_POST['myusername']=="")  
    $errors .= "Please provide a username. <br/>";  
  if ($_POST['mypassword']=="")  
    $errors .= "Please provide a password. <br/>";  
  if ($_POST['email']=="")  
    $errors .= "Please provide an email address. <br/>";
  if ($errors == "") { 
	$myusername=$_POST['myusername']; 
	$mypassword=$_POST['mypassword'];
	$myemail=$_POST['email'];

// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myemail=stripslashes($myemail);

	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$myemail=mysql_real_escape_string($myemail);

    $sql="SELECT * FROM CT_user WHERE user_name='$myusername'";
  	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	if($count==1){
	// Register $myusername, $mypassword and redirect to file "login_success.php"
		echo "User Name Taken !"; 
     
	  // header("location:cs53001final.html");
	}
	else {
	    $sql_1="INSERT INTO CT_user VALUES('$myusername','$mypassword')";
		mysql_query($sql_1) or die(mysql_error()); 
    	
		if(!session_is_registered("myusername"))
			session_unregister("myusername");
		session_register("myusername");
		header("location:register_successful.php");

	}
  }else {
		echo $errors;
	}
    
?> 
