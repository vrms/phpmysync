<?php
header("content-type: text/html; charset=utf-8");

function showauswahl($menu,$database,$onlyshow) {
  $db = new SQLite3('../data/'.$database);
  $qry = "SELECT * FROM tbltable";
  $results = $db->query($qry);
  $anztables=0;
  $arrvontables = array();
  $arrnchtables = array();
  $arrvonindex = array();
  $arrnchindex = array();
  $arrvonbez = array();
  $arrnchbez = array();
  $arrnchwebsite = array();
  $arrvondbtyp = array();
  $arrnchdbtyp = array();
  $arrvondbname = array();
  $arrnchdbname = array();
  $arrvondbuser = array();
  $arrnchdbuser = array();
  $arrvondbpassword = array();
  $arrnchdbpassword = array();
  $arrdbsyncnr = array();
  while ($line = $results->fetchArray()) {
    $aktiv=$line['fldaktiv'];
    if ($aktiv=='J') {
      $anztables=$anztables+1;
      array_push($arrvontables,$line['fldvontblname']);
      array_push($arrnchtables,$line['fldnachtblname']);
      array_push($arrvonindex,$line['fldvontblindex']);
      array_push($arrnchindex,$line['fldnachtblindex']);
      array_push($arrvonbez,$line['fldvontblbez']);
      array_push($arrnchbez,$line['fldnachtblbez']);
      $qrydb = "SELECT * FROM tbldatabase WHERE fldindex=".$line['fldid_vondatabase'];
      $resdb = $db->query($qrydb);
      $lindb = $resdb->fetchArray();
      array_push($arrvondbtyp,$lindb['flddbtyp']);
      array_push($arrvondbname,$lindb['fldbez']);
      array_push($arrvondbuser,$lindb['flddbuser']);
      array_push($arrvondbpassword,$lindb['flddbpassword']);
      $qrydb = "SELECT * FROM tbldatabase WHERE fldindex=".$line['fldid_nachdatabase'];
      //echo $qrydb."<br>";
      $resdb = $db->query($qrydb);
      $lindb = $resdb->fetchArray();
      //echo $lindb['fldpfad'];
      array_push($arrnchwebsite,$lindb['fldpfad']);
      array_push($arrnchdbtyp,$lindb['flddbtyp']);
      array_push($arrnchdbname,$lindb['fldbez']);
      array_push($arrnchdbuser,$lindb['flddbuser']);
      array_push($arrnchdbpassword,$lindb['flddbpassword']);
      array_push($arrdbsyncnr,$lindb['flddbsyncnr']);
    }
  }  

  if ($anztables==0) {
    echo "<div class='alert alert-warning'>";
    echo "Keine Tables zum synchronisieren aktiviert.";
    echo "</div>";
  } else {
    $strvontables=json_encode($arrvontables);
    $strnchtables=json_encode($arrnchtables);
    $strvonindex=json_encode($arrvonindex);
    $strnchindex=json_encode($arrnchindex);
    $strvonbez=json_encode($arrvonbez);
    $strnchbez=json_encode($arrnchbez);
    $strnchwebsite=json_encode($arrnchwebsite);
    $strvondbtyp=json_encode($arrvondbtyp);
    $strnchdbtyp=json_encode($arrnchdbtyp);
    $strvondbname=json_encode($arrvondbname);
    $strnchdbname=json_encode($arrnchdbname);
    $strvondbuser=json_encode($arrvondbuser);
    $strvondbpassword=json_encode($arrvondbpassword);
    $strdbsyncnr=json_encode($arrdbsyncnr);
    //echo $strnchindex."<br>";
    $value="Anzeige starten";
    if ($onlyshow=="N") {
      $value="Sync starten";
    }
	$synctyp='remote';
    echo "<form class='form-horizontal' method='post' action='sync.php?showsync=1&menu=".$menu."&onlyshow=".$onlyshow."'>";
    echo "<select name='typ' size='1'>";
	if ($synctyp=="local") {
      echo "<option style='background-color:#c0c0c0;' selected>local</option>";
      echo "<option style='background-color:#c0c0c0;' >remote</option>";
	} else {
      echo "<option style='background-color:#c0c0c0;' >local</option>";
      echo "<option style='background-color:#c0c0c0;' selected>remote</option>";
	}
    echo "</select>";
    echo "<input type='hidden' name='status' value='sync' />";
    echo "<input type='hidden' name='anztables' value=".$anztables." />";
    echo "<input type='hidden' name='strvontables' value=".$strvontables." />";
    echo "<input type='hidden' name='strnchtables' value=".$strnchtables." />";
    echo "<input type='hidden' name='strvonindex' value=".$strvonindex." />";
    echo "<input type='hidden' name='strnchindex' value=".$strnchindex." />";
    echo "<input type='hidden' name='strvonbez' value=".$strvonbez." />";
    echo "<input type='hidden' name='strnchbez' value=".$strnchbez." />";
    echo "<input type='hidden' name='strnchwebsite' value=".$strnchwebsite." />";
    echo "<input type='hidden' name='strvondbtyp' value=".$strvondbtyp." />";
    echo "<input type='hidden' name='strnchdbtyp' value=".$strnchdbtyp." />";
    echo "<input type='hidden' name='strvondbname' value=".$strvondbname." />";
    echo "<input type='hidden' name='strnchdbname' value=".$strnchdbname." />";
    echo "<input type='hidden' name='strvondbuser' value=".$strvondbuser." />";
    echo "<input type='hidden' name='strvondbpassword' value=".$strvondbpassword." />";
    echo "<input type='hidden' name='strdbsyncnr' value=".$strdbsyncnr." />";
    echo "<dd><input type='submit' value='".$value."' /></dd>";
    echo "</form>";
  }	
  
	
}
 
