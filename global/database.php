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
  public function create_or_update_machine_type($user, $machine_type) {
    if (!$user->loggedIn($this)) {
      $returnArray = array('location' => 'index.php', 'status' => 'You are not allowed to modify or create machine types without first logging in.');
    } elseif (!isset($machine_type['name']) || !isset($machine_type['description'])) {
      $returnArray = array('location' => 'machine_type.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    } else {
      //check to see if this is an update.
      $check_machine_type = $this->queryCount("SELECT COUNT(*) FROM `machine_types` WHERE UPPER(`name`) = ".$this->quoteSmart(strtoupper($machine_type['name']))." LIMIT 1");
      if ($check_machine_type === false || $check_machine_type > 0) {
        $get_machine_type_id = intval($this->queryFirstValue("SELECT `id` FROM `machine_types` WHERE UPPER(`name`) = ".$this->quoteSmart(strtoupper($machine_type['name']))." LIMIT 1"));
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
  public function create_or_update_form($user, $form) {
    if (!$user->loggedIn($this)) {
      return array('location' => 'index.php', 'status' => 'You are not allowed to modify or create forms without first logging in.');
    }
    if (!isset($form['name']) || !isset($form['description']) || !isset($form['machine_type_id'])) {
      return array('location' => 'form.php'.((isset($form['id'])) ? "?id=".intval($form['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
    }
    if (isset($form['id'])) {
      // update. check to ensure that this form exists.
      $updateForm = $this->stdQuery("UPDATE `forms` SET `name` = ".$this->quoteSmart($form['name']).", `description` = ".$this->quoteSmart($form['description']).", `machine_type_id` = ".intval($form['machine_type_id']).", `js` = ".$this->quoteSmart($form['js']).", `php` = ".$this->quoteSmart($form['php'])."
                                      WHERE `id` = ".intval($form['id'])." LIMIT 1");
      if (!$updateForm) {
        return array('location' => 'form.php?action=edit&id='.intval($form['id']), 'status' => "An error occurred while updating this form. Please try again.");
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
    if (!isset($form_entry['machine_id']) || !isset($form_entry['form_id'])) {
      return array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'Please specify a machine ID and form ID and try again.');
    } else {
      if (isset($form_entry['id'])) {
        // updating a form entry. check permissions and existence of form entry.
        $checkUser = $this->queryFirstValue("SELECT `user_id` FROM `form_entries` WHERE `id` = ".intval($form_entry['id'])." && `form_id` = ".intval($form_entry['form_id']));
        if (!$checkUser) {
          return array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => 'Cannot find that form entry to update.');          
        }
        if ($user->id != intval($checkUser)) {
          return array('location' => 'form_entry.php'.((isset($form_entry['id'])) ? "?id=".intval($form_entry['id']) : ""), 'status' => "You don't have permissions to update that form entry.");          
        }
        foreach ($form_entry['form_values'] as $name=>$value) {
          $findField = $this->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->quoteSmart($name));
          if (!$findField) {
            $insertField = $this->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->quoteSmart($name).")");
            $findField = $this->insert_id;
          }
          $insertOrUpdateValue = $this->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES (".$this->quoteSmart($value).", ".intval($findField).", ".intval($form_entry['id']).") ON DUPLICATE KEY UPDATE `value` = ".$this->quoteSmart($value));
        }
        return array('location' => 'form_entry.php', 'status' => "Successfully updated form entry.");
      } else {
        // inserting a form entry.
        // ensure that this form exists.
        $checkForm = $this->queryCount("SELECT COUNT(*) FROM `forms` WHERE `id` = ".intval($form_entry['form_id']));
        if (!$checkForm || $checkForm != 1) {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "The specified form does not exist.");                  
        }
        $insertEntry = $this->stdQuery("INSERT INTO `form_entries` (`form_id`, `machine_id`, `user_id`, `comments`, `created_at`, `updated_at`) VALUES (".intval($form_entry['form_id']).", ".intval($form_entry['machine_id']).", ".intval($user->id).", ".$this->quoteSmart($form_entry['comments']).", '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        $form_entry['id'] = intval($this->insert_id);
        $valueQueryArray = [];
        foreach ($form_entry['form_values'] as $name=>$value) {
          $findField = $this->queryFirstValue("SELECT `id` FROM `form_fields` WHERE `form_id` = ".intval($form_entry['form_id'])." && `name` = ".$this->quoteSmart($name));
          if (!$findField) {
            $insertField = $this->stdQuery("INSERT INTO `form_fields` (`form_id`, `name`) VALUES (".intval($form_entry['form_id']).", ".$this->quoteSmart($name).")");
            $findField = $this->insert_id;
          }
          $valueQueryArray[] = "(".$this->quoteSmart($value).", ".intval($findField).", ".intval($form_entry['id']).")";
        }
        $insertFormValues = $this->stdQuery("INSERT INTO `form_values` (`value`, `form_field_id`, `form_entry_id`) VALUES ".implode(",", $valueQueryArray));
        if ($insertFormValues) {
          return array('location' => 'form_entry.php', 'status' => "Successfully inserted form entry.");
        } else {
          return array('location' => 'form_entry.php?action=new'.((isset($form_entry['form_id'])) ? "&form_id=".intval($form_entry['form_id']) : ""), 'status' => "Error while inserting form entry. Please try again.");
        }
      }
    }
  }
}

?>