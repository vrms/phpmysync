<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("../config.php");
$menu=$_GET['menu'];
//echo $menu."=menu<br>";
$pfad=$_POST['pfad'];
//echo $pfad."=pfad<br>";
$dbtable=$_GET['dbtable'];
$fldindex=$_POST['fldindex'];
$fldindexrmt=$_GET['fldindexremote'];
$fldindexloc=$_GET['fldindexloc'];
$nuranzeigen=$_GET['nuranzeigen'];
$urladr=$_GET['urladr'];
bootstraphead();
bootstrapbegin("Datenaustausch");
//$database="/var/www/html/android/own/joorgsqlite/data/joorgsqlite.db";
$database=$_POST['database'];
echo $database."=database<br>";
//$db = new SQLite3($database);
$dbtyp="MYSQL";
$dbuser="root";
$dbpassword="mysql";
$db=dbopentyp($dbtyp,$database,$dbuser,$dbpassword);

$showsync=$_GET['showsync'];
$dbsyncnr=8;
echo "<a href='http://".$pfad."showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
if ($showsync=="J") {
  $website="allnosync.php?menu=".$menu;	
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='submit' value='All NoSync' />";
  echo "<input type='hidden' name='pfad' value='".$pfad."' />";
  echo "<input type='hidden' name='dbtable' value='".$dbtable."' />";
  echo "<input type='hidden' name='database' value='".$database."' />";
  echo "<input type='hidden' name='dbsyncnr' value='".$dbsyncnr."' />";
  echo "</form>";	
  //echo "<a href='allnosync.php?menu=".$menu."&pfad=".$pfad."&dbtable=".$dbtable."'  class='btn btn-primary btn-sm active' role='button'>All NoSync</a> ";

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
  echo "Timestamp:".$timestamp."<br>";
  //echo $database."<br>";
  echo "</div>";


  $col="*";
  $qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr." AND flddbsyncstatus='SYNC'";
  //echo $qryval."<br>";
  $results = $db->query($qryval);
  echo "<table class='table table-hover'>";  
  echo "<tr><th>dummy</th><th>NOSYNC</th></tr>";
  while ($linval = $results->fetchArray()) {
    echo "<tr>";
    echo "<td>";
    echo $linval['fldVondatum'];
    echo "</td>";
    echo "<td><a href='nosync.php?menu=".$menu."&dbindex=".$linval[$fldindex]."' class='btn btn-primary btn-sm active' role='button'>NOSYNC</a></td> ";
    echo "</tr>";
  }
  echo "</table>";

  
} else {
echo "menu=".$menu."<br>";
echo "pfad=".$pfad."<br>";
echo "dbtable=".$dbtable."<br>";
echo "fldindexrmt=".$fldindexrmt."<br>";
echo "fldindexloc=".$fldindexloc."<br>";
echo "nuranzeigen=".$nuranzeigen."<br>";
echo "urladr=".$urladr."<br>";


//echo "<a href='http://".$pfad."showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
echo "<div class='alert alert-success'>";
echo "Daten von ".$pfad." holen.<br>";

//timestamp ermitteln
$qryval = "SELECT * FROM tblsyncstatus WHERE fldtable='".$dbtable."'";
//echo $qryval."<br>";
$results = $db->query($qryval);
if ($linval = $results->fetchArray()) {
  $timestamp=$linval['fldtimestamp'];
} else {
  $timestamp="";
}	
echo "Timestamp:".$timestamp."<br>";;
echo "</div>";

$col = "";
$lincnt = 1;
$count = 0;
$query="SELECT name,sql FROM sqlite_master WHERE type='table' AND name='".$dbtable."'";
//echo $query."<br>";
$results = $db->query($query);
$arrcol = array();
if ($row = $results->fetchArray()) {
  $colstr=$row['sql'];
  $pos = strpos($colstr, '(', 0);
  $colstr=substr($colstr,$pos+1,-1); 
  $colarr = explode(",", $colstr);
  $count = count($colarr);
  foreach ( $colarr as $arrstr ) {
  	$arrstr=ltrim($arrstr);
  	$pos=strpos($arrstr,' ',0);
  	$colstr=substr($arrstr,0,$pos);
    $colstr=str_replace('"','',$colstr);
    $arrcol[] = $colstr;
    $lincnt = $lincnt + 1;
    if ($col=="") {
      $col=$colstr;
    } else {	
      $col=$col.",".$colstr;
    }  
  }
}	

$website="http://".$pfad."sync.php?menu=".$menu;
echo "<form class='form-horizontal' method='post' action='".$website."'>";
echo "<input type='hidden' name='status' value='empfangen'/>"; 
echo "<input type='hidden' name='nuranzeigen' value='".$nuranzeigen."'/>"; 
echo "<input type='hidden' name='urladr' value='".$urladr."'/>"; 
echo "<input type='hidden' name='timestamp' value='".$timestamp."'/>"; 

$qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$autoinc_start;
echo $qryval."<br>";
$results = $db->query($qryval);
echo "<input type='hidden' name='sql' value='".$qryval."'/>";
$datcnt=0;
while ($linval = $results->fetchArray()) {
  if (!$linval) {
    echo " ist leer (INSERT).<br>";    
  } else {
    $val = "#".$linval[0]."#";
    $updsql=$arrcol[0]."=#".$linval[0]."#";
    for($lincount = 1; $lincount+1 < $lincnt; $lincount++) {
      $val = $val . ",#".$linval[$lincount]."#";
      $updsql = $updsql.",".$arrcol[$lincount]."=#".$linval[$lincount]."#";
    }
    $datcnt=$datcnt+1;
    $index=$linval[$fldindexrmt];
    $updsql="UPDATE ".$dbtable." SET ".$updsql." WHERE ".$fldindexrmt."=".$index;
    $inssql = "INSERT INTO ".$dbtable."(".$col.") VALUES (".$val.");";
    //echo $updsql."<br>";
    //echo "<input type='hidden' name='sqlarr".$datcnt."' value='".$qry."'/>";
    echo "<input type='hidden' name='index".$datcnt."' value='".$index."'/>";
    echo "<input type='hidden' name='updsql".$datcnt."' value='".$updsql."'/>";
    echo "<input type='hidden' name='inssql".$datcnt."' value='".$inssql."'/>";
  }  
} 
echo "<input type='hidden' name='dbtable' value='".$dbtable."'/>";
echo "<input type='hidden' name='dbindex' value='".$fldindexloc."'/>";
echo "<input type='hidden' name='datcntremote' value='".$datcnt."'/>";


echo "<dd><input type='submit' value='Daten austauschen' /></dd>";
echo "</form>";

echo "<br>";
echo "<div class='alert alert-info'>";
echo $datcnt." Datensätze senden.";
echo "</div>";   

if ($nuranzeigen<>"anzeigen") {
  if ($timestamp=="") {
    $sql="INSERT INTO tblsyncstatus (fldtable,fldtimestamp) VALUES ('".$dbtable."',datetime('now', 'localtime'))";
  } else {
    $sql="UPDATE tblsyncstatus SET fldtimestamp=datetime('now', 'localtime') WHERE fldtable='".$dbtable."'";
  }  
  $query = $db->exec($sql);
}
}

bootstrapend();

?>