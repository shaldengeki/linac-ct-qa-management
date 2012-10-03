<?php
function joinPaths() {
    $args = func_get_args();
    $paths = array();
    foreach ($args as $arg) {
        $paths = array_merge($paths, (array)$arg);
    }

    $paths = array_map(create_function('$p', 'return trim($p, "'.addslashes(DIRECTORY_SEPARATOR).'");'), $paths);
    $paths = array_filter($paths);
    return join(DIRECTORY_SEPARATOR, $paths);
}

function getNormalizedFILES() {
    $newfiles = array();
    foreach($_FILES as $fieldname => $fieldvalue)
        foreach($fieldvalue as $paramname => $paramvalue)
            foreach((array)$paramvalue as $index => $value)
                $newfiles[$fieldname][$index][$paramname] = $value;
    return $newfiles;
}

function get_numeric($val) { 
  if (is_numeric($val)) { 
    return $val + 0; 
  } else {
    return false;
  }
}

function convert_usermask_to_text($usermask) {
  $usermask = intval($usermask);
  $roles = [];
  if ($usermask == 0) {
    return "Guest";
  }
  if ($usermask & 4) {
    $roles[] = "Administrator";
  }
  if ($usermask & 2) {
    $roles[] = "Physicist";
  }
  if ($usermask & 1) {
    $roles[] = "Resident";
  }
  if (count($roles) == 0) {
    return "Unknown";
  }
  return implode(", ", $roles);
}

function stream_large_file($filename, $mimeType='text/plain; charset="UTF-8"', $chunkSize=1048576, $retbytes = TRUE) {
  // Read a file and display its content chunk by chunk
  header('Content-Type: '.$mimeType );
  header('Content-Disposition: attachment; filename='.escape_output(basename($filename)));
  header('Content-Length: '.filesize($filename));
  $buffer = '';
  $cnt =0;
  // $handle = fopen($filename, 'rb');
  $handle = fopen($filename, 'rb');
  if ($handle === false) {
    return false;
  }
  while (!feof($handle)) {
    $buffer = fread($handle, $chunkSize);
    echo $buffer;
    ob_flush();
    flush();
    if ($retbytes) {
      $cnt += strlen($buffer);
    }
  }
  $status = fclose($handle);
  if ($retbytes && $status) {
    return $cnt; // return num. bytes delivered like readfile() does.
  }
  return $status;
}

function udate($format, $utimestamp = null) {
  if (is_null($utimestamp)) {
    $utimestamp = microtime(true);
  }
  $timestamp = floor($utimestamp);
  $milliseconds = round(($utimestamp - $timestamp) * 1000000);
  return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}
?>