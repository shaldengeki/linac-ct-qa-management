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
      return array('location' => 'form.php'.((isset($_REQUEST['id'])) ? "?id=".intval($_REQUEST['id']) : ""), 'status' => 'One or more required fields are missing. Please check your input and try again.');
      
    }
  }
}

?>