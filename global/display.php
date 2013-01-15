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
  if ($input === '' || $input === 'NULL') {
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
  exit;
}

function display_error($title="Error", $text="An unknown error occurred. Please try again.") {
  echo "<h1>".escape_output($title)."</h1>
  <p>".escape_output($text)."</p>";
}

function start_html($user, $title="UC Medicine QA", $subtitle="", $status="", $statusClass="") {
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n\n".'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>'.escape_output($title).($subtitle != "" ? " - ".escape_output($subtitle) : "").'</title>
  	<link rel="shortcut icon" href="http://ucmcqa.dyndns.org/favicon.ico" />
  	<link rel="stylesheet" href="'.joinPaths(ROOT_URL, "css/bootstrap.min.css").'" type="text/css" />
  	<link rel="stylesheet" href="'.joinPaths(ROOT_URL, "css/bootstrap-responsive.min.css").'" type="text/css" media="all" />
  	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
  	<link rel="stylesheet" href="'.joinPaths(ROOT_URL, "css/jquery.dataTables.css").'" type="text/css" />
    <link rel="stylesheet" href="'.joinPaths(ROOT_URL, "css/linac-qa.css").'" type="text/css" />
    <link rel="stylesheet" href="'.joinPaths(ROOT_URL, "css/print.css").'" type="text/css" media="print" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    <script type="text/javascript" src="'.joinPaths(ROOT_URL, "js/jquery-ui-timepicker-addon.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/jquery.dropdownPlain.js").'"></script>
    <script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/jquery.dataTables.min.js").'"></script>
    <script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/jquery.autosave.js").'"></script>
    <script type="text/javascript" src="'.joinPaths(ROOT_URL, "js/d3.v2.min.js").'"></script>
    <script type="text/javascript" src="'.joinPaths(ROOT_URL, "js/d3-helpers.js").'"></script>
    <script type="text/javascript" src="'.joinPaths(ROOT_URL, "js/highcharts.js").'"></script>
    <script type="text/javascript" src="'.joinPaths(ROOT_URL, "js/exporting.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/calcFunctions.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/renderHighCharts.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/bootstrap.min.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/bootstrap-dropdown.js").'"></script>
  	<script type="text/javascript" language="javascript" src="'.joinPaths(ROOT_URL, "js/loadInterface.js").'"></script>
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
            <ul class="nav">'."\n";
  // display daily, monthly, yearly forms.
  if ($user->loggedIn()) {
    $formTypes = $user->dbConn->stdQuery("SELECT `id`, `name` FROM `form_types` ORDER BY `id` ASC");
    while ($formType = $formTypes->fetch_assoc()) {
      $formType = new FormType($user->dbConn, intval($formType['id']));
      echo '                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    '.escape_output($formType->name).'
                    <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">'."\n";
      foreach ($formType->forms as $form) {
        echo '                    <li><a href="form_entry.php?action=new&form_id='.intval($form['id']).'">'.escape_output($form['name']).'</a></li>'."\n";
      }
      echo '                  </ul>
                </li>
                <li class="divider-vertical"></li>'."\n";
    }
    // display analysis toolbar.
    echo '                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Analysis
                    <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">'."\n";
    $forms = $user->dbConn->stdQuery("SELECT `id`, `name` FROM `forms` ORDER BY `name` ASC");
    while ($form = $forms->fetch_assoc()) {
      echo '                        <li class="dropdown-submenu">
                          <a tabindex="-1" href="#">'.escape_output($form['name']).'</a>
                          <ul class="dropdown-menu">
                            <li><a href="form_entry.php?action=index&form_id='.intval($form['id']).'">Entries</a></li>
                            <li><a href="graph.php?action=show&form_id='.intval($form['id']).'">Plot</a></li>
                          </ul>'."\n";
    }
    echo '                  </ul>'."\n";
  }
  // display administrator tools.
  if ($user->isAdmin()) {
    echo '                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Admin
                    <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="facility.php">Facilities</a></li>
                    <li><a href="form.php">Forms</a></li>
                    <li><a href="machine_type.php">Machine Types</a></li>
                    <li><a href="machine.php">Machines</a></li>
                    <li><a href="user.php">Users</a></li>
                    <li><a href="backup.php">Backup</a></li>
                  </ul>
                </li>
                <li class="divider-vertical"></li>'."\n";
  }
  echo '            </ul>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li class="dropdown">'."\n";
  // display user settings / log out link, or sign in form.
  if ($user->loggedIn()) {
    echo '                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i>'.escape_output($user->name).'<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/user.php?action=show&id='.intval($user->id).'">Profile</a></li>
                  <li><a href="/user.php?action=edit&id='.intval($user->id).'">User Settings</a></li>
                  <li class="divider"></li>
                  <li><a href="/logout.php">Sign out</a></li>
                </ul>'."\n";
  } else {
    echo '                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in<b class="caret"></b></a>
                <ul class="dropdown-menu">'."\n";
    display_login_form();
    echo '                </ul>'."\n";
  }
  echo '              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">'."\n";
  // display alerts if applicable.
  if ($status != "") {
    echo '    <div class="alert alert-'.escape_output($statusClass).'">
      <button class="close" data-dismiss="alert" href="#">×</button>
      '.escape_output($status).'
    </div>'."\n";
  }
}

