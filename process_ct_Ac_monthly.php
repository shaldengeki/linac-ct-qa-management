<? 
session_start();
if(!session_is_registered(username)){
header("location:login.html");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP   

  // register_action.php  
  	include("dbconnect.php");
	$myusername=$_SESSION["username"];
	echo $myusername;
    echo "\n";
  // username and password sent from form 
	$month=$_POST["month"]; 
	$year=$_POST["year"]; 
//	$date=$_POST["date"]; 
	//$physicist=$_POST["physicist"];
	$cs1=(float)$_POST["cs1"];
	$cs2=(float)$_POST["cs2"];
	$cs3=(float)$_POST["cs3"];
	$cs4=(float)$_POST["cs4"];
	$cs5=(float)$_POST["cs5"];

	$n1=(float)$_POST["n1"];
	$n2=(float)$_POST["n2"];
	$n3=(float)$_POST["n3"];
	$n4=(float)$_POST["n4"];
	$n5=(float)$_POST["n5"];

	$lp1=(float)$_POST["lp1"];
	$lp2=(float)$_POST["lp2"];
	$lp3=(float)$_POST["lp3"];
	$lcd1=$_POST["lcd1"];
	$ti1=$_POST["ti1"];
	$rd1=$_POST["rd1"];
	$spa1=(float)$_POST["spa1"];
	$ll1=$_POST["ll1"];
	$hcr1=(float)$_POST["hcr1"];
	$st1=$_POST["st1"];
	$fu1=(float)$_POST["fu1"];
	$fu2=(float)$_POST["fu2"];
	$fu3=(float)$_POST["fu3"];
	$fu4=(float)$_POST["fu4"];
	$fu5=(float)$_POST["fu5"];
	$n1=(float)$_POST["n1"];
	$n2=(float)$_POST["n2"];
	$n3=(float)$_POST["n3"];
	$n4=(float)$_POST["n4"];
	$n5=(float)$_POST["n5"];
	

// To protect MySQL injection (more detail about MySQL injection)
	/*
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myemail=stripslashes($myemail);

	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$myemail=mysql_real_escape_string($myemail);
	*/

		$sql_1="insert into CT_monthly values ('AcQSim','$month','$year',CURDATE(),
		'$myusername',0,'$cs1','$cs2','$cs3','$cs4','$cs5','$n1','$n2','$n3','$n4','$n5','$lp1',
		'$lp2','$lp3','$lcd1','$ti1','$rd1','$spa1','$ll1','$hcr1','$st1','$fu1','$fu2','$fu3','$fu4','$fu5',
		'$n1','$n2','$n3','$n4','$n5')";
		mysql_query($sql_1) or die(mysql_error()); 

    	echo "Save Edited CT Form Successfully!";
		
//header("location:main.php");




    
?> 
<form method=get action="index.php">
<input type="submit" value="Return">
</form>
<form method=get action="logout.php">
<input type="submit" value="Logout">
</form>
</p>
</body>
</html>