function showsynclocal($menu,$database,$pfad,$onlyshow) {
  $db = new SQLite3('../data/'.$database);
  $qry = "SELECT * FROM tbltable";
  $results = $db->query($qry);


  echo "<br>";
  //echo "<div class='alert alert-info'>";
  //echo "onlyshow=".$onlyshow;
  //echo "</div>";
  while ($line = $results->fetchArray()) {
    $aktiv=$line['fldaktiv'];
    if ($aktiv=='J') {
      $dbvonid=$line['fldid_vondatabase'];
      $qryvondb = "SELECT * FROM tbldatabase WHERE fldindex=".$dbvonid;
      $resvondb = $db->query($qryvondb);
      if ($linvondb = $resvondb->fetchArray()) {
        $dbvontyp=$linvondb['flddbtyp'];

      }
      $dbvontable=$line['fldvontblname'];
      $dbtable=$line['fldvontblname'];
      //echo $dbtable."<br>";

      $dbtyp="MYSQL";
      $dblocal="dbjoorgportal";
      $dbuser="root";
      $dbpassword="mysql";

  $dbsyncnr=1;
  $qryval = "SELECT * FROM tblsyncstatus WHERE flddbsyncnr=".$dbsyncnr." and fldtable='".$dbtable."'";
  echo $qryval."<br>";
  $results = dbquerytyp('SQLITE3',$db,$qryval);
  if ($linval = dbfetchtyp('SQLITE3',$results)) {
      $timestamp=$linval['fldtimestamp'];
  } else {
      $timestamp="2015-01-01 06:00:00";
  }
  echo $timestamp."<br>";

  $website="allnosync.php?menu=".$menu;
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='submit' value='All NoSync' />";
  echo "<input type='hidden' name='pfad' value='".$pfad."' />";
  echo "<input type='hidden' name='dbvontyp' value='".$dbvontyp."' />";
  echo "<input type='hidden' name='dbtable' value='".$dbtable."' />";
  echo "<input type='hidden' name='database' value='".$dblocal."' />";
  echo "<input type='hidden' name='dbuser' value='".$dbuser."' />";
  echo "<input type='hidden' name='dbpassword' value='".$dbpassword."' />";
  echo "<input type='hidden' name='dbsyncnr' value='".$dbsyncnr."' />";
  echo "<input type='hidden' name='timestamp' value='".$timestamp."' />";
  echo "</form>";	


  echo "<table>";
  echo "<tr><td>Pfad</td><td> : ".$pfad."</td></tr>";
  echo "<tr><td>Datenbank</td><td> : ".$dblocal."</td></tr>";
  echo "<tr><td>Table</td><td> : ".$dbtable."</td></tr>";
  echo "<tr><td>dbsyncnr</td><td> : ".$dbsyncnr."</td></tr>";
  echo "<tr><td>timestamp</td><td> : ".$timestamp."</td></tr>";
  echo "</table>";


      if ($onlyshow=="N") {
        echo "<form class='form-horizontal' method='post' action='sync.php?menu=".$menu."'>";
        echo "<dd><input type='submit' value='Daten senden' /></dd>";
      }
      
          
        $dbopen=dbopentyp($dbvontyp,$dblocal,$dbuser,$dbpassword);
        $col = "";
        $lincnt = 1;
        $count = 0;
  		  $query="SHOW COLUMNS FROM ".$dbtable;
          $results = dbquerytyp($dbtyp,$dbopen,$query);
          $arrcol = array();
          while ($row = dbfetchtyp($dbtyp,$results)) {
            $colstr=$row['Field'];
            $lincnt = $lincnt + 1;
            $arrcol[] = $colstr;
            if ($col=="") {
              $col=$colstr;
            } else {	
              $col=$col.",".$colstr;
            }    
		  }
      
      
      $dblocalopen=dbopentyp($dbvontyp,$dblocal,$dbuser,$dbpassword);
      $colsel="*";
      $dbsyncnr="1";
      $qryval = "SELECT ".$colsel." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr." AND flddbsyncstatus='SYNC'";
	   echo $qryval."<br>";
      $resval = dbquerytyp($dbvontyp,$dblocalopen,$qryval);
      $datcnt=0;
      $dbindex="fldIndex";
      echo "<table class='table table-hover'>";
      echo "<tr><th>dummy</th><th>NOSYNC</th></tr>";
      while ($linval = dbfetchtyp($dbtyp,$resval)) {
        echo "<tr>";
        echo "<td>";
        echo $linval[1];
        echo "</td>";
        //echo "<td>NOSYNC</td>";
        echo "<td><a href='nosync.php?menu=".$menu."&dbindex=".$linval[0]."' class='btn btn-primary btn-sm active' role='button'>NOSYNC</a></td> ";
        echo "</tr>";
        
        $val = "#".$linval[0]."#";
        $updsql=$arrcol[0]."=#".$linval[0]."#";
        for($lincount = 1; $lincount+1 < $lincnt; $lincount++) {
          $val = $val . ",#".$linval[$lincount]."#";
          $updsql = $updsql.",".$arrcol[$lincount]."=#".$linval[$lincount]."#";
        }
        $datcnt=$datcnt+1;
        $index=$linval[$dbindex];
        $updsql="UPDATE ".$dbtable." SET ".$updsql." WHERE ".$dbindex."=".$index;
        $inssql = "INSERT INTO ".$dbtable."(".$col.") VALUES (".$val.");";
        echo "<input type='hidden' name='index".$datcnt."' value='".$index."'/>";
        echo "<input type='hidden' name='updsql".$datcnt."' value='".$updsql."'/>";
        echo "<input type='hidden' name='inssql".$datcnt."' value='".$inssql."'/>";
        
      }
      echo "<input type='hidden' name='datcnt' value='".$datcnt."'/>";
      echo "<input type='hidden' name='dbtable' value='".$dbtable."'/>";
      echo "</table>";
      
      if ($onlyshow=="N") {
        echo "<input type='hidden' name='status' value='senden' />";
        echo "</form>";
      }      
    }
  }  

}

