<?php

class Machine {
  public $id;
  public $name;
  public $machineType;
  public $facility;
  public $formEntries;
  public $machineParameters;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new machine. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->machineType = $this->facility = $this->formEntries = $this->machineParameters = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `machines` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `machines` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $this->name = $this->dbConn->queryFirstValue("SELECT `name` FROM `machines` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->machineType = $this->getMachineType();
      $this->facility = $this->getFacility();
      $this->formEntries = $this->getFormEntries();
      $this->machineParameters = $this->getMachineParameters();
    }
  }
  public function getMachineType() {
    // retrieves an id,name array corresponding to this machine's machine_type.
    return $this->dbConn->queryFirstRow("SELECT `machine_types`.`id`, `machine_types`.`name` FROM `machines` LEFT OUTER JOIN `machine_types` ON `machine_types`.`id` = `machines`.`machine_type_id` WHERE `machines`.`id` = ".intval($this->id));
  }
  public function getFacility() {
    // retrieves an id,name array corresponding to this machine's facility.
    return $this->dbConn->queryFirstRow("SELECT `facilities`.`id`, `facilities`.`name` FROM `machines` LEFT OUTER JOIN `facilities` ON `facilities`.`id` = `machines`.`facility_id` WHERE `machines`.`id` = ".intval($this->id));
  }
  public function getFormEntries() {
    // retrieves a list of ids corresponding tot his machine's form entries, ordered by updated_at desc.
    return $this->dbConn->queryAssoc("SELECT `id` FROM `form_entries` WHERE `machine_id` = ".intval($this->id)." ORDER BY `updated_at` DESC");
  }
  public function getMachineParameters() {
    // retrieves a list of MachineParameter objects belonging to the current machine.
    $machineParameterQuery = $this->dbConn->stdQuery("SELECT `machine_type_attribute_id` FROM `machine_parameters` WHERE `machine_id` = ".intval($this->id)." ORDER BY `machine_type_attribute_id` ASC");
    $machineParameters = [];
    while ($parameter = $machineParameterQuery->fetch_assoc()) {
      $parameter = new MachineParameter($this->dbConn, $this->id, intval($parameter['machine_type_attribute_id']));
      $machineParameters[$parameter->machineTypeAttribute['name']] = $parameter;
    }
    return $machineParameters;
  }
}

?>