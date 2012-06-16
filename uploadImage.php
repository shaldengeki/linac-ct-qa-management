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

</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h2></h2>
<?php 

  

if(empty($_GET[submit])) 

{ 

?> 
<form enctype="multipart/form-data" action="<?php $_SERVER['PHP_SELF']?>?submit=1" method="post"> 
<p align="left">
UPLOAD IMAGE
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
	<select name="machine">
		<option value="">Machine Name</option>
		<option value="TrueBeam1">TrueBeam1</option>
		<option value="TrueBeam2">TrueBeam2</option>
		<option value="Trilogy">Trilogy</option>
		<option value="Linac4">Linac4</option>
	</select>
  </p>
<p align="left"> Select File:

  <input name="filename" type="file"> 
  <input type="submit" value="Upload"> 
</p>
</form> 
<?php 
}else{ 
$path="uploadImage/"; // 
$user = $_SESSION['name'];
$machine=$_POST["machine"];
//echo $_FILES["filename"]["type"]; 
$month=(int)$_POST["month"];
$year=(int)$_POST["year"];

if(!file_exists($path)) 
{ 

mkdir("$path", 0700); 
}//END IF 

$tp = array("image/gif","image/pjpeg","image/png"); 

//if(!in_array($_FILES["filename"]["type"],$tp)) 
//{ 
//echo "failed"; 
//exit; 
//}//END IF 
if($_FILES["filename"]["name"]) 
{ 
$file1=$_FILES["filename"]["name"]; 
$file2 = $path.time().$file1; 
$flag=1;


}//END IF 
if($flag) $result=move_uploaded_file($_FILES["filename"]["tmp_name"],$file2);
if($result) 
{ 
echo "uploaded successfully!".$file2; 
echo $year;
echo $month;
$sql_2="insert into linac_image values('$machine','$month','$year','$file2')";
$database->stdQuery($sql_2);
echo "<script language='javascript'>"; 
echo "alert(\"upload successfully!\");"; 
echo "</script>"; 
//header("location:.php");
}//END IF 


} 

?>
<p>

//<a href="showImage.php">Show Uploaded Image.</a></p>
<p>

</div>
<div id="aside">
<h3></h3>
</div>
</div>
</div>
<?php
display_footer();
?>