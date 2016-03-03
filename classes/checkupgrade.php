<?php

function getactvers($pfad) {
  $db = new SQLite3($pfad.'joorgsqlite.db');
  $sql="SELECT * FROM tblversion ORDER BY fldversion";
  $results = $db->query($sql);
  while ($row = $results->fetchArray()) {
    $arr=$row;
  }
  $versnr=$arr['fldversion'];
  $db->close();	
//  $versnr="0.0";
  return $versnr;
}


function check_version() {
  $servername=$_SERVER['HTTP_HOST'];
  $serverpfad=$_SERVER['REQUEST_URI'];
  $file = strrchr($serverpfad, '/');
  $file = ($file===false) ? $serverpfad : (($file==='/') ? '' : substr($file, 1));
  $serverpfad = ($file==='') ? $serverpfad : substr($serverpfad, 0, -strlen($file));

  $ini_verarr = parse_ini_file("http://horald.github.io/joorgsqlite/versionphpmysync.txt");
  $versnr=$ini_verarr['versnrphpmysync'];

  $ini_locarr = parse_ini_file("http://".$servername.$serverpfad."version.txt");
  $locvers=$ini_locarr['versnr'];
  //$actvers=getactvers("data/");	
//echo "locvers".$locvers.",".$versnr."<br>";
  if ($locvers<$versnr) {
    echo "<div class='alert alert-info'>";
    echo "<a href='classes/checkupdate.php?neuevers=".$versnr."'>Neue Version ".$versnr." verfügbar</a>";
    echo "</div>";
/*    
  } else {  
//    if ($actvers<$versnr) {
//      echo "<div class='alert alert-info'>";
//      echo "<a href='classes/installupdate.php?newvers=".$versnr."&oldvers=".$actvers."&versdat=".$versdat."'>Auf neue Version ".$versnr." aktualisieren</a>";
//      echo "</div>";
      }
*/
  }
}

?>