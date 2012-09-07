<?php

function humanize($str) {
  $str = trim(strtolower($str));
  $str = preg_replace('/_/', ' ', $str);
  $str = preg_replace('/[^a-z0-9\s+]/', '', $str);
  $str = preg_replace('/\s+/', ' ', $str);
  $str = explode(' ', $str);

  $str = array_map('ucwords', $str);

  return implode(' ', $str);
}

function format_mysql_timestamp($date) {
  return date('n/j/Y', strtotime($date));
}

function escape_output($input) {
  if ($input == '' || $input == 'NULL') {
    return '';
  }
  return htmlspecialchars($input, ENT_QUOTES, "UTF-8");
}

function redirect_to($redirect_array) {
  $location = (isset($redirect_array['location'])) ? $redirect_array['location'] : 'index.php';
  $status = (isset($redirect_array['status'])) ? $redirect_array['status'] : '';
  $class = (isset($redirect_array['class'])) ? $redirect_array['class'] : '';
  
  $redirect = "Location: ".$location;
  if ($status != "") {
    if (strpos($location, "?") === FALSE) {
      $redirect .= "?status=".$status."&class=".$class;
    } else {
      $redirect .= "&status=".$status."&class=".$class;
    }
  }
  header($redirect);
}

function display_error($title="Error", $text="An unknown error occurred. Please try again.") {
  echo "<h1>".escape_output($title)."</h1>
  <p>".escape_output($text)."</p>";
}

function start_html($database, $user, $title="UC Medicine QA", $subtitle="", $status="", $statusClass="") {
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>'.escape_output($title).($subtitle != "" ? " - ".escape_output($subtitle) : "").'</title>
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" />
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" href="css/jquery.dataTables.css" type="text/css" />
	<link rel="stylesheet" href="css/linac-qa.css" type="text/css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/d3.v2.min.js"></script>
  <script type="text/javascript" src="js/d3-helpers.js"></script>
  <script type="text/javascript" src="js/highcharts.js"></script>
  <script type="text/javascript" src="js/exporting.js"></script>
	<script type="text/javascript" language="javascript" src="js/calcFunctions.js"></script>
	<script type="text/javascript" language="javascript" src="js/renderHighCharts.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" language="javascript" src="js/loadInterface.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a href="./index.php" class="brand">UC Medicine QA</a>
        <div class="nav-collapse">
          <ul class="nav">
';
  if ($user->loggedIn($database)) {
    $forms = $database->stdQuery("SELECT `id`, `name` FROM `forms` ORDER BY `id` ASC");
    while ($form = mysqli_fetch_assoc($forms)) {
      echo '              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  '.escape_output($form['name']).'
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="form_entry.php?action=new&form_id='.intval($form['id']).'">Submit new record</a></li>
                  <li><a href="form_entry.php?action=index&form_id='.intval($form['id']).'">View history</a></li>
                  <li><a href="graph.php?action=show&form_id='.intval($form['id']).'">Plot history</a></li>
                </ul>
              </li>
              <li class="divider-vertical"></li>
';
    }
  }
  if ($user->isAdmin($database)) {
  echo '              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Admin
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="form.php">Forms</a></li>
                  <li><a href="machine_type.php">Machine Types</a></li>
                  <li><a href="machine.php">Machines</a></li>
                  <li><a href="facility.php">Facilities</a></li>
                  <li><a href="user.php">Users</a></li>
                  <li><a href="backup.php">Backup</a></li>
                </ul>
              </li>
              <li class="divider-vertical"></li>
';
  }
  echo '          </ul>
          <ul class="nav pull-right">
            <li class="divider-vertical"></li>
            <li class="dropdown">
';
  if ($user->loggedIn($database)) {
    echo '              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i>'.escape_output($user->name).'<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <a href="/user.php?action=show&id='.intval($user->id).'">Profile</a>
                <a href="/user.php?action=edit&id='.intval($user->id).'">User Settings</a>
                <a href="/logout.php">Sign out</a>
              </ul>
';
  } else {
    echo '              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in<b class="caret"></b></a>
              <ul class="dropdown-menu">
';
    display_login_form();
    echo '              </ul>
';
  }
  echo '            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
';
  if ($status != "") {
    echo '<div class="alert alert-'.escape_output($statusClass).'">
  <button class="close" data-dismiss="alert" href="#">×</button>
  '.escape_output($status).'
</div>
';
  }
}

function display_login_form() {
  echo '<form id="login_form" accept-charset="UTF-8" action="/login.php" method="post">
  <label for="Email">Email</label>
  <input id="username" name="username" size="30" type="email" />
  <label for="password">Password</label>
  <input id="password" name="password" size="30" type="password" />
  <input class="btn btn-small btn-primary" name="commit" type="submit" value="Sign in" />
</form>
';
}