function showsyncremote($menu,$database,$pfad) {
  echo "<br><br>";	
  $remotedatabase="/var/www/html/own/joorgsqlite/data/joorgsqlite.db";
  $dbtable="tblfahrtenbuch";
  $fldindex="fldindex";
  $website="http://localhost/own/phpmysyncremote/classes/syncremote.php?menu=".$menu."&dbtable=".$dbtable."&showsync=J";	
  echo "<div class='alert alert-info'>";
  //echo $website."<br>";
  echo "<table>";
  echo "<tr><td>website</td><td> : ".$website."</td></tr>";
  echo "<tr><td>Pfad</td><td> : ".$pfad."</td></tr>";
  echo "<tr><td>Datenbank</td><td> : ".$remotedatabase."</td></tr>";
  echo "<tr><td>Table</td><td> : ".$dbtable."</td></tr>";
  echo "<tr><td>fldindex</td><td> : ".$fldindex."</td></tr>";
  echo "</table>";
  echo "</div>";
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='pfad' value='".$pfad."' />";
  echo "<input type='hidden' name='database' value='".$remotedatabase."' />";
  echo "<input type='hidden' name='fldindex' value='".$fldindex."' />";
  echo "<dd><input type='submit' value='Daten zeigen' /></dd>";
  echo "</form>";

}

