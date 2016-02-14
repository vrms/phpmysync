<?php
function gettablelocal($pfad,$database,$db,$dbid,$bemerk) {
$dbget = dbopen($pfad,$database);

$qrydel="DELETE FROM tbltable WHERE fldid_database=".$dbid;
$db->exec($qrydel);
$sql="SELECT name FROM sqlite_master WHERE type='table'";
$results = dbquery($pfad,$dbget,$sql);
$anz=0;
$dbrowarr=array();
while ($row = dbfetch($pfad,$results)) {
  $menge = array_push ( $dbrowarr, $row);  
  $anz=$anz+1;
}
for ($i = 0; $i < $anz; $i++) {
  $qryins="INSERT INTO tbltable (fldid_database,fldbez,fldtyp) VALUES (".$dbid.",'".$dbrowarr[$i]['name']."','')";
  //echo $qryins."<br>";
  $db->exec($qryins);
}
echo "<div class='alert alert-success'>";
echo $anz." Tables ausgelesen f&uumlr ".$bemerk.".";
echo "</div>";

}

function gettableremote($pfad,$database,$dbid,$bemerk) {
  $website="http://localhost:8080/own/mysqlitesync/classes/getremotetablestruc.php?pfad=".$pfad."&database=".$database."&dbid=".$dbid."&bemerk=".$bemerk;
  //echo $website."=website<br>";
  include($website);
}  

function gettableempfangen($datcnt,$bemerk) {
  for ($i = 0; $i < $datcnt; $i++) {
    $dbid=$_POST['dbid'.$i];
	$name=$_POST['name'.$i];
	echo $dbid.",".$name."<br>";
  }  
  echo "<div class='alert alert-success'>";
  echo $datcnt." Tables empfangen f&uumlr ".$bemerk.".";
  echo "</div>";
}

?>