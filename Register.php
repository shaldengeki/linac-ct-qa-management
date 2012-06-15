<? 
include_once("global/includes.php");
start_html();
?>
<div id="sample-container">
		 <img src="images/title.gif"  />
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
<li><a href="#">CT AcQSim</a></li>
<li><a href="#">HELP</a></li>
<li><a href="#">Contact us</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2>Login and Register</h2>
<body style="" background="image\8.jpg"  behavior="fixed">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<h3><center>CT Data Center</center></h3>
</table>
<p>
<center></center>
</p>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="Register_action.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td width="78">Register</td>
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
Username<br/><input type="text" name="myusername" maxlength="20" /><br/>
Password<br/><input type="password" name="mypassword" /><br/>
Email<br/><input type="text" name="email" /><br/>
<td><input width="300" type="submit" name="submit" value="Register"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form2" method="get" action="register.php">

</form>
</tr>
</table>
</div>
<div id="aside">
<h3>&nbsp;</h3>
</div>
</div>
</div>
<?php
display_footer();
?>