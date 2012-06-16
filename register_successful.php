<?php
include_once("global/includes.php");
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
?>
<div id="sample-container">
		 <img src="images/title.gif"  />
<p align="right">
    <input type="submit" value="LOGOUT"  style="width:25%; float: right;"/>
</p>
<p align="right">
</p>

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
			
<li><a href="CT_Br.php">CT Brilliance</a></li>
<li><a href="CT_Ac.php">CT AcQSim</a></li>
<li><a href="working_history.php">HISTORY RECORD</a></li>
<li><a href="#">HELP</a></li>
<li><a href="#">Contact us</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2>Congratulations,Registered Successfully!</h2>

</div>
<div id="aside">
<h3>Please Go to Home Page and Login!</h3>
</div>
</div>
</div>
<?php
display_footer();
?>