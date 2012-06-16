<?php

function escape_output($input) {
  return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
}

function start_html($user, $database, $title="UCMC Radiation Oncology QA", $subtitle="", $status="") {
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>'.escape_output($title).($subtitle != "" ? " - ".$subtitle : "").'</title>
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="css/linac-qa.css" type="text/css" />
	<!--<link rel="stylesheet" href="css/sample.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection"/>-->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
  <script type="text/javascript" src="js/highcharts.js"></script>
  <script type="text/javascript" src="js/exporting.js"></script>
	<script type="text/javascript" language="javascript" src="js/calcFunctions.js"></script>
	<script type="text/javascript" language="javascript" src="js/renderHighCharts.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" language="javascript" src="js/loadInterface.js"></script>
</head>
<body>
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a href="./index.php" class="brand">UCMC Equipment QA</a>
        <div class="nav-collapse">
          <ul class="nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Linac
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li>Stuff here.</li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  CT
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li>Stuff here.</li>
                </ul>
              </li>
          </ul>
          <ul class="nav pull-right">
            <li class="dropdown">
';
  if ($user->loggedIn($database)) {
    echo '              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Charles Guo<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <a href="/profile.php">Profile</a>
                <a href="/logout.php">Sign out</a>
              </ul>
';
  } else {
    echo '              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in<b class="caret"></b></a>
              <ul class="dropdown-menu">
';
    display_login_form();
    echo '              </ul>
            </li>
            <li>
              <a href="register.php">Register</a>
';
  }
  echo '            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
';
  if ($status != "") {
    echo '<div class="alert">
  <button class="close" data-dismiss="alert" href="#">×</button>
  '.escape_output($status).'
</div>
';
  }
}

function display_login_form() {
  echo '<form accept-charset="UTF-8" action="/login.php" method="post">
  <label for="Email">Email</label>
  <input id="username" name="username" size="30" type="text" />
  <label for="password">Password</label>
  <input id="password" name="password" size="30" type="password" />
  <input class="btn btn-small btn-primary" name="commit" type="submit" value="Sign in" />
</form>
';
}

function display_footer() {
  echo '<div id="footer-container">
<div id="footer">Copyright &copy; Rodney D. Wiersma, 2012</div>
</div>
</div>
</div>
</div>
</body>
</html>';
}

?>