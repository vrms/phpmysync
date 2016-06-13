<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("../config.php");
$callbackurl=$_POST['callbackurl'];
$onlyshow=$_POST['onlyshow'];
$anztables=$_POST["anztables"];
$arrvontables=json_decode($_POST["strvontables"]);
$arrnchtables=json_decode($_POST["strnchtables"]);
$strnchtables=$arrnchtables[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchtables=$strnchtables.",".$arrnchtables[$tablecount];
}
$arrvonindex=json_decode($_POST["strvonindex"]);
$arrnchindex=json_decode($_POST["strnchindex"]);
$strnchindex=$arrnchindex[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchindex=$strnchindex.",".$arrnchindex[$tablecount];
}
$arrnchbez=json_decode($_POST["strnchbez"]);
$strnchbez=$arrnchbez[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchbez=$strnchbez.",".$arrnchbez[$tablecount];
}
$arrvondbtyp=json_decode($_POST["strvondbtyp"]);
$strvondbtyp=$arrvondbtyp[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strvondbtyp=$strvondbtyp.",".$arrvondbtyp[$tablecount];
}
$arrnchdbtyp=json_decode($_POST["strnchdbtyp"]);
$strnchdbtyp=$arrnchdbtyp[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchdbtyp=$strnchdbtyp.",".$arrnchdbtyp[$tablecount];
}
$arrvondbname=json_decode($_POST["strvondbname"]);
$strvondbname=$arrvondbname[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strvondbname=$strvondbname.",".$arrvondbname[$tablecount];
}
$arrnchdbname=json_decode($_POST["strnchdbname"]);
$strnchdbname=$arrnchdbname[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchdbname=$strnchdbname.",".$arrnchdbname[$tablecount];
}

$arrvondbuser=json_decode($_POST["strvondbuser"]);
$strvondbuser=$arrvondbuser[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strvondbuser=$strvondbuser.",".$arrvondbuser[$tablecount];
}
$arrnchdbuser=json_decode($_POST["strnchdbuser"]);
$strnchdbuser=$arrnchdbuser[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchdbuser=$strnchdbuser.",".$arrnchdbuser[$tablecount];
}

$arrvondbpassword=json_decode($_POST["strvondbpassword"]);
$strvondbpassword=$arrvondbpassword[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strvondbpassword=$strvondbpassword.",".$arrvondbpassword[$tablecount];
}
$arrnchdbpassword=json_decode($_POST["strnchdbpassword"]);
$strnchdbpassword=$arrnchdbpassword[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
	 $strnchdbpassword=$strnchdbpassword.",".$arrnchdbpassword[$tablecount];
}

$arrdbsyncnr=json_decode($_POST["strdbsyncnr"]);
$strdbsyncnr=$arrdbsyncnr[0];
for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  $strdbsyncnr=$strdbsyncnr.",".$arrdbsyncnr[$tablecount];
}
$arrcolsel=json_decode($_POST["strcolsel"]);

bootstraphead();
bootstrapbegin("Datenaustausch");

echo "<a href='".$callbackurl."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";

echo "<div class='alert alert-info'>";
echo "<table>";
echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
echo "<tr><td>strnchtables</td><td> : ".$strnchtables."</td></tr>";
echo "<tr><td>strnchindex</td><td> : ".$strnchindex."</td></tr>";
echo "<tr><td>strnchbez</td><td> : ".$strnchbez."</td></tr>";
echo "<tr><td>strnchdbtyp</td><td> : ".$strnchdbtyp."</td></tr>";
echo "<tr><td>strnchdbname</td><td> : ".$strnchdbname."</td></tr>";
echo "<tr><td>strnchdbuser</td><td> : ".$strnchdbuser."</td></tr>";
echo "<tr><td>strnchdbpassword</td><td> : ".$strnchdbpassword."</td></tr>";
echo "<tr><td>strvondbtyp</td><td> : ".$strvondbtyp."</td></tr>";
echo "<tr><td>strvondbname</td><td> : ".$strvondbname."</td></tr>";
echo "<tr><td>strvondbuser</td><td> : ".$strvondbuser."</td></tr>";
echo "<tr><td>strvondbpassword</td><td> : ".$strvondbpassword."</td></tr>";
echo "<tr><td>strdbsyncnr</td><td> : ".$strdbsyncnr."</td></tr>";
echo "</table>";
echo "</div>";

