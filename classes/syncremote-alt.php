<?php
include("bootstrapfunc.php");
$menu=$_GET['menu'];
$pfad=$_GET['pfad'];
$dbtable=$_GET['dbtable'];
$fldindex=$_GET['fldindex'];
$timestamp=$_GET['timestamp'];
$datcnt=$_POST['datcnt'];


$db = new SQLite3('../data/joorgsqlite.db');
bootstraphead();
bootstrapbegin('Datenaustausch');

$website="http://".$pfad."sync.php?menu=".$menu;
echo $website."<br>";
echo $datcnt."<br>";

for( $i=1; $i <= $datcnt; $i++ ) {
  echo "<div class='alert alert-success'>";
  $index=$_POST['index'.$i];
  $qryval = "SELECT * FROM ".$dbtable." WHERE ".$fldindex."=".$index;
  $results = $db->query($qryval);
  if ($linval = $results->fetchArray()) {
    $sql=$_POST['updsql'.$i];
  } else {
    $sql=$_POST['inssql'.$i];
  }	
  $sql=str_replace("#","'",$sql);
  echo $sql."<br>";
//  echo $qryval."=qryval";
  echo "</div>";
  if ($nuranzeigen<>"anzeigen") {
    $query = $db->exec($sql);
  }  
}


//$website="";
echo "<form class='form-horizontal' method='post' action='".$website."'>";
echo "<input type='hidden' name='status' value='fertig'/>"; 
echo "<input type='hidden' name='dbtable' value='".$dbtable."'/>"; 
echo "<input type='hidden' name='timestamp' value='".$timestamp."'/>"; 
echo "<dd><input type='submit' value='Daten abschliessen' /></dd>";
echo "</form>";
bootstrapend();
?>