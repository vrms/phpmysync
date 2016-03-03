<?php
include("bootstrapfunc.php");
include("dbtool.php");
bootstraphead();
bootstrapbegin("Datenaustausch - Allnosync");
include("../config.php");
$menu=$_GET['menu'];
$pfad=$_POST['pfad'];
$dbtable=$_POST['dbtable'];
echo "<a href='http://".$pfad."showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";

$dbsyncnr=$_POST['dbsyncnr'];
$database=$_POST['database'];
$dbtyp="SQLITE3";
$dbuser="";
$dbpassword="";
//$db = new SQLite3($database);
$db=dbopentyp($dbtyp,$database,$dbuser,$dbpassword);

echo "<div class='alert alert-success'>";
//timestamp ermitteln
$qryval = "SELECT * FROM tblsyncstatus WHERE fldtable='".$dbtable."'";
//echo $qryval."<br>";
$results = $db->query($qryval);
if ($linval = $results->fetchArray()) {
  $timestamp=$linval['fldtimestamp'];
} else {
  $timestamp="";   
}	
echo "table:".$dbtable."<br>";;
echo "Timestamp:".$timestamp."<br>";;
echo "</div>";

  $col="*";
  $qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr;
  //echo $qryval."<br>";
  $results = $db->query($qryval);
  while ($linval = $results->fetchArray()) {
    $qryupd="UPDATE ".$dbtable." SET flddbsyncstatus='NOSYNC' WHERE fldindex=".$linval['fldindex'];
    echo $qryupd."<br>";
    $query = $db->exec($qryupd);
  }

bootstrapend();
?>