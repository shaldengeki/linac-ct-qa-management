<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("location:re_login.php");
}

start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>	
<div id="sample-container">
		 <img src="images/title.gif"  />
<p align="right">
</p>
Welcome,<?php
echo $user->name;
?>!
<p>&nbsp;</p>

</form>

<div id="layout-two-fixed-spread">
<div id="head-container">
<div id="header">
<h1>CT Philips AcQSim</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="#">HOME</a></li>
<li><a href="#">MONTHLY</a></li>
<li><a href="#">YEARLY</a></li>
<li><a href="Ac_history.php">HISTORY RECORD</a></li>
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


</div>
<div id="aside">
<h3></h3>
</div>
</div>
</div>
<p align="left">&nbsp;</p>
<p align="left">&nbsp;</p>


<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center"><strong>MONTHLY CT QA </strong></p>
<p align="center"><strong>Philips AcQSim</strong></p>

<form id="form2" action="process_ct_Ac_History.php" method="post">
  <p align="Center">
  
  Select Year and Month For This History Record of the AcQSim CT   
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
  </p>
  
  <p align="right">	
    <input type="submit" value="SUBMIT"  style="width:25%; float: right;"/>
  </p>
  <p>&nbsp;</p>

</form>
<?php
display_footer();
?>