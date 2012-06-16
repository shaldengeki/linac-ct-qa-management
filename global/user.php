<?php

class User {

  private $id;
  public $name;
  
  public function __construct($inputArray) {
    foreach ($inputArray as $key=>$value) {
      $this->{$key}= $value;
    }
  }
  public function loggedIn($database) {
    if (intval($this->id) <= 0) {
      return false;
    }
    $thisUserInfo = $database->queryFirstRow("SELECT `last_ip` FROM `users` WHERE `id` = ".intval($this->id)." LIMIT 1");
    if ($thisUserInfo['last_ip'] != $_SERVER['REMOTE_ADDR']) {
      return false;
    }
    return true;
  }
  public function logIn($database, $username, $password) {
    $bcrypt = new Bcrypt();
    $findUsername = $database->queryFirstRow("SELECT `id`, `name`, `password_hash`, `salt` FROM `users` WHERE `email` = ".$database->quoteSmart($username)." LIMIT 1");
    if (!$findUsername) {
      return false;
    }
    if (!$bcrypt->verify($findUsername['salt'].$password, $findUsername['password_hash'])) {
      return false;
    }
    $_SESSION['id'] = $findUsername['id'];
    $_SESSION['name'] = $findUsername['name'];
    $this->id = $findUsername['id'];
    return true;
  }
}

?>