function syncsenden($database,$datcnt,$dbtypVon,$dbtable) {
  echo $datcnt."x syncsenden<br>";
  $fldindexNch="fldIndex";
  $dbtypNch="SQLITE3";
  $dbaseNch="/var/www/html/own/joorgsqlite/data/joorgsqlite.db";
  $dbuserNch="";
  $dbpasswordNch="";
  $dbNch=dbopentyp($dbtypNch,$dbaseNch,$dbuserNch,$dbpasswordNch);

  //$fldindexVon="fldIndex";
  //$dbtyp="MYSQL";
  //$dbaseVon="dbjoorgportal";
  //$dbuserVon="root";
  //$dbpasswordVon="mysql";
  //$dbVon=dbopentyp($dbtypVon,$dbaseVon,$dbuserVon,$dbpasswordVon);
  for($cnt = 1; $cnt <= $datcnt; $cnt++) {
  	
    $index=$_POST['index'.$cnt];
    $qryval = "SELECT * FROM ".$dbtable." WHERE ".$fldindexNch."=".$index;
	 echo $qryval."<br>";
    $results = dbquerytyp($dbtypNch,$dbNch,$qryval);
    if ($linval = dbfetchtyp($dbtypNch,$results)) {
    	 echo $_POST['index'.$datcnt]."<br>";
    	 $sql=$_POST['updsql'.$datcnt];
  	    $sql=str_replace("#","'",$sql);
  	 } else {  
  	   echo $sql."<br>";
  	   $sql=$_POST['inssql'.$datcnt];
  	   $sql=str_replace("#","'",$sql);
  	 }  
  	 echo $sql."<br>";
  	 dbexecutetyp($dbtypNch,$dbNch,$sql);
  	 //$qryupd="UPDATE ".$dbtable." SET flddbsyncstatus='NOSYNC' WHERE fldindex=".$index;
  	 //echo $qryupd."<br>";
  	 //dbexecutetyp($dbtyploc,$dblocal,$qryupd);
  }  
//  $db = new SQLite3('../data/'.$database);
  $db=dbopentyp('SQLITE3','../data/'.$database,'','');
  $datetime = new DateTime();
  $timestamp=$datetime->format('Y-m-d H:i:s');  
  echo $timestamp."=timestamp<br>";
  $qryval = "SELECT * FROM tblsyncstatus WHERE flddbsyncnr=1 and fldtable='".$dbtable."'";
  echo $qryval."<br>";
  $results = dbquerytyp('SQLITE3',$db,$qryval);
  if ($linval = dbfetchtyp('SQLITE3',$results)) {
    $sql="UPDATE tblsyncstatus SET fldtimestamp='".$timestamp."' WHERE fldtable='".$dbtable."' and flddbsyncnr=1";
  } else {
    $sql="INSERT INTO tblsyncstatus (fldtable,fldtimestamp,flddbsyncnr) VALUES('".$dbtable."','".$timestamp."',1)";
  }
  echo $sql."<br>";
  dbexecutetyp('SQLITE3',$db,$sql);
}

function auslesen($menu,$database,$onlyshow) {
//  echo "<div class='alert alert-success'>";
//  echo "Auslesen<br><br>";
//  echo "</div>";

//  $websitetest="http://localhost/own/phpmysync/classes/syncremote.php?menu=".$menu;
  $aktpfad=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];  
  $callbackurl="http://".$aktpfad."?menu=".$menu;
  $anztables=$_POST["anztables"];
  $arrvontables=json_decode($_POST["strvontables"]);
  $strvontables=$arrvontables[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvontables=$strvontables.",".$arrvontables[$tablecount];
  }
  $arrnchtables=json_decode($_POST["strnchtables"]);
  $strnchtables=$arrnchtables[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchtables=$strnchtables.",".$arrnchtables[$tablecount];
  }
  $arrvonindex=json_decode($_POST["strvonindex"]);
  $strvonindex=$arrvonindex[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvonindex=$strvonindex.",".$arrvonindex[$tablecount];
  }
  $arrnchindex=json_decode($_POST["strnchindex"]);
  $strnchindex=$arrnchindex[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchindex=$strnchindex.",".$arrnchindex[$tablecount];
  }
  $arrvonbez=json_decode($_POST["strvonbez"]);
  $strvonbez=$arrvonbez[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvonbez=$strvonbez.",".$arrvonbez[$tablecount];
  }
  $arrnchbez=json_decode($_POST["strnchbez"]);
  $strnchbez=$arrnchbez[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchbez=$strnchbez.",".$arrnchbez[$tablecount];
  }
  $arrnchwebsite=json_decode($_POST["strnchwebsite"]);
  $strnchwebsite=$arrnchwebsite[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchwebsite=$strnchwebsite.",".$arrnchwebsite[$tablecount];
  }
  $website=$arrnchwebsite[0]."classes/syncremote.php?menu=".$menu;
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
  
