<?php
include("bootstrapfunc.php");
include("../config.php");
bootstraphead();
bootstrapbegin($headline."<br>");
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
echo "<a href='about.php' class='btn btn-primary btn-sm active' role='button'>About</a><br><br>"; 
//$neuevers=$_GET['neuevers'];
$ini_locarr = parse_ini_file("http://horald.github.io/joorgsqlite/versionphpmysync.txt");
$neueversnr=$ini_locarr['versnrphpmysync'];
if ($neueversnr=="") {
  $ini_locarr = parse_ini_file("../version-new.txt");
  $neueversnr=$ini_locarr['versnrphpmysync'];
}

echo "<a href='https://github.com/horald/phpmysync/tree/master/sites/update/zip/update-".$neueversnr.".tar.gz' class='btn btn-primary btn-sm active' role='button'>Download Version ".$neuevers."</a> "; 

bootstrapend();
?>