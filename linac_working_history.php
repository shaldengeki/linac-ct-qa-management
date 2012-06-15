<? 
include_once("global/includes.php");
if(!isset($_SESSION['username'])){
header("location:login.php");
}
start_html();
?>
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

  
$sql="select * from linac_monthly order by year desc, month desc";
$result=$database->stdQuery($sql);
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
<?php
display_footer();
?>