//  $strdatenstruc="";
//  $strdatenval="";

  echo "<div class='alert alert-info'>";
  echo "Auslesen<br>";
  echo "<table>";
//  echo "<tr><td>website (Test)</td><td> : ".$websitetest."</td></tr>";
  echo "<tr><td>website</td><td> : ".$website."</td></tr>";
//  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
//  echo "<tr><td>menu</td><td> : ".$menu."</td></tr>";
//  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "<tr><td>anztables</td><td> : ".$anztables."</td></tr>";
  echo "<tr><td>strvontables</td><td> : ".$strvontables."</td></tr>";
  echo "<tr><td>strvonindex</td><td> : ".$strvonindex."</td></tr>";
  echo "<tr><td>strvonbez</td><td> : ".$strvonbez."</td></tr>";
  echo "<tr><td>strvondbtyp</td><td> : ".$strvondbtyp."</td></tr>";
  echo "<tr><td>strvondbname</td><td> : ".$strvondbname."</td></tr>";
  echo "<tr><td>strvondbuser</td><td> : ".$strvondbuser."</td></tr>";
  echo "<tr><td>strvondbpassword</td><td> : ".$strvondbpassword."</td></tr>";
  echo "<tr><td>strnchtables</td><td> : ".$strnchtables."</td></tr>";
  echo "<tr><td>strnchindex</td><td> : ".$strnchindex."</td></tr>";
  echo "<tr><td>strnchbez</td><td> : ".$strnchbez."</td></tr>";
  echo "<tr><td>strnchdbtyp</td><td> : ".$strnchdbtyp."</td></tr>";
  echo "<tr><td>strnchdbname</td><td> : ".$strnchdbname."</td></tr>";
  echo "<tr><td>strnchdbuser</td><td> : ".$strnchdbuser."</td></tr>";
  echo "<tr><td>strnchdbpassword</td><td> : ".$strnchdbpassword."</td></tr>";
  echo "<tr><td>strdbsyncnr</td><td> : ".$strdbsyncnr."</td></tr>";
