<?php
include("bootstrapfunc.php");
include("dbtool.php");
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
  echo "</table>";
  echo "</div>";

  $idxcnt=0;
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    //$dbnchopen=dbopentyp($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);
  	
    //echo $arrnchdbtyp[$tablecount]."<br>";    
    for( $i=1; $i <= $arranzds[$tablecount]; $i++ ) {
      //$qryval = "SELECT * FROM ".$dbtable." WHERE ".$fldindex."=".$index;
      $qryval = "SELECT * FROM ".$arrnchtables[$tablecount]." WHERE ".$arrnchindex[$tablecount]."=".$arridxds[$idxcnt];
	   echo $qryval."<br>";
      /*
      $results = $db->query($qryval);
      if ($linval = $results->fetchArray()) {
        $sql="upd<br>";	
        //$sql=$_POST['updsql'.$i];
      } else {
        $sql="ins<br>";	
        //$sql=$_POST['inssql'.$i];
      }	
      //$sql=str_replace("#","'",$sql);
      echo $sql."<br>";
      */
    	$idxcnt=$idxcnt+1;
	}
  }
  
  echo "<form class='form-horizontal' method='post' action='".$callbackurl."&onlyshow=".$onlyshow."'>";
  if ($action=="einspielen") {
    echo "<input type='hidden' name='status' value='fertig' />";
    echo "<input type='submit' value='Daten fertig' />";
  } else {
    echo "<input type='hidden' name='status' value='einspielen' />";
    echo "<input type='submit' value='Daten einspielen' />";
  }  
  echo "</form>";

bootstrapend();
?>