function display_month_year_dropdown($select_id="", $select_name_prefix="form_entry", $selected=array(1,1)) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[qa_month]'>
";
  for ($month_i = 1; $month_i <= 12; $month_i++) {
    echo "  <option value='".$month_i."'".(($selected[0] === $month_i) ? "selected='selected'" : "").">".htmlentities(date('M', mktime(0, 0, 0, $month_i, 1, 2000)), ENT_QUOTES, "UTF-8")."</option>
";
  }
echo "</select>
<select id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[qa_year]'>
";
  for ($year = 2007; $year <= intval(date('Y', time())); $year++) {
    echo "  <option value='".$year."'".(($selected[1] === $year) ? "selected='selected'" : "").">".$year."</option>
";
  }
echo "</select>
";
}

function display_ok_notok_dropdown($select_id="ok_notok", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
                    <option value=1".((intval($selected) == 1) ? " selected='selected'" : "").">OK</option>
                    <option value=0".((intval($selected) == 0) ? " selected='selected'" : "").">NOT OK</option>
</select>
";
}

function display_facilities($database, $user) {
  //lists all facilities.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
";
  $facilities = $database->stdQuery("SELECT `id`, `name` FROM `facilities` ORDER BY `id` ASC");
  while ($facility = mysqli_fetch_assoc($facilities)) {
    echo "    <tr>
      <td><a href='facility.php?action=edit&id=".intval($facility['id'])."'>".escape_output($facility['name'])."</a></td>
    </tr>
";
    }
  echo "  </tbody>
</table>
";
}

function display_facility_dropdown($database, $select_id="facility_id", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
";
  $facilities = $database->stdQuery("SELECT `id`, `name` FROM `facilities`");
  while ($facility = mysqli_fetch_assoc($facilities)) {
    echo "  <option value='".intval($facility['id'])."'".(($selected == intval($facility['id'])) ? "selected='selected'" : "").">".escape_output($facility['name'])."</option>
";
  }
  echo "</select>
";
}

function display_facility_edit_form($database, $user, $id=false) {
  // displays a form to edit facility type parameters.
  if (!($id === false)) {
    $facilityObject = $database->queryFirstRow("SELECT * FROM `facilities` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$facilityObject) {
      $id = false;
    }
  }
  echo "<form action='facility.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
".(($id === false) ? "" : "<input type='hidden' name='facility[id]' value='".intval($id)."' />")."
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='facility[name]'>Name</label>
      <div class='controls'>
        <input name='facility[name]' type='text' class='input-xlarge' id='facility[name]'".(($id === false) ? "" : " value='".escape_output($facilityObject['name'])."'").">
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add Facility" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>
</form>
";
}

function display_register_form($database, $action=".") {
  echo '    <form class="form-horizontal" name="register" method="post" action="'.$action.'">
      <fieldset>
        <legend>Sign up</legend>
        <div class="control-group">
          <label class="control-label">Name</label>
          <div class="controls">
            <input type="text" class="" name="name" id="name" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Email</label>
          <div class="controls">
            <input type="text" class="" name="email" id="email" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Password</label>
          <div class="controls">
            <input type="password" class="" name="password" id="password" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Confirm password</label>
          <div class="controls">
            <input type="password" class="" name="password_confirmation" id="password_confirmation" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">Facility</label>
          <div class="controls">
';
  echo display_facility_dropdown($database);
  echo '          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
      </fieldset>
    </form>
';
}

function display_ionization_chamber_dropdown($select_id = "form_entry_form_values_ionization_chamber", $select_name_prefix="form_entry[form_values]", $selected="") {
  echo "<select class='span12' id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[ionization_chamber]'>
  <option value='Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)'".(($selected === 'Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)') ? "selected='selected'" : "").">Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)</option>
  <option value='Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)'".(($selected === 'Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)') ? "selected='selected'" : "").">Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)</option>
</select>
";
}

function display_electrometer_dropdown($select_id = "form_entry_form_values_electrometer", $select_name_prefix="form_entry[form_values]", $selected="") {
  echo "<select class='span12' id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[electrometer]'>
  <option value='Keithley Model 614 (S/N 42215, Kelec 0.995)'".(($selected === 'Keithley Model 614 (S/N 42215, Kelec 0.995)') ? "selected='selected'" : "").">Keithley Model 614 (S/N 42215, Kelec 0.995)</option>
  <option value='SI CDX 2000B #1 (S/N J073443, Kelec 1.000)'".(($selected === 'SI CDX 2000B #1 (S/N J073443, Kelec 1.000)') ? "selected='selected'" : "").">SI CDX 2000B #1 (S/N J073443, Kelec 1.000)</option>
  <option value='SI CDX 2000B #2 (S/N J073444, Kelec 1.000)'".(($selected === 'SI CDX 2000B #2 (S/N J073444, Kelec 1.000)') ? "selected='selected'" : "").">SI CDX 2000B #2 (S/N J073444, Kelec 1.000)</option>
</select>
";  
}

