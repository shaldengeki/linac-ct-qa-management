<?php
include_once("global/includes.php");
if (!$user->loggedIn($database)) {
header("location:index.php");
}
start_html($user, $database, "UCMC Radiation Oncology QA", "", $_REQUEST['status']);
if(empty($_GET[submit])) 

{ 

?> 
<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']?>?submit=1" method="post">

 Which CT Image You Want To Show 
  <select name="year">
  	<option value="2017">2017</option>
	<option value="2016">2016</option>
	<option value="2015">2015</option>
	<option value="2014">2014</option>
	<option value="2013">2013</option>
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
    <p>
     <input type="submit" value="Show">
	</p>
</form>
<?php 
}else{ 
$month=(int)$_GET["month"];
$year=(int)$_GET["year"];
$query_image ="select pathName from CT_image where year='$year' and month='$month'";
$resultimage =$database->stdQuery($query_image);

$result_image=mysql_fetch_row($resultimage);
}
?>
<p>
<center><img src="<?php echo $result_image[0] ?>" width="400" align="left" height="300" /></center>
</p>
<p>
<a href="main.php">return to Main Page</a>
</p>
<?php
display_footer();
?>