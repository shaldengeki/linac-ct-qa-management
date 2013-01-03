<?php

class Equipment {
  public $id;
  public $name;
  public $facility;
  public $machine;
  public $formEntries;
  public $parameters;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new equipment. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->machine = $this->facility = $this->formEntries = $this->parameters = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `equipment` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `equipment` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $info = $this->dbConn->queryFirstRow("SELECT `name`, `parameters` FROM `equipment` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->name = $info['name'];
      $this->parameters = $info['parameters'] != '' ? unserialize($info['parameters']) : array();
      $this->machine = $this->getMachine();
      $this->facility = $this->getFacility();
      $this->formEntries = $this->getFormEntries();
      $this->parameters = $this->getParameters();
    }
  }
  public function getMachine() {
    // retrieves an id,name array corresponding to this equipment's machine_type.
    return $this->dbConn->queryFirstRow("SELECT `machines`.`id`, `machines`.`name` FROM `equipment` LEFT OUTER JOIN `machines` ON `machines`.`id` = `equipment`.`machine_id` WHERE `equipment`.`id` = ".intval($this->id));
  }
  public function getFacility() {
    // retrieves an id,name array corresponding to this equipment's facility.
    return $this->dbConn->queryFirstRow("SELECT `facilities`.`id`, `facilities`.`name` FROM `equipment` LEFT OUTER JOIN `facilities` ON `facilities`.`id` = `equipment`.`facility_id` WHERE `equipment`.`id` = ".intval($this->id));
  }
  public function getFormEntries() {
    // retrieves a list of ids corresponding to this equipment's form entries, ordered by updated_at desc.
    return $this->dbConn->queryAssoc("SELECT `form_entry_id` FROM `form_entries_equipment` LEFT OUTER JOIN `form_entries` ON `form_entries`.`id` = `form_entries_equipment`.`form_entry_id` WHERE `equipment_id` = ".intval($this->id)." ORDER BY `form_entries`.`updated_at` DESC");
  }
  public function create_or_update($equipment) {
    // creates or updates a equipment based on the parameters passed in $equipment and this object's attributes.
    // returns False if failure, or the ID of the equipment if success.
    
    // convert parameters to serialized format.
    if (isset($equipment['parameters']) && is_array($equipment['parameters'])) {
      $equipment['parameters'] = serialize($equipment['parameters']);
    }

    $params = array();
    foreach ($equipment as $parameter => $value) {
      if (!is_array($value)) {
        $params[] = "`".$this->dbConn->real_escape_string($parameter)."` = ".$this->dbConn->quoteSmart($value);
      }
    }
    // check to see if this is an update.
    if ($this->id != 0) {
      // update this equipment.
      $updateEquipment = $this->dbConn->stdQuery("UPDATE `equipment` SET ".implode(", ", $params)."  WHERE `id` = ".intval($this->id)." LIMIT 1");
      if (!$updateEquipment) {
        return False;
      }
      return intval($this->id);
    } else {
      // add this equipment.
      $addEquipment = $this->dbConn->stdQuery("INSERT INTO `equipment` SET ".implode(",", $params));
      if (!$addEquipment) {
        return False;
      } else {
        return intval($this->dbConn->insert_id);
      }
    }
  }
}

?>