//  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
//    echo "<tr><td>strdatenstruc</td><td> : ".$strdatenstruc."</td></tr>";
//    echo "<tr><td>strdatenval</td><td> : ".$strdatenval."</td></tr>";
//  }

  $arrcolsel=array();
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    $column=getdbcolumn($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvontables[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);   
    array_push($arrcolsel,$column);
    //echo "<tr><td>strdatenstruc</td><td> : ".$column."</td></tr>";
  }

  echo "</table>";
  echo "</div>";
  
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='callbackurl' value='".$callbackurl."' />";
  echo "<input type='hidden' name='onlyshow' value='".$onlyshow."' />";
  echo "<input type='hidden' name='action' value='einspielen' />";
  echo "<input type='hidden' name='anztables' value=".$anztables." />";
  echo "<input type='hidden' name='strnchdbtyp' value=".json_encode($arrnchdbtyp)." />";
  echo "<input type='hidden' name='strnchdbname' value=".json_encode($arrnchdbname)." />";
  echo "<input type='hidden' name='strnchdbuser' value=".json_encode($arrnchdbuser)." />";
  echo "<input type='hidden' name='strnchdbpassword' value=".json_encode($arrnchdbpassword)." />";
  echo "<input type='hidden' name='strnchtables' value=".json_encode($arrnchtables)." />";
  echo "<input type='hidden' name='strnchindex' value=".json_encode($arrnchindex)." />";
  echo "<input type='hidden' name='strcolsel' value=".json_encode($arrcolsel)." />";
  echo "<input type='hidden' name='strdbsyncnr' value=".json_encode($arrdbsyncnr)." />";
  echo "<input type='submit' value='Daten einspielen' /><br>";
  
  echo "<table class='table table-hover'>";
  echo "<tr><th>Table</th><th>Index</th><th>Bezeichnung</th><th>NOSYNC</th></tr>";
  //$qryval = "SELECT ".$colsel." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr." AND flddbsyncstatus='SYNC'";
  //echo "<br>";
  $arranzds = array();
  $arridxds = array();
  $arrdaten = array();
  $db = new SQLite3('../data/'.$database);
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    $query="SELECT * FROM tblsyncstatus WHERE fldtable='".$arrnchtables[$tablecount]."' AND flddbsyncnr=".$arrdbsyncnr[$tablecount];
	echo $query."<br>";
    $resst = $db->query($query);
    if ($linst = $resst->fetchArray()) {
	  $timestamp=$linst['fldtimestamp'];
	} else {
      $timestamp='2015-01-01 00:00:00'; 
	}
	echo $timestamp."=timestamp<br>";
    $dbvonopen=dbopentyp($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);
    $qryval = "SELECT ".$arrcolsel[$tablecount]." FROM ".$arrvontables[$tablecount]." WHERE flddbsyncstatus='SYNC' AND fldtimestamp>'".$timestamp."'";
	echo $qryval."<br>";
    $resval = dbquerytyp($arrvondbtyp[$tablecount],$dbvonopen,$qryval);
	$datcnt=0;
    while ($linval = dbfetchtyp($arrvondbtyp[$tablecount],$resval)) {
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
      echo "<td>".$arrvontables[$tablecount]."</td>";
      echo "<td>".$linval[$arrvonindex[$tablecount]]."</td>";
      echo "<td>".$linval[$arrvonbez[$tablecount]]."</td>";
      echo "<td><a href='nosync.php?menu=".$menu."&dbindex=".$linval[$arrvonindex[$tablecount]]."' class='btn btn-primary btn-sm active' role='button'>NOSYNC</a></td> ";
      echo "</tr>";
      array_push($arridxds,$linval[$arrvonindex[$tablecount]]);
	 }  
	 echo $datcnt."=anzds<br>";
	 array_push($arranzds,$datcnt);
  }	
  echo "</table>";  
  $strdaten=json_encode($arrdaten);
  echo "<div class='alert alert-info'>";
  echo $strdaten."=strdaten<br>";
  echo "</div>";
  echo "<input type='hidden' name='stranzds' value=".json_encode($arranzds)." />";
  echo "<input type='hidden' name='stridxds' value=".json_encode($arridxds)." />";
  echo "<input type='hidden' name='strdaten' value=".$strdaten." />";
  
  echo "</form>";
  
}