function display_login_form() {
  echo '  <form id="login_form" accept-charset="UTF-8" action="/login.php" method="post">
    <label for="Email">Email</label>
    <input id="username" name="username" size="30" type="email" />
    <label for="password">Password</label>
    <input id="password" name="password" size="30" type="password" />
    <input class="btn btn-small btn-primary" name="commit" type="submit" value="Sign in" />
  </form>'."\n";
}

function display_dropdown($id="", $name="", array $choices=array(), $selected=Null) {
  echo "<select id='".escape_output($id)."' name='".escape_output($name)."'>\n";
  foreach ($choices as $key=>$value) {
    echo "<option value='".escape_output($value)."'".($selected == $value ? " selected='selected'" : "").">".escape_output($key)."</option>\n";
  }
  echo "</select>";
}

function display_month_year_dropdown($select_id="", $select_name_prefix="form_entry", $selected=False) {
  if ($selected === false) {
    $selected = array( 0 => intval(date('n')), 1 => intval(date('Y')));
  }
  $months = [];
  for ($month_i = 1; $month_i <= 12; $month_i++) {
    $months[date('M', mktime(0, 0, 0, $month_i, 1, 2000))] = $month_i;
  }
  $years = [];
  for ($year = intval(date('Y', time())); $year >= 2007; $year--) {
    $years[$year] = $year;
  }
  display_dropdown($select_id, $select_name_prefix."[qa_month]", $months, $selected[0]);
  display_dropdown($select_id, $select_name_prefix."[qa_year]", $years, $selected[1]);
}

function display_ok_notok_dropdown($select_id="ok_notok", $selected=0) {
  display_dropdown($select_id, $select_id, array("OK" => 1, "NOT OK" => 0), $selected);
}

function display_facilities($user) {
  //lists all facilities.
  $userIsAdmin = $user->isAdmin();
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th></th>
    </tr>
  </thead>
  <tbody>\n";
  $facilities = $user->dbConn->stdQuery("SELECT `id`, `name` FROM `facilities` ORDER BY `id` ASC");
  while ($facility = $facilities->fetch_assoc()) {
    echo "    <tr>
      <td><a href='facility.php?action=show&id=".intval($facility['id'])."'>".escape_output($facility['name'])."</a></td>\n";
    if ($user->facility['id'] == intval($facility['id']) && $userIsAdmin) {
      echo "<td><a href='facility.php?action=edit&id=".intval($facility['id'])."'>Edit</a></td>\n";
    } else {
      echo "<td></td>\n";
    }
    echo "    </tr>\n";
    }
  echo "  </tbody>\n</table>\n";
}

function display_facility_dropdown($database, $select_id="facility_id", $selected=0) {
  $facilityQuery = $database->stdQuery("SELECT `id`, `name` FROM `facilities`");
  $facilities = [];
  while ($facility = mysqli_fetch_assoc($facilityQuery)) {
    $facilities[$facility['name']] = $facility['id'];
  }
  display_dropdown($select_id, $select_id, $facilities, $selected);
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
          <div class="controls">'."\n";
  display_facility_dropdown($database);
  echo '          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
      </fieldset>
    </form>'."\n";
}

function display_ionization_chamber_dropdown($select_id = "form_entry_form_values_ionization_chamber", $select_name_prefix="form_entry[form_values]", $selected="") {
  echo "<select class='span12' id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[ionization_chamber]'>
  <option value='Farmer (S/N 944, ND.SW(Gy/C) 5.20E+07)'".(($selected === 'Farmer (S/N 944, ND.SW(Gy/C) 5.20E+07)') ? "selected='selected'" : "").">Farmer (S/N 944, ND.SW(Gy/C) 5.20E+07)</option>
  <option value='Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)'".(($selected === 'Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)') ? "selected='selected'" : "").">Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)</option>\n</select>\n";
}

