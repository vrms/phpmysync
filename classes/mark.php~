<?php
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
$id=$_GET['id'];
$db = new SQLite3('../data/joorgsqlite.db');
$status="OK";
$sql="SELECT * FROM ".$pararray['dbtable']." WHERE fldindex=".$id;
//echo $sql."<br>";
$results = $db->query($sql);
while ($row = $results->fetchArray()) {
  $arr=$row;
}
if ($arr['fldStatus']=="OK") {
  $status="offen";
}	
$sql="UPDATE ".$pararray['dbtable']." SET fldStatus='".$status."' WHERE fldindex=".$id;
$query = $db->exec($sql);
echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."'>";  
?>