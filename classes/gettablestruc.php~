<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("gettablestrucfunc.php");
bootstraphead();
bootstrapbegin("Get Tables<br>");
$menu=$_GET['menu'];
$dbid=$_GET['dbid'];
echo "<a href='showtab.php?menu=".$menu."&dbid=".$dbid."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
$db = dbopen('../','../data/mysqlitesync.db');
$sql = "SELECT * FROM tbldatabase WHERE fldindex=".$dbid;
$results = $db->query($sql);
if ($row = dbfetch('../',$results)) {
  $database=$row['fldbez'];
  $bemerk=$row['fldbemerk'];
  $pfad=$row['fldpfad'];
  $idsel=$row['fldid_select'];
  //echo $pfad.",".$database."=pfad,database<br>";
}
$status=$_POST['status'];
if ($status=="empfangen") {
  $datcnt=$_POST['datcnt'];
  $bemerk="";
  gettableempfangen($datcnt,$bemerk);
} else {
  if ($idsel==1) {
    gettablelocal($pfad,$database,$db,$dbid,$bemerk);
  } else {
    echo "<div class='alert alert-warning'>";
    echo "Remote-Funktion gestartet.";
    echo "</div>";
    gettableremote($pfad,$database,$dbid,$bemerk);
  }  
}

bootstrapend();
?>