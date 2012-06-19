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
}

?>