function display_machine_types($database, $user) {
  //lists all machine types.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
";
  $machine_types = $database->stdQuery("SELECT `id`, `name`, `description` FROM `machine_types` ORDER BY `id` ASC");
  while ($machine_type = mysqli_fetch_assoc($machine_types)) {
    echo "    <tr>
      <td><a href='machine_type.php?action=show&id=".intval($machine_type['id'])."'>".escape_output($machine_type['name'])."</a></td>
      <td>".escape_output($machine_type['description'])."</td>
    </tr>
";
    }
  echo "  </tbody>
</table>
";
}

function display_machine_type_dropdown($database, $select_id="machine_type_id", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
";
  $machineTypes = $database->stdQuery("SELECT `id`, `name` FROM `machine_types`");
  while ($machineType = mysqli_fetch_assoc($machineTypes)) {
    echo "  <option value='".intval($machineType['id'])."'".(($selected == intval($machineType['id'])) ? "selected='selected'" : "").">".escape_output($machineType['name'])."</option>
";
  }
  echo "</select>
";
}

function display_machine_type_edit_form($database, $user, $id=false) {
  // displays a form to edit machine type parameters.
  if (!($id === false)) {
    $machineTypeObject = $database->queryFirstRow("SELECT * FROM `machine_types` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$machineTypeObject) {
      $id = false;
    }
  }
  echo "<form action='machine_type.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='machine_type[name]'>Name</label>
      <div class='controls'>
        <input name='machine_type[name]' type='text' class='input-xlarge' id='machine_type[name]'".(($id === false) ? "" : " value='".escape_output($machineTypeObject['name'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine_type[description]'>Description</label>
      <div class='controls'>
        <input name='machine_type[description]' type='text' class='input-xlarge' id='machine_type[description]'".(($id === false) ? "" : " value='".escape_output($machineTypeObject['description'])."'").">
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add Machine Type" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>
</form>
";
}

function display_machine_type_info($database, $user, $machine_type_id, $graph_div_prefix = "machine_type_info") {
  $machineTypeObject = $database->queryFirstRow("SELECT * FROM `machine_types` WHERE `id` = ".intval($machine_type_id)." LIMIT 1");
  if (!$machineTypeObject) {
    echo "This machine_type does not exist. Please select another machine_type and try again.";
  } else {
    $machines = $database->stdQuery("SELECT `id`, `name` FROM `machines` WHERE `facility_id` = ".intval($user->facility_id)." AND `machine_type_id` = ".intval($machineTypeObject['id']));
    while ($machine = mysqli_fetch_assoc($machines)) {
      echo "<h2>".escape_output($machine['name'])."</h2>
";
      display_machine_info($database, $user, $machine['id'], $graph_div_prefix."_".$machine['id']);
    }
  }
}

function display_machines($database, $user) {
  //lists all machines.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Facility</th>
    </tr>
  </thead>
  <tbody>
";
  $machines = $database->stdQuery("SELECT `id`, `name`, `machine_type_id`, `facility_id` FROM `machines` WHERE `facility_id` = ".intval($user->facility_id)." ORDER BY `id` ASC");
  while ($machine = mysqli_fetch_assoc($machines)) {
    $facility = $database->queryFirstValue("SELECT `name` FROM `facilities` WHERE `id` = ".intval($machine['facility_id'])." LIMIT 1");
    $type = $database->queryFirstValue("SELECT `name` FROM `machine_types` WHERE `id` = ".intval($machine['machine_type_id'])." LIMIT 1");
    if (!$facility) {
      $facility = "None";
    }
    if (!$type) {
      $type = "None";
    }
    echo "    <tr>
      <td><a href='machine.php?action=show&id=".intval($machine['id'])."'>".escape_output($machine['name'])."</a></td>
      <td>".escape_output($type)."</td>
      <td>".escape_output($facility)."</td>
    </tr>
";
  }
  echo "  </tbody>
</table>
";
}

function display_machine_dropdown($database, $user, $select_id="machine_id", $selected=0, $machine_type=false) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
";
  $machineTypeFilter = intval($machine_type) ? " && `machine_type_id` = ".intval($machine_type) : "";
  $machines = $database->stdQuery("SELECT `id`, `name` FROM `machines` WHERE `facility_id` = ".intval($user->facility_id).$machineTypeFilter." ORDER BY `name` ASC");
  while ($machine = mysqli_fetch_assoc($machines)) {
    echo "  <option value='".intval($machine['id'])."'".(($selected == intval($machine['id'])) ? "selected='selected'" : "").">".escape_output($machine['name'])."</option>
";
  }
  echo "</select>
";
}

