<?php
include_once("global/includes.php");
if(!session_is_registered(username)){
header("location:login.html");
}
start_html();

  // register_action.php  
	$myusername=$_SESSION["username"];
	echo $myusername;
    echo "\n";
  // username and password sent from form
  	$name=$_POST["machine"]; 
	$month=$_POST["month"]; 
	$year=$_POST["year"]; 
	//$imagePath=$_POST["imagePath"];
//	$date=$_POST["date"]; 
	//$physicist=$_POST["physicist"];
	
	
	$temperature=(float)$_POST["temperature"];
	$pressure=(float)$_POST["pressure"];
	$chamber=$_POST["chamber"];
	$electrometer=$_POST["electrometer"];
	
	$q1_1=(float)$_POST["q1_1"];
	$q1_2=(float)$_POST["q1_2"];
	$q2_1=(float)$_POST["q2_1"];
	$q2_2=(float)$_POST["q2_2"];
	$q3_1=(float)$_POST["q3_1"];
	$q3_2=(float)$_POST["q3_2"];
	
	$aq1_1=(float)$_POST["aq1_1"];
	$aq1_2=(float)$_POST["aq1_2"];
	$aq2_1=(float)$_POST["aq2_1"];
	$aq2_2=(float)$_POST["aq2_2"];
	$aq3_1=(float)$_POST["aq3_1"];
	$aq3_2=(float)$_POST["aq3_2"];
	
	$bq1_1 =(float)$_POST["bq1_1"];
	$bq1_2 =(float)$_POST["bq1_2"];
	$bq2_1 =(float)$_POST["bq2_1"];
	$bq2_2 =(float)$_POST["bq2_2"];
	$bq3_1 =(float)$_POST["bq3_1"];
	$bq3_2 =(float)$_POST["bq3_2"];
	
	
	$gating_1=(float)$_POST["gating_q1"];
	$gating_2=(float)$_POST["gating_q2"];
	$gating_3=(float)$_POST["gating_q3"];
	
	$edw_q1_1 =(float)$_POST["edw_q1_1"];
	$edw_q1_2 =(float)$_POST["edw_q1_2"];
	$edw_q2_1 =(float)$_POST["edw_q2_1"];
	$edw_q2_2 =(float)$_POST["edw_q2_2"];
	$edw_q3_1 =(float)$_POST["edw_q3_1"];
	$edw_q3_2 =(float)$_POST["edw_q3_2"];
	
	$a_q1_1=(float)$_POST["a_q1_1"];
	$a_q1_2=(float)$_POST["a_q1_2"];
	$a_q1_3=(float)$_POST["a_q1_3"];
	$a_q1_4=(float)$_POST["a_q1_4"];
	$a_q1_5=(float)$_POST["a_q1_5"];
	
	$a_q2_1=(float)$_POST["a_q2_1"];
	$a_q2_2=(float)$_POST["a_q2_2"];
	$a_q2_3=(float)$_POST["a_q2_3"];
	$a_q2_4=(float)$_POST["a_q2_4"];
	$a_q2_5=(float)$_POST["a_q2_5"];
	
	$a_q3_1=(float)$_POST["a_q3_1"];
	$a_q3_2=(float)$_POST["a_q3_2"];
	$a_q3_3=(float)$_POST["a_q3_3"];
	$a_q3_4=(float)$_POST["a_q3_4"];
	$a_q3_5=(float)$_POST["a_q3_5"];
	
	$b_q1_1=(float)$_POST["b_q1_1"];
	$b_q1_2=(float)$_POST["b_q1_2"];
	$b_q1_3=(float)$_POST["b_q1_3"];
	$b_q1_4=(float)$_POST["b_q1_4"];
	$b_q1_5=(float)$_POST["b_q1_5"];
	
	$b_q2_1=(float)$_POST["b_q2_1"];
	$b_q2_2=(float)$_POST["b_q2_2"];
	$b_q2_3=(float)$_POST["b_q2_3"];
	$b_q2_4=(float)$_POST["b_q2_4"];
	$b_q2_5=(float)$_POST["b_q2_5"];
	
	$b_q3_1=(float)$_POST["b_q3_1"];
	$b_q3_2=(float)$_POST["b_q3_2"];
	$b_q3_3=(float)$_POST["b_q3_3"];
	$b_q3_4=(float)$_POST["b_q3_4"];
	$b_q3_5=(float)$_POST["b_q3_5"];
	
	$c_q1_1 =(float)$_POST["c_q1_1"];
	$c_q1_2 =(float)$_POST["c_q1_2"];
	$c_q1_3 =(float)$_POST["c_q1_3"];
	$c_q1_4 =(float)$_POST["c_q1_4"];
	$c_q1_5 =(float)$_POST["c_q1_5"];
	
	$c_q2_1 =(float)$_POST["c_q2_1"];
	$c_q2_2 =(float)$_POST["c_q2_2"];
	$c_q2_3 =(float)$_POST["c_q2_3"];
	$c_q2_4 =(float)$_POST["c_q2_4"];
	$c_q2_5 =(float)$_POST["c_q2_5"];
	
	$c_q3_1 =(float)$_POST["c_q3_1"];
	$c_q3_2 =(float)$_POST["c_q3_2"];
	$c_q3_3 =(float)$_POST["c_q3_3"];
	$c_q3_4 =(float)$_POST["c_q3_4"];
	$c_q3_5 =(float)$_POST["c_q3_5"];

	
	
	$lwv=(float)$_POST["lwv"];
	$rwv=(float)$_POST["rwv"];
	$lwh=(float)$_POST["lwh"];
	$rwh=(float)$_POST["rwh"];
	$sagittal=(float)$_POST["sagittal"];
	$odi1=(float)$_POST["odi1"];
	$odi2=(float)$_POST["oid2"];
	$odi3=(float)$_POST["oid3"];
	$distance1=(float)$_POST["distance1"];
	$distance2=(float)$_POST["distance2"];
	$distance3=(float)$_POST["distance3"];
	$dr1 =(float)$_POST["dr1"];
	$dr2 =(float)$_POST["dr2"];
	$dr3 =(float)$_POST["dr3"];
	$dr4 =(float)$_POST["dr4"];
	$dr5 =(float)$_POST["dr5"];
	$dr6 =(float)$_POST["dr6"];
	$x1a =(float)$_POST["x1a"];
	$x1b =(float)$_POST["x1b"];
	$x1c =(float)$_POST["x1c"];
	$x2a =(float)$_POST["x2a"];
	$x2b =(float)$_POST["x2b"];
	$x2c =(float)$_POST["x2c"];
	$y1a =(float)$_POST["y1a"];
	$y1b =(float)$_POST["y1b"];
	$y1c =(float)$_POST["y1c"];
	$y2a =(float)$_POST["y2a"];
	$y2b =(float)$_POST["y2b"];
	$y2c =(float)$_POST["y2c"];
	$doorStatus =$_POST["door_status"];
	$keyStatus =$_POST["key_status"];
	$wedge =$_POST["wedge"];
	$cone =$_POST["cone"];
	$block =$_POST["block"];
	$crossLine =(float)$_POST["corss_line"];
	$inLine =(float)$_POST["in_line"];
	$psa1 =(float)$_POST["psa1"];
	$psa2 =(float)$_POST["psa2"];
	$psa3 =(float)$_POST["psa3"];
	$comment=$_POST["comment"];
	
 
	$path="uploadImage/"; // 
	echo $_FILES["filename"]["type"];

	if(!file_exists($path)) 
	{ 
	mkdir("$path", 0700); 
	}
	$tp = array("image/gif","image/pjpeg","image/png"); 

	if($_FILES["filename"]["name"]) 
	{ 
	$file1=$_FILES["filename"]["name"]; 
	$file2 = $path.time().$file1; 
	$flag=1;


	}//END IF 
	if($flag) $result=move_uploaded_file($_FILES["filename"]["tmp_name"],$file2);
	if($result) 
	{ 
	//echo "UpLoaded Successfully!".$file2; 
	echo "<script language='javascript'>"; 
	echo "alert(\"upload successfully!\");"; 
	echo "</script>"; 
	//header("location:.php");
	}//END IF 



