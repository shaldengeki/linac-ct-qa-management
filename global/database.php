<?php

class DbConn extends mysqli {
  //basic database connection class that provides input-escaping and standardized query error output.
  
  private $host, $username, $password, $database;

  public function __construct($host, $username, $password, $database) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->database = $database;
    parent::__construct($host, $username, $password, $database);
    if (mysqli_connect_error()) {
      die('Connection error ('.mysqli_connect_errno().')'.
            mysqli_connect_error());
    }
  }
  public function quoteSmart($value) {
    //escapes input values for insertion into a query.
    if( is_array($value) ) {
      return array_map(array($this, $this->quoteSmart), $value);
    } else {
      if( get_magic_quotes_gpc() ) {
        $value = stripslashes($value);
      }
      if( $value == '' ) {
        $value = 'NULL';
      } if( !is_numeric($value) || $value[0] == '0' ) {
        $value = "\"".$this->real_escape_string($value)."\"";
      }
      return $value;
    }
  }
  public function stdQuery($query) {
    //executes a query with standardized error message.
    $result = $this->query($query)
      or die("Could not query MySQL database in ".$_SERVER['PHP_SELF'].".<br />
          ".$this->error."<br />
          Time: ".time());
    return $result;
  }
  public function queryFirstRow($query) {
    $result = $this->stdQuery($query);
    if ($result->num_rows < 1) {
      return false;
    }
    $returnValue = $result->fetch_assoc();
    $result->free();
    return $returnValue;
  }
  public function queryFirstValue($query) {
    $result = $this->queryFirstRow($query);
    if (!$result || count($result) != 1) {
      return false;
    }
    $resultKeys = array_keys($result);
    return $result[$resultKeys[0]];
  }
  public function queryAssoc($query) {
    $result = $this->stdQuery($query);
    if ($result->num_rows < 1) {
      return false;
    }
    $returnValue = $result->fetch_all();
    $result->free();
    return $returnValue;
  }
  public function queryCount($query, $column="*") {
    $result = $this->queryFirstRow($query);
    if (!$result) {
      return false;
    }
    return intval($result['COUNT('.$column.')']);
  }
  public function log_failed_login($email, $password) {
    $insert_log = $this->stdQuery("INSERT IGNORE INTO `failed_logins` (`ip`, `date`, `email`, `password`) VALUES ('".$_SERVER['REMOTE_ADDR']."', NOW(), ".$this->quoteSmart($email).", ".$this->quoteSmart($password).")");
  }
  public function create_or_update_facility($user, $facility) {
    if (!$user->loggedIn($this) || !$user->isAdmin($this)) {
      $returnArray = array('location' => 'index.php', 'status' => 'You are not an administrator and cannot add or update facilities.');
    } elseif (!isset($facility['name'])) {
      $returnArray = array('location' => 'facility.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    } else {
      //check to see if this is an update.
      if (isset($facility['id'])) {
        $get_facility_id = intval($this->queryFirstValue("SELECT `id` FROM `facilities` WHERE `id` = ".intval($facility['id'])." LIMIT 1"));
      } else {
        $get_facility_id = intval($this->queryFirstValue("SELECT `id` FROM `facilities` WHERE UPPER(`name`) = ".$this->quoteSmart(strtoupper($facility['name']))." LIMIT 1"));
      }
      if ($get_facility_id) {
        $update_facility = $this->stdQuery("UPDATE `facilities` SET `name` = ".$this->quoteSmart($facility['name'])." WHERE `id` = ".intval($get_facility_id)." LIMIT 1");
        if (!$update_facility) {
          $returnArray =  array('location' => 'facility.php?action=show&id='.intval($get_facility_id), 'status' => 'An error occurred while updating a facility.');
        } else {
          $returnArray =  array('location' => 'facility.php?action=show&id='.intval($get_facility_id), 'status' => 'Successfully updated facility.');
        }
      } else {
        //add this facility and redirect to it.
        $add_facility = $this->stdQuery("INSERT INTO `facilities` (`name`) VALUES (".$this->quoteSmart($facility['name']).")");
        if (!$add_facility) {
          $returnArray =  array('location' => 'facility.php?action=new', 'status' => 'An error occurred while inserting a facility.');
        } else {
          $returnArray =  array('location' => 'facility.php?action=show&id='.intval($this->insert_id), 'status' => 'Successfully created facility.');
        }
      }
    }
    return $returnArray;
  }
  public function create_or_update_machine_type($user, $machine_type) {
    if (!$user->loggedIn($this) || !$user->isAdmin($this)) {
      $returnArray = array('location' => 'index.php', 'status' => 'You are not allowed to modify or create machine types without first logging in.');
    } elseif (!isset($machine_type['name']) || !isset($machine_type['description'])) {
      $returnArray = array('location' => 'machine_type.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    } else {
      //check to see if this is an update.
      if (isset($machine_type['id'])) {
        $get_machine_type_id = intval($this->queryFirstValue("SELECT `id` FROM `machine_types` WHERE `id` = ".intval($machine_type['id'])." LIMIT 1"));
      } else {
        $get_machine_type_id = intval($this->queryFirstValue("SELECT `id` FROM `machine_types` WHERE UPPER(`name`) = ".$this->quoteSmart(strtoupper($machine_type['name']))." LIMIT 1"));
      }
      if ($get_machine_type_id) {
        $update_machine_type = $this->stdQuery("UPDATE `machine_types` SET `name` = ".$this->quoteSmart($machine_type['name']).", `description` = ".$this->quoteSmart($machine_type['description'])." WHERE `id` = ".intval($get_machine_type_id)." LIMIT 1");
        if (!$update_machine_type) {
          $returnArray =  array('location' => 'machine_type.php?action=show&id='.intval($get_machine_type_id), 'status' => 'An error occurred while updating a machine type.');
        } else {
          $returnArray =  array('location' => 'machine_type.php?action=show&id='.intval($get_machine_type_id), 'status' => 'Successfully updated machine type.');
        }
      } else {
        //add this machine type and redirect to it.
        $add_machine_type = $this->stdQuery("INSERT INTO `machine_types` (`name`, `description`) VALUES (".$this->quoteSmart($machine_type['name']).", ".$this->quoteSmart($machine_type['description']).")");
        if (!$add_machine_type) {
          $returnArray =  array('location' => 'machine_type.php?action=new', 'status' => 'An error occurred while inserting a machine type.');
        } else {
          $returnArray =  array('location' => 'machine_type.php?action=show&id='.intval($this->insert_id), 'status' => 'Successfully created machine type.');
        }
      }
    }
    return $returnArray;
  }
  public function create_or_update_machine($user, $machine) {
    if (!$user->loggedIn($this) || !$user->isAdmin($this) || (intval($machine['facility_id']) != $user->facility_id)) {
      $returnArray = array('location' => 'index.php', 'status' => 'You are not an administrator of this facility and cannot add machines to it.');
    } elseif (!isset($machine['name']) || !isset($machine['machine_type_id']) || !isset($machine['facility_id'])) {
      $returnArray = array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    } else {
      //ensure that this facility exists.
      $check_facility = $this->queryCount("SELECT COUNT(*) FROM `facilities` WHERE `id` = ".intval($machine['facility_id'])." LIMIT 1");
      if (!$check_facility) {
        $returnArray = array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This facility does not exist.');
      } else {
        //ensure that this machine type exists.
        $check_machine_type = $this->queryCount("SELECT COUNT(*) FROM `machine_types` WHERE `id` = ".intval($machine['machine_type_id'])." LIMIT 1");
        if (!$check_machine_type) {
          $returnArray = array('location' => 'machine.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'This machine_type does not exist.');
        } else {
          //check to see if this is an update.
          if (isset($machine['id'])) {
            $get_machine_id = intval($this->queryFirstValue("SELECT `id` FROM `machines` WHERE `id` = ".intval($machine['id'])." LIMIT 1"));
          } else {
            $get_machine_id = intval($this->queryFirstValue("SELECT `id` FROM `machines` WHERE UPPER(`name`) = ".$this->quoteSmart(strtoupper($machine['name']))." LIMIT 1"));
          }
          if ($get_machine_id) {
            $update_machine = $this->stdQuery("UPDATE `machines` SET `name` = ".$this->quoteSmart($machine['name']).", `machine_type_id` = ".intval($machine['machine_type_id']).", `facility_id` = ".intval($machine['facility_id'])." WHERE `id` = ".intval($get_machine_id)." LIMIT 1");
            if (!$update_machine) {
              $returnArray =  array('location' => 'machine.php?action=show&id='.intval($get_machine_id), 'status' => 'An error occurred while updating a machine.');
            } else {
              $returnArray =  array('location' => 'machine.php?action=show&id='.intval($get_machine_id), 'status' => 'Successfully updated machine.');
            }
          } else {
            //add this machine and redirect to it.
            $add_machine = $this->stdQuery("INSERT INTO `machines` (`name`, `machine_type_id`, `facility_id`) VALUES (".$this->quoteSmart($machine['name']).", ".intval($machine['machine_type_id']).", ".intval($machine['facility_id']).")");
            if (!$add_machine) {
              $returnArray =  array('location' => 'machine.php?action=new', 'status' => 'An error occurred while inserting a machine.');
            } else {
              $returnArray =  array('location' => 'machine.php?action=show&id='.intval($this->insert_id), 'status' => 'Successfully created machine.');
            }
          }
        }
      }
    }
    return $returnArray;
  }
  public function create_or_update_form($user, $form) {
    if (!$user->loggedIn($this) || !$user->isAdmin($this)) {
      return array('location' => 'index.php', 'status' => 'You are not allowed to modify or create forms without first logging in.');
    }
    if (!isset($form['name']) || !isset($form['description']) || !isset($form['machine_type_id'])) {
      return array('location' => 'form.php'.((isset($form['id'])) ? "?id=".intval($form['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    }
    $get_form_id = intval($this->queryFirstValue("SELECT `id` FROM `forms` WHERE `id` = ".intval($form['id'])." LIMIT 1"));
    if ($get_form_id) {
      // update. check to ensure that this form exists.
      $updateForm = $this->stdQuery("UPDATE `forms` SET `name` = ".$this->quoteSmart($form['name']).", `description` = ".$this->quoteSmart($form['description']).", `machine_type_id` = ".intval($form['machine_type_id']).", `js` = ".$this->quoteSmart($form['js']).", `php` = ".$this->quoteSmart($form['php'])."
                                      WHERE `id` = ".intval($get_form_id)." LIMIT 1");
      if (!$updateForm) {
        return array('location' => 'form.php?action=edit&id='.intval($get_form_id), 'status' => "An error occurred while updating this form. Please try again.");
      } else {
        return array('location' => 'form.php', 'status' => "Form successfully updated.");
      }
    } else {
      // inserting form.
      $insertForm = $this->stdQuery("INSERT INTO `forms` SET `name` = ".$this->quoteSmart($form['name']).", `description` = ".$this->quoteSmart($form['description']).", `machine_type_id` = ".intval($form['machine_type_id']).", `js` = ".$this->quoteSmart($form['js']).", `php` = ".$this->quoteSmart($form['php']));
      if (!$insertForm) {
        return array('location' => 'form.php?action=new', 'status' => "An error occurred while creating this form. Please try again.");
      } else {
        return array('location' => 'form.php', 'status' => "Form successfully created.");
      }
    }
  }
  public function create_or_update_form_entry($user, $form_entry) {
    if (!$user->loggedIn($this)) {
      return array('location' => 'index.php', 'status' => 'You are not allowed to modify or create forms without first logging in.');
    }
    if (!isset($form_entry['machine_id']) || !isset($form_entry['form_id']) || !isset($form_entry['created_at']) || intval($form_entry['machine_id']) == 0 || intval($form_entry['form_id']) == 0 || intval($form_entry['created_at']) == 0) {
      return array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'Please specify a machine ID, form ID, and recording time and try again.');
    } else {
      $machineFacility = intval($this->queryFirstValue("SELECT `facility_id` FROM `machines` WHERE `id` = ".intval($form_entry['machine_id'])." LIMIT 1"));
      if ($machineFacility != $user->facility_id) {
        return array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'This machine does not belong to your facility.');
      } else {
        $get_form_entry_id = intval($this->queryFirstValue("SELECT `id` FROM `form_entries` WHERE `id` = ".intval($form_entry['id'])." LIMIT 1"));
        if ($get_form_entry_id) {
          // updating a form entry.
          $checkUser = $this->queryFirstValue("SELECT `user_id` FROM `form_entries` WHERE `id` = ".intval($get_form_entry_id)." && `form_id` = ".intval($form_entry['form_id']));
          if (!$checkUser) {
            return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => 'Cannot find that form entry to update.');          
          }
          if ($user->id != intval($checkUser) && !$user->isAdmin($this)) {
            return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "You don't have permissions to update that form entry.");
          }
          foreach ($form_entry['form_values'] as $name=>$value) {
            if ($value == 'NULL') {
              continue;
            }
            $findField = $this->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->quoteSmart($name));
            if (!$findField) {
              $insertField = $this->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->quoteSmart($name).")");
              $findField = $this->insert_id;
            }
            $insertOrUpdateValue = $this->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES (".$this->quoteSmart($value).", ".intval($findField).", ".intval($get_form_entry_id).") ON DUPLICATE KEY UPDATE `value` = ".$this->quoteSmart($value));
          }
          // process uploaded image.
          $file_array = $_FILES['form_image'];
          if (!empty($file_array['tmp_name']) && is_uploaded_file($file_array['tmp_name'])) {
            if ($file_array['error'] != UPLOAD_ERR_OK) {
              return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "There was an error uploading your image file.");
            }
            $file_contents = file_get_contents($file_array['tmp_name']);
            if (!$file_contents) {
              return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "Could not read contents of uploaded image file.");
            }
            $newIm = @imagecreatefromstring($file_contents);
            if (!$newIm) {
              return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "The image file you uploaded is invalid.");
            }
            $imageSize = getimagesize($file_array['tmp_name']);
            if ($imageSize[0] > 5000 || $imageSize[1] > 5000) {
              return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "The maximum allowed size for images is 5000x5000 pixels.");
            }
            // move file to destination and save path in db.
            if (!is_dir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']))) {
              mkdir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']));
            }
            $imagePathInfo = pathinfo($file_array['tmp_name']);
            $imagePath = joinPaths("uploads", "forms", $form_entry['form_id'], $form_entry['id'].image_type_to_extension($imageSize[2]));
            if (!move_uploaded_file($file_array['tmp_name'], $imagePath)) {
              return array('location' => 'form_entry.php'.((isset($get_form_entry_id)) ? "?id=".intval($get_form_entry_id) : ""), 'status' => "There was an error moving your uploaded file.");
            }
            $updateFormEntry = $this->stdQuery("UPDATE `form_entries` SET `machine_id` = ".intval($form_entry['machine_id']).", `image_path` = ".$this->quoteSmart($imagePath).", `created_at` = '".date('Y-m-d H:i:s', strtotime($form_entry['created_at']))."', `qa_month` = ".intval($form_entry['qa_month']).", `qa_year` = ".intval($form_entry['qa_year']).", `updated_at` = '".date('Y-m-d H:i:s')."' WHERE `id` = ".intval($form_entry['id'])." LIMIT 1");
          }
          return array('location' => 'form_entry.php?action=index&form_id='.$form_entry['form_id'], 'status' => "Successfully updated form entry.");
        } else {
          // inserting a form entry.
          // ensure that this form exists.
          $checkForm = $this->queryCount("SELECT COUNT(*) FROM `forms` WHERE `id` = ".intval($form_entry['form_id']));
          if (!$checkForm || $checkForm != 1) {
            return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The specified form does not exist.");                  
          }
          $insertEntry = $this->stdQuery("INSERT INTO `form_entries` (`form_id`, `machine_id`, `user_id`, `comments`, `image_path`, `created_at`, `qa_month`, `qa_year`, `updated_at`) VALUES (".intval($form_entry['form_id']).", ".intval($form_entry['machine_id']).", ".intval($user->id).", ".$this->quoteSmart($form_entry['comments']).", '', '".date('Y-m-d H:i:s', strtotime($form_entry['created_at']))."', ".intval($form_entry['qa_month']).", ".intval($form_entry['qa_year']).", '".date('Y-m-d H:i:s')."')");
          $form_entry['id'] = intval($this->insert_id);
          $valueQueryArray = [];
          foreach ($form_entry['form_values'] as $name=>$value) {
            $findField = $this->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->quoteSmart($name));
            if (!$findField) {
              $insertField = $this->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->quoteSmart($name).")");
              $findField = $this->insert_id;
            }
            if ($value != '') {
              $valueQueryArray[] = "(".$this->quoteSmart($value).", ".intval($findField).", ".intval($form_entry['id']).")";
            }
          }
          $insertFormValues = $this->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES ".implode(",", $valueQueryArray));
          if (!$insertFormValues) {
            return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "Error while inserting form entry. Please try again.");
          }
          // process uploaded image (if there is one)
          $file_array = $_FILES['form_image'];
          if (!empty($file_array['tmp_name']) && is_uploaded_file($file_array['tmp_name'])) {
            if ($file_array['error'] != UPLOAD_ERR_OK) {
              return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "There was an error uploading your image file.");
            }
            $file_contents = file_get_contents($file_array['tmp_name']);
            if (!$file_contents) {
              return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "Could not read contents of uploaded image file.");
            }
            $newIm = @imagecreatefromstring($file_contents);
            if (!$newIm) {
              return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The image file you uploaded is invalid.");
            }
            $imageSize = getimagesize($file_array['tmp_name']);
            if ($imageSize[0] > 5000 || $imageSize[1] > 5000) {
              return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The maximum allowed size for images is 2000x2000 pixels.");
            }
            // move file to destination and save path in db.
            if (!is_dir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']))) {
              mkdir(joinPaths($_SERVER[''], "uploads", "forms", $form_entry['form_id']));
            }
            $imagePathInfo = pathinfo($file_array['tmp_name']);
            $imagePath = joinPaths("uploads", "forms", $form_entry['form_id'], $form_entry['id'].'.'.$imagePathInfo['extension']);
            if (!move_uploaded_file($file_array['tmp_name'], $imagePath)) {
              return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "There was an error moving your uploaded file.");
            }
            $updateImagePath = $this->stdQuery("UPDATE `form_entries` SET `image_path` = ".$this->quoteSmart($imagePath)." WHERE `id` = ".intval($form_entry['id'])." LIMIT 1");
          }
          return array('location' => 'form_entry.php?action=index&form_id='.intval($form_entry['form_id']), 'status' => "Successfully inserted form entry.");
        }
      }
    }
  }
  public function create_or_update_user($user, $user_entry) {
    //check to see if we have permissions to insert/update this user.
    if (!$user->loggedIn($this)) {
      return array('location' => 'user.php', 'status' => 'You are not allowed to modify or create users without first logging in.');
    }
    if (!isset($user_entry['id']) && !$user->isAdmin($this)) {
      return array('location' => 'user.php', 'status' => 'Only administrators are allowed to register new users. Please contact your facility administrator.');
    }
    if (isset($user_entry['id']) && intval($user_entry['id']) != $user->id && !$user->isAdmin($this)) {
      return array('location' => 'user.php', 'status' => 'You are not allowed to modify another user.');
    }
    
    //if changing userlevel, check to ensure that they are setting it equal to or less than their current userlevel.
    if (isset($user_entry['userlevel']) && intval($user_entry['userlevel']) > $user->userlevel) {
      return array('location' => 'user.php', 'status' => 'You are not allowed to set userlevels beyond your current userlevel.');
    }
    //if changing facility, check to ensure that they are an administrator.
    if (isset($user_entry['facility_id']) && !$user->isAdmin($this)) {
      return array('location' => 'user.php', 'status' => 'You are not allowed to change your facility. Please contact a facility administrator.');
    }
    
    //check to ensure that email and password are well-formed and valid.
    $email_regex = "/[0-9A-Za-z\\+\\-\\%\\.]+@[0-9A-Za-z\\.\\-]+\\.[A-Za-z]{2,4}/";
    if (!preg_match($email_regex, $user_entry['email'])) {
      return array("location" => "user.php", "status" => "The email address you have entered is malformed. Please check it and try again.");
    }
    if ($user_entry['password'] != $user_entry['password_confirmation']) {
      return array("location" => "user.php", "status" => "The passwords you have entered do not match. Please check them and try again.");
    }
    
    //go ahead and register or update this user.
    if (isset($user_entry['id'])) {
      //update this user.
      $optionalFields = "";
      $userDbObject = False;
      if (isset($user_entry['password']) && $user_entry['password'] != '') {
        $bcrypt = new Bcrypt();
        $optionalFields .= ", `password_hash` = ".$this->quoteSmart($bcrypt->hash($user_entry['password']));
      }
      if (isset($user_entry['userlevel']) && intval($user_entry['userlevel']) != 0) {
        $optionalFields .= ", `userlevel` = ".intval($user_entry['userlevel']);
      }
      if (isset($user_entry['facility_id']) && intval($user_entry['facility_id']) != 0) {
        $optionalFields .= ", `facility_id` = ".intval($user_entry['facility_id']);
      }
      $updateUser = $this->stdQuery("UPDATE `users` SET `name` = ".$this->quoteSmart($user_entry['name']).", 
                                      `email` = ".$this->quoteSmart($user_entry['email']).$optionalFields."
                                      WHERE `id` = ".intval($user_entry['id'])."
                                      LIMIT 1");
      if (!$updateUser) {
        return array('location' => 'user.php?action=edit&id='.intval($user_entry['id']), 'status' => "Error while updating user. Please try again.");
      }
    } else {
      //insert this user.
      $bcrypt = new Bcrypt();
      $insertUser = $this->stdQuery("INSERT INTO `users` (`name`, `email`, `password_hash`, `userlevel`, `facility_id`) VALUES (".$this->quoteSmart($user_entry['name']).", ".$this->quoteSmart($user_entry['email']).", ".$this->quoteSmart($bcrypt->hash($user_entry['password'])).", ".intval($user_entry['userlevel']).", ".intval($user_entry['facility_id']).")");
      if (!$insertUser) {
        return array('location' => 'user.php?action=new', 'status' => "Error while creating user. Please try again.");
      }
    }
    return array('location' => 'user.php', 'status' => 'Successfully created user.');
  }
  public function generate_backup($user, $backup) {
    //generates a backup according to submitted parameters.
    if (!$user->loggedIn($this)) {
      return array('location' => 'main.php', 'status' => 'Please log in to generate backups.');
    }
    if (!isset($backup['contents']) || !is_array($backup['contents']) || count($backup['contents']) < 1) {
      return array('location' => 'backup.php', 'status' => 'Please select at least one option for backup contents.');
    }
    if (!isset($backup['action']) || !is_array($backup['action']) || count($backup['action']) < 1) {
      return array('location' => 'backup.php', 'status' => 'Please select at least one place to save backup contents.');
    }
    //create the individual backup files.
    $output_files = array();
    $dateObject = new DateTime();
    foreach ($backup['contents'] as $content) {
      switch($content) {
        case 'database':
          $backup_file_name = 'backup-database-'.$dateObject->format('Y-m-d-H-i-s-u').'.sql';
          exec('mysqldump -u'.addslashes(MYSQL_USERNAME).' -p'.addslashes(MYSQL_PASSWORD).' --ignore-table='.addslashes(MYSQL_DATABASE).'.users '.addslashes(MYSQL_DATABASE).' > '.APP_ROOT.'/backups/'.$backup_file_name, $file_output, $file_return);
          if (intval($file_return) != 0) {
            return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($file_return).') while creating a backup of the database structure. Please try again.');
          }
          $output_files[] = $backup_file_name;
          break;
        case 'files':
          $backup_file_name = 'backup-files-'.$dateObject->format('Y-m-d-H-i-s-u').'.tar.gz';
          exec('cd '.APP_ROOT.' && tar cf ./backups/'.$backup_file_name.' --exclude "backups/*.tar.gz" *', $file_output, $file_return);
          if (intval($file_return) != 0) {
            return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($file_return).') while creating a backup of the files. Please try again.');
          }
          $output_files[] = $backup_file_name;
          break;
        default:
          break;
      }
    }
    if (count($output_files) < 1) {
      return array('location' => 'backup.php', 'status' => 'Nothing was successfully backed up. Please try again.');      
    }
    //create a single backup tarball.
    $backup_file_name = 'backup-'.$dateObject->format('Y-m-d-H-i-s-u').'.tar.gz';
    $tar_command = 'cd '.APP_ROOT.'/backups/ && tar cf '.$backup_file_name.' '.implode(' ', $output_files);
    $cleanup_command = 'cd '.APP_ROOT.'/backups/ && rm '.implode(' ', $output_files);
    exec($tar_command, $tar_output, $tar_return);
    if (intval($tar_return) != 0) {
      return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($tar_return).') while creating a master tarball backup. Please try again.');
    }
    exec($cleanup_command, $cleanup_output, $cleanup_return);
    if (intval($cleanup_return) != 0) {
      return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($cleanup_return).') while cleaning up the backup directory. Please try again.');
    }
    
    //insert this backup into the db list.
    $insert_backup = $this->stdQuery("INSERT INTO `backups` (`created_at`, `path`, `user_id`) VALUES ('".date('Y-m-d H:i:s')."', ".$this->quoteSmart('backups/'.$backup_file_name).", ".intval($user->id).")");
    if (!$insert_backup) {
      return array('location' => 'backup.php', 'status' => 'There was an error while logging the backup. Please try again.');
    }
    
    //now do what the user has requested with these backup files.
    foreach ($backup['action'] as $action) {
      switch($action) {
        case 'local':
          break;
        case 'remote':
          return array('location' => 'backups/'.$backup_file_name, 'status' => '');
          break;
        default:
          break;
      }
    }
    return array('location' => 'backup.php', 'status' => 'Backup successfully created.');
  }
}

?>