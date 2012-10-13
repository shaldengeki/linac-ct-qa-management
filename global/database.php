<?php

class DbConn extends mysqli {
  //basic database connection class that provides input-escaping and standardized query error output.
  private $host, $username, $password, $database, $profile;

  public function __construct($host, $username, $password, $database, $profile=False) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    $this->database = $database;
    $this->profile = $profile;
    parent::__construct($host, $username, $password, $database);
    if (mysqli_connect_error()) {
      die('Connection error ('.mysqli_connect_errno().')'.
            mysqli_connect_error());
    }
    if ($this->profile) {
      $this->stdQuery('SET profiling=1');
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
    $returnArray = [];
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $returnArray[] = $row;
      }
    }
    $result->free();
    return $returnArray;
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
  public function generate_backup($user, $backup) {
    //generates a backup according to submitted parameters.
    if (!$user->loggedIn($this)) {
      return array('location' => 'main.php', 'status' => 'Please log in to generate backups.', 'class' => 'error');
    }
    if (!isset($backup['contents']) || !is_array($backup['contents']) || count($backup['contents']) < 1) {
      return array('location' => 'backup.php', 'status' => 'Please select at least one option for backup contents.');
    }
    if (!isset($backup['action']) || !is_array($backup['action']) || count($backup['action']) < 1) {
      return array('location' => 'backup.php', 'status' => 'Please select at least one place to save backup contents.');
    }
    //create the individual backup files.
    $output_files = array();
    $timestamp = udate('Y-m-d-H-i-s-u');
    foreach ($backup['contents'] as $content) {
      switch($content) {
        case 'database':
          $backup_file_name = 'backup-database-'.$timestamp.'.sql';
          exec('mysqldump -u'.addslashes(MYSQL_USERNAME).' -p'.addslashes(MYSQL_PASSWORD).' --ignore-table='.addslashes(MYSQL_DATABASE).'.users '.addslashes(MYSQL_DATABASE).' > '.APP_ROOT.'/backups/'.$backup_file_name, $file_output, $file_return);
          if (intval($file_return) != 0) {
            return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($file_return).') while creating a backup of the database structure. Please try again.', 'class' => 'error');
          }
          $output_files[] = $backup_file_name;
          break;
        case 'files':
          $backup_file_name = 'backup-files-'.$timestamp.'.zip';
          $backup_file_command = 'cd '.APP_ROOT.' && zip -q --compression-method bzip2 -9 -x backups/\* -r backups/'.$backup_file_name.' .';
          exec($backup_file_command, $file_output, $file_return);
          if (intval($file_return) != 0) {
            return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($file_return).') while creating a backup of the files. Please try again.', 'class' => 'error');
          }
          $output_files[] = $backup_file_name;
          break;
        default:
          break;
      }
    }
    if (count($output_files) < 1) {
      return array('location' => 'backup.php', 'status' => 'Nothing was successfully backed up. Please try again.', 'class' => 'error');      
    }
    //create a single backup tarball.
    $backup_file_name = 'backup-'.$timestamp.'.zip';
    $tar_command = 'cd '.APP_ROOT.'/backups/ && zip -q --compression-method bzip2 '.$backup_file_name.' '.implode(' ', $output_files);
    $cleanup_command = 'cd '.APP_ROOT.'/backups/ && rm '.implode(' ', $output_files);
    exec($tar_command, $tar_output, $tar_return);
    if (intval($tar_return) != 0) {
      return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($tar_return).') while creating a master tarball backup. Please try again.', 'class' => 'error');
    }
    exec($cleanup_command, $cleanup_output, $cleanup_return);
    if (intval($cleanup_return) != 0) {
      return array('location' => 'backup.php', 'status' => 'There was an error (code '.intval($cleanup_return).') while cleaning up the backup directory. Please try again.', 'class' => 'error');
    }
    
    //insert this backup into the db list.
    $insert_backup = $this->stdQuery("INSERT INTO `backups` (`created_at`, `path`, `user_id`) VALUES ('".date('Y-m-d H:i:s')."', ".$this->quoteSmart('backups/'.$backup_file_name).", ".intval($user->id).")");
    if (!$insert_backup) {
      return array('location' => 'backup.php', 'status' => 'There was an error while logging the backup. Please try again.', 'class' => 'error');
    }
    $insert_id = $this->insert_id;
    
    //now do what the user has requested with these backup files.
    foreach ($backup['action'] as $action) {
      switch($action) {
        case 'local':
          break;
        case 'remote':
          return array('location' => 'backup.php?action=download&id='.intval($insert_id));
          break;
        default:
          break;
      }
    }
    return array('location' => 'backup.php', 'status' => 'Backup successfully created.', 'class' => 'success');
  }
}

?>