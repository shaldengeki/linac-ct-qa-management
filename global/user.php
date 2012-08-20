<?php

class User {

  public $id;
  public $name;
  public $userlevel;
  public $facility_id;
  
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
    // rate-limit requests.
    $numFailedRequests = $database->queryCount("SELECT COUNT(*) FROM `failed_logins` WHERE `ip` = ".$database->quoteSmart($_SERVER['REMOTE_ADDR'])." AND `date` > NOW() - INTERVAL 1 HOUR");
    if ($numFailedRequests > 5) {
      return array("location" => "index.php", "status" => "You have had too many unsuccessful login attempts. Please wait awhile and try again.");
    }
  
    $bcrypt = new Bcrypt();
    $findUsername = $database->queryFirstRow("SELECT `id`, `name`, `facility_id`, `userlevel`, `password_hash` FROM `users` WHERE `email` = ".$database->quoteSmart($username)." LIMIT 1");
    if (!$findUsername) {
      $database->log_failed_login($username, $password);
      return array("location" => "index.php", "status" => "Could not log in with the supplied credentials.");
    }
    if (!$bcrypt->verify($password, $findUsername['password_hash'])) {
      $database->log_failed_login($username, $password);
      return array("location" => "index.php", "status" => "Could not log in with the supplied credentials.");
    }
    
    //update last IP address.
    $updateLastIP = $database->stdQuery("UPDATE `users` SET `last_ip` = ".$database->quoteSmart($_SERVER['REMOTE_ADDR'])." WHERE `id` = ".intval($findUsername['id'])." LIMIT 1");
    $_SESSION['id'] = $findUsername['id'];
    $_SESSION['name'] = $findUsername['name'];
    $_SESSION['facility_id'] = $findUsername['facility_id'];
    $_SESSION['userlevel'] = $findUsername['userlevel'];
    $this->id = intval($findUsername['id']);
    $this->facility_id = intval($findUsername['facility_id']);
    $this->userlevel = intval($findUsername['userlevel']);
    return array("location" => "main.php", "status" => "Successfully logged in.");
  }
  
  public function register($database, $name, $email, $password, $password_confirmation, $facility_id) {
    //registration is closed to all non-admin users.
    if (!$this->loggedIn($database) || !$this->isAdmin($database)) {
      $returnArray = array("location" => "register.php", "status" => "Registration is closed to all non-admin users. Please contact your facility administrator for access.");
    } else {
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
            //check if this facility exists.
            $checkFacilityExists = intval($database->queryCount("SELECT COUNT(*) FROM `facilities` WHERE `id` = ".intval($facility_id)));
            if ($checkFacilityExists < 1) {
              $returnArray = array("location" => "register.php", "status" => "That facility does not exist. Please try again.");
            } else {
              //register this user.
              $bcrypt = new Bcrypt();
              $registerUser = $database->stdQuery("INSERT INTO `users` SET `name` = ".$database->quoteSmart($name).", `email` = ".$database->quoteSmart($email).", `password_hash` = ".$database->quoteSmart($bcrypt->hash($password)).", `userlevel` = 1, `last_ip` = ".$database->quoteSmart($_SERVER['REMOTE_ADDR']).", `facility_id` = ".intval($facility_id));
              if (!$registerUser) {
                $returnArray = array("location" => "register.php", "status" => "Database errors were encountered during registration. Please try again later.");
              } else {
                $returnArray = array("location" => "register.php", "status" => "Registration successful. ".escape_output($name)." can now log in.");
              }
            }
          }
        }
      }
    }
    return $returnArray;
  }
  
  public function isAdmin($database) {
    if (!$this->loggedIn($database)) {
      return false;
    }
    $checkUserlevel = $database->queryFirstValue("SELECT `userlevel` FROM `users` WHERE `id` = ".intval($this->id));
    if (!$checkUserlevel or intval($checkUserlevel) < 2) {
      return false;
    }
    return true;
  }
  
  public function facility($database) {
    if (!$this->facility_id) {
      return false;
    }
    $getFacility = $database->queryFirstRow("SELECT * FROM `facilities` WHERE `id` = ".intval($this->facility_id)." LIMIT 1");
    if (!$getFacility) {
      return false;
    }
    return $getFacility;
  }
}

?>