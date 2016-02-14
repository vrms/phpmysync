<?php

function dbopen($pfad,$dbname) {
  include($pfad."config.php");
  //echo $dbtyp."=dbtyp<br>";
  switch($dbtyp)
  {
    case 'SQLITE2';
     $db = new SQLiteDatabase($dbname);
      break;
    case 'SQLITE3';
      $db = new SQLite3($dbname);
      break;
    case 'MYSQL';
        echo 'Mysql noch nicht fertig.';
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $db;
}

function dbopentyp($dbtyp,$dbname,$dbuser,$dbpass) {
  switch($dbtyp)
  {
    case 'SQLITE2';
     $db = new SQLiteDatabase($dbname);
      break;
    case 'SQLITE3';
      $db = new SQLite3($dbname);
      break;
    case 'MYSQL';
      $dbcon = mysql_connect('localhost',$dbuser,$dbpass) or die(mysql_error());
      $db = mysql_select_db($dbname) or die(mysql_error());
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $db;
}

function dbquery($pfad,$db,$query) {
  include($pfad."config.php");
  switch($dbtyp)
  {
    case 'SQLITE2';
      $result = $db->query($query);
      break;
    case 'SQLITE3';
      $result = $db->query($query);
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $result;
}

function dbquerytyp($dbtyp,$db,$query) {
  switch($dbtyp)
  {
    case 'SQLITE2';
      $result = $db->query($query);
      break;
    case 'SQLITE3';
      $result = $db->query($query);
      break;
    case 'MYSQL';
      $result = mysql_query($query) or die(mysql_error());
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $result;
}

function dbfetch($pfad,$result) {
  include($pfad."config.php");
  switch($dbtyp)
  {
    case 'SQLITE2';
      $row = $result->fetch(SQLITE_ASSOC);
      break;
    case 'SQLITE3';
      $row = $result->fetchArray();
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $row;
}  

function dbfetchtyp($dbtyp,$result) {
  switch($dbtyp)
  {
    case 'SQLITE2';
      $row = $result->fetch(SQLITE_ASSOC);
      break;
    case 'SQLITE3';
      $row = $result->fetchArray();
      break;
    case 'MYSQL';
      $row = mysql_fetch_array($result);
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
  return $row;
}  

function dbexecute($pfad,$db,$sql) {
  include($pfad."config.php");
  switch($dbtyp)
  {
    case 'SQLITE2';
      if(!$db->queryExec($sql, $error)) {
        die($error);
      }  
      break;
    case 'SQLITE3';
      $query = $db->exec($sql);
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
}

function dbexecutetyp($dbtyp,$db,$sql) {
  switch($dbtyp)
  {
    case 'SQLITE2';
      if(!$db->queryExec($sql, $error)) {
        die($error);
      }  
      break;
    case 'SQLITE3';
      $query = $db->exec($sql);
      break;
    case 'MYSQL';
      mysql_query($sql) or die("Error using mysql_query($sql): ".mysql_error());
      break;
    default;
        echo 'Unbekannter dbtyp '.$dbtyp;
    break;
  }
}

?>