<? 
session_start();
if(!session_is_registered(username)){
header("location:re_login.html");
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

<li><a href="index.php">HOME</a></li>
<li><a href="uploadimage.php">Upload Image</a></li>
			
<li><a href="">Submit Form</a></li>
<li><a href="">Analysis Image</a></li>
<li><a href="">HISTORY RECORD</a></li>
<li><a href="">HELP</a></li>
<li><a href="">Contact us</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2>Page heading</h2>

</div>
<div id="aside">
<h3>Aside heading</h3>
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