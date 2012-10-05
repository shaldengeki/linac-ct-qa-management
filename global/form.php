<?php

class Form {
  public $id;
  public $name;
  public $description;
  public $formType;
  public $machineType;
  public $machines;
  public $js;
  public $php;
  public $formFields;
  public $formEntries;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new machine. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->machineType = $this->machines = $this->formType = $this->formFields = $this->formEntries = array();
      $this->$description = $this->js = $this->php = "";
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `forms` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `forms` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $info = $this->dbConn->queryFirstRow("SELECT `name`, `description`, `js`, `php` FROM `forms` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->name = $info['name'];
      $this->description = $info['description'];
      $this->js = $info['js'];
      $this->php = $info['php'];
      $this->machineType = $this->getMachineType();
      $this->machines = $this->getMachines();
      $this->facility = $this->getFormType();
      $this->formFields = $this->getFormFields();
      $this->formEntries = $this->getFormEntries();
    }
  }
  public function getMachineType() {
    // retrieves an id,name array corresponding to this form's machine type.
    return $this->dbConn->queryFirstRow("SELECT `machine_types`.`id`, `machine_types`.`name` FROM `forms` LEFT OUTER JOIN `machine_types` ON `machine_types`.`id` = `forms`.`machine_type_id` WHERE `forms`.`id` = ".intval($this->id));
  }
  public function getMachines() {
    // retrieves a list of id,name arrays corresponding to this form's machines, ordered by name asc.
    return $this->dbConn->queryAssoc("SELECT `id`, `name` FROM `machines` WHERE `machines`.`machine_type_id` = ".intval($this->machineType['id'])." ORDER BY `name` ASC");
  }
  public function getFormType() {
    // retrieves an id,name array corresponding to this form's type.
    return $this->dbConn->queryFirstRow("SELECT `form_types`.`id`, `form_types`.`name` FROM `forms` LEFT OUTER JOIN `form_types` ON `form_types`.`id` = `forms`.`form_type_id` WHERE `forms`.`id` = ".intval($this->id));
  }
  public function getFormFields() {
    // retrieves a list of id,name arrays corresponding to this form's fields.
    return $this->dbConn->queryAssoc("SELECT `form_fields`.`id`, `form_fields`.`name` FROM `form_fields` WHERE `form_id` = ".intval($this->id)." ORDER BY `id` ASC");
  }
  public function getFormEntries() {
    // retrieves a list of ids corresponding to this form's entries, ordered by updated_at desc.
    return $this->dbConn->queryAssoc("SELECT `id` FROM `form_entries` WHERE `form_id` = ".intval($this->id)." ORDER BY `updated_at` DESC");
  }
}

?>