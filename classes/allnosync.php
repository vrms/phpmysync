<?php
include("bootstrapfunc.php");
include("stdlib/dbtool.php");
bootstraphead();
bootstrapbegin("Datenaustausch - Allnosync");
include("../config.php");
$menu=$_GET['menu'];
$pfad=$_POST['pfad'];
$dbtable=$_POST['dbtable'];
echo "<a href='http://".$pfad."showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";

$dbsyncnr=$_POST['dbsyncnr'];
$dbtyp=$_POST['dbtyp'];
//$database="../data/".$_POST['database'];
$database=$_POST['database'];
$dbuser=$_POST['dbuser'];
$dbpassword=$_POST['dbpassword'];
$timestamp=$_POST['timestamp'];
$fldindex=$_POST['fldindex'];
//$db = new SQLite3($database);
echo $dbtyp."<br>";
echo $database."<br>";
$db=dbopentyp($dbtyp,$database,$dbuser,$dbpassword);

//echo "<div class='alert alert-success'>";
//timestamp ermitteln
//$qryval = "SELECT * FROM tblsyncstatus WHERE fldtable='".$dbtable."'";
//echo $qryval."<br>";
//$results = $db->query($qryval);
//if ($linval = $results->fetchArray()) {
//  $timestamp=$linval['fldtimestamp'];
//} else {
//  $timestamp="";   
//}	
//echo "table:".$dbtable."<br>";;
echo "Timestamp:".$timestamp."<br>";;
//echo "</div>";

  $col="*";
  $qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr." AND flddbsyncstatus='SYNC'";
  echo $qryval."<br>";
  $results = dbquerytyp($dbtyp,$db,$qryval);
  while ($linval = dbfetchtyp($dbtyp,$results)) {
    $qryupd="UPDATE ".$dbtable." SET flddbsyncstatus='NOSYNC' WHERE ".$fldindex."=".$linval[$fldindex];
    echo $qryupd."<br>";
    dbexecutetyp($dbtyp,$db,$qryupd);
  }

bootstrapend();
?>