function fernabfrage($menu,$onlyshow) {

  $anztables=$_POST["anztables"];
  $arrvontables=json_decode($_POST["strvontables"]);
  $strvontables=$arrvontables[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvontables=$strvontables.",".$arrvontables[$tablecount];
  }
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
  $arrcolsel=array();
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    $column=getdbcolumn($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvontables[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);   
    array_push($arrcolsel,$column);
	//echo $column."<br>";
    //echo "<tr><td>strdatenstruc</td><td> : ".$column."</td></tr>";
  }

  
  $arrnchwebsite=json_decode($_POST["strnchwebsite"]);
  //$website="http://localhost:8080/own/phpmysync/classes/syncauslesen.php?menu=".$menu;
  $website=$arrnchwebsite[0]."classes/syncauslesen.php?menu=".$menu;
  $aktpfad=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];  
  $callbackurl="http://".$aktpfad."?menu=".$menu;

  echo "<div class='alert alert-info'>";
  echo "Fernabfrage";
  echo "<table>";
  echo "<tr><td>website</td><td> : ".$website."</td></tr>";
  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
  echo "<tr><td>menu</td><td> : ".$menu."</td></tr>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "<tr><td>strnchtables</td><td> : ".$strnchtables."</td></tr>";
  echo "<tr><td>strnchindex</td><td> : ".$strnchindex."</td></tr>";
  echo "<tr><td>strnchbez</td><td> : ".$strnchbez."</td></tr>";
  echo "<tr><td>strnchdbtyp</td><td> : ".$strnchdbtyp."</td></tr>";
  echo "<tr><td>strnchdbname</td><td> : ".$strnchdbname."</td></tr>";
  echo "<tr><td>strnchdbuser</td><td> : ".$strnchdbuser."</td></tr>";
  echo "<tr><td>strnchdbpassword</td><td> : ".$strnchdbpassword."</td></tr>";
  echo "<tr><td>strvontables</td><td> : ".$strvontables."</td></tr>";
  echo "<tr><td>strvondbtyp</td><td> : ".$strvondbtyp."</td></tr>";
  echo "<tr><td>strvondbname</td><td> : ".$strvondbname."</td></tr>";
  echo "<tr><td>strvondbuser</td><td> : ".$strvondbuser."</td></tr>";
  echo "<tr><td>strvondbpassword</td><td> : ".$strvondbpassword."</td></tr>";
  echo "<tr><td>strdbsyncnr</td><td> : ".$strdbsyncnr."</td></tr>";
  echo "</table>";
  echo "</div>";
  
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='callbackurl' value='".$callbackurl."' />";
  echo "<input type='hidden' name='onlyshow' value='".$onlyshow."' />";
  echo "<input type='hidden' name='anztables' value='".$anztables."' />";
  echo "<input type='hidden' name='strnchtables' value='".json_encode($arrnchtables)."' />";
  echo "<input type='hidden' name='strvontables' value='".json_encode($arrvontables)."' />";
  echo "<input type='hidden' name='strnchindex' value='".json_encode($arrnchindex)."' />";
  echo "<input type='hidden' name='strvonindex' value='".json_encode($arrvonindex)."' />";
  echo "<input type='hidden' name='strnchbez' value='".json_encode($arrnchbez)."' />";
  echo "<input type='hidden' name='strnchdbtyp' value='".json_encode($arrnchdbtyp)."' />";
  echo "<input type='hidden' name='strnchdbname' value='".json_encode($arrnchdbname)."' />";
  echo "<input type='hidden' name='strnchdbuser' value='".json_encode($arrnchdbuser)."' />";
  echo "<input type='hidden' name='strnchdbpassword' value='".json_encode($arrnchdbpassword)."' />";
  echo "<input type='hidden' name='strvondbtyp' value='".json_encode($arrvondbtyp)."' />";
  echo "<input type='hidden' name='strvondbname' value='".json_encode($arrvondbname)."' />";
  echo "<input type='hidden' name='strvondbuser' value='".json_encode($arrvondbuser)."' />";
  echo "<input type='hidden' name='strvondbpassword' value='".json_encode($arrvondbpassword)."' />";
  echo "<input type='hidden' name='strdbsyncnr' value='".json_encode($arrdbsyncnr)."' />";
  echo "<input type='hidden' name='strcolsel' value='".json_encode($arrcolsel)."' />";
  echo "<input type='hidden' name='strnchwebsite' value='".json_encode($arrnchwebsite)."' />";
  echo "<input type='hidden' name='action' value='auslesen' />";
  echo "<input type='submit' value='Daten auslesen' />";
  echo "</form>";
  
}

