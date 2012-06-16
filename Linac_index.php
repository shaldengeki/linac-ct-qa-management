<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("location:index.php");
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
<h1>Machine QA Management</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="index.php">HOME</a></li>
<li><a href="TrueBeam1.php">TrueBeam1</a></li>
<li><a href="TrueBeam2.php">TrueBeam2</a></li>
<li><a href="Trilogy.php">Trilogy</a></li>
<li><a href="Linac4.php">Linac4</a></li>
<li><a href="uploadImage.php">Upload Image</a><li>
<li><a href="linac_working_history.php">Working History</a></li>
<li><a href="Help/CT_QA_Procedure.pdf">HELP</a></li>
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
<?php
display_footer();
?>