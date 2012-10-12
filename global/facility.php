<?php

class Facility {
  public $id;
  public $name;
  public $users;
  public $machines;
  public $dbConn;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new facility. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->users = $this->machines = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `facilities` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `facilities` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $this->name = $this->dbConn->queryFirstValue("SELECT `name` FROM `facilities` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->users = $this->getUsers();
      $this->machines = $this->getMachines();
    }
  }
  public function create_or_update($facility) {
    // creates or updates a facility based on the parameters passed in $facility and this object's attributes.
    // returns False if failure, or the ID of the facility if success..
    $params = array();
    foreach ($facility as $parameter => $value) {
      if (!is_array($value)) {
        $params[] = "`".$this->dbConn->real_escape_string($parameter)."` = ".$this->dbConn->quoteSmart($value);
      }
    }
    // check to see if this is an update.
    if ($this->id != 0) {
      // update this facility.
      $updateFacility = $this->dbConn->stdQuery("UPDATE `facilities` SET ".implode(", ", $params)."  WHERE `id` = ".intval($this->id)." LIMIT 1");
      if (!$updateFacility) {
        return False;
      }
      return intval($this->id);
    } else {
      // add this facility.
      $addFacility = $this->dbConn->stdQuery("INSERT INTO `facilities` SET ".implode(",", $params));
      if (!$addFacility) {
        return False;
      } else {
        return intval($this->dbConn->insert_id);
      }
    }
  }
  public function getUsers() {
    // retrieves a list of id,name,usermask arrays belonging to the current facility.
    return $this->dbConn->queryAssoc("SELECT `id`, `name`, `usermask` FROM `users` WHERE `facility_id` = ".intval($this->id));
  }
  public function getMachines() {
    // retrieves a list of id,name,machine_type_id arrays belonging to the current facility.
    return $this->dbConn->queryAssoc("SELECT `id`, `name`, `machine_type_id` FROM `machines` WHERE `facility_id` = ".intval($this->id));
  }
  public function displayEditForm($title="Add a Facility") {
    // displays a form to edit facility type parameters.
    echo "<h1>".escape_output($title)."</h1>
    <form action='facility.php".(($this->id == 0) ? "" : "?id=".intval($this->id))."' method='POST' class='form-horizontal'>\n".(($this->id === false) ? "" : "<input type='hidden' name='facility[id]' value='".intval($this->id)."' />")."
      <fieldset>
        <div class='control-group'>
          <label class='control-label' for='facility[name]'>Name</label>
          <div class='controls'>
            <input name='facility[name]' type='text' class='input-xlarge' id='facility[name]'".(($this->id === 0) ? "" : " value='".escape_output($this->name)."'").">
          </div>
        </div>
        <div class='form-actions'>
          <button type='submit' class='btn btn-primary'>".(($this->id === 0) ? "Add Facility" : "Save changes")."</button>
          <a href='#' onClick='window.location.replace(document.referrer);' class='btn'>".(($this->id === 0) ? "Go back" : "Discard changes")."</a>
        </div>
      </fieldset>
    </form>\n";
  }
  public function displayProfile($user) {
    echo "    <h1>".escape_output($this->name).(($user->isAdmin() && $this->id == $user->facility['id']) ? "<small><a href='facility.php?action=edit&id=".intval($this->id)."'>(edit)</a></small>" : "")."</h1>
    <h3>People</h3>
    <table class='table table-striped table-bordered dataTable'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>QA Entries</th>
        </tr>
      </thead>
      <tbody>\n";
    foreach ($this->users as $thisUser) {
      $thisUser = new User($this->dbConn, $thisUser['id']);
      echo "        <tr>
          <td><a href='user.php?action=show&id=".intval($thisUser->id)."'>".escape_output($thisUser->name)."</a></td>
          <td>".escape_output($thisUser->email)."</td>
          <td>".escape_output(convert_usermask_to_text($thisUser->usermask))."</td>
          <td>".escape_output(count($thisUser->formEntries))."</td>
        </tr>\n";
    }
    echo "      </tbody>
    </table>\n";
    echo "    <h3>Machines</h3>
    <table class='table table-striped table-bordered dataTable'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Type</th>
          <th>QA Entries</th>
          <th>Last Entry</th>
        </tr>
      </thead>
      <tbody>\n";
    foreach ($this->machines as $machine) {
      $machine = new Machine($this->dbConn, $machine['id']);
      $lastEntry = new FormEntry($machine->dbConn, (count($machine->formEntries) > 0) ? $machine->formEntries[0]['id'] : 0);
      echo "      <tr>
        <td><a href='machine.php?action=show&id=".intval($machine->id)."'>".escape_output($machine->name)."</a></td>
        <td>".escape_output($machine->machineType['name'])."</td>
        <td>".escape_output(count($machine->formEntries))."</td>
        <td>".escape_output((($lastEntry->updatedAt == '') ? "N/A" : format_mysql_timestamp($lastEntry->updatedAt)))."</td>
      </tr>\n";
    }
    echo "      </tbody>
    </table>\n";
  }

}

?>