<?php
include_once("global/includes.php");
if(!session_is_registered(username)){
header("location:login.html");
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
<h1>CT Philips AcQSim</h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="index.php">HOME</a></li>
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

<?PHP   

  // register_action.php  
  	include("dbconnect.php");
	$myusername=$_SESSION["username"];
	//echo $myusername;
   // echo "\n";
  // username and password sent from form 
	$month=$_POST["month"]; 
	$year=$_POST["year"];
	$machine=$_POST["machine"];
	
	$result = mysql_query("SELECT * FROM CT_monthly where name='$machine' and month_number='$month' and year_number='$year'");
	$row = mysql_fetch_array($result);
	//echo $row['name'];
	?>

  <p align="right">
  
	Machine Name:<?php echo $row['name'] ?>
    <p>&nbsp;</p>
    Date:<?php echo $row['month_number'] ?>/<?php echo $row['year_number'] ?>
    <p>&nbsp;</p>
    Physicist:<?php echo $row['physicist_name'] ?>
  </p>
  <div align="center" style="display:inline;">
  <table width="402" border="2" style="width: 45%; float: left; font-size: 18px;">
    <tr>
      <td height="40" colspan="3"><p align="center">Contrast Scale</p>
      <p align="center">Slice 1-5 (-511mm)</p></td>
    </tr>
    <tr>
      <td width="84"><div align="center">Plug</div></td>
      <td width="169" align="center"><div align="center">CT# and Noise </div></td>
      <td width="125"><div align="center">Nominal</div></td>
    </tr>
    <tr>
      <td><div align="center">1</div></td>
      <td><div align="center">
        <input name="cs1" type="text" id="cs1" value="<?php echo $row['cs1'] ?>" size="12" />

        <strong>±</strong>
        <label>
        <input name="n1" type="text" value="<?php echo $row['n1'] ?>" size="12" />
        </label>
      </div></td>
      <td><div align="center">-95  <strong>±</strong> 15</div></td>
    </tr>
    <tr>
      <td><div align="center">2</div></td>
      <td><div align="center">
        <input name="cs2" type="text" id="cs2" value="<?php echo $row['cs2'] ?>" size="12"  />
        <strong>±</strong>
        <label>
        <input name="n2" type="text" value="<?php echo $row['n2'] ?>" size="12" />
        </label>
</div></td>
      <td><div align="center">913  <strong>±</strong> 50</div></td>
    </tr>
    <tr>
      <td><div align="center">3</div></td>
      <td><div align="center">
        <input name="cs3" type="text" id="cs3" value="<?php echo $row['cs3'] ?>" size="12" />
        <strong>±</strong>
        <label>
        <input name="n3" type="text" value="<?php echo $row['n3'] ?>" size="12" />
        </label>
</div></td>
      <td><div align="center">-988  <strong>± </strong>5</div></td>
    </tr>
    <tr>
      <td><div align="center">4</div></td>
      <td><div align="center">
        <input name="cs4" type="text" id="cs4" value="<?php echo $row['cs4'] ?>" size="12"/>
        <strong>±</strong>
        <label>
        <input name="n4" type="text" value="<?php echo $row['n4'] ?>" size="12" />
        </label>
</div></td>
      <td><div align="center">120  <strong>± </strong>15</div></td>
    </tr>
    <tr>
      <td height="24"><div align="center">5</div></td>
      <td><div align="center">
        <input name="cs5" type="text" id="cs5" value="<?php echo $row['cs5'] ?>" size="12" />
        <strong>±
        <label>
        <input name="n5" type="text"  value="<?php echo $row['n5'] ?>" size="12" />
        </label>
</strong></div></td>
      <td><div align="center">0  <strong>± </strong>4</div></td>
    </tr>
</table>
  <table width="402" border="2" style="width: 45%; float: right;">
    <tr>
      <td colspan="3"><p align="center">Laser Position</p>
        <p align="center">Willke Phantom</p></td>
      </tr>
    <tr>
      <td width="88"><div align="center">Laser</div></td>
      <td width="171"><div align="center">Measurement</div></td>
      <td width="119"><div align="center">Nominal</div></td>
    </tr>
    <tr>
      <td><div align="center">Cor</div></td>
      <td><div align="center">
        <input type="text" name="lp1" id="lp1" value="<?php echo $row['lp1'] ?>" />
      </div></td>
      <td><div align="center">0  <strong>±</strong>2</div></td>
    </tr>
    <tr>
      <td><div align="center">Sag</div></td>
      <td><div align="center">
        <label for="lp2"></label>
        <input type="text" name="lp2" id="lp2" value="<?php echo $row['lp2'] ?>"/>
      </div></td>
      <td><div align="center">0  <strong>±</strong>2</div></td>
    </tr>
    <tr>
      <td><div align="center">Axial</div></td>
      <td><div align="center">
        <input type="text" name="lp3" id="lp3" value="<?php echo $row['lp3'] ?>"/>
      </div></td>
      <td><div align="center">0 <strong>±</strong>2</div></td>
    </tr>
</table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
  
  <table width="402" border="2" style="width: 45%; float: left;">
    <tr>
      <td colspan="3"><p align="center">Low Contrast Detectability</p>
        <p align="center">Slice 2-5(-471 mm)(W/L=100/100)</p></td>
      </tr>
    <tr>
      <td width="173"><div align="center">See 6mm row?</div></td>
      <td width="129"><div align="center">
        <input type="text" name="lcd1" id="lcd1" value="<?php echo $row['lcd1'] ?>"/>
      </div></td>
      <td width="76"><div align="center">5</div></td>
    </tr>
</table>
   <table width="402" border="2" style="width: 45%; float:right;">
    <tr>
      <td colspan="3"><div align="center">Review Daily QA Logs</div></td>
      </tr>
    <tr>
      <td width="144"><div align="center">Performed</div></td>
      <td width="172"><div align="center">
        <input type="text" name="rd1" id="rd1" value="<?php echo $row['rd1'] ?>"/>
      </div></td>
      <td width="62"><div align="center">Y/N</div></td>
    </tr>
</table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="402" border="2" style="width: 45%; float: left;" >
    <tr>
      <td colspan="2"><p align="center">Spatial Integrity</p>
        <p align="center">Slice 3-5(-431 mm)</p></td>
      </tr>
    <tr>
      <td width="192"><div align="center">BB to BB</div></td>
      <td width="192"><div align="center">Nominal</div></td>
      </tr>
    <tr>
      <td>
        <div align="center">
          <input type="text" name="si1" id="si1" value="<?php echo $row['spa1'] ?>"/>
        </div></td>
      <td><div align="center">100  <strong>±</strong> 1</div></td>
      </tr>
  </table>
  <table width="493" border="2" style="width: 45%; float: right;">
    <tr>
      <td colspan="3"><div align="center">Table Incrementation</div></td>
      </tr>
    <tr>
      <td width="178"><div align="center">Within Tolerance?(<strong>±</strong>1mm)</div></td>
      <td width="210"><div align="center">
       
        <input type="text" name="ti1" id="ti1" value="<?php echo $row['ti1'] ?>" />
      </div></td>
      <td width="75"><div align="center">Y/N</div></td>
    </tr>
</table>
  <p>&nbsp;</p>
  </div>
   <p>&nbsp;</p>
   <table width="402" border="2" style="width: 45%; float: right;">
    <tr>
      <td colspan="3"><p align="center">Laser Localization</p>
      <p align="center">Pinnacle</p></td>
     </tr>
    <tr>
      <td width="185" height="38"><div align="center">Laser within 1mm of BB?</div></td>
      <td width="160">
        <div align="center">
          <input type="text" name="ll1" id="ll1" value="<?php echo $row['laser_localization'] ?>" />
      </div></td>
      <td width="33"><div align="center">Y/N</div></td>
    </tr>
  </table>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="486" border="2"  style="width: 45%; float:left;" >
    <tr>
      <td colspan="3"><p align="center">High Contrast Resolution</p>
      <p align="center">Slice 4-5(-391) (W/L 100/1100)</p></td>
    </tr>
    <tr>
      <td width="203"><div align="center">Highest Ip/cm block seen</div></td>
      <td width="175">
        <div align="center">
          <input type="text" name="hcr1" id="hcr1" value="<?php echo $row['hcr1'] ?>"/>
      </div></td>
      <td width="84"><div align="center">8</div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="402" border="2" style="width: 45%; float:right;" >
    <tr>
      <td colspan="3"><div align="center">Slice Thickness (Slice 1-5)</div></td>
    </tr>
    <tr>
      <td width="223"><div align="center">Slice Thickness (mm)</div></td>
      <td width="192">
        <div align="center">
          <input type="text" name="st1" id="st1" value="<?php echo $row['st1'] ?>" />
      </div></td>
      <td width="48"><div align="center">3</div></td>
    </tr>
  </table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="center">
  <table width="1080" border="2">
    <tr>
      <td colspan="7"><p align="center">Field Uniformity (head)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Noise (head)</p>
      <p align="center">Slice 3-5 (-431mm)</p></td>
    </tr>
    <tr>
      <td width="122"><div align="center">ROI</div></td>
      <td width="224"><div align="center">CT#</div></td>
      <td width="119"><div align="center">Nominal</div></td>
      <td width="106" rowspan="6"><div align="center"></div></td>
      <td width="117"><div align="center">ROI</div></td>
      <td width="208"><div align="center">CT#</div></td>
      <td width="136"><div align="center">Nominal</div></td>
    </tr>
    <tr>
      <td><div align="center">1</div></td>
      <td><label for="fu1"></label>
        <div align="center">
          <input name="fu1" type="text" id="fu1" value="<?php echo $row['fu1'] ?>" size="12" maxlength="12" />
          <strong>±</strong>
          <label></label>
          <label>
          <input name="n1" type="text" size="12" value="<?php echo $row['n1'] ?>" maxlength="12" />
          </label>
        </div></td>
      <td><div align="center"><strong>0±5</strong></div></td>
      <td><div align="center">1</div></td>
      <td><label for="n1"></label>
        <div align="center">
          <input type="text" name="n1" id="n1" value="<?php echo $row['noise1'] ?>" />
      </div></td>
      <td><div align="center"><strong>11±2</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">2</div></td>
      <td>
        <div align="center">
          <input name="fu2" type="text" id="fu2" value="<?php echo $row['fu2'] ?>" size="12" maxlength="12" />
          <strong>±</strong>
          <label></label>
          <label>
          <input name="n2" type="text" size="12" value="<?php echo $row['n2'] ?>" maxlength="12" />
          </label>
</div></td>
      <td><div align="center"><strong>0±5</strong></div></td>
      <td><div align="center">2</div></td>
      <td>
        <div align="center">
          <input type="text" name="n2" id="n2" value="<?php echo $row['noise2'] ?>" />
      </div></td>
      <td><div align="center"><strong>9±2</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">3</div></td>
      <td><label for="fu3"></label>
        <div align="center">
          <input name="fu3" type="text" id="fu3" value="<?php echo $row['fu3'] ?>" size="12" maxlength="12"/>
          <strong>±</strong>
          <label></label>
          <label>
          <input name="n3" type="text" size="12" value="<?php echo $row['n3'] ?>" maxlength="12" />
          </label>
</div></td>
      <td><div align="center"><strong>0±5</strong></div></td>
      <td><div align="center">3</div></td>
      <td><label for="n3"></label>
        <div align="center">
          <input type="text" name="n3" id="n3" value="<?php echo $row['noise3'] ?>"/>
      </div></td>
      <td><div align="center"><strong>9±2</strong></div></td>
    </tr>
    <tr>
      <td><div align="center">4</div></td>
      <td>
        <div align="center">
          <input name="fu4" type="text" id="fu4" value="<?php echo $row['fu4'] ?>" size="12" maxlength="12"/>
          <strong>±</strong>
          <label></label>
          <label>
          <input name="n4" type="text" size="12" value="<?php echo $row['n4'] ?>" maxlength="12" />
          </label>
      </div></td>
      <td><div align="center"><strong>0±5</strong></div></td>
      <td><div align="center">4</div></td>
      <td>
        <div align="center">
          <input type="text" name="n4" id="n4" value="<?php echo $row['noise4'] ?>"/>
      </div></td>
      <td><div align="center"><strong>9±2</strong></div></td>
    </tr>
    <tr>
      <td height="23"><div align="center">5</div></td>
      <td>
        <div align="center">
          <input name="fu5" type="text" id="fu5" value="<?php echo $row['fu5'] ?>" size="12" maxlength="12" />
          <strong>±</strong>
          <label></label>
          <label>
          <input name="n5" type="text" size="12" value="<?php echo $row['n5'] ?>" maxlength="12" />
          </label>
</div></td>
      <td><div align="center"><strong>0±5</strong></div></td>
      <td><div align="center">5</div></td>
      <td>
        <div align="center">
          <input type="text" name="n5" id="n5" value="<?php echo $row['noise5'] ?>"/>
      </div></td>
      <td><div align="center"><strong>9±2</strong></div></td>
    </tr>
  </table>
  </div>
<?php	
display_footer();
?>