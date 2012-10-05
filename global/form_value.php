<?php

class FormValue {
  public $id;
  public $value;
  public $formField;
  public $formEntry;
  public $dbConn;
  public function __construct($database, $id=Null, $formField=Null, $formEntry=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new value. initialize blank values.
      $this->id = 0;
      $this->value = $this->formEntry = 0;
      $this->formField = array();
    } else {
      if (!$id || !is_numeric($id)) {
        if (!($formField === Null || !is_numeric($formField)) && !($formEntry === Null || !is_numeric($formEntry))) {
          $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `form_values` WHERE `form_field_id` = ".intval($formField)." && `form_entry_id` = ".intval($formEntry)." LIMIT 1"));
        } else {
          throw new Exception("Invalid Arguments");
        }
      } else {
        $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `form_values` WHERE `id` = ".intval($id)." LIMIT 1"));
      }
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $this->value = $this->dbConn->queryFirstValue("SELECT `value` FROM `form_values` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->formField = $this->getFormField();
      $this->formEntry = $this->getFormEntry();
    }
  }
  public function getFormField() {
    // retrieves an id,name array corresponding to the field under which this value is submitted.
    return $this->dbConn->queryFirstRow("SELECT `form_fields`.`id`, `form_fields`.`name` FROM `form_values` LEFT OUTER JOIN `form_fields` ON `form_fields`.`id` = `form_values`.`form_field_id` WHERE `form_values`.`id` = ".intval($this->id));
  }
  public function getFormEntry() {
    // retrieves the id corresponding to the form entry under which this value is submitted.
    return $this->dbConn->queryFirstRow("SELECT `form_entries`.`id` FROM `form_values` LEFT OUTER JOIN `form_entries` ON `form_entries`.`id` = `form_values`.`form_entry_id` WHERE `form_values`.`id` = ".intval($this->id));
  }
}

?>