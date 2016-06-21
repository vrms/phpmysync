<?php
include("bootstrapfunc.php");
include("stdlib/dbtool.php");
$action=$_POST['action'];
$onlyshow=$_POST['onlyshow'];
$callbackurl=$_POST['callbackurl'];
$anztables=$_POST['anztables'];
bootstraphead();
bootstrapbegin("Datenaustausch");

  $arrnchdbtyp=json_decode($_POST["strnchdbtyp"]);
  $strnchdbtyp=$arrnchdbtyp[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchdbtyp=$strnchdbtyp.",".$arrnchdbtyp[$tablecount];
  }
  $arrnchdbname=json_decode($_POST["strnchdbname"]);
  $strnchdbname=$arrnchdbname[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchdbname=$strnchdbname.",".$arrnchdbname[$tablecount];
  }
  $arrnchtables=json_decode($_POST["strnchtables"]);
  $strnchtables=$arrnchtables[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchtables=$strnchtables.",".$arrnchtables[$tablecount];
  }
  $arrnchindex=json_decode($_POST["strnchindex"]);
  $strnchindex=$arrnchindex[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchindex=$strnchindex.",".$arrnchindex[$tablecount];
  }
  $arranzds=json_decode($_POST["stranzds"]);
  $stranzds=$arranzds[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $stranzds=$stranzds.",".$arranzds[$tablecount];
  }
  $arridxds=json_decode($_POST["stridxds"]);
