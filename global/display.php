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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>'.escape_output($title).($subtitle != "" ? " - ".$subtitle : "").'</title>
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" />
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" href="css/linac-qa.css" type="text/css" />
	<!--<link rel="stylesheet" href="css/sample.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection"/>-->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
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
      <div class="container-fluid">
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
                  <li><a href="form_entry.php?action=new&form_id=1">Submit new record</a></li>
                  <li><a href="image.php?type=linac">Upload an image</a></li>
                  <li><a href="history.php?type=linac">View history</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  CT
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="form_entry.php?action=new&form_id=2">Submit new record</a></li>
                  <li><a href="image.php?type=ct">Upload an image</a></li>
                  <li><a href="history.php?type=ct">View history</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Admin
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="machine_type.php">Machine Types</a></li>
                  <li><a href="form.php">Forms</a></li>
                  <li><a href="#">Users</a></li>
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
  <div class="container-fluid">
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

function display_register_form($action=".") {
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
          <label class="control-label">Confirm your password</label>
          <div class="controls">
            <input type="password" class="" name="password_confirmation" id="password_confirmation" />
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
      </fieldset>
    </form>
';
}

function display_ionization_chamber_dropdown($select_id = "form_entry_form_values_ionization_chamber", $select_name_prefix="form_entry[form_values][]", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."[ionization_chamber]'>
  <option value='Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)'>Farmer (S/N 944, ND.SW(Gy/C) 5.18E+07)</option>
  <option value='Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)'>Farmer (S/N 269, ND.SW(Gy/C) 5.32E+07)</option>
</select>
";
}

function display_electrometer_dropdown($select_id = "form_entry_form_values_electrometer", $select_name_prefix="form_entry[form_values][]", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."[electrometer]'>
  <option value='Keithley Model 614 (S/N 42215, Kelec 0.995)'>Keithley Model 614 (S/N 42215, Kelec 0.995)</option>
  <option value='SI CDX 2000B #1 (S/N J073443, Kelec 1.000)'>SI CDX 2000B #1 (S/N J073443, Kelec 1.000)</option>
  <option value='SI CDX 2000B #2 (S/N J073444, Kelec 1.000)'>SI CDX 2000B #2 (S/N J073444, Kelec 1.000)</option>
</select>
";  
}

function display_machine_types($database) {
  //lists all machine types.
  echo "<table class='table table-striped table-bordered'>
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
      <td><a href='machine_type.php?action=edit&id=".intval($machine_type['id'])."'>".escape_output($machine_type['name'])."</a></td>
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

function display_machine_type_edit_form($database, $id=false) {
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
      <button class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</button>
    </div>
  </fieldset>
</form>
";
}

function display_machine_dropdown($database, $select_id="machine_id", $selected=0) {
  echo "<select id='".escape_output($select_id)."' name='".escape_output($select_id)."'>
";
  $machines = $database->stdQuery("SELECT `id`, `name` FROM `machines`");
  while ($machine = mysqli_fetch_assoc($machines)) {
    echo "  <option value='".intval($machine['id'])."'".(($selected == intval($machine['id'])) ? "selected='selected'" : "").">".escape_output($machine['name'])."</option>
";
  }
  echo "</select>
";
}

function display_forms($database) {
  //lists all forms.
  echo "<table class='table table-striped table-bordered'>
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

function display_form_edit_form($database, $id=false) {
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
        <textarea class='input-xlarge' id='form[js]' cols='500' rows='10'>".escape_output($formObject['js'])."</textarea>
      </div>
    </div>
    <div class='control-group'>
      <label class='control-label' for='form[php]'>PHP</label>
      <div class='controls'>
        <textarea class='input-xlarge' id='form[php]' cols='500' rows='10'>".escape_output($formObject['php'])."</textarea>
      </div>
    </div>
    <div class='form-actions'>
      <button type='submit' class='btn btn-primary'>".(($id === false) ? "Create form" : "Save changes")."</button>
      <button class='btn'>".(($id === false) ? "Go back" : "Discard changes")."</button>
    </div>
  </fieldset>
</form>
";
}

function display_form_entry_edit_form($database, $id=false, $form_id=false) {
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
  if ($formObject['php'] != '') {
    eval($formObject['php']);
  }
  if ($formObject['js'] != '') {
    echo "<script type='text/javascript'>
  ".$formObject['js']."
</script>
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