echo "<form class='form-horizontal' method='post' action='".$callbackurl."&onlyshow=".$onlyshow."'>";
echo "<input type='submit' value='Daten einspielen' />";
echo "<br>";
$db = new SQLite3('../data/'.$database);
echo "<table class='table table-hover'>";
echo "<tr><th>Table</th><th>Index</th><th>Bezeichnung</th><th>NOSYNC</th></tr>";
$arranzds = array();
$arrtblstatus = array();
$arridxds = array();
$arrdaten = array();
for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
  $dbnchopen=dbopentyp($arrnchdbtyp[$tablecount],$arrnchdbname[$tablecount],$arrnchdbuser[$tablecount],$arrnchdbpassword[$tablecount]);
  $column=getdbcolumn($arrnchdbtyp[$tablecount],$arrnchdbname[$tablecount],$arrnchtables[$tablecount],$arrnchdbuser[$tablecount],$arrnchdbpassword[$tablecount]);   
  echo $column."=column<br>";
  if ($arrcolsel[$tablecount]==$column) {
    array_push($arrtblstatus,"OK");
    $query="SELECT * FROM tblsyncstatus WHERE fldtable='".$arrnchtables[$tablecount]."' AND flddbsyncnr=".$arrdbsyncnr[$tablecount];
    echo $query."<br>";
    $resst = $db->query($query);
    if ($linst = $resst->fetchArray()) {
      $timestamp=$linst['fldtimestamp'];
    } else {
      $timestamp='2015-01-01 00:00:00'; 
    }
  
    $qryval = "SELECT ".$arrcolsel[$tablecount]." FROM ".$arrnchtables[$tablecount]." WHERE flddbsyncstatus='SYNC' AND fldtimestamp>'".$timestamp."'";
    echo $qryval."<br>";
    $resval = dbquerytyp($arrnchdbtyp[$tablecount],$dbnchopen,$qryval);
	$datcnt=0;
    while ($linval = dbfetchtyp($arrnchdbtyp[$tablecount],$resval)) {
	  $datcnt=$datcnt+1;
      $arrcolumn = explode(",", $arrcolsel[$tablecount]);
      for($colcnt = 0; $colcnt < count($arrcolumn); $colcnt++) {
        //$inh="#".$linval[$arrcolumn[$colcnt]]."#";	
		$inh=$linval[$arrcolumn[$colcnt]];
		$inh=str_replace(" ","#",$inh);
  	    //echo "<tr><td>".$arrvontables[$tablecount]."</td><td>".$arrcolumn[$colcnt]."</td><td>".$inh."</td><td>_</td></tr>";
        array_push($arrdaten,$inh);
      }
      echo "<tr>";
      echo "<td>".$arrnchtables[$tablecount]."</td>";
      echo "<td>".$linval[$arrnchindex[$tablecount]]."</td>";
      echo "<td>".$linval[$arrnchbez[$tablecount]]."</td>";
      echo "<td><a href='nosync.php?menu=".$menu."&dbindex=".$linval[$arrnchindex[$tablecount]]."' class='btn btn-primary btn-sm active' role='button'>NOSYNC</a></td> ";
      echo "</tr>";
      array_push($arridxds,$linval[$arrnchindex[$tablecount]]);
	}
	array_push($arranzds,$datcnt);
  } else {
    array_push($arrtblstatus,"FEHLER");
    echo $arrnchtables[$tablecount]." no ok.";
  }  
}
echo "</table>";

echo "<input type='hidden' name='status' value='einspielen' />";
echo "<input type='hidden' name='anztables' value=".$anztables." />";
echo "<input type='hidden' name='strvontables' value=".json_encode($arrvontables)." />";
echo "<input type='hidden' name='strvonindex' value=".json_encode($arrvonindex)." />";
echo "<input type='hidden' name='strvondbtyp' value=".json_encode($arrvondbtyp)." />";
echo "<input type='hidden' name='strvondbname' value=".json_encode($arrvondbname)." />";
echo "<input type='hidden' name='strvondbuser' value=".json_encode($arrvondbuser)." />";
echo "<input type='hidden' name='strvondbpassword' value=".json_encode($arrvondbpassword)." />";
echo "<input type='hidden' name='strtblstatus' value=".json_encode($arrtblstatus)." />";
echo "<input type='hidden' name='stranzds' value=".json_encode($arranzds)." />";
echo "<input type='hidden' name='stridxds' value=".json_encode($arridxds)." />";
echo "<input type='hidden' name='strdaten' value=".json_encode($arrdaten)." />";
echo "</form>";


bootstrapend();
?>