function einspielen($menu,$onlyshow) {
  $anztables=$_POST["anztables"];
  $arrvontables=json_decode($_POST["strvontables"]);
  $arrnchtables=json_decode($_POST["strnchtables"]);
  $arrvonindex=json_decode($_POST["strvonindex"]);
  $arrvondbtyp=json_decode($_POST["strvondbtyp"]);
  $arrvondbname=json_decode($_POST["strvondbname"]);
  $arrvondbuser=json_decode($_POST["strvondbuser"]);
  $arrvondbpassword=json_decode($_POST["strvondbpassword"]);
  $arrtblstatus=json_decode($_POST["strtblstatus"]);
  $arrdbsyncnr=json_decode($_POST["strdbsyncnr"]);
  $arranzds=json_decode($_POST["stranzds"]);
  $arridxds=json_decode($_POST["stridxds"]);
  $arrdaten=json_decode($_POST["strdaten"]);
  $arrnchwebsite=json_decode($_POST["strnchwebsite"]);
  echo "<div class='alert alert-info'>";
  echo "einspielen<br>";
  echo "<table>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "<tr><td>anztables</td><td> : ".$anztables."</td></tr>";
  echo "</table>";
  $idxcnt=0;
  $idxcol=0;
  for($tablecount = 0; $tablecount < $anztables; $tablecount++) {
    if ($arrtblstatus[$tablecount]=="OK") {
      $dbvonopen=dbopentyp($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);
      $column=getdbcolumn($arrvondbtyp[$tablecount],$arrvondbname[$tablecount],$arrvontables[$tablecount],$arrvondbuser[$tablecount],$arrvondbpassword[$tablecount]);   
      $arrcolumn = explode(",", $column);
	  echo $arranzds[$tablecount]."=anzds<br>";
      for( $i=1; $i <= $arranzds[$tablecount]; $i++ ) {
        $qryval="SELECT * FROM ".$arrvontables[$tablecount]." WHERE ".$arrvonindex[$tablecount]."=".$arridxds[$idxcnt];
	    echo $qryval."<br>";
        $resval = dbquerytyp($arrvondbtyp[$tablecount],$dbvonopen,$qryval);
        if ($linval = dbfetchtyp($arrvondbtyp[$tablecount],$resval)) {
          $upd=$arrcolumn[0]."='".str_replace("#"," ",$arrdaten[$idxcol])."'";
          //$upd=$arrcolumn[0]."=''";
          for( $colidx=1; $colidx <count($arrcolumn); $colidx++) {
          	$idxcol=$idxcol+1;
          	$upd=$upd.", ".$arrcolumn[$colidx]."='".str_replace("#"," ",$arrdaten[$idxcol])."'";
          	//$upd=$upd.", ".$arrcolumn[$colidx]."=''";
          }
		  $sql="UPDATE ".$arrvontables[$tablecount]." SET ".$upd." WHERE ".$arrvonindex[$tablecount]."=".$arridxds[$idxcnt];;
		} else {
        for( $colidx=0; $colidx <count($arrcolumn); $colidx++) {
        	 if ($colidx==0) {
            $ins="'".str_replace("#"," ",$arrdaten[$colidx])."'";
        	 } else {
            $ins=$ins.", '".str_replace("#"," ",$arrdaten[$colidx])."'";
          }  
        }
		  $sql="INSERT INTO ".$arrvontables[$tablecount]." (".$column.") VALUES(".$ins.")";
		}
		echo $sql."<br>";
        dbexecutetyp($arrvondbtyp[$tablecount],$dbvonopen,$sql); 
       	$idxcol=$idxcol+1;
     	$idxcnt=$idxcnt+1;
	  }	
	}
  }
  echo "</div>";
  //$website="http://localhost:8080/own/phpmysync/classes/syncfertig.php?menu=".$menu;
  $website=$arrnchwebsite[0]."syncfertig.php?menu=".$menu;
  $aktpfad=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];  
  $callbackurl="http://".$aktpfad."?menu=".$menu;
  
  $onlyshow="";
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='callbackurl' value='".$callbackurl."' />";
  echo "<input type='hidden' name='strnchtables' value='".json_encode($arrnchtables)."' />";
  echo "<input type='hidden' name='strtblstatus' value='".json_encode($arrtblstatus)."' />";
  echo "<input type='hidden' name='strdbsyncnr' value='".json_encode($arrdbsyncnr)."' />";
  echo "<input type='submit' value='Daten abschließen' />";
  echo "</form>";
  
}

function abschliessen($onlyshow,$database) {
  echo "<br>";	
  echo "<div class='alert alert-info'>";
  if ($onlyshow=="J") {
    echo "Datenanzeige abgeschlossen.<br>";	
  } else {
    $arrtblstatus=json_decode($_POST["strtblstatus"]);
    $arrdbsyncnr=json_decode($_POST["strdbsyncnr"]);
    $db = new SQLite3('../data/'.$database);
    $date = date('Y-m-d');
    $time = date('H:i:s', time());
	$timestamp=$date." ".$time;
    $arrnchtables=json_decode($_POST["strnchtables"]);
	echo count($arrnchtables)."=anztable<br>";
    for($tblcnt = 0; $tblcnt < count($arrnchtables); $tblcnt++) {
	  if ($arrtblstatus[$tblcnt]=="OK") {
	    $query="SELECT * FROM tblsyncstatus WHERE fldtable='".$arrnchtables[$tblcnt]."'";
	    echo $query."<br>";
        $results = $db->query($query);
        if ($line = $results->fetchArray()) {
	      $sql="UPDATE tblsyncstatus SET fldtimestamp='".$timestamp."' WHERE fldtable='".$arrnchtables[$tblcnt]."' AND flddbsyncnr=".$arrdbsyncnr[$tblcnt];
	    } else {
	      $sql="INSERT INTO tblsyncstatus (fldtable,fldtimestamp,flddbsyncnr) VALUES('".$arrnchtables[$tblcnt]."','".$timestamp."',".$arrdbsyncnr[$tblcnt].")";
	    }
	    echo $sql."<br>";
        dbexecutetyp("SQLITE3",$db,$sql); 
	  } else {
	    echo $arrnchtables[$tblcnt]." not ok.<br>";
      }	  
	}
    echo "Timestamp:".$timestamp."<br>";
    echo "Datensynchronisation abgeschlossen.<br>";	
  }
  echo "onlyshow=".$onlyshow."<br>";	
  echo "</div>";
}

?>