function display_electrometer_dropdown($select_id = "form_entry_form_values_electrometer", $select_name_prefix="form_entry[form_values]", $selected="") {
  echo "<select class='span12' id='".escape_output($select_id)."' name='".escape_output($select_name_prefix)."[electrometer]'>
  <option value='Keithley Model 614 (S/N 42215, Kelec 0.995)'".(($selected === 'Keithley Model 614 (S/N 42215, Kelec 0.995)') ? "selected='selected'" : "").">Keithley Model 614 (S/N 42215, Kelec 0.995)</option>
  <option value='SI CDX 2000B #1 (S/N J073443, Kelec 1.000)'".(($selected === 'SI CDX 2000B #1 (S/N J073443, Kelec 1.000)') ? "selected='selected'" : "").">SI CDX 2000B #1 (S/N J073443, Kelec 1.000)</option>
  <option value='SI CDX 2000B #2 (S/N J073444, Kelec 1.000)'".(($selected === 'SI CDX 2000B #2 (S/N J073444, Kelec 1.000)') ? "selected='selected'" : "").">SI CDX 2000B #2 (S/N J073444, Kelec 1.000)</option>\n</select>\n";
}

function display_machine_types($user) {
  //lists all machine types.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>\n";
  $machine_types = $user->dbConn->stdQuery("SELECT `id`, `name`, `description` FROM `machine_types` ORDER BY `id` ASC");
  while ($machine_type = $machine_types->fetch_assoc()) {
    echo "    <tr>
      <td><a href='machine_type.php?action=show&id=".intval($machine_type['id'])."'>".escape_output($machine_type['name'])."</a></td>
      <td>".escape_output($machine_type['description'])."</td>
    </tr>\n";
    }
  echo "  </tbody>\n</table>\n";
}

function display_machine_type_dropdown($database, $select_id="machine_type_id", $selected=0) {
  $machineTypesQuery = $database->stdQuery("SELECT `id`, `name` FROM `machine_types`");
  $machineTypes = [];
  while ($machineType = mysqli_fetch_assoc($machineTypesQuery)) {
    $machineTypes[$machineType['name']] = $machineType['id'];
  }
  display_dropdown($select_id, $select_id, $machineTypes, $selected);
}

function display_machine_type_edit_form($user, $id=false) {
  // displays a form to edit machine type parameters.
  if (!($id === false)) {
    try {
      $machineType = new MachineType($user->dbConn, $id);
    } catch (Exception $e) {
      $id = false;
    }
  }
  echo "<form action='machine_type.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='machine_type[name]'>Name</label>
      <div class='controls'>
        <input name='machine_type[name]' type='text' class='input-xlarge' id='machine_type[name]'".(($id === false) ? "" : " value='".escape_output($machineType->name)."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine_type[description]'>Description</label>
      <div class='controls'>
        <input name='machine_type[description]' type='text' class='input-xlarge' id='machine_type[description]'".(($id === false) ? "" : " value='".escape_output($machineType->description)."'").">
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add Machine Type" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>\n</form>\n";
}

function display_machine_type_info($user, $machine_type_id, $graph_div_prefix = "machine_type_info") {
  try {
    $machineType = new MachineType($user->dbConn, $machine_type_id);
  } catch (Exception $e) {
    echo "This machine_type does not exist. Please select another machine_type and try again.";
    return;
  }
  $userFacility = new Facility($user->dbConn, $user->facility['id']);
  foreach ($userFacility->machines as $machine) {
    $machine = new Machine($userFacility->dbConn, $machine['id']);
    if ($machine->machineType['id'] == $machine_type_id) {
      echo "<h2>".escape_output($machine->name)."</h2>\n";
      display_machine_info($user, $machine->id, $graph_div_prefix."_".$machine->id);
    }
  }
}

function display_machines($user) {
  //lists all machines.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Facility</th>
    </tr>
  </thead>
  <tbody>\n";
  $facility = new Facility($user->dbConn, $user->facility['id']);
  foreach ($facility->machines as $machine) {
    $machine = new Machine($facility->dbConn, $machine['id']);
    if (!$facility) {
      $facility = "None";
    }
    if (!$machine->machineType) {
      $machine->machineType = array('name' => "None");
    }
    echo "    <tr>
      <td><a href='machine.php?action=show&id=".intval($machine->id)."'>".escape_output($machine->name)."</a></td>
      <td>".escape_output($machine->machineType['name'])."</td>
      <td>".escape_output($facility->name)."</td>
    </tr>\n";
  }
  echo "  </tbody>\n</table>\n";
}

