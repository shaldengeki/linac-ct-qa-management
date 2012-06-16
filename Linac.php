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
<?php
display_footer();
?>