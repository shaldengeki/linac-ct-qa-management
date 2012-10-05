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
  public function getUsers() {
    // retrieves a list of id,name,usermask arrays belonging to the current facility.
    return $this->dbConn->queryAssoc("SELECT `id`, `name`, `usermask` FROM `users` WHERE `facility_id` = ".intval($this->id));
  }
  public function getMachines() {
    // retrieves a list of id,name,machine_type_id arrays belonging to the current facility.
    return $this->dbConn->queryAssoc("SELECT `id`, `name`, `machine_type_id` FROM `machines` WHERE `facility_id` = ".intval($this->id));
  }
}

?>