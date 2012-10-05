<?php

class FormType {
  public $id;
  public $name;
  public $forms;
  public $dbConn;
  public function __construct($database, $id=Null, $name=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new form type. initialize blank values.
      $this->id = 0;
      $this->name = $name;
      $this->forms = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($name === Null)) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `form_types` WHERE UPPER(`name`) = ".$this->dbConn->quoteSmart($name)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `form_types` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $this->name = $this->dbConn->queryFirstValue("SELECT `name` FROM `form_types` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->forms = $this->getForms();
    }
  }
  public function getForms() {
    // retrieves a list of id,name arrays belonging to the current form type.
    return $this->dbConn->queryAssoc("SELECT `id`, `name` FROM `forms` WHERE `form_type_id` = ".intval($this->id));
  }
}

?>