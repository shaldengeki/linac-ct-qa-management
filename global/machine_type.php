<?php

class MachineType {
  public $id;
  public $name;
  public $machines;
  public $forms;
  public $dbConn;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new form type. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->forms = $this->machines = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `machine_types` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `machine_types` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $this->name = $this->dbConn->queryFirstValue("SELECT `name` FROM `machine_types` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->machines = $this->getMachines();
      $this->forms = $this->getForms();
    }
  }
  public function getForms() {
    // retrieves a list of id,name arrays belonging to the current form type.
    return $this->dbConn->queryAssoc("SELECT `id`, `name` FROM `forms` WHERE `form_type_id` = ".intval($this->id));
  }
  public function getMachines() {
    // retrieves a list of id,name arrays corresponding to this machine type's machines, ordered by name asc.
    return $this->dbConn->queryAssoc("SELECT `id`, `name` FROM `machines` WHERE `machines`.`machine_type_id` = ".intval($this->id)." ORDER BY `name` ASC");
  }
  public function create_or_update($machine_type) {
    // creates or updates a machine type based on the parameters passed in $machine_type and this object's attributes.
    // returns False if failure, or the ID of the machine type if success.
    $params = array();
    foreach ($machine_type as $parameter => $value) {
      if (!is_array($value)) {
        $params[] = "`".$this->dbConn->real_escape_string($parameter)."` = ".$this->dbConn->quoteSmart($value);
      }
    }
    // check to see if this is an update.
    if ($this->id != 0) {
      // update this machine type.
      $updateMachineType = $this->dbConn->stdQuery("UPDATE `machine_types` SET ".implode(", ", $params)."  WHERE `id` = ".intval($this->id)." LIMIT 1");
      if (!$updateMachineType) {
        return False;
      }
      return intval($this->id);
    } else {
      // add this machine type.
      $addMachineType = $this->dbConn->stdQuery("INSERT INTO `machine_types` SET ".implode(",", $params));
      if (!$addMachineType) {
        return False;
      } else {
        return intval($this->dbConn->insert_id);
      }
    }
  }
}
?>