function display_machine_dropdown($user, $select_id="machine_id", $selected=0, $machine_type=false) {
  $facility = new Facility($user->dbConn, $user->facility['id']);
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>\n";
  foreach ($facility->machines as $machine) {
    $display = True;
    if (!($machine_type === false)) {
      $machineObject = new Machine($facility->dbConn, $machine['id']);
      $display = $machineObject->machineType['id'] == $machine_type;
    }
    if ($display) {
      echo "  <option value='".intval($machine['id'])."'".(($selected == intval($machine['id'])) ? "selected='selected'" : "").">".escape_output($machine['name'])."</option>\n";
    }
  }
  echo "</select>\n";
}

function display_machine_edit_form($user, $id=false) {
  // displays a form to edit machine type parameters.
  if (!($id === false)) {
    try {
      $machine = new Machine($user->dbConn, $id);
    } catch (Exception $e) {
      $id = false;
    }
  }  
  echo "<form action='machine.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>\n".(($id === false) ? "" : "<input type='hidden' name='machine[id]' value='".intval($id)."' />")."
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='machine[name]'>Name</label>
      <div class='controls'>
        <input name='machine[name]' type='text' class='input-xlarge' id='machine[name]'".(($id === false) ? "" : " value='".escape_output($machine->name)."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine[machine_type_id]'>Machine Type</label>
      <div class='controls'>\n";
  display_machine_type_dropdown($user->dbConn, "machine[machine_type_id]", ($id === false) ? 0 : $machine->machineType['id']);
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='machine[facility_id]'>Facility</label>
      <div class='controls'>
        <input name='machine[facility_id]' value='".intval($user->facility['id'])."' type='hidden' />
        <span class='input-xlarge uneditable-input'>".escape_output($user->facility['name'])."</span>
      </div>
    </div>\n";
  if (!($id === false)) {
    if (count($machine->machineParameters) > 0) {
      echo "    <div class='control-group'>
      <label class='control-label' for='machine[machine_parameters]'>Machine Parameters</label>
      <div class='controls'>\n";
      foreach ($machine->machineParameters as $machineParameter) {
        echo "        <div class='control-group'>
          <label class='control-label' for='machine[machine_parameters][".intval($machineParameter->machineTypeAttribute['id'])."][value]'>".escape_output($machineParameter->machineTypeAttribute['name'])."</label>\n";
        $jsonArray = json_decode($machineParameter->value, true);
        if ($jsonArray == null) {
          echo "          <input name='machine[machine_parameters][".intval($machineParameter->machineTypeAttribute['id'])."][value]' value='".escape_output($machineParameter->value)."' />\n";
        } else {
          echo "    <div class='controls'>\n";
          foreach ($jsonArray as $key=>$value) {
            echo "            <label class='control-label' for='machine[machine_parameters][".intval($machineParameter->machineTypeAttribute['id'])."][".escape_output($key)."]'>".escape_output($key)."</label>
            <div class='controls'>
              <input name='machine[machine_parameters][".intval($machineParameter->machineTypeAttribute['id'])."][".escape_output($key)."]' value='".escape_output($value)."' />
            </div><br />\n";
          }
          echo "          </div>\n";
        }
        echo "        </div>\n";
      }
      echo "    </div>\n";
    }
  }
  echo "    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add Machine" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>\n</form>\n";
}

function display_machine_info($user, $machine_id, $graph_div_prefix = "machine_info") {
  try {
    $machine = new Machine($user->dbConn, $machine_id);
  } catch (Exception $e) {
    echo "This machine does not exist. Please select another machine and try again.";
    return;
  }
  $i = 0;
  $machine_fields = $user->dbConn->stdQuery("SELECT `form_fields`.`id`, `form_fields`.`name` FROM `form_entries` LEFT OUTER JOIN `form_fields` ON `form_fields`.`form_id` = `form_entries`.`form_id` WHERE `form_entries`.`machine_id` = ".intval($machine_id)." GROUP BY `form_fields`.`id` ORDER BY `form_fields`.`name` ASC");
  while ($machine_field = $machine_fields->fetch_assoc()) {
    $field_values = $user->dbConn->queryAssoc("SELECT `form_values`.`value`, `form_entries`.`created_at` AS `date` FROM `form_values` LEFT OUTER JOIN `form_entries` ON `form_values`.`form_entry_id` = `form_entries`.`id` WHERE `form_values`.`form_field_id` = ".intval($machine_field['id'])." ORDER BY `form_entries`.`created_at` ASC");
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
  </script>\n";
        $i++;
      }
    }
  }
}

