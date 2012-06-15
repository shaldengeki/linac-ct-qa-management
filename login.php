<?php
include_once("global/includes.php");
start_html();
?>
<div id="sample-container">
		 <img src="images/title.gif"  />
<div id="layout-two-fixed-spread">
<div id="head-container">
<div id="header">
<h1>Machine QA Management</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2>USER LOGIN</h2>
<body style="" background="image\8.jpg"  behavior="fixed">
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
<h3><center></center></h3>
</table>
<p>
<center></center>
</p>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="check_login.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td width="78">Select</td>

<td width="294"><select name="user_selection" id="user_selection">
  <option value="user">Common User</option>
  <option value="admin">Administrator</option>
</select></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="294"><input name="username" type="text" id="username"></td>
</tr>
<tr>
<td>Password</td>
<td><input name="password" type="password" id="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form2" method="get" action="">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>User Register </strong></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="submit" value="Register"></td>
</tr>
</table>
</td>
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