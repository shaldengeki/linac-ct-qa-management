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
<h1>LINAC </h1>
</div>
</div>
<div id="navigation-container">
<div id="navigation">

<ul>
<li><a href="index.php">HOME</a></li>
<li><a href="#">MONTHLY</a></li>
<li><a href="#">YEARLY</a></li>
<li><a href="linac_history.php">History List</a></li>
</ul>
</div>
</div>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
  <h2>&nbsp;</h2>
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
<p align="center"><strong>MONTHLY LINAC QA </strong></p>
<p align="center">TrueBeam 2</p>
<form id="form2" action="process_linac_monthly.php" method="post">
  <input type="hidden" name="machine" value="TureBeam 2" >
 <div align="right">
  <p>&nbsp;</p>
  <p>
    <label></label>
  </p>
  <p>
    <label>Month
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
    </label>
	<label>year
	<select name="year">
	<option value="2012">2017</option>
	<option value="2012">2016</option>
	<option value="2012">2015</option>
	<option value="2012">2014</option>
	<option value="2012">2013</option>
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
   </label>
  </p>
  <table width="269" height="67" border="1" align="center">
    <tr>
      <td align="center"><span class="STYLE12">Photon Dosimetry </span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="426" height="151" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Measurement Parameters </span></td>
      </tr>
    <tr>
      <td width="198">Temperature. (C):</td>
      <td width="212"><input type="text" name="temperature" /></td>
    </tr>
    <tr>
      <td>Pressure.(mmHg)</td>
      <td><input type="text" name="pressure" /></td>
    </tr>
    <tr>
      <td valign="middle">TPCF:
        <input type="button" value="Calculate" onClick="calTPCF()">
        </td>
      <td><input type="text" name="tpcf" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="534" height="122" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Equipment Used For This Measurement</span></td>
    </tr>
    <tr>
      <td width="159"> Ionization Chamber :</td>
      <td width="359"><select name="chamber">
          <option value="NULL">Select a Chamber</option>
          <option value="Farmer ( S/N  944 , ND.SW(Gy/C)  5.18E+07 )">Farmer ( S/N 944 , ND.SW(Gy/C)  5.18E+07 ) </option>
          <option value="Farmer ( S/N  269 , ND.SW(Gy/C)  5.32E+07 )">Farmer ( S/N 269 , ND.SW(Gy/C)  5.32E+07 ) </option>
      </select></td>
    </tr>
    <tr>
      <td>Electrometer:</td>
      <td><select name="electrometer">
	  		<option>Select a Electrometer</option>
          <option value="Keithley Model 614 ( S/N 42215, Kelec 0.995)">Keithley Model 614 ( S/N 42215, Kelec 0.995)</option>
        <option value="SI CDX 2000B #1 ( S/N J073443 ,Kelec 1.000)">SI CDX 2000B #1 ( S/N J073443, Kelec 1.000)</option>    
        <option value="SI CDX 2000B #2 ( S/N J073444, Kelec 1.000)">SI CDX 2000B #2 ( S/N J073444, Kelec 1.000)</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="429" height="292" border="1" align="center">
    <tr>
      <td colspan="3" align="center"><span class="STYLE2">Constants for Electrons obtained from TG-51</span></td>
      </tr>
    <tr>
      <td width="172">&nbsp;</td>
      <td width="129">6MV</td>
      <td width="132">18MV</td>
    </tr>
    <tr>
      <td>PDD(10,10x10)</td>
      <td>67.200</td>
      <td>832.(Pb corr)</td>
    </tr>
    <tr>
      <td>Kq(Ex.A12)</td>
      <td>0.995</td>
      <td>0.970</td>
    </tr>
    <tr>
      <td>Kq(Farmer)</td>
      <td>0.991</td>
      <td>0.965</td>
    </tr>
    <tr>
      <td>P<span class="STYLE8">pol</span></td>
      <td>1.000</td>
      <td>1.000</td>
    </tr>
    <tr>
      <td>P<span class="STYLE8">lon</span></td>
      <td>1.001</td>
      <td>1.004</td>
    </tr>
    <tr>
      <td>K<span class="STYLE8">elec</span></td>
      <td colspan="2">0.995</td>
      </tr>
    <tr>
      <td>N<span class="STYLE8">D,SW</span>(Gy/C)</td>
      <td colspan="2">5.180E+07</td>
      </tr>
  </table>
  <p>&nbsp;</p>
  <table width="433" height="791" border="1" align="center">
    <tr>
      <td colspan="3" align="center"><span class="STYLE2">Output Calibration </span></td>
      </tr>
    <tr>
      <td colspan="3" align="center">Irradiation Conditions</td>
      </tr>
    <tr>
      <td colspan="2">Collimator</td>
      <td width="138">10x10</td>
    </tr>
    <tr>
      <td colspan="2">SAD</td>
      <td>100cm</td>
    </tr>
    <tr>
      <td colspan="2">Depth</td>
      <td>10cm solid water </td>
    </tr>
    <tr>
      <td colspan="2">Dose</td>
      <td>100MU</td>
    </tr>
    <tr>
      <td colspan="2">Chamber Bias </td>
      <td>-300MV</td>
    </tr>
    <tr>
      <td height="51" colspan="3">Output Calibration </td>
      </tr>
    <tr>
      <td width="127" height="38" align="center">Photon Enegey </td>
      <td width="146" align="center">6MV</td>
      <td height="38" align="center">18MV</td>
    </tr>
    <tr>
      <td height="38" align="center">Q1</td>
      <td align="center"><label>
        <input type="text" name="q1_1" />
      </label></td>
      <td height="38" align="center"><input type="text" name="q1_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q2</td>
      <td align="center"><input type="text" name="q2_1" /></td>
      <td height="38" align="center"><input type="text" name="q2_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q3</td>
      <td align="center"><input type="text" name="q3_1" /></td>
      <td height="38" align="center"><input type="text" name="q3_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">average</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">M</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(TG-51)</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(abs)</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">%diff</td>
      <td align="center" bgcolor="#009900">&nbsp;</td>
      <td height="38" align="center" bgcolor="#009900">&nbsp;</td>
    </tr>
    <tr>
      <td height="58" colspan="3" align="left"><span class="STYLE9">Adjusted Output Calibration </span></td>
      </tr>
    <tr>
      <td height="38" colspan="3" align="center"><span class="STYLE2">Charge (x10^-8 C) </span></td>
      </tr>
    <tr>
      <td height="38" align="center">Photon Enegey </td>
      <td align="center">6MV</td>
      <td height="38" align="center">18MV</td>
    </tr>
    <tr>
      <td height="38" align="center">Bias</td>
      <td align="center">-300</td>
      <td height="38" align="center">-300</td>
    </tr>
    <tr>
      <td height="38" align="center">Q1</td>
      <td align="center"><label>
        <input type="text" name="aq1_1" />
      </label></td>
      <td height="38" align="center"><input type="text" name="aq1_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q2</td>
      <td align="center"><input type="text" name="aq2_1" /></td>
      <td height="38" align="center"><input type="text" name="aq2_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q3</td>
      <td align="center"><input type="text" name="aq3_1" /></td>
      <td height="38" align="center"><input type="text" name="aq3_2" /></td>
    </tr>
    <tr>
      <td height="38" align="center">average</td>
      <td align="center">#DIV/0!</td>
      <td height="38" align="center">#DIV/0!</td>
    </tr>
    <tr>
      <td height="38" align="center">M</td>
      <td align="center">#DIV/0!</td>
      <td height="38" align="center">#DIV/0!</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(TG-51)</td>
      <td align="center">#DIV/0!</td>
      <td height="38" align="center">#DIV/0!</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(abs0</td>
      <td align="center">0.85</td>
      <td height="38" align="center">0.9</td>
    </tr>
    <tr>
      <td height="38" align="center">%diff</td>
      <td align="center" bgcolor="#009900">#DIV/0!</td>
      <td height="38" align="center" bgcolor="#009900">#DIV/0!</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="432" height="295" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE10">TPR Check </span></td>
    </tr>
    <tr>
      <td colspan="2" align="center">Irradiation Conditions </td>
    </tr>
    <tr>
      <td width="200">Collimator</td>
      <td width="216">10x10</td>
    </tr>
    <tr>
      <td>SAD</td>
      <td>100cm</td>
    </tr>
    <tr>
      <td>Depth</td>
      <td>5 cm solid water </td>
    </tr>
    <tr>
      <td>Dose</td>
      <td>100MU</td>
    </tr>
    <tr>
      <td>Chamber Bias </td>
      <td>-300V</td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
  </table>
  <table width="433" height="791" border="1" align="center">
    <tr>
      <td height="38" colspan="3" align="center"><span class="STYLE2">Charge (x10^-8 C) </span></td>
    </tr>
    <tr>
      <td width="127" height="38" align="center">Photon Enegey </td>
      <td width="146" align="center">6MV</td>
      <td height="38" align="center">18MV</td>
    </tr>
    <tr>
      <td height="38" align="center">Bias</td>
      <td align="center">-300</td>
      <td height="38" align="center">-300</td>
    </tr>
    <tr>
      <td height="38" align="center">Q1</td>
      <td align="center"><label>
        <input type="text" name="q1_12" />
      </label></td>
      <td height="38" align="center"><input type="text" name="q1_22" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q2</td>
      <td align="center"><input type="text" name="q2_12" /></td>
      <td height="38" align="center"><input type="text" name="q2_22" /></td>
    </tr>
    <tr>
      <td height="38" align="center">Q3</td>
      <td align="center"><input type="text" name="q3_12" /></td>
      <td height="38" align="center"><input type="text" name="q3_22" /></td>
    </tr>
    <tr>
      <td height="38" align="center">average</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">M</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(TG-51)</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">Dw(abs0</td>
      <td align="center">&nbsp;</td>
      <td height="38" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="38" align="center">%diff</td>
      <td align="center" bgcolor="#009900">&nbsp;</td>
      <td height="38" align="center" bgcolor="#009900">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="432" height="295" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE10">Gating &amp; EDW Check </span></td>
    </tr>
    <tr>
      <td colspan="2" align="center">Irradiation Conditions </td>
    </tr>
    <tr>
      <td width="200">Collimator</td>
      <td width="216">10x10</td>
    </tr>
    <tr>
      <td>SAD</td>
      <td>100cm</td>
    </tr>
    <tr>
      <td>Depth</td>
      <td>5 cm solid water </td>
    </tr>
    <tr>
      <td>Dose</td>
      <td>100MU</td>
    </tr>
    <tr>
      <td>Chamber Bias </td>
      <td>-300V</td>
    </tr>
    <tr>
      <td>Gating Window </td>
      <td>~10%</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="475" height="401" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Gating</span></td>
      </tr>
    <tr>
      <td colspan="2" align="center">Charge (x10^8C) </td>
      </tr>
    <tr>
      <td width="149">Photon Energy </td>
      <td width="162">6 MV </td>
    </tr>
    <tr>
      <td>Test</td>
      <td>Gating</td>
    </tr>
    <tr>
      <td>Bias</td>
      <td>-300</td>
    </tr>
    <tr>
      <td>Q1</td>
      <td><label>
        <input type="text" name="gating_q1" />
      </label></td>
    </tr>
    <tr>
      <td>Q2</td>
      <td><input type="text" name="gating_q2" /></td>
    </tr>
    <tr>
      <td>Q3</td>
      <td><input type="text" name="gating_q3" /></td>
    </tr>
    <tr>
      <td>average</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Measured TPR(5) </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Reference TPR(5) </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>%diff</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="474" height="447" border="1" align="center">
    <tr>
      <td colspan="3" align="center"><span class="STYLE2">EDW Check </span></td>
      </tr>
    <tr>
      <td colspan="3" align="center">Charge(x10^~8C)</td>
      </tr>
    <tr>
      <td width="142">Photon Energy </td>
      <td width="127">6MV</td>
      <td width="141">18 MV </td>
    </tr>
    <tr>
      <td>Test</td>
      <td>60  ° EDW IN </td>
      <td>60  ° EDW IN </td>
    </tr>
    <tr>
      <td>Bias</td>
      <td>-300</td>
      <td>-300</td>
    </tr>
    <tr>
      <td>Q1</td>
      <td><input type="text" name="edw_q1_1" /></td>
      <td><input type="text" name="edw_q1_2" /></td>
    </tr>
    <tr>
      <td>Q2</td>
      <td><input type="text" name="edw_q2_1" /></td>
      <td><input type="text" name="edw_q2_2" /></td>
    </tr>
    <tr>
      <td>Q3</td>
      <td><input type="text" name="edw_q3_1" /></td>
      <td><input type="text" name="edw_q3_2" /></td>
    </tr>
    <tr>
      <td>average</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Measured WF(5) </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Reference WF(5) </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="32">%diff</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="324" height="67" border="1" align="center">
    <tr>
      <td align="center"><span class="STYLE12">Electron Dosimetry </span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="795" height="165" border="1" align="center">
    <tr>
      <td colspan="3" align="center"><span class="STYLE2">Available Chambers</span></td>
      <td colspan="5" align="center"><span class="STYLE13">Mc (nC) for MeV beam </span></td>
    </tr>
    <tr>
      <td width="113">Model</td>
      <td width="81" colspan="-1">S/N</td>
      <td width="132">N<span class="STYLE8">D.SW</span>(Gy/C)</td>
      <td width="87" colspan="-1">6</td>
      <td width="84">9</td>
      <td width="89">12</td>
      <td width="81">16</td>
      <td width="76">20</td>
    </tr>
    <tr>
      <td>Farmer 23333</td>
      <td>944</td>
      <td>5.18E+07</td>
      <td colspan="-1">20.5</td>
      <td>20.8</td>
      <td>21.0</td>
      <td>21.6</td>
      <td>21.6</td>
    </tr>
    <tr>
      <td>Farmer 23333</td>
      <td>269</td>
      <td>5.32E+07</td>
      <td colspan="-1">20.0</td>
      <td>20.3</td>
      <td>20.4</td>
      <td>21.0</td>
      <td>21.2</td>
    </tr>
    <tr>
      <td colspan="8" align="center">MC is the expected charge at dmeas for 1.00 cGy/MU at dmax</td>
      </tr>
  </table>
  <p>&nbsp;</p>
  <table align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <col width="171" />
    <col width="75" span="5" />
    <col width="74" />
    <tr align="center" bordercolor="#000066" height="21">
      <td height="21" colspan="7">Constants for Electrons obtained from TG-51</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="21">
      <td width="396" height="21">&nbsp;</td>
      <td colspan="5">Electron Energy (MeV)</td>
      <td width="36" rowspan="12"></td>
    </tr>
    <tr align="center" bordercolor="#000066" height="21">
      <td height="21">&nbsp;</td>
      <td width="36">6</td>
      <td width="36">9</td>
      <td width="36">12</td>
      <td width="75">16</td>
      <td width="148">20</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">dmax(cm)</td>
      <td>1.40</td>
      <td>2.00</td>
      <td>2.50</td>
      <td>2.50</td>
      <td>2.00</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">R50(cm)</td>
      <td>2.40</td>
      <td>3.70</td>
      <td>5.10</td>
      <td>6.80</td>
      <td>8.50</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">dref(cm)</td>
      <td>1.30</td>
      <td>2.10</td>
      <td>3.00</td>
      <td>4.00</td>
      <td>5.00</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">dmeas (cm)</td>
      <td>1.50</td>
      <td>2.50</td>
      <td>2.50</td>
      <td>2.50</td>
      <td>2.50</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">Pion</td>
      <td colspan="5">1.010</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="26">kR50'</td>
      <td>1.027</td>
      <td>1.016</td>
      <td>1.008</td>
      <td>1.002</td>
      <td>0.998</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">kecal</td>
      <td colspan="5">0.897</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">ND,SW(60Co) (Gy/C)</td>
      <td colspan="5">5.18E+07</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">PDD(dref)</td>
      <td>99.5</td>
      <td>100</td>
      <td>100</td>
      <td>98.9</td>
      <td>95.5</td>
      </tr>
    <tr align="center" bordercolor="#000066" height="25">
      <td height="25">kelec</td>
      <td colspan="5">0.995</td>
      </tr>
  </table>
  <p>&nbsp;</p>
  <table width="200" border="1" align="center">
    <tr>
      <td><span class="STYLE1">Output Calibration </span></td>
    </tr>
  </table>
  <table width="728" height="334" border="1" align="center">
    <tr>
      <td width="96">&nbsp;</td>
      <td colspan="5" align="center">Charge(x10^~8C)</td>
      </tr>
    <tr>
      <td>Electron Energy </td>
      <td width="80">6 Mev </td>
      <td width="86">9 Mev </td>
      <td width="88">12 Mev </td>
      <td width="82">16 Mev </td>
      <td width="81">20 Mev </td>
    </tr>
    <tr>
      <td>Depth(cm)</td>
      <td>1.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
    </tr>
    <tr>
      <td>Q1</td>
      <td><label>
        <input name="a_q1_1" type="text" size="15" />
      </label></td>
      <td><input name="a_q1_2" type="text" size="15" /></td>
      <td><input name="a_q1_3" type="text" size="15" /></td>
      <td><input name="a_q1_4" type="text" size="15" /></td>
      <td><input name="a_q1_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q2</td>
      <td><input name="a_q2_1" type="text" size="15" /></td>
      <td><input name="a_q2_2" type="text" size="15" /></td>
      <td><input name="a_q2_3" type="text" size="15" /></td>
      <td><input name="a_q2_4" type="text" size="15" /></td>
      <td><input name="a_q2_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q3</td>
      <td><input name="a_q3_1" type="text" size="15" /></td>
      <td><input name="a_q3_2" type="text" size="15" /></td>
      <td><input name="a_q3_3" type="text" size="15" /></td>
      <td><input name="a_q3_4" type="text" size="15" /></td>
      <td><input name="a_q3_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>average</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>M</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Mc</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>%difference</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="364" height="47" border="1" align="center">
    <tr>
      <td width="375" align="center"><span class="STYLE13">Adjusted Output Calibration </span></td>
      </tr>
  </table>
  <table width="728" height="334" border="1" align="center">
    <tr>
      <td width="96">&nbsp;</td>
      <td colspan="5" align="center">Charge(x10^~8C)</td>
    </tr>
    <tr>
      <td>Electron Energy </td>
      <td width="80">6 Mev </td>
      <td width="86">9 Mev </td>
      <td width="88">12 Mev </td>
      <td width="82">16 Mev </td>
      <td width="81">20 Mev </td>
    </tr>
    <tr>
      <td>Depth(cm)</td>
      <td>1.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
    </tr>
    <tr>
      <td>Q1</td>
      <td><label>
        <input name="b_q1_12" type="text" size="15" />
      </label></td>
      <td><input name="b_q1_2" type="text" size="15" /></td>
      <td><input name="b_q1_3" type="text" size="15" /></td>
      <td><input name="b_q1_4" type="text" size="15" /></td>
      <td><input name="b_q1_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q2</td>
      <td><input name="b_q2_1" type="text" size="15" /></td>
      <td><input name="b_q2_2" type="text" size="15" /></td>
      <td><input name="b_q2_3" type="text" size="15" /></td>
      <td><input name="b_q2_4" type="text" size="15" /></td>
      <td><input name="b_q2_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q3</td>
      <td><input name="b_q3_1" type="text" size="15" /></td>
      <td><input name="b_q3_2" type="text" size="15" /></td>
      <td><input name="b_q3_3" type="text" size="15" /></td>
      <td><input name="b_q3_4" type="text" size="15" /></td>
      <td><input name="b_q3_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>average</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
    </tr>
    <tr>
      <td>M</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
    </tr>
    <tr>
      <td>Mc</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>%difference</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
      <td>#DIV/0!</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="231" height="70" border="1" align="center">
    <tr>
      <td width="221" align="center" class="STYLE10">Energy Ratio Check </td>
    </tr>
  </table>
  <table width="728" height="334" border="1" align="center">
    <tr>
      <td width="96">&nbsp;</td>
      <td colspan="5" align="center">Charge(x10^~8C)</td>
    </tr>
    <tr>
      <td>Electron Energy </td>
      <td width="80">6 Mev </td>
      <td width="86">9 Mev </td>
      <td width="88">12 Mev </td>
      <td width="82">16 Mev </td>
      <td width="81">20 Mev </td>
    </tr>
    <tr>
      <td>Depth(cm)</td>
      <td>1.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
      <td>2.5</td>
    </tr>
    <tr>
      <td>Q1</td>
      <td><input name="c_q1_1" type="text" size="15" />
      <td><input name="c_q1_2" type="text" size="15" /></td>
      <td><input name="c_q1_3" type="text" size="15" /></td>
      <td><input name="c_q1_4" type="text" size="15" /></td>
      <td><input name="c_q1_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q2</td>
      <td><input name="c_q2_1" type="text" size="15" /></td>
      <td><input name="c_q2_2" type="text" size="15" /></td>

      <td><input name="c_q2_3" type="text" size="15" /></td>
      <td><input name="c_q2_4" type="text" size="15" /></td>
      <td><input name="c_q2_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>Q3</td>
      <td><input name="c_q3_1" type="text" size="15" /></td>
      <td><input name="c_q3_2" type="text" size="15" /></td>
      <td><input name="c_q3_3" type="text" size="15" /></td>
      <td><input name="c_q3_4" type="text" size="15" /></td>
      <td><input name="c_q3_5" type="text" size="15" /></td>
    </tr>
    <tr>
      <td>average</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>M</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Mc</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>%difference</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="344" height="77" border="1" align="center">
    <tr>
      <td align="center"><span class="STYLE10 STYLE2">Manchanical QA </span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="426" height="370" border="1" align="center">
    <tr>
      <td height="93" colspan="2" align="left"><div align="center">
        <p align="left" class="STYLE2">Laser Position </p>
        <p align="center" class="STYLE2"> <span class="STYLE3">Gantry=0 Coll=0 </span></p>
      </div></td>
    </tr>
    <tr>
      <td width="206" height="43" align="center"><div align="center">Left Wall<span class="STYLE5"> <span class="STYLE6">Vertical</span> </span></div></td>
      <td width="204"><label>
        <input type="text" name="lwv" />
      </label></td>
    </tr>
    <tr>
      <td height="51"><div align="center">Right Wall Vertical</div></td>
      <td><label>
        <input type="text" name="rwv" />
      </label></td>
    </tr>
    <tr>
      <td><div align="center">Left Wall Horizontal </div></td>
      <td><label>
        <input type="text" name="lwh" />
      </label></td>
    </tr>
    <tr>
      <td height="71"><div align="center">Right Wall Horizona<span class="STYLE4">l </span></div></td>
      <td>        <label>
        <div align="left">
          <input type="text" name="rwh" />
        </div>
          </label>      </td>
    </tr>
    <tr>
      <td><div align="center">Sagittal</div></td>
      <td><label>
        <input type="text" name="sagittal" />
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="418" height="364" border="1" align="center">
    <tr>
      <td colspan="2"><span class="STYLE2">ODI vs Light Field Isocenter </span></td>
    </tr>
    <tr>
      <td width="200">Gantry Angle </td>
      <td width="209">ODI Reading at IC </td>
    </tr>
    <tr>
      <td>0</td>
      <td><label>
        <input type="text" name="odi1" />
      </label></td>
    </tr>
    <tr>
      <td>90</td>
      <td><label>
        <input type="text" name="odi2" />
      </label></td>
    </tr>
    <tr>
      <td>270</td>
      <td><label>
        <input type="text" name="odi3" />
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="445" height="433" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Centering of Light Field Cross-Hair </span></td>
    </tr>
    <tr>
      <td width="200">Gantry Angle </td>
      <td width="209">Distance From IC in mm </td>
    </tr>
    <tr>
      <td>0</td>
      <td><label>
        <input type="text" name="distance1" />
      </label></td>
    </tr>
    <tr>
      <td>90</td>
      <td><label>
        <input type="text" name="distance2" />
      </label></td>
    </tr>
    <tr>
      <td height="69">270</td>
      <td><label>
        <input type="text" name="distance3" />
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="606" height="438" border="1" align="center">
    <tr>
      <td colspan="2"><div align="center" class="STYLE2">
        <div align="left">Gantry and Collimator Angles vs Readout </div>
      </div></td>
    </tr>
    <tr>
      <td width="203">Setting</td>
      <td width="206">Digital Readout </td>
    </tr>
    <tr>
      <td>Gantry=0</td>
      <td><label>
        <input type="text" name="dr1" />
      </label></td>
    </tr>
    <tr>
      <td>Gantry=90</td>
      <td><label>
        <input type="text" name="dr2" />
      </label></td>
    </tr>
    <tr>
      <td>Gantry=270</td>
      <td><label>
        <input type="text" name="dr3" />
      </label></td>
    </tr>
    <tr>
      <td>Collimator=0</td>
      <td><label>
        <input type="text" name="dr4" />
      </label></td>
    </tr>
    <tr>
      <td>Collimator=90</td>
      <td><label>
        <input type="text" name="dr5" />
      </label></td>
    </tr>
    <tr>
      <td>Collimator=270</td>
      <td><label>
        <input type="text" name="dr6" />
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="832" height="433" border="1" align="center">
    <tr>
      <td colspan="3" align="center"><div align="center" class="STYLE2">
        <div align="left">Optical Field Size vs Digital Readout </div>
      </div></td>
    </tr>
    <tr>
      <td width="225">Digital</td>
      <td colspan="2"><div align="center" class="STYLE2">Measured Field Size </div></td>
    </tr>
    <tr>
      <td>x=5.0cm</td>
      <td width="278"><label>x1=
          <input type="text" name="x1a" />
      </label></td>
      <td width="244">x2=
      <input type="text" name="x2a" /></td>
    </tr>
    <tr>
      <td>x=10.0cm</td>
      <td>x1=
      <input type="text" name="x1b" /></td>
      <td>x2=
      <input type="text" name="x2b" /></td>
    </tr>
    <tr>
      <td>x=20.0.cm</td>
      <td>x1=
      <input type="text" name="x1c" /></td>
      <td>x2=
      <input type="text" name="x2c" /></td>
    </tr>
    <tr>
      <td>y=5.0cm</td>
      <td>y1=
      <input type="text" name="y1a" /></td>
      <td>y2=
      <input type="text" name="y2a" /></td>
    </tr>
    <tr>
      <td>y=10.0cm</td>
      <td>y1=
      <input type="text" name="y1b" /></td>
      <td>y2=
      <input type="text" name="y2b" /></td>
    </tr>
    <tr>
      <td>y=20.0cm</td>
      <td>y1=
      <input type="text" name="y1c" /></td>
      <td>y2=
      <input type="text" name="y2c" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="453" height="205" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Door and Key Interlock </span></td>
    </tr>
    <tr>
      <td width="164">Door Status </td>
      <td width="273">
        <select name="door_status"> 
		<option value="YES">YES</option>
		<option value="NO">NO</option>
  		</select>
    </tr>
    <tr>
      <td>Key Status </td>
      <td><label>
        <span class="STYLE4">
      	<select name="key_status"> 
		<option value="YES">YES</option>
		<option value="NO">NO</option>
  		</select>
      </span>(Y/N)</label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="452" height="149" border="1" align="center">
    <tr>
      <td colspan="2" align="center"><span class="STYLE2">Accessory Position and Latching </span></td>
    </tr>
    <tr>
      <td width="242">Wedge</td>
      <td width="240"><label>
        <select name="wedge">
          <option value="15">15</option>
          <option value="30">30</option>
          <option value="45">45</option>
          <option value="60">60</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Cone</td>
      <td><label>
        <select name="cone">
          <option value="6*6">6*6</option>
          <option value="10*10">10*10</option>
          <option value="15*15">15*15</option>
          <option value="20*20">20*20</option>
          <option value="25*25">25*25</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Block</td>
      <td><label>
        <select name="block">
          <option value=" "> </option>
          <option value="N">N</option>
          <option value="Y">Y</option>
        </select>
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="473" height="211" border="1" align="center">
    <tr>
      <td height="99" colspan="2" align="center"><p class="STYLE2">BB Tray Alignment</p>
      <p class="STYLE2">(Distance off relative to wires) </p></td>
    </tr>
    <tr>
      <td width="164"><span class="STYLE2">Cross-line</span></td>
      <td width="293"><label>
        <input type="text" name="cross_line" />
      </label></td>
    </tr>
    <tr>
      <td><span class="STYLE2">In-line</span></td>
      <td><label>
        <input type="text" name="in_line" />
      </label></td>
    </tr>
  </table>
       <p>&nbsp;</p>
       <table width="474" height="183" border="1" align="center">
         <tr>
           <td colspan="2" align="center" valign="middle" class="STYLE2">PSA Position Indicator (Digital Readout vs Floor) </td>
         </tr>
         <tr>
           <td width="161" class="STYLE7">0</td>
           <td width="297" class="STYLE7"><label>
             <input type="text" name="psa1" />
           </label></td>
         </tr>
         <tr>
           <td class="STYLE7">27</td>
           <td class="STYLE7"><input type="text" name="psa2" /></td>
         </tr>
         <tr>
           <td class="STYLE7">90</td>
           <td class="STYLE7"><input type="text" name="psa3" /></td>
         </tr>
       </table>
       <p>&nbsp;</p>
       <p>
         <label>         </label>
         <label></label>
       </p>
  <p class="STYLE7">
  <td height="99" colspan="2" align="center">
    <label>
    <textarea name="comment" cols="50" rows="8" class="STYLE4" al="al">Please comment here.</textarea>
    </label>
	</td>
  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
  
  <p align="right">	
    <input type="submit" value="SUBMIT"  style="width:25%; float: right;"/>
  </p>
  <p>&nbsp;</p>

</form>
<?php
display_footer();
?>