function display_form_type_dropdown($database, $select_id="form_type_id", $selected=0) {
  $formTypesQuery = $database->stdQuery("SELECT `id`, `name` FROM `form_types` ORDER BY `id` ASC");
  $formTypes = [];
  while ($formType = $formTypesQuery->fetch_assoc()) {
    $formTypes[$formType['name']] = $formType['id'];
  }
  display_dropdown($select_id, $select_id, $formTypes, $selected);
}

function display_forms($user) {
  //lists all forms.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th>Machine Type</th>
    </tr>
  </thead>
  <tbody>\n";
  $forms = $user->dbConn->stdQuery("SELECT `forms`.`id`, `forms`.`name`, `forms`.`description`, `machine_types`.`name` AS `machine_type_name` FROM `forms` LEFT OUTER JOIN `machine_types` ON `forms`.`machine_type_id` = `machine_types`.`id` ORDER BY `forms`.`id` ASC");
  while ($form = $forms->fetch_assoc()) {
    echo "    <tr>
      <td><a href='form.php?action=edit&id=".intval($form['id'])."'>".escape_output($form['name'])."</a></td>
      <td>".escape_output($form['description'])."</td>
      <td>".escape_output($form['machine_type_name'])."</td>
    </tr>\n";
  }
  echo "  </tbody>\n</table>\n";
}

function display_form_field_graph($database, $form_field) {
  $field_values = $database->queryAssoc("SELECT * FROM `form_values` WHERE `form_field_id` = ".intval($form_field['id']));
}

function display_form_history($user, $form_id) {
  try {
    $form = new Form($user->dbConn, $form_id);
  } catch (Exception $e) {
    echo "This form does not exist. Please select another form and try again.";
    return;
  }
  $form_fields = $user->dbConn->stdQuery("SELECT `id`, `name` FROM `form_fields` WHERE `form_id` = ".intval($form_id));
  while ($form_field = mysqli_fetch_assoc($form_fields)) {
    display_form_field_graph($user->dbConn, $form_field);
  }
}

function display_form_edit_form($user, $id=false) {
  // displays a form to edit form parameters.
  if (!($id === false)) {
    try {
      $form = new Form($user->dbConn, $id);
    } catch (Exception $e) {
      $id = false;
    }
  }
  echo "<form action='form.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>
  <fieldset>\n".(($id === false) ? "" : "<input type='hidden' name='form[id]' value='".intval($id)."' />")."
    <div class='control-group'>
      <label class='control-label' for='form[name]'>Name</label>
      <div class='controls'>
        <input name='form[name]' type='text' class='input-xlarge' id='form[name]'".(($id === false) ? "" : " value='".escape_output($form->name)."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[description]'>Description</label>
      <div class='controls'>
        <input name='form[description]' type='text' class='input-xlarge' id='form[description]'".(($id === false) ? "" : " value='".escape_output($form->description)."'").">
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[form_type_id]'>Type</label>
      <div class='controls'>
    ";
    display_form_type_dropdown($user->dbConn, "form[form_type_id]", (($id === false) ? 0 : intval($form->formType['id'])));
    echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[machine_type_id]'>Machine Type</label>
      <div class='controls'>
        ";
  display_machine_type_dropdown($user->dbConn, "form[machine_type_id]", (($id === false) ? 0 : intval($form->machineType['id'])));
  echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[js]'>Javascript</label>
      <div class='controls'>
        <textarea class='input-xlarge' id='form[js]' name='form[js]' cols='500' rows='10'>".(($id === false) ? "" : escape_output($form->js))."</textarea>
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[php]'>PHP</label>
      <div class='controls'>
        <textarea class='input-xlarge' id='form[php]' name='form[php]' cols='500' rows='10'>".(($id === false) ? "" : escape_output($form->php))."</textarea>
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Create form" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>\n</form>\n";
}

