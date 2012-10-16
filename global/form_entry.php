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
  public function __construct($database, $id, $form_id=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      // creating a new entry. initialize blank values.
      $this->id = 0;
      $this->qaMonth = $this->qaYear = 0;
      $this->comments = $this->imagePath =  $this->createdAt = $this->updatedAt = $this->approvedOn = "";
      $this->form = $this->machine = $this->user = $this->approvedUser = $this->formValues = array();
      if ($form_id === Null || !is_numeric($form_id)) {
      } else {
        try {
          $targetForm = new Form($database, intval($form_id));
          $this->form = array('id' => $targetForm->id, 'name' => $targetForm->name);
        } catch (Exception $e) {
          $this->form = array();
        }
      }
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
  public function getAutosaveValues($user) {
    // retrieve this user's autosave values for this form.
    if (!$this->form) {
      return array();
    }
    $formValues = [];
    $autosaveValues = $this->dbConn->stdQuery("SELECT `form_field_id`, `value` FROM `form_values_autosave` LEFT OUTER JOIN `form_fields` ON `form_fields`.`id` = `form_field_id` WHERE `form_id` = ".intval($this->form['id'])." && `user_id` = ".intval($user->id));
    while ($value = $autosaveValues->fetch_assoc()) {
      $formValue = new FormValue($this->dbConn, 0, intval($value['form_field_id']));
      $formValue->value = $value['value'];
      $formValues[$formValue->formField['name']] = $formValue;
    }
    return $formValues;
  }
  public function setApproval($user, $approval) {
    // takes a user and an approval value and sets this form entry to be approved by this user / unapproved.
    // returns a boolean.
    if (intval($approval)) {
      $setApproval = $this->dbConn->stdQuery("UPDATE `form_entries` SET `updated_at` = NOW(), `approved_on` = NOW(), `approved_user_id` = ".intval($user->id)." WHERE `id` = ".intval($this->id)." LIMIT 1");
    } else {
      $setApproval = $this->dbConn->stdQuery("UPDATE `form_entries` SET `updated_at` = NOW(), `approved_on` = NULL, `approved_user_id` = NULL WHERE `id` = ".intval($this->id)." LIMIT 1");
    }
    if ($setApproval) {
      return True;
    } else {
      return False;
    }
  }
  public function create_or_update($form_entry) {
    // creates or updates the current form entry with the information in $form_entry
    // returns a redirect_to array.
    if ($this->id != 0) {
      //update this form entry.
      foreach ($form_entry['form_values'] as $name=>$value) {
        if ($value == 'NULL') {
          continue;
        }
        $findField = $this->dbConn->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->dbConn->quoteSmart($name));
        if (!$findField) {
          $insertField = $this->dbConn->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->dbConn->quoteSmart($name).")");
          $findField = $this->dbConn->insert_id;
        }
        $insertOrUpdateValue = $this->dbConn->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES (".$this->dbConn->quoteSmart($value).", ".intval($findField).", ".intval($this->id).") ON DUPLICATE KEY UPDATE `value` = ".$this->dbConn->quoteSmart($value));
      }
      // process uploaded image.
      $file_array = $_FILES['form_image'];
      $imagePath = "";
      if (!empty($file_array['tmp_name']) && is_uploaded_file($file_array['tmp_name'])) {
        if ($file_array['error'] != UPLOAD_ERR_OK) {
          return array('location' => 'form_entry.php?action=edit&id='.intval($this->id), 'status' => "There was an error uploading your image file.", 'class' => 'error');
        }
        $file_contents = file_get_contents($file_array['tmp_name']);
        if (!$file_contents) {
          return array('location' => 'form_entry.php?action=edit&id='.intval($this->id), 'status' => "Could not read contents of uploaded image file.", 'class' => 'error');
        }
        $newIm = @imagecreatefromstring($file_contents);
        if (!$newIm) {
          return array('location' => 'form_entry.php?action=edit&id='.intval($this->id), 'status' => "The image file you uploaded is invalid.", 'class' => 'error');
        }
        $imageSize = getimagesize($file_array['tmp_name']);
        if ($imageSize[0] > 5000 || $imageSize[1] > 5000) {
          return array('location' => 'form_entry.php?action=edit&id='.intval($this->id), 'status' => "The maximum allowed size for images is 5000x5000 pixels.", 'class' => 'error');
        }
        // move file to destination and save path in db.
        if (!is_dir(joinPaths($_SERVER[''], "uploads", "forms", intval($form_entry['form_id'])))) {
          mkdir(joinPaths($_SERVER[''], "uploads", "forms", intval($form_entry['form_id'])));
        }
        $imagePathInfo = pathinfo($file_array['tmp_name']);
        $imagePath = joinPaths("uploads", "forms", intval($form_entry['form_id']), $form_entry['id'].image_type_to_extension($imageSize[2]));
        if (!move_uploaded_file($file_array['tmp_name'], $imagePath)) {
          return array('location' => 'form_entry.php?action=edit&id='.intval($this->id), 'status' => "There was an error moving your uploaded file.", 'class' => 'error');
        }
      } else {
        $imagePath = $this->imagePath;
      }
      $updateFormEntry = $this->dbConn->stdQuery("UPDATE `form_entries` SET `user_id` = ".intval($form_entry['user_id']).", `machine_id` = ".intval($form_entry['machine_id']).", `comments` = ".$this->dbConn->quoteSmart($form_entry['comments']).", `image_path` = ".$this->dbConn->quoteSmart($imagePath).", `created_at` = '".date('Y-m-d H:i:s', strtotime($form_entry['created_at']))."', `qa_month` = ".intval($form_entry['qa_month']).", `qa_year` = ".intval($form_entry['qa_year']).", `updated_at` = '".date('Y-m-d H:i:s')."' WHERE `id` = ".intval($form_entry['id'])." LIMIT 1");
      return array('location' => 'form_entry.php?action=index&form_id='.$form_entry['form_id'], 'status' => "Successfully updated form entry.", 'class' => 'success');
    } else {
      // inserting a form entry.
      // ensure that this form exists.
      $checkForm = $this->dbConn->queryCount("SELECT COUNT(*) FROM `forms` WHERE `id` = ".intval($form_entry['form_id']));
      if (!$checkForm || $checkForm != 1) {
        return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The specified form does not exist.", 'class' => 'error');                  
      }
      $insertEntry = $this->dbConn->stdQuery("INSERT INTO `form_entries` (`form_id`, `machine_id`, `user_id`, `comments`, `image_path`, `created_at`, `qa_month`, `qa_year`, `updated_at`) VALUES (".intval($form_entry['form_id']).", ".intval($form_entry['machine_id']).", ".intval($form_entry['user_id']).", ".$this->dbConn->quoteSmart($form_entry['comments']).", '', '".date('Y-m-d H:i:s', strtotime($form_entry['created_at']))."', ".intval($form_entry['qa_month']).", ".intval($form_entry['qa_year']).", '".date('Y-m-d H:i:s')."')");
      $form_entry['id'] = intval($this->dbConn->insert_id);
      $valueQueryArray = [];
      foreach ($form_entry['form_values'] as $name=>$value) {
        $findField = $this->dbConn->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->dbConn->quoteSmart($name));
        if (!$findField) {
          $insertField = $this->dbConn->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->dbConn->quoteSmart($name).")");
          $findField = $this->dbConn->insert_id;
        }
        if ($value != '') {
          $valueQueryArray[] = "(".$this->dbConn->quoteSmart($value).", ".intval($findField).", ".intval($form_entry['id']).")";
        }
      }
      $insertFormValues = $this->dbConn->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES ".implode(",", $valueQueryArray));
      if (!$insertFormValues) {
        return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "Error while inserting form entry. Please try again.", 'class' => 'error');
      }
      // process uploaded image (if there is one)
      $file_array = $_FILES['form_image'];
      if (!empty($file_array['tmp_name']) && is_uploaded_file($file_array['tmp_name'])) {
        if ($file_array['error'] != UPLOAD_ERR_OK) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "There was an error uploading your image file.", 'class' => 'error');
        }
        $file_contents = file_get_contents($file_array['tmp_name']);
        if (!$file_contents) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "Could not read contents of uploaded image file.", 'class' => 'error');
        }
        $newIm = @imagecreatefromstring($file_contents);
        if (!$newIm) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The image file you uploaded is invalid.", 'class' => 'error');
        }
        $imageSize = getimagesize($file_array['tmp_name']);
        if ($imageSize[0] > 5000 || $imageSize[1] > 5000) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The maximum allowed size for images is 5000x5000 pixels.", 'class' => 'error');
        }
        // move file to destination and save path in db.
        if (!is_dir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']))) {
          mkdir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']));
        }
        $imagePathInfo = pathinfo($file_array['tmp_name']);
        $imagePath = joinPaths("uploads", "forms", $form_entry['form_id'], $form_entry['id'].'.'.$imagePathInfo['extension']);
        if (!move_uploaded_file($file_array['tmp_name'], $imagePath)) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "There was an error moving your uploaded file.", 'class' => 'error');
        }
        $updateImagePath = $this->dbConn->stdQuery("UPDATE `form_entries` SET `image_path` = ".$this->dbConn->quoteSmart($imagePath)." WHERE `id` = ".intval($form_entry['id'])." LIMIT 1");
      }
      return array('location' => 'form_entry.php?action=index&form_id='.intval($form_entry['form_id']), 'status' => "Successfully inserted form entry.", 'class' => 'success');
    }
  }
  public function create_or_update_autosave($user, $form_id, $form_entry) {
    // takes a user and a form entry value and creates or updates an autosave entry for it.
    // check to see if this user already has an autosave entry under this value.
    foreach ($form_entry['form_values'] as $fieldName => $entryValue) {
      // get this form field.
      $formField = $this->dbConn->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_id)." && `name` = ".$this->dbConn->quoteSmart($fieldName)." LIMIT 1");
      if (!$formField) {
        return False;
      }
      // see if this user already has an autosave entry under this form field.
      $extantValue = $this->dbConn->queryFirstValue("SELECT `value` FROM `form_values_autosave` WHERE `form_field_id` = ".intval($formField)." && `user_id` = ".intval($user->id)." LIMIT 1");
      if ($extantValue) {
        if ($extantValue != $entryValue) {
          // update extant entry.
          $updateEntry = $this->dbConn->stdQuery("UPDATE `form_values_autosave` SET `value` = ".$this->dbConn->quoteSmart($entryValue)." WHERE `form_field_id` = ".intval($formField)." && `user_id` = ".intval($user->id)." LIMIT 1");
          if (!$updateEntry) {
            return False;
          }
        }
      } else {
        $insertEntry = $this->dbConn->stdQuery("INSERT INTO `form_values_autosave` (`form_field_id`, `user_id`, `value`) VALUES (".intval($formField).", ".intval($user->id).", ".$this->dbConn->quoteSmart($entryValue).")");
        if (!$insertEntry) {
          return False;
        }
      }
    }

    return True;
  }
  public function delete() {
    // deletes the current form entry.
    // returns a boolean.
    if (!is_numeric($this->id) || !$this->id) {
      return False;
    }
    $deleteEntry = $this->dbConn->stdQuery("DELETE FROM `form_entries` WHERE `id` = ".intval($this->id)." LIMIT 1");
    if ($deleteEntry) {
      return True;
    } else {
      return False;
    }
  }
}

?>