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
    //if userID is not proper, or if user's last IP was not the requester's IP, return false.
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
    $findUsername = $database->queryFirstRow("SELECT `id`, `name`, `password_hash` FROM `users` WHERE `email` = ".$database->quoteSmart($username)." LIMIT 1");
    if (!$findUsername) {
      return false;
    }
    if (!$bcrypt->verify($password, $findUsername['password_hash'])) {
      return false;
    }
    $_SESSION['id'] = $findUsername['id'];
    $_SESSION['name'] = $findUsername['name'];
    $this->id = $findUsername['id'];
    return true;
  }
  
  public function register($database, $name, $email, $password, $password_confirmation) {
    //check if user's passwords match.
    if ($password != $password_confirmation) {
        $returnArray = array("location" => "register.php", "status" => "Your passwords do not match. Please try again.");      
    } else {
      //check if email is well-formed.
      $email_regex = "/[0-9A-Za-z\\+\\-\\%\\.]+@[0-9A-Za-z\\.\\-]+\\.[A-Za-z]{2,4}/";
      if (!preg_match($email_regex, $email)) {
        $returnArray = array("location" => "register.php", "status" => "The email address you have entered is malformed. Please check it and try again.");
      } else {
        //check if user is already registered.
        $checkNameEmail = intval($database->queryCount("SELECT COUNT(*) FROM `users` WHERE (`name` = ".$database->quoteSmart($name)." || `email` = ".$database->quoteSmart($email).")"));
        if ($checkNameEmail > 0) {
          $returnArray = array("location" => "register.php", "status" => "Your name or email has previously been registered. Please try logging in.");
        } else {
          //register this user.
          $bcrypt = new Bcrypt();
          $registerUser = $database->stdQuery("INSERT INTO `users` SET `name` = ".$database->quoteSmart($name).", `email` = ".$database->quoteSmart($email).", `password_hash` = ".$database->quoteSmart($bcrypt->hash($password)).", `userlevel` = 1, `last_ip` = ".$database->quoteSmart($_SERVER['REMOTE_ADDR']));
          if (!$registerUser) {
            $returnArray = array("location" => "register.php", "status" => "Database errors were encountered during registration. Please try again later.");
          } else {
            $returnArray = array("location" => "index.php", "status" => "Registration successful. You can now log in.");
          }
        }
      }
    }
    return $returnArray;
  }
  
  public function isAdmin($database) {
    if (!$this->loggedIn) {
      return false;
    }
    $checkUserlevel = $database->queryFirstRow("SELECT `userlevel` FROM `users` WHERE `id` = ".intval($this->id));
    if (!$checkUserlevel or intval($checkUserlevel) < 2) {
      return false;
    }
    return true;
  }
}

?>