function display_form_entries($user, $form_id=false) {
  //lists all form_entries.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Machine</th>
      <th class='dataTable-default-sort' data-sort-order='desc'>QA Month</th>
      <th>Submitted By</th>
      <th>Submitted On</th>
      <th>Approved By</th>
      <th>Approved On</th>
      <th>Comments</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>\n";
  $form_entries = $user->dbConn->stdQuery("SELECT `form_entries`.`id`, `form_entries`.`machine_id`, `machines`.`name` AS `machine_name`, `form_entries`.`user_id`, `users`.`name` AS `user_name`, `created_at`, `qa_month`, `qa_year`, `approved_on`, `approved_user_id`, `approved_user`.`name` AS `approved_user_name`, `comments` FROM `form_entries` LEFT OUTER JOIN `forms` ON `forms`.`id` = `form_entries`.`form_id` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`user_id` LEFT OUTER JOIN `users` AS `approved_user` ON `approved_user`.`id` = `form_entries`.`approved_user_id` WHERE `form_entries`.`form_id` = ".$form_id." ORDER BY `qa_year` DESC, `qa_month` DESC");
  while ($form_entry = $form_entries->fetch_assoc()) {
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
      <td>".intval($form_entry['qa_year'])."/".((intval($form_entry['qa_month']) >= 10) ? "" : "0").intval($form_entry['qa_month'])."</td>
      <td><a href='user.php?action=show&id=".intval($form_entry['user_id'])."'>".escape_output($form_entry['user_name'])."</a></td>
      <td>".escape_output(format_mysql_timestamp($form_entry['created_at']))."</td>
      <td>".$approval_user."</td>
      <td>".$approval_date."</td>
      <td>".escape_output($form_entry['comments'])."</td>
      <td><a href='form_entry.php?action=edit&id=".intval($form_entry['id'])."'>Edit</a></td>
      <td></td>
    </tr>\n";
  }
  echo "  </tbody>\n</table>\n";
}

function display_form_entry_edit_form($user, $id=False, $form_id=False) {
  // displays a form to edit form parameters.
  if (!($id === False)) {
    $caught = False;
    try {
      $formEntry = new FormEntry($user->dbConn, $id);
      $form_id = $formEntry->form['id'];
    } catch (Exception $e) {
      $id = False;
      $form_id = False;
      $caught = True;
    }
  } else {
    $formEntry = new FormEntry($user->dbConn, 0, ($form_id ? intval($form_id) : Null));
    $formEntry->formValues = $formEntry->getAutosaveValues($user);
  }
  if (!($form_id === False)) {
    try {
      $form = new Form($user->dbConn, $form_id);
    } catch (Exception $e) {
      $form_id = False;
    }
    $formEntry->form = array('id' => $form->id, 'name' => $form->name);
  } else {
    echo "Please specify a valid form entry ID or form ID.";
    return;
  }
  $jsParameters = array();
  if ($formEntry->machine) {
    // instantiate all machine_type_attributes in php and js.
    $machine = new Machine($user->dbConn, $formEntry->machine['id']);
    foreach ($machine->machineParameters as $parameter) {
      @$value = unserialize($parameter->value);
      if (!$value) {
        $value = $parameter->value;
      } else {
        $value = json_encode($value);
      }
      ${$parameter->machineTypeAttribute['name']} = $value;
      $jsParameters[$parameter->machineTypeAttribute['name']] = $value;
    }
  } else {
    // instantiate all the global machine parameters.
    $machineParameters = $user->dbConn->stdQuery("SELECT `machine_type_attributes`.`name` FROM `machine_type_attributes`");
    while ($parameter = $machineParameters->fetch_assoc()) {
      ${$parameter['name']} = array();
      $jsParameters[$parameter['name']] = "{}";
    }
  }
  if ($form->php != '' && $form->php != 'NULL') {
    // i know this is terrible ugh but custom forms eventually
    eval($form->php);
  }
  if ($form->js != '' && $form->js != 'NULL') {
    echo "<script type='text/javascript'>\n";
    foreach ($jsParameters as $name => $value) {
      echo "var ".$name." = ".$value.";\n";
    }
    echo $form->js."\n</script>\n";
  }
}

function display_users($user) {
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
  <tbody>\n";
  if ($user->isAdmin()) {
    $users = $user->dbConn->stdQuery("SELECT `users`.`id`, `users`.`name`, `users`.`email`, `users`.`usermask`, `facilities`.`name` AS `facility_name` FROM `users` LEFT OUTER JOIN `facilities` ON `users`.`facility_id` = `facilities`.`id` ORDER BY `users`.`name` ASC");
  } else {
    $users = $user->dbConn->stdQuery("SELECT `users`.`id`, `users`.`name`, `users`.`email`, `users`.`usermask`, `facilities`.`name` AS `facility_name` FROM `users` LEFT OUTER JOIN `facilities` ON `users`.`facility_id` = `facilities`.`id` WHERE `users`.`facility_id` = ".intval($user->facility['id'])." ORDER BY `users`.`name` ASC");
  }
  while ($thisUser = $users->fetch_assoc()) {
    echo "    <tr>
      <td><a href='user.php?action=show&id=".intval($thisUser['id'])."'>".escape_output($thisUser['name'])."</a></td>
      <td>".escape_output($thisUser['email'])."</td>
      <td>".escape_output(convert_usermask_to_text($thisUser['usermask']))."</td>
      <td>".escape_output($thisUser['facility_name'])."</td>
      <td>"; if ($user->isAdmin()) { echo "<a href='user.php?action=edit&id=".intval($thisUser['id'])."'>Edit</a>"; } echo "</td>
      <td>"; if ($user->isAdmin()) { echo "<a href='user.php?action=delete&id=".intval($thisUser['id'])."'>Delete</a>"; } echo "</td>
    </tr>\n";
  }
  echo "  </tbody>\n</table>\n";
}