function display_machine_edit_form($database, $user, $id=false) {
  // displays a form to edit machine type parameters.
  if (!($id === false)) {
    $machineObject = $database->queryFirstRow("SELECT * FROM `machines` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$machineObject) {
      $id = false;
    }
  }
  $facility = $database->queryFirstValue("SELECT `name` FROM `facilities` WHERE `id` = ".intval($user->facility_id)." LIMIT 1");
  if (!$facility) {
    $facility = "None";
  }
  
  echo "<form action='machine.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
".(($id === false) ? "" : "<input type='hidden' name='machine[id]' value='".intval($id)."' />")."
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='machine[name]'>Name</label>
      <div class='controls'>
        <input name='machine[name]' type='text' class='input-xlarge' id='machine[name]'".(($id === false) ? "" : " value='".escape_output($machineObject['name'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine[facility_id]'>Facility</label>
      <div class='controls'>
";
  display_machine_type_dropdown($database, "machine[machine_type_id]", ($id === false) ? 0 : $machineObject['machine_type_id']);
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine[facility_id]'>Facility</label>
      <div class='controls'>
        <input name='machine[facility_id]' value='".intval($user->facility_id)."' type='hidden' />
        <span class='input-xlarge uneditable-input'>".escape_output($facility)."</span>
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add Machine" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>
</form>
";
}

function display_machine_info($database, $user, $machine_id, $graph_div_prefix = "machine_info") {
  $machineObject = $database->queryFirstRow("SELECT * FROM `machines` WHERE `id` = ".intval($machine_id)." LIMIT 1");
  if (!$machineObject) {
    echo "This machine does not exist. Please select another machine and try again.";
  } else {
    $i = 0;
    $machine_fields = $database->stdQuery("SELECT `form_fields`.`id`, `form_fields`.`name` FROM `form_entries` LEFT OUTER JOIN `form_fields` ON `form_fields`.`form_id` = `form_entries`.`form_id` WHERE `form_entries`.`machine_id` = ".intval($machine_id)." GROUP BY `form_fields`.`id` ORDER BY `form_fields`.`name` ASC");
    while ($machine_field = mysqli_fetch_assoc($machine_fields)) {
      $field_values = $database->queryAssoc("SELECT `form_values`.`value`, `form_entries`.`created_at` AS `date` FROM `form_values` LEFT OUTER JOIN `form_entries` ON `form_values`.`form_entry_id` = `form_entries`.`id` WHERE `form_values`.`form_field_id` = ".intval($machine_field['id'])." ORDER BY `form_entries`.`created_at` ASC");
      if ($field_values) {
        $field_strings = array();
        $field_labels = array();
      
        foreach ($field_values as $key => $field_value) {
          if (is_numeric($field_value[0])) {
            $field_strings[] = "{x: '".date('m/d/y', strtotime($field_value[1]))."', y: ".escape_output($field_value[0])."}";
          }
        }
        if (count($field_strings) > 1) {
          echo "<span id='".escape_output($graph_div_prefix)."_".intval($i)."'></span>
<script type='text/javascript'>
var data = [".implode(",", $field_strings)."];
displayFormFieldLineGraph(data, '".humanize($machine_field['name'])."', '".escape_output($graph_div_prefix)."_".intval($i)."');
</script>
";
          $i++;
        }
      }
    }
  }
}

function display_forms($database, $user) {
  //lists all forms.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Machine Type</th>
    </tr>
  </thead>
  <tbody>
";
  $forms = $database->stdQuery("SELECT `forms`.`id`, `forms`.`name`, `forms`.`description`, `machine_types`.`name` AS `machine_type_name` FROM `forms` LEFT OUTER JOIN `machine_types` ON `forms`.`machine_type_id` = `machine_types`.`id` ORDER BY `forms`.`id` ASC");
  while ($form = mysqli_fetch_assoc($forms)) {
    echo "    <tr>
      <td><a href='form.php?action=edit&id=".intval($form['id'])."'>".escape_output($form['name'])."</a></td>
      <td>".escape_output($form['description'])."</td>
      <td>".escape_output($form['machine_type_name'])."</td>
    </tr>
";
  }
  echo "  </tbody>
</table>
";
}

function display_form_field_graph($database, $form_field) {
  $field_values = $database->queryAssoc("SELECT * FROM `form_values` WHERE `form_field_id` = ".intval($form_field['id']));
}

function display_form_history($database, $user, $form_id) {
  $formObject = $database->queryFirstRow("SELECT * FROM `forms` WHERE `id` = ".intval($form_id)." LIMIT 1");
  if (!$formObject) {
    echo "This form does not exist. Please select another form and try again.";
  } else {
    $form_fields = $database->stdQuery("SELECT `id`, `name` FROM `form_fields` WHERE `form_id` = ".intval($form_id));
    while ($form_field = mysqli_fetch_assoc($form_fields)) {
      display_form_field_graph($database, $form_field);
    }
  }
}