//  $stridxds=$arridxds[0];
//  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
//  	 $stridxds=$stridxds.",".$arridxds[$tablecount];
//  }
  $arrdaten=json_decode($_POST["strdaten"]);
  //$strdaten=$arrdaten[0];
  //for($colcnt = 1; $colcnt < count($arrdaten)-1; $colcnt++) {
  //	 $strdaten=$strdaten.",".$arrdaten[$colcnt];
  //}
  //echo $strdaten."=daten<br>";
  echo $_POST["strdaten"]."=daten<br>";
  echo count($arrdaten)."=count<br>";
  $arrcolsel=json_decode($_POST["strcolsel"]);
  $arrnchdbuser=json_decode($_POST["strdbuser"]);
  $arrnchdbpassword=json_decode($_POST["strdbpassword"]);
  $arrdbsyncnr=json_decode($_POST["strdbsyncnr"]);
  $strdbsyncnr=$arrdbsyncnr[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strdbsyncnr=$strdbsyncnr.",".$arrdbsyncnr[$tablecount];
  }
  
  echo "<a href='".$callbackurl."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
  echo "<div class='alert alert-success'>";
  echo "Remotezugang";
  echo "</div>";

  echo "<div class='alert alert-info'>";
  echo "<table>";
  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
  echo "<tr><td>action</td><td> : ".$action."</td></tr>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "<tr><td>anztables</td><td> : ".$anztables."</td></tr>";
  echo "<tr><td>stranzds</td><td> : ".$stranzds."</td></tr>";
  echo "<tr><td>strnchdbtyp</td><td> : ".$strnchdbtyp."</td></tr>";
  echo "<tr><td>strnchdbname</td><td> : ".$strnchdbname."</td></tr>";
  echo "<tr><td>strnchtables</td><td> : ".$strnchtables."</td></tr>";
  echo "<tr><td>strnchindex</td><td> : ".$strnchindex."</td></tr>";
  echo "<tr><td>strdbsyncnr</td><td> : ".$strdbsyncnr."</td></tr>";
  echo "</table>";
  echo "</div>";
  echo $anztables."=anztables<br>";

  $idxcnt=0;
  $idxcol=0;
  $arrtblstatus=array();
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    echo $tablecount.",".$arrnchdbtyp[$tablecount].",".$arrnchdbname[$tablecount]."=tablecount<br>"; 
    $dbnchopen=dbopentyp($arrnchdbtyp[$tablecount],$arrnchdbname[$tablecount],$arrnchdbuser[$tablecount],$arrnchdbpassword[$tablecount]);
    $nchcolumn=getdbcolumn($arrnchdbtyp[$tablecount],$arrnchdbname[$tablecount],$arrnchtables[$tablecount],$arrnchdbuser[$tablecount],$arrnchdbpassword[$tablecount]);   
    echo "nch:".$nchcolumn."<br>";
  	//echo "von:".$arrcolsel[$tablecount]."<br>";
    //echo $arrnchdbtyp[$tablecount]."<br>";   
    if ($nchcolumn==$arrcolsel[$tablecount]) { 
      $tblstatus="OK";
      for( $i=1; $i <= $arranzds[$tablecount]; $i++ ) {
        //$qryval = "SELECT * FROM ".$dbtable." WHERE ".$fldindex."=".$index;
        $arrcolumn = explode(",", $arrcolsel[$tablecount]);
        $qryval = "SELECT ".$arrcolsel[$tablecount]." FROM ".$arrnchtables[$tablecount]." WHERE ".$arrnchindex[$tablecount]."=".$arridxds[$idxcnt];
	     echo $qryval."<br>";
		 
        $resval = dbquerytyp($arrnchdbtyp[$tablecount],$dbnchopen,$qryval);
        
        if ($linval = dbfetchtyp($arrnchdbtyp[$tablecount],$resval)) {
          $upd=$arrcolumn[0]."='".str_replace("#"," ",$arrdaten[$idxcol])."'";
          for( $colidx=1; $colidx <count($arrcolumn); $colidx++) {
          	$idxcol=$idxcol+1;
          	$upd=$upd.", ".$arrcolumn[$colidx]."='".str_replace("#"," ",$arrdaten[$idxcol])."'";
          }
          $sql="UPDATE ".$arrnchtables[$tablecount]." SET ".$upd." WHERE ".$arrnchindex[$tablecount]."=".$arridxds[$idxcnt];
        } else {
          $idxcol=$idxcol+1;
          $ins="'".str_replace("#"," ",$arrdaten[$idxcol])."'";
          for( $colidx=1; $colidx <count($arrcolumn); $colidx++) {
          	$idxcol=$idxcol+1;
          	$ins=$ins.",'".str_replace("#"," ",$arrdaten[$idxcol])."'";
          }	
          $sql="INSERT INTO ".$arrnchtables[$tablecount]." (".$arrcolsel[$tablecount].") VALUES(".$ins.")";	
        }
        echo $sql."<br>";
        dbexecutetyp($arrnchdbtyp[$tablecount],$dbnchopen,$sql); 
		
		
     	$idxcnt=$idxcnt+1;
      
      }

	} else {
	  $tblstatus="FEHLER";
      $arrcolumn = explode(",", $arrcolsel[$tablecount]);
      $idxcol=$idxcol+count($arrcolumn);
      echo $idxcol."=idxcol<br>";    
      echo "nch:".$nchcolumn."<br>";
  	  echo "von:".$arrcolsel[$tablecount]."<br>";
	}
	array_push($arrtblstatus,$tblstatus);
	
  }
  
  echo "<form class='form-horizontal' method='post' action='".$callbackurl."&onlyshow=".$onlyshow."'>";
  if ($action=="einspielen") {
    echo "<input type='hidden' name='status' value='fertig' />";
	echo "<input type='hidden' name='strnchtables' value=".$_POST["strnchtables"]." />";
	echo "<input type='hidden' name='strtblstatus' value=".json_encode($arrtblstatus)." />";
	echo "<input type='hidden' name='strdbsyncnr' value=".json_encode($arrdbsyncnr)." />";
    echo "<input type='submit' value='Daten fertig' />";
  } else {
    echo "<input type='hidden' name='status' value='einspielen' />";
    echo "<input type='submit' value='Daten einspielen' />";
  }  
  echo "</form>";

bootstrapend();
?>