function display_user_dropdown($user, $select_id="user_id", $selected=0) {
  $facility = new Facility($user->dbConn, $user->facility['id']);
  $users = [];
  foreach ($facility->users as $user) {
    $users[$user['name']] = $user['id'];
  }
  display_dropdown($select_id, $select_id, $users, $selected);
}

function display_user_roles_select($select_id="usermask[]", $mask=0) {
  for ($usermask = 0; $usermask <= 2; $usermask++) {
    echo "<label class='checkbox'>
  <input type='checkbox' name='".escape_output($select_id)."' value='".intval(pow(2, $usermask))."'".(($mask & intval(pow(2, $usermask))) ? "checked='checked'" : "")." />".escape_output(convert_usermask_to_text(pow(2, $usermask)))."\n</label>\n";
  }
}

function display_user_edit_form($user, $id=false) {
  // displays a form to edit user parameters.
  if (!($id === false)) {
    try {
      $userObject = new User($user->dbConn, $id);
    } catch (Exception $e) {
      $id = false;
    }
    if (intval($userObject->facility['id']) != $user->facility['id']) {
      echo "You may only modify users under your own facility.";
      return;
    }
  }    
  echo "<form action='user.php".(($id === false) ? "" : "?id=".intval($id))."' method='POST' class='form-horizontal'>\n".(($id === false) ? "" : "<input type='hidden' name='user[id]' value='".intval($id)."' />")."
  <fieldset>
    <div class='control-group'>
      <label class='control-label' for='user[name]'>Name</label>
      <div class='controls'>
        <input name='user[name]' type='text' class='input-xlarge' id='user[name]'".(($id === false) ? "" : " value='".escape_output($userObject->name)."'").">
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
        <input name='user[email]' type='email' class='input-xlarge' id='user[email]'".(($id === false) ? "" : " value='".escape_output($userObject->email)."'").">
      </div>
    </div>\n";
  if ($user->isAdmin()) {
    echo "    <div class='control-group'>
      <label class='control-label' for='user[facility_id]'>Facility</label>
      <div class='controls'>\n";
    display_facility_dropdown($user->dbConn, "user[facility_id]", ($id === false) ? 0 : $userObject->facility['id']);
    echo "      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='user[usermask][]'>Role(s)</label>
      <div class='controls'>\n";
    display_user_roles_select("user[usermask][]", ($id === false) ? 0 : intval($userObject->usermask));
    echo "      </div>
    </div>\n";
  }
  echo "    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Add User" : "Save changes")."</button>
      <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</a>
    </div>
  </fieldset>\n</form>\n";
}

