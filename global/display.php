<?php

function start_html($title="", $subtitle="") {
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Hosital of University of Chiago</title>
	<meta name="Description" content="Max Design - standards based web design, development and training" />
	<meta name="robots" content="all, index, follow" />
	<meta name="distribution" content="global" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/sample.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection"/>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
  <script type="text/javascript" src="plotJavascript/js/highcharts.js"></script>
  <script type="text/javascript" src="plotJavascript/js/modules/exporting.js"></script>
	<script type="text/javascript" language="javascript" src="js/calcFunctions.js"></script>
	<script type="text/javascript" language="javascript" src="js/renderHighCharts.js"></script>
</head>
<body>
';
}

function display_footer() {
echo '<div id="footer-container">
<div id="footer">Copyright &copy; Rodney D. Wiersma, 2012</div>
</div>
</div>
</div>
</body>
</html>';
}

?>