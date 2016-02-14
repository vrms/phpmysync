<?php
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
include("../config.php");
$id=$_GET['id'];
$db = new SQLite3('../data/'.$database);
$status="J";
$sql="SELECT * FROM ".$pararray['dbtable']." WHERE fldindex=".$id;
//echo $sql."<br>";
$results = $db->query($sql);
while ($row = $results->fetchArray()) {
  $arr=$row;
}
if ($arr['fldStatus']=="J") {
  $status="N";
}	
$sql="UPDATE ".$pararray['dbtable']." SET fldStatus='".$status."' WHERE fldindex=".$id;
$query = $db->exec($sql);
echo "<meta http-equiv='refresh' content='0; URL=showtab.php?menu=".$menu."'>";  
?>