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
<h1>Linac And CT Management</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="#">LINAC</a></li>
			
<li><a href="#">CT Brilliance</a></li>
<li><a href="CT_Ac.php">CT AcQSim</a></li>
<li><a href="History_Record.php">HISTORY RECORD</a></li>
<li><a href="#">HELP</a></li>
<li><a href="#">Contact us</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2></h2>
<form id="form2" action="process_History_Record.php" method="post">
  <p align="left">
  
  Select History Record Time and Machine Name   
  <select name="year">
    <option value="2012">2012</option>
	<option value="2011">2011</option>
	<option value="2010">2010</option>
	<option value="2009">2009</option>
	<option value="2008">2008</option>
	<option value="2007">2007</option>
	<option value="2006">2006</option>
	<option value="2005">2005</option>
	<option value="2004">2004</option>
	<option value="2003">2003</option>
	<option value="2002">2002</option>
	<option value="2001">2001</option>
	<option value="2000">2000</option>
   </select>
   <select name="month">
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <select name="machine">
     	<option value=" ">Machine Name </option>
        <option value="AcQSim">CT AcQSim</option>
        <option value="Brilliance">CT Brilliance</option>
 
    </select>
  </p>
  
  <p align="right">	
    <input type="submit" value="SUBMIT"  style="width:25%; float: right;"/>
  </p>
  <p>&nbsp;</p>

</form>
</div>
<div id="aside">
<h3></h3>
</div>
</div>
</div>
<div id="footer-container">
<div id="footer">Copyright &copy; Rodney D. Wiersma , 2012</div>
</div>
</div>
</div>
</body>
</html>