function display_form_edit_form($database, $user, $id=false) {
  // displays a form to edit form parameters.
  if (!($id === false)) {
    $formObject = $database->queryFirstRow("SELECT * FROM `forms` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$formObject) {
      $id = false;
    }
  }
  echo "<form action='form.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
  <fieldset>
".(($id === false) ? "" : "<input type='hidden' name='form[id]' value='".intval($id)."' />")."
    <div class='control-group'>
      <label class='control-label' for='form[name]'>Name</label>
      <div class='controls'>
        <input name='form[name]' type='text' class='input-xlarge' id='form[name]'".(($id === false) ? "" : " value='".escape_output($formObject['name'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[description]'>Description</label>
      <div class='controls'>
        <input name='form[description]' type='text' class='input-xlarge' id='form[description]'".(($id === false) ? "" : " value='".escape_output($formObject['description'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[machine_type_id]'>Machine Type</label>
      <div class='controls'>
        ";
  display_machine_type_dropdown($database, "form[machine_type_id]", (($id === false) ? 0 : intval($formObject['machine_type_id'])));
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[js]'>Javascript</label>
      <div class='controls'>
        <textarea class='input-xlarge' id='form[js]' name='form[js]' cols='500' rows='10'>".(($id === false) ? "" : escape_output($formObject['js']))."</textarea>
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[php]'>PHP</label>
      <div class='controls'>
        <textarea class='input-xlarge' id='form[php]' name='form[php]' cols='500' rows='10'>".(($id === false) ? "" : escape_output($formObject['php']))."</textarea>
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Create form" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>
</form>
";
}

function display_form_entries($database, $user, $form_id=false) {
  //lists all form_entries.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Machine</th>
      <th>User</th>
      <th>QA Month</th>
      <th>Submitted on</th>
      <th>Approved By</th>
      <th>Approved On</th>
      <th>Comments</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
";
  if (is_numeric($form_id)) {
    $form_id = intval($form_id);
  } else {
    $form_id = "`form_entries`.`form_id`";
  }
  $form_entries = $database->stdQuery("SELECT `form_entries`.`id`, `form_entries`.`machine_id`, `machines`.`name` AS `machine_name`, `form_entries`.`user_id`, `users`.`name` AS `user_name`, `created_at`, `qa_month`, `qa_year`, `approved_on`, `approved_user_id`, `approved_user`.`name` AS `approved_user_name`, `comments` FROM `form_entries` LEFT OUTER JOIN `forms` ON `forms`.`id` = `form_entries`.`form_id` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`user_id` LEFT OUTER JOIN `users` AS `approved_user` ON `approved_user`.`id` = `form_entries`.`approved_user_id` WHERE `form_entries`.`form_id` = ".$form_id." ORDER BY `id` ASC");
  while ($form_entry = mysqli_fetch_assoc($form_entries)) {
    if ($form_entry['approved_on'] == '') {
      $row_class = " class='error'";
      $approval_user = "Unapproved";
      $approval_date = "";
    } else {
      $row_class = "";
      $approval_user = "<a href='user.php?action=show&id=".intval($form_entry['approved_user_id'])."'>".escape_output($form_entry['approved_user_name'])."</a>";
      $approval_date = escape_output(format_mysql_timestamp($form_entry['approved_on']));
    }
    echo "    <tr".$row_class.">
      <td><a href='machine.php?action=show&id=".intval($form_entry['machine_id'])."'>".escape_output($form_entry['machine_name'])."</a></td>
      <td><a href='user.php?action=show&id=".intval($form_entry['user_id'])."'>".escape_output($form_entry['user_name'])."</a></td>
      <td>".intval($form_entry['qa_year'])."/".((intval($form_entry['qa_month']) >= 10) ? "" : "0").intval($form_entry['qa_month'])."</td>
      <td>".escape_output(format_mysql_timestamp($form_entry['created_at']))."</td>
      <td>".$approval_user."</td>
      <td>".$approval_date."</td>
      <td>".escape_output($form_entry['comments'])."</td>
      <td><a href='form_entry.php?action=edit&id=".intval($form_entry['id'])."'>Edit</a></td>
      <td></td>
    </tr>
";
  }
  echo "  </tbody>
</table>
";
}

