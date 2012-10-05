<?php

class User {
  public $id;
  public $name;
  public $email;
  public $usermask;
  public $facility_id;
  public $facility;
  public $formEntries;
  public $approvals;
  public $backups;
  public $dbConn;
  public function __construct($database, $id=Null) {
    $this->dbConn = $database;
    if ($id === 0) {
      $this->id = 0;
      $this->name = "Guest";
      $this->usermask = 0;
      $this->email = "";
      $this->facility = $this->formEntries = $this->approvals = $this->backups = [];
    } else {
      $userInfo = $this->dbConn->queryFirstRow("SELECT `id`, `name`, `usermask`, `email`, `facility_id` FROM `users` WHERE `id` = ".intval($id)." LIMIT 1");
      $this->id = intval($userInfo['id']);
      $this->name = $userInfo['name'];
      $this->usermask = intval($userInfo['usermask']);
      $this->email = $userInfo['email'];
      $this->facility = $this->getFacility();
      $this->formEntries = $this->getFormEntries();
      $this->approvals = $this->getApprovals();
      $this->backups = $this->getBackups();
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
    $findUsername = $this->dbConn->queryFirstRow("SELECT `id`, `name`, `facility_id`, `usermask`, `password_hash` FROM `users` WHERE `email` = ".$this->dbConn->quoteSmart($username)." LIMIT 1");
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
    $_SESSION['usermask'] = $findUsername['usermask'];
    $this->id = intval($findUsername['id']);
    $this->facility['id'] = intval($findUsername['facility_id']);
    $this->usermask = intval($findUsername['usermask']);
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
              $registerUser = $this->dbConn->stdQuery("INSERT INTO `users` SET `name` = ".$this->dbConn->quoteSmart($name).", `email` = ".$this->dbConn->quoteSmart($email).", `password_hash` = ".$this->dbConn->quoteSmart($bcrypt->hash($password)).", `usermask` = 1, `last_ip` = ".$this->dbConn->quoteSmart($_SERVER['REMOTE_ADDR']).", `facility_id` = ".intval($facility_id));
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
  public function isResident() {
    if (!$this->usermask or !(intval($this->usermask) & 1)) {
      return false;
    }
    return true;
  }
  public function isPhysicist() {
    if (!$this->usermask or !(intval($this->usermask) & 2)) {
      return false;
    }
    return true;
  }
  public function isAdmin() {
    if (!$this->usermask or !(intval($this->usermask) & 4)) {
      return false;
    }
    return true;
  }
  public function getFacility() {
    // retrieves an id,name array corresponding to this users's facility.
    return $this->dbConn->queryFirstRow("SELECT `facilities`.`id`, `facilities`.`name` FROM `users` LEFT OUTER JOIN `facilities` ON `facilities`.`id` = `users`.`facility_id` WHERE `users`.`id` = ".intval($this->id));
  }
  public function getFormEntries() {
    // retrieves a list of id arrays corresponding to form entries belonging to this user.
    return $this->dbConn->queryAssoc("SELECT `id` FROM `form_entries` WHERE `user_id` = ".intval($this->id)." ORDER BY `updated_at` DESC");
  }
  public function getApprovals() {
    // retrieves a list of FormEntry objects that the user has approved, ordered by updated_at desc.
    $formEntryQuery = $this->dbConn->stdQuery("SELECT `id` FROM `form_entries` WHERE `approved_user_id` = ".intval($this->id)." ORDER BY `updated_at` DESC");
    $formEntries = [];
    while ($entry = $formEntryQuery->fetch_assoc()) {
      $formEntries[] = new FormEntry($this->dbConn, intval($entry['id']));
    }
    return $formEntries;
  }
  public function getBackups() {
    // retrieves a list of id,created_at,path arrays for backups belonging to the current user, sorted by created_at desc.
    return $this->dbConn->queryAssoc("SELECT `id`, `created_at`, `path` FROM `backups` WHERE `user_id` = ".intval($this->id)." ORDER BY `created_at` DESC");
  }

}

?>