<?php

class MachineParameter {
  public $machine;
  public $machineTypeAttribute;
  public $value;
  public $dbConn;
  public function __construct($database, $machine=Null, $machineTypeAttribute=Null) {
    $this->dbConn = $database;
    if ($machine === 0) {
      // creating a new parameter. initialize blank values.
      $this->machine = $this->machineTypeAttribute = array();
      $this->value = 0;
    } else {
      $info = $this->dbConn->queryFirstValue("SELECT `value` FROM `machine_parameters` WHERE `machine_id` = ".intval($machine)." && `machine_type_attribute_id` = ".intval($machineTypeAttribute)." LIMIT 1");
      if (!$info) {
        throw new Exception("ID Not Found");
      }
      $this->value = $info;

      // need to initialize these values before fetching from the db.
      $this->machine = array('id' => intval($machine));
      $this->machineTypeAttribute = array('id' => intval($machineTypeAttribute));

      $this->machine = $this->getMachine();
      $this->machineTypeAttribute = $this->getMachineTypeAttribute();
    }
  }
  public function getMachine() {
    // retrieves an id,name array corresponding to the machine under which this parameter is submitted.
    return $this->dbConn->queryFirstRow("SELECT `machines`.`id`, `machines`.`name` FROM `machine_parameters` LEFT OUTER JOIN `machines` ON `machines`.`id` = `machine_parameters`.`machine_id` WHERE `machine_parameters`.`machine_id` = ".intval($this->machine['id'])." && `machine_parameters`.`machine_type_attribute_id` = ".intval($this->machineTypeAttribute['id'])." LIMIT 1");
  }
  public function getMachineTypeAttribute() {
    // retrieves the id corresponding to the machine type attribute under which this parameter is submitted.
    return $this->dbConn->queryFirstRow("SELECT `machine_type_attributes`.`id`, `machine_type_attributes`.`name` FROM `machine_parameters` LEFT OUTER JOIN `machine_type_attributes` ON `machine_type_attributes`.`id` = `machine_parameters`.`machine_type_attribute_id` WHERE `machine_parameters`.`machine_id` = ".intval($this->machine['id'])." && `machine_parameters`.`machine_type_attribute_id` = ".intval($this->machineTypeAttribute['id'])." LIMIT 1");
  }
}

?>