function display_form_entry_edit_form($database, $user, $id=false, $form_id=false) {
  // displays a form to edit form parameters.
  if (!($id === false)) {
    $formEntryObject = $database->queryFirstRow("SELECT * FROM `form_entries` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$formEntryObject) {
      $id = false;
      $form_id = false;
    } else {
      $form_id = $formEntryObject['form_id'];
    }
  }
  if (!($form_id === false)) {
    $formObject = $database->queryFirstRow("SELECT * FROM `forms` WHERE `id` = ".intval($form_id)." LIMIT 1");
    if (!$formObject) {
      $form_id = false;
    }
  }
  if ($form_id === false) {
    echo "Please specify a valid form entry ID or form ID.";
    return;
  }
  if (!($id === false)) {
    $formValues = $database->stdQuery("SELECT * FROM `form_values` WHERE `form_entry_id` = ".intval($id));
    while ($formValue = mysqli_fetch_assoc($formValues)) {
      $formField = $database->queryFirstValue("SELECT `name` FROM `form_fields` WHERE `id` = ".intval($formValue['form_field_id'])." LIMIT 1");
      if ($formField) {
        $formEntryObject['form_values'][$formField] = $formValue['value'];
      }
    }
  }
  if ($formObject['php'] != '' && $formObject['php'] != 'NULL') {
    eval($formObject['php']);
  }
  if ($formObject['js'] != '' && $formObject['js'] != 'NULL') {
    echo "<script type='text/javascript'>
  ".$formObject['js']."
</script>
";
  }
}

function display_users($database, $user) {
  //lists all users.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Facility</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
";
  if ($user->isAdmin($database)) {
    $users = $database->stdQuery("SELECT `users`.`id`, `users`.`name`, `users`.`email`, `users`.`userlevel`, `facilities`.`name` AS `facility_name` FROM `users` LEFT OUTER JOIN `facilities` ON `users`.`facility_id` = `facilities`.`id` ORDER BY `users`.`name` ASC");
  } else {
    $users = $database->stdQuery("SELECT `users`.`id`, `users`.`name`, `users`.`email`, `users`.`userlevel`, `facilities`.`name` AS `facility_name` FROM `users` LEFT OUTER JOIN `facilities` ON `users`.`facility_id` = `facilities`.`id` WHERE `users`.`facility_id` = ".intval($user->facility_id)." ORDER BY `users`.`name` ASC");
  }
  while ($thisUser = mysqli_fetch_assoc($users)) {
    echo "    <tr>
      <td><a href='user.php?action=show&id=".intval($thisUser['id'])."'>".escape_output($thisUser['name'])."</a></td>
      <td>".escape_output($thisUser['email'])."</td>
      <td>".escape_output(convert_userlevel_to_text($thisUser['userlevel']))."</td>
      <td>".escape_output($thisUser['facility_name'])."</td>
      <td>"; if ($user->isAdmin($database)) { echo "<a href='user.php?action=edit&id=".intval($thisUser['id'])."'>Edit</a>"; } echo "</td>
      <td>"; if ($user->isAdmin($database)) { echo "<a href='user.php?action=delete&id=".intval($thisUser['id'])."'>Delete</a>"; } echo "</td>
    </tr>
";
  }
  echo "  </tbody>
</table>
";
}

function display_userlevel_dropdown($database, $select_id="userlevel", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
";
  for ($userlevel = 0; $userlevel <= 3; $userlevel++) {
    echo "  <option value='".intval($userlevel)."'".(($selected == intval($userlevel)) ? "selected='selected'" : "").">".escape_output(convert_userlevel_to_text($userlevel))."</option>
";
  }
  echo "</select>
";
}

function display_user_edit_form($database, $user, $id=false) {
  // displays a form to edit user parameters.
  if (!($id === false)) {
    $userObject = $database->queryFirstRow("SELECT * FROM `users` WHERE `id` = ".intval($id)." LIMIT 1");
    if (!$userObject) {
      $id = false;
    } elseif (intval($userObject['facility_id']) != $user->facility_id) {
      echo "You may only modify users under your own facility.";
      return;
    }
  }    
  echo "<form action='user.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
".(($id === false) ? "" : "<input type='hidden' name='user[id]' value='".intval($id)."' />")."
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='user[name]'>Name</label>
      <div class='controls'>
        <input name='user[name]' type='text' class='input-xlarge' id='user[name]'".(($id === false) ? "" : " value='".escape_output($userObject['name'])."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='user[password]'>Password</label>
      <div class='controls'>
        <input name='user[password]' type='password' class='input-xlarge' id='user[password]' />
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='user[password_confirmation]'>Confirm Password</label>
      <div class='controls'>
        <input name='user[password_confirmation]' type='password' class='input-xlarge' id='user[password_confirmation]' />
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='user[name]'>Email</label>
      <div class='controls'>
        <input name='user[email]' type='email' class='input-xlarge' id='user[email]'".(($id === false) ? "" : " value='".escape_output($userObject['email'])."'").">
      </div>
    </div>
";
  if ($user->isAdmin($database)) {
    echo "    <div class='control-group'>
      <label class='control-label' for='user[facility_id]'>Facility</label>
      <div class='controls'>
";
  display_facility_dropdown($database, "user[facility_id]", ($id === false) ? 0 : $userObject['facility_id']);
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='user[userlevel]'>Role</label>
      <div class='controls'>
";
  display_userlevel_dropdown($database, "user[userlevel]", ($id === false) ? 0 : intval($userObject['userlevel']));
  echo "      </div>
    </div>
";
    }
  echo "    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add User" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>
</form>
";
}