// To protect MySQL injection (more detail about MySQL injection)
	/*
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myemail=stripslashes($myemail);

	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$myemail=mysql_real_escape_string($myemail);
	*/

		$sql_1="insert into linac_monthly values ('$name','$month','$year',CURDATE(),
				'$myusername',0,'$temperature','$pressure','$chamber','$electrometer','$q1_1','$q1_2','$q2_1','$q2_2','$q3_1','$q3_2','$aq1_1','$aq1_2','$aq2_1','$aq2_2','$aq3_1','$aq3_2','$bq1_1','$bq1_2','$bq2_1',		'$bq2_2','$bq3_1','$bq3_2','$gating_1','$gating_2','$gating_3','$edw_q1_1','$edw_q1_2','$edw_q2_1','$edw_q2_2','$edw_q3_1','$edw_q3_2','$a_q1_1','$a_q1_2','$a_q1_3','$a_q1_4','$a_q1_5','$a_q2_1','$a_q2_2','$a_q2_3','$a_q2_4','$a_q2_5','$a_q3_1','$a_q3_2','$a_q3_3','$a_q3_4','$a_q3_5','$b_q1_1','$b_q1_2','$b_q1_3','$b_q1_4','$b_q1_5','$b_q2_1','$b_q2_2','$b_q2_3','$b_q2_4','$b_q2_5','$b_q3_1','$b_q3_2','$b_q3_3','$b_q3_4','$b_q3_5','$c_q1_1','$c_q1_2','$c_q1_3','$c_q1_4','$c_q1_5','$c_q2_1','$c_q2_2','$c_q2_3','$c_q2_4','$c_q2_5','$c_q3_1','$c_q3_2','$c_q3_3','$c_q3_4','$c_q3_5','$lwv','$rwv','$lwh','$rwh','$sagittal','$odi1','$oid2','$odi3','$distance1','$distance2','$distance3','$dr1','$dr2','$dr3','$dr4','$dr5','$dr6','$x1a','$x1b','$x1c','$x2a','$x2b','$x2c','$y1a','$y1b','$y1c','$y2a','$y2b','$y2c','$doorStatus','$keyStatus','$wedge','$cone','$block','$crossLine','$inLine','$psa1','$psa2','$psa3','$comment','$file2')";
		mysql_query($sql_1) or die(mysql_error()); 

    	echo "Save Edited QA Form Successfully!";
		
//header("location:main.php");




    
?> 
<form method=get action="index.php">
<input type="submit" value="Return">
</form>
<form method=get action="logout.php">
<input type="submit" value="Logout">
</form>
</p>
<?php	
display_footer();
?>