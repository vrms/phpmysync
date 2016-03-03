<?php

function nosyncfunc($dbindex) {
  //$dbtyp="MYSQL";
  //$dblocal="dbjoorgportal";
  //$dbuser="root";
  //$dbpassword="mysql";
  //$dblocal=dbopentyp($dbtyp,$dblocal,$dbuser,$dbpassword);

  echo "<div class='alert alert-info'>";
  echo "nosync<br>";
  //echo $dbindex."=dbindex<br>";
  $sql="UPDATE table SET flddbsyncstatus='NO' WHERE fldindex=".$dbindex;
  echo $sql."<br>";
  echo "</div>";
  
}

?>