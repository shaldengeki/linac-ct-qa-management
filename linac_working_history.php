<? 
session_start();
if(!session_is_registered(username)){
header("location:login.html");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Hosital of University of Chiago</title>
	<meta name="Description" content="Max Design - standards based web design, development and training" />
	<meta name="robots" content="all, index, follow" />
	<meta name="distribution" content="global" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/sample.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection"/>
	<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>	
	<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
</head>
<body>

<div id="sample-container">
		 <img src="images/title.gif"  />
 <form id="form1" action="logout.php" name="form1" method="post" >
<p align="right">
    <input type="submit" value="LOGOUT"  style="width:25%; float: right;"/>
</p>
<p align="right">
</p>
Welcome,<?php
echo $_SESSION["username"];
?>!
<p>&nbsp;</p>

</form>

<div id="layout-two-fixed-spread">
<div id="head-container">
<div id="header">
<h1>Machine QA Management</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="index.php">HOME</a></li>
<li><a href="#">HELP</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2></h2>
  <p>&nbsp;</p>
  <p>
  Working History:
  </p>
   Submit Date******************QA Period******** Machine********User
   <p>&nbsp;</p>
<?php   

include("dbconnect.php");
$sql="select * from linac_monthly order by year desc, month desc";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
   ?>
	
   <form action="process_linac_history.php" method="post"><br />
   <a href="#">
   <?php 
   echo '';
   echo $row['date']; 
   echo '    ';
   echo '********';
   echo $row['month'];
   echo '/';
   echo $row['year'];
   echo '  ';
   echo '********';
   echo $row['name'];
   echo '********';
   echo $row['physicist_name'];
   ?>
   </a>
	<input name="machine" type="hidden" value="<?php echo $row['name']?>" />
	<input name="month" type="hidden" value="<?php echo $row['month']?>" />
	<input name="year" type="hidden" value="<?php echo $row['year']?>" />
	 <input type="submit" value="View"/>
   </form>
<?php } ?>

  <p>&nbsp;</p>

</form>
</div>
<div id="aside">
<h3></h3>
</div>
</div>
</div>
<div id="footer-container">
<div id="footer"></div>
</div>
</div>
</div>
</body>
</html>