function display_user_profile($database, $user, $user_id) {
  $userObject = new User($database->queryFirstRow("SELECT * FROM `users` WHERE `id` = ".intval($user_id)." LIMIT 1"));
  $facility = $database->queryFirstValue("SELECT `name` FROM `facilities` WHERE `id` = ".intval($userObject->facility_id)." LIMIT 1");
  $form_entries = $database->stdQuery("SELECT `form_entries`.*, `forms`.`name` AS `form_name`, `machines`.`name` AS `machine_name` FROM `form_entries` 
                                        LEFT OUTER JOIN `forms` ON `forms`.`id` = `form_entries`.`form_id`
                                        LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id`
                                        WHERE `user_id` = ".intval($user_id)." 
                                        ORDER BY `updated_at` DESC");
  echo "<dl class='dl-horizontal'>
    <dt>Email</dt>
    <dd>".escape_output($userObject->email)."</dd>
    <dt>Facility</dt>
    <dd>".escape_output($facility)."</dd>
    <dt>User Role</dt>
    <dd>".escape_output(convert_userlevel_to_text($userObject->userlevel))."</dd>
  </dl>
";
  if (convert_userlevel_to_text($userObject->userlevel) == 'Physicist') {
    $form_approvals = $database->stdQuery("SELECT `form_entries`.`id`, `qa_month`, `qa_year`, `machine_id`, `machines`.`name` AS `machine_name`, `user_id`, `users`.`name` AS `user_name`, `approved_on` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`user_id` WHERE `approved_user_id` = ".intval($userObject->id)." ORDER BY `approved_on` DESC");
    echo "  <h3>Approvals</h3>
  <table class='table table-striped table-bordered dataTable'>
    <thead>
      <tr>
        <th>QA Date</th>
        <th>Machine</th>
        <th>Submitter</th>
        <th>Approval Date</th>
      </tr>
    </thead>
    <tbody>
";
    while ($approval = mysqli_fetch_assoc($form_approvals)) {
      echo "      <tr>
        <td><a href='form_entry.php?action=edit&id=".intval($approval['id'])."'>".escape_output($approval['qa_year']."/".$approval['qa_month'])."</a></td>
        <td><a href='form.php?action=show&id=".intval($approval['machine_id'])."'>".escape_output($approval['machine_name'])."</a></td>
        <td><a href='user.php?action=show&id=".intval($approval['user_id'])."'>".escape_output($approval['user_name'])."</a></td>
        <td>".escape_output(format_mysql_timestamp($approval['approved_on']))."</td>
      </tr>
";
    }
    echo "    </tbody>
  </table>
";
  }
  echo "  <h3>Form Entries</h3>
  <table class='table table-striped table-bordered dataTable'>
    <thead>
      <tr>
        <th>Form</th>
        <th>Machine</th>
        <th>Comments</th>
        <th>QA Date</th>
        <th>Submitted on</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
";
  while ($form_entry = mysqli_fetch_assoc($form_entries)) {
    echo "    <tr>
      <td><a href='form.php?action=show&id=".intval($form_entry['form_id'])."'>".escape_output($form_entry['form_name'])."</a></td>
      <td><a href='form.php?action=show&id=".intval($form_entry['machine_id'])."'>".escape_output($form_entry['machine_name'])."</a></td>
      <td>".escape_output($form_entry['comments'])."</td>
      <td>".escape_output($form_entry['qa_year']."/".$form_entry['qa_month'])."</td>
      <td>".escape_output(format_mysql_timestamp($form_entry['created_at']))."</td>
      <td><a href='form_entry.php?action=edit&id=".intval($form_entry['id'])."'>View</a></td>
    </tr>
";
  }
  echo "    </tbody>
  </table>
";
}

function display_backups($database, $user) {
  //lists all backups.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Requested by</th>
      <th>Path</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
";
  $backups = $database->stdQuery("SELECT * FROM `backups` ORDER BY `created_at` DESC");
  while ($backup = mysqli_fetch_assoc($backups)) {
    $user = $database->queryFirstValue("SELECT `name` FROM `users` WHERE `id` = ".intval($backup['user_id'])." LIMIT 1");
    if (!$user) {
      $user = "None";
    }
    echo "    <tr>
      <td>".escape_output($user)."</td>
      <td><a href='backup.php?action=download&id=".intval($backup['id'])."'>".escape_output(basename($backup['path']))."</a></td>
      <td>".escape_output(date('Y/m/d H:i', strtotime($backup['created_at'])))."</td>
    </tr>
";
  }
  echo "  </tbody>
</table>
<a class='btn btn-primary' href='backup.php?action=create'>Create a backup</a>
";
}

function display_backup_form($database) {
  echo "<form class='form form-horizontal' method='post' action='backup.php'>
  <fieldset>
    <div classs='control-group'>
      <label class='control-label' for=''>Contents</label>
      <div class='controls'>
        <label class='checkbox'>
          <input type='checkbox' name='backup[contents][]' value='database' />
          Database
        </label>
        <label class='checkbox'>
          <input type='checkbox' name='backup[contents][]' value='files' />
          Files
        </label>
      </div>
    </div>
    <div classs='control-group'>
      <label class='control-label' for=''>Save as</label>
      <div class='controls'>
        <label class='checkbox'>
          <input type='checkbox' name='backup[action][]' value='local' />
          File on webserver
        </label>
        <label class='checkbox'>
          <input type='checkbox' name='backup[action][]' value='remote' />
          Downloadable file
        </label>
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>Create backup</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>Go back</a>
    </div>
  </fieldset>
</form>
";
}

function display_history_json($database, $user, $fields = array(), $machines=array()) {
  header('Content-type: application/json');
  $return_array = array();
  
  if (!$user->loggedIn($database)) {
    $return_array['error'] = "You must be logged in to view history data.";
  } elseif (!is_array($fields) || !is_array($machines)) {
    $return_array['error'] = "Please provide a valid list of fields and machines.";  
  } else {
    foreach ($fields as $field) {
      foreach ($machines as $machine) {
        $line_array = array();
        $values = $database->stdQuery("SELECT `form_field_id`, `form_entries`.`machine_id`, `form_entries`.`qa_month`, `form_entries`.`qa_year`, `value` FROM `form_values`
                                    LEFT OUTER JOIN `form_entries` ON `form_entry_id` = `form_entries`.`id`
                                    WHERE `form_field_id` = ".intval($field)." && `machine_id` = ".intval($machine)."
                                    ORDER BY `qa_year` ASC, `qa_month` ASC");
        while ($value = mysqli_fetch_assoc($values)) {
          $line_array[] = array('x' => intval($value['qa_month'])."/".intval($value['qa_year']),
                                  'y' => doubleval($value['value']),
                                  'machine' => intval($value['machine_id']),
                                  'field' => intval($value['form_field_id']));
        }
        if (count($line_array) > 1) {
          $return_array[] = $line_array;
        }
      }
    }
  }
  echo json_encode($return_array);
}

function display_history_plot($database, $user, $form_id) {
  //displays plot for a particular form.
  $formObject = $database->queryFirstRow("SELECT * FROM `forms` WHERE `id` = ".intval($form_id)." LIMIT 1");
  if (!$formObject) {
    echo "The form ID you provided was invalid. Please try again.
";
  } else {
    $formFields = $database->stdQuery("SELECT `id`, `name` FROM `form_fields`
                                        WHERE `form_id` = ".intval($form_id)."
                                        ORDER BY `name` ASC");
    $machines = $database->stdQuery("SELECT `id`, `name` FROM `machines`
                                        WHERE `machine_type_id` = ".intval($formObject['machine_type_id'])."
                                        ORDER BY `name` ASC");
    echo "<div id='vis'></div>
  <form action='#'>
    <input type='hidden' id='form_id' name='form_id' value='".intval($form_id)."' />
    <div class='row-fluid'>
      <div class='span4'>
        <div class='row-fluid'><h3 class='span12' style='text-align:center;'>Machines</h3></div>
        <div class='row-fluid'>
          <select multiple='multiple' id='machines' class='span12' size='10' name='machines[]'>
";
    while ($machine = mysqli_fetch_assoc($machines)) {
      echo "           <option value='".intval($machine['id'])."'>".escape_output($machine['name'])."</option>
";
    }
    echo "         </select>
        </div>
      </div>
      <div class='span4'>
        <div class='row-fluid'><h3 class='span12' style='text-align:center;'>Fields</h3></div>
        <div class='row-fluid'>
          <select multiple='multiple' id='form_fields' class='span12' size='10' name='form_fields[]'>
";
    while ($field = mysqli_fetch_assoc($formFields)) {
      echo "            <option value='".intval($field['id'])."'>".escape_output($field['name'])."</option>
";
    }
    echo "          </select>
        </div>
      </div>
      <div class='span4'>
        <div class='row-fluid'><h3 class='span12' style='text-align:center;'>Time Range</h3></div>
        <div class='row-fluid'>
          <div class='span12' style='text-align:center;'>(Coming soon)</div>
        </div>
      </div>
    </div>
    <div class='row-fluid'>
      <div class='span12' style='text-align:center;'>As a reminder, you can highlight multiple fields by either clicking and dragging, or holding down Control and clicking on the fields you want.</div>
    </div>
    <div class='form-actions'>
      <a class='btn btn-xlarge btn-primary' href='#' onClick='drawLargeD3Plot();'>Redraw Plot</a>
    </div>
  </form>
";
  }
}

function display_footer() {
  echo '    <hr />
  </div>
</body>
</html>';
}

?>