function display_user_profile($user, $user_id) {
  $userObject = new User($user->dbConn, $user_id);
  echo "<dl class='dl-horizontal'>
    <dt>Email</dt>
    <dd>".escape_output($userObject->email)."</dd>
    <dt>Facility</dt>
    <dd><a href='facility.php?action=show&id=".intval($userObject->facility['id'])."'>".escape_output($userObject->facility['name'])."</a></dd>
    <dt>User Role</dt>
    <dd>".escape_output(convert_usermask_to_text($userObject->usermask))."</dd>
  </dl>\n";
  if ($userObject->isPhysicist()) {
    $form_approvals = $user->dbConn->stdQuery("SELECT `form_entries`.`id`, `qa_month`, `qa_year`, `machine_id`, `machines`.`name` AS `machine_name`, `user_id`, `users`.`name` AS `user_name`, `approved_on` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`user_id` WHERE `approved_user_id` = ".intval($userObject->id)." ORDER BY `approved_on` DESC");
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
    <tbody>\n";
    foreach ($userObject->approvals as $approval) {
      echo "      <tr>
        <td><a href='form_entry.php?action=edit&id=".intval($approval->id)."'>".escape_output($approval->qaYear."/".$approval->qaMonth)."</a></td>
        <td><a href='machine.php?action=show&id=".intval($approval->machine['id'])."'>".escape_output($approval->machine['name'])."</a></td>
        <td><a href='user.php?action=show&id=".intval($approval->user['id'])."'>".escape_output($approval->user['name'])."</a></td>
        <td>".escape_output(format_mysql_timestamp($approval->approvedOn))."</td>
      </tr>\n";
    }
    echo "    </tbody>
  </table>\n";
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
    <tbody>\n";
  foreach ($userObject->formEntries as $form_entry) {
    $form_entry = new FormEntry($userObject->dbConn, $form_entry['id']);
    echo "    <tr>
      <td><a href='form.php?action=show&id=".intval($form_entry->form['id'])."'>".escape_output($form_entry->form['name'])."</a></td>
      <td><a href='machine.php?action=show&id=".intval($form_entry->machine['id'])."'>".escape_output($form_entry->machine['name'])."</a></td>
      <td>".escape_output($form_entry->comments)."</td>
      <td>".escape_output($form_entry->qaYear."/".$form_entry->qaMonth)."</td>
      <td>".escape_output(format_mysql_timestamp($form_entry->createdAt))."</td>
      <td><a href='form_entry.php?action=edit&id=".intval($form_entry->id)."'>View</a></td>
    </tr>\n";
  }
  echo "    </tbody>
  </table>\n";
}

function display_backups($user) {
  //lists all backups.
  echo "<table class='table table-striped table-bordered dataTable'>
  <thead>
    <tr>
      <th>Requested by</th>
      <th>Path</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>\n";
  $backups = $user->dbConn->stdQuery("SELECT * FROM `backups` ORDER BY `created_at` DESC");
  while ($backup = mysqli_fetch_assoc($backups)) {
    $username = $user->dbConn->queryFirstValue("SELECT `name` FROM `users` WHERE `id` = ".intval($backup['user_id'])." LIMIT 1");
    if (!$username) {
      $username = "None";
    }
    echo "    <tr>
      <td>".escape_output($username)."</td>
      <td><a href='backup.php?action=download&id=".intval($backup['id'])."'>".escape_output(basename($backup['path']))."</a></td>
      <td>".escape_output(date('Y/m/d H:i', strtotime($backup['created_at'])))."</td>
    </tr>\n";
  }
  echo "  </tbody>\n</table>\n<a class='btn btn-primary' href='backup.php?action=create'>Create a backup</a>\n";
}

function display_backup_form() {
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
  </fieldset>\n</form>\n";
}

function display_history_json($user, $fields = array(), $machines=array()) {
  header('Content-type: application/json');
  $return_array = array();
  
  if (!$user->loggedIn()) {
    $return_array['error'] = "You must be logged in to view history data.";
  } elseif (!is_array($fields) || !is_array($machines)) {
    $return_array['error'] = "Please provide a valid list of fields and machines.";  
  } else {
    foreach ($fields as $field) {
      foreach ($machines as $machine) {
        $line_array = array();
        $values = $user->dbConn->stdQuery("SELECT `form_field_id`, `form_entries`.`machine_id`, `form_entries`.`qa_month`, `form_entries`.`qa_year`, `value` FROM `form_values`
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

function display_history_plot($user, $form_id) {
  //displays plot for a particular form.
  try {
    $form = new Form($user->dbConn, $form_id);
  } catch (Exception $e) {
    echo "The form ID you provided was invalid. Please try again.\n";
    return;
  }
  echo "<div id='vis'></div>
  <form action='#'>
    <input type='hidden' id='form_id' name='form_id' value='".intval($form_id)."' />
    <div class='row-fluid'>
      <div class='span4'>
        <div class='row-fluid'><h3 class='span12' style='text-align:center;'>Machines</h3></div>
        <div class='row-fluid'>
          <select multiple='multiple' id='machines' class='span12' size='10' name='machines[]'>\n";
  foreach ($form->machines as $machine) {
    echo "           <option value='".intval($machine['id'])."'>".escape_output($machine['name'])."</option>\n";
  }
  echo "         </select>
        </div>
      </div>
      <div class='span4'>
        <div class='row-fluid'><h3 class='span12' style='text-align:center;'>Fields</h3></div>
        <div class='row-fluid'>
          <select multiple='multiple' id='form_fields' class='span12' size='10' name='form_fields[]'>\n";
  foreach ($form->formFields as $field) {
    echo "            <option value='".intval($field['id'])."'>".escape_output($field['name'])."</option>\n";
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
  </form>\n";
}

function display_footer() {
  echo "    <hr />  
  </div>\n</body>\n</html>";
}

?>