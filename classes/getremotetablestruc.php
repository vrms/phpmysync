<?php
include("dbtool.php");
$pfad=$_GET['pfad'];
$database=$_GET['database'];
$bemerk=$_GET['bemerk'];
$dbid=$_GET['dbid'];
//echo $pfad.",".$database."pfad,database<br>";
$dbget = dbopen($pfad,$database);

$sql="SELECT name FROM sqlite_master WHERE type='table'";
$results = dbquery($pfad,$dbget,$sql);
$anz=0;
$dbrowarr=array();
while ($row = dbfetch($pfad,$results)) {
  $menge = array_push ( $dbrowarr, $row);  
  $anz=$anz+1;
}
echo "<div class='alert alert-success'>";
echo $anz." Tables ausgelesen f&uumlr ".$bemerk.".";
echo "</div>";


$website="http://localhost:8080/own/mysqlitesync/classes/gettablestruc.php?menu=table&dbid=".$dbid;
echo "<form class='form-horizontal' method='post' action='".$website."'>";
echo "<input type='hidden' name='status' value='empfangen'/>"; 

for ($i = 0; $i < $anz; $i++) {
    echo "<input type='hidden' name='dbid".$i."' value='".$dbid."'/>";
    echo "<input type='hidden' name='name".$i."' value='".$dbrowarr[$i]['name']."'/>";
}
echo "<input type='hidden' name='datcnt' value='".$anz."'/>";


echo "<dd><input type='submit' value='Get Table' /></dd>";
echo "</form>";

?>