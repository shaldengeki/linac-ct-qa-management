<?php

class User {
  public $id;
  public $name;
  public $userlevel;
  public $facility_id;
  public $email;
  public $dbConn;
  public function __construct($database, $id, $inputArray=False) {
    $this->dbConn = $database;
    if ($id == 0) {
      $this->id = 0;
      $this->name = "Guest";
      $this->userlevel = 0;
      $this->facility_id = 0;
      $this->email = "";
    } else {
      $userInfo = $this->dbConn->queryFirstRow("SELECT `id`, `name`, `userlevel`, `email`, `facility_id` FROM `users` WHERE `id` = ".intval($id)." LIMIT 1");
      $this->id = intval($userInfo['id']);
      $this->name = $userInfo['name'];
      $this->userlevel = intval($userInfo['userlevel']);
      $this->email = $userInfo['email'];
      $this->facility_id = intval($userInfo['facility_id']);
    }
    if (is_array($inputArray)) {
      foreach ($inputArray as $key=>$value) {
        @$this->{$key}= $value;
      }
    }
  }
  public function loggedIn() {
    //if userID is not proper, or if user's last IP was not the requester's IP, return false.
    if (intval($this->id) <= 0) {
      return false;
    }
    $thisUserInfo = $this->dbConn->queryFirstRow("SELECT `last_ip` FROM `users` WHERE `id` = ".intval($this->id)." LIMIT 1");
    if ($thisUserInfo['last_ip'] != $_SERVER['REMOTE_ADDR']) {
      return false;
    }
    return true;
  }
  public function logIn($username, $password) {
    // rate-limit requests.
    $numFailedRequests = $this->dbConn->queryCount("SELECT COUNT(*) FROM `failed_logins` WHERE `ip` = ".$this->dbConn->quoteSmart($_SERVER['REMOTE_ADDR'])." AND `date` > NOW() - INTERVAL 1 HOUR");
    if ($numFailedRequests > 5) {
      return array("location" => "index.php", "status" => "You have had too many unsuccessful login attempts. Please wait awhile and try again.", 'class' => 'error');
    }
  
    $bcrypt = new Bcrypt();
    $findUsername = $this->dbConn->queryFirstRow("SELECT `id`, `name`, `facility_id`, `userlevel`, `password_hash` FROM `users` WHERE `email` = ".$this->dbConn->quoteSmart($username)." LIMIT 1");
    if (!$findUsername) {
      $this->dbConn->log_failed_login($username, $password);
      return array("location" => "index.php", "status" => "Could not log in with the supplied credentials.", 'class' => 'error');
    }
    if (!$bcrypt->verify($password, $findUsername['password_hash'])) {
      $this->dbConn->log_failed_login($username, $password);
      return array("location" => "index.php", "status" => "Could not log in with the supplied credentials.", 'class' => 'error');
    }
    
    //update last IP address.
    $updateLastIP = $this->dbConn->stdQuery("UPDATE `users` SET `last_ip` = ".$this->dbConn->quoteSmart($_SERVER['REMOTE_ADDR'])." WHERE `id` = ".intval($findUsername['id'])." LIMIT 1");
    $_SESSION['id'] = $findUsername['id'];
    $_SESSION['name'] = $findUsername['name'];
    $_SESSION['facility_id'] = $findUsername['facility_id'];
    $_SESSION['userlevel'] = $findUsername['userlevel'];
    $this->id = intval($findUsername['id']);
    $this->facility_id = intval($findUsername['facility_id']);
    $this->userlevel = intval($findUsername['userlevel']);
    return array("location" => "main.php", "status" => "Successfully logged in.", 'class' => 'success');
  }
  public function register($name, $email, $password, $password_confirmation, $facility_id) {
    //registration is closed to all non-admin users.
    if (!$this->loggedIn() || !$this->isAdmin()) {
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
          $checkNameEmail = intval($this->dbConn->queryCount("SELECT COUNT(*) FROM `users` WHERE (`name` = ".$this->dbConn->quoteSmart($name)." || `email` = ".$this->dbConn->quoteSmart($email).")"));
          if ($checkNameEmail > 0) {
            $returnArray = array("location" => "register.php", "status" => "Your name or email has previously been registered. Please try logging in.");
          } else {
            //check if this facility exists.
            $checkFacilityExists = intval($this->dbConn->queryCount("SELECT COUNT(*) FROM `facilities` WHERE `id` = ".intval($facility_id)));
            if ($checkFacilityExists < 1) {
              $returnArray = array("location" => "register.php", "status" => "That facility does not exist. Please try again.", 'class' => 'error');
            } else {
              //register this user.
              $bcrypt = new Bcrypt();
              $registerUser = $this->dbConn->stdQuery("INSERT INTO `users` SET `name` = ".$this->dbConn->quoteSmart($name).", `email` = ".$this->dbConn->quoteSmart($email).", `password_hash` = ".$this->dbConn->quoteSmart($bcrypt->hash($password)).", `userlevel` = 1, `last_ip` = ".$this->dbConn->quoteSmart($_SERVER['REMOTE_ADDR']).", `facility_id` = ".intval($facility_id));
              if (!$registerUser) {
                $returnArray = array("location" => "register.php", "status" => "Database errors were encountered during registration. Please try again later.", 'class' => 'error');
              } else {
                $returnArray = array("location" => "register.php", "status" => "Registration successful. ".escape_output($name)." can now log in.", 'class' => 'success');
              }
            }
          }
        }
      }
    }
    return $returnArray;
  }
  public function isPhysicist() {
    if (!$this->loggedIn()) {
      return false;
    }
    if (!$this->userlevel or intval($this->userlevel) != 2) {
      return false;
    }
    // $checkUserlevel = $this->dbConn->queryFirstValue("SELECT `userlevel` FROM `users` WHERE `id` = ".intval($this->id));
    // if (!$checkUserlevel or intval($checkUserlevel) != 2) {
    //   return false;
    // }
    return true;
  }
  public function isAdmin() {
    if (!$this->loggedIn()) {
      return false;
    }
    if (!$this->userlevel or intval($this->userlevel) < 3) {
      return false;
    }
    // $checkUserlevel = $this->dbConn->queryFirstValue("SELECT `userlevel` FROM `users` WHERE `id` = ".intval($this->id));
    // if (!$checkUserlevel or intval($checkUserlevel) < 3) {
    //   return false;
    // }
    return true;
  }
  public function facility() {
    if (!$this->facility_id) {
      return false;
    }
    $getFacility = $this->dbConn->queryFirstRow("SELECT * FROM `facilities` WHERE `id` = ".intval($this->facility_id)." LIMIT 1");
    if (!$getFacility) {
      return false;
    }
    return $getFacility;
  }
}

?>