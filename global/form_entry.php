<?php

class FormEntry {
  public $id;
  public $form;
  public $machine;
  public $user;
  public $comments;
  public $imagePath;
  public $createdAt;
  public $updatedAt;
  public $qaMonth;
  public $qaYear;
  public $approvedOn;
  public $approvedUser;
  public $formValues;
  public $dbConn;
  public function __construct($database, $id) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new entry. initialize blank values.
      $this->id = 0;
      $this->qaMonth = $this->qaYear = 0;
      $this->comments = $this->imagePath =  $this->createdAt = $this->updatedAt = $this->approvedOn = "";
      $this->form = $this->machine = $this->user = $this->approvedUser = $this->formValues = array();
    } else {
      $this->id = intval($this->dbConn->queryFirstValue("SELECT `id` FROM `form_entries` WHERE `id` = ".intval($id)." LIMIT 1"));
      if (!$this->id) {
        throw new Exception("ID Not Found");
      }
      $info = $this->dbConn->queryFirstRow("SELECT `comments`, `image_path`, `created_at`, `qa_month`, `qa_year`, `updated_at`, `approved_on` FROM `form_entries` WHERE `id` = ".intval($this->id)." LIMIT 1");
      $this->comments = $info['comments'];
      $this->imagePath = $info['image_path'];
      $this->createdAt = $info['created_at'];
      $this->qaMonth = intval($info['qa_month']);
      $this->qaYear = intval($info['qa_year']);
      $this->updatedAt = $info['updated_at'];
      $this->approvedOn = $info['approved_on'];
      $this->form = $this->getForm();
      $this->machine = $this->getMachine();
      $this->user = $this->getUser();
      $this->approvedUser = $this->getApprovedUser();
      $this->formValues = $this->getFormValues();
    }
  }
  public function getForm() {
    // retrieves an id,name array corresponding to the form under which this entry is submitted.
    return $this->dbConn->queryFirstRow("SELECT `forms`.`id`, `forms`.`name` FROM `form_entries` LEFT OUTER JOIN `forms` ON `forms`.`id` = `form_entries`.`form_id` WHERE `form_entries`.`id` = ".intval($this->id));
  }
  public function getMachine() {
    // retrieves an id,name,facility_id,machine_type_id array corresponding to the machine for which this entry is submitted.
    return $this->dbConn->queryFirstRow("SELECT `machines`.`id`, `machines`.`name`, `machines`.`facility_id`, `machines`.`machine_type_id` FROM `form_entries` LEFT OUTER JOIN `machines` ON `machines`.`id` = `form_entries`.`machine_id` WHERE `form_entries`.`id` = ".intval($this->id));
  }
  public function getUser() {
    // retrieves an id,name array corresponding to the user who submitted this form entry.
    return $this->dbConn->queryFirstRow("SELECT `users`.`id`, `users`.`name` FROM `form_entries` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`user_id` WHERE `form_entries`.`id` = ".intval($this->id));
  }
  public function getApprovedUser() {
    // retrieves an id,name array corresponding to the user who approved this form entry.
    return $this->dbConn->queryFirstRow("SELECT `users`.`id`, `users`.`name` FROM `form_entries` LEFT OUTER JOIN `users` ON `users`.`id` = `form_entries`.`approved_user_id` WHERE `form_entries`.`id` = ".intval($this->id));
  }
  public function getFormValues() {
    // returns a list of FormValue objects belonging to this entry, ordered by id asc.
    $formValues = [];
    $formValueQuery = $this->dbConn->stdQuery("SELECT `id` FROM `form_values` WHERE `form_entry_id` = ".intval($this->id)." ORDER BY `id` ASC");
    while ($value = $formValueQuery->fetch_assoc()) {
      $formValue = new FormValue($this->dbConn, intval($value['id']));
      $formValues[$formValue->formField['name']] = $formValue;
    }
    return $formValues;
  }
}

?>