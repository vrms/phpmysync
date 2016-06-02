<?php

function showauswahl($menu,$database,$onlyshow) {
  $db = new SQLite3('../data/'.$database);
  $qry = "SELECT * FROM tbltable";
  $results = $db->query($qry);
  $anztables=0;
  $arrvontables = array();
  $arrnchtables = array();
  $arrvonindex = array();
  $arrnchindex = array();
  $arrnchwebsite = array();
  $arrnchdbtyp = array();
  while ($line = $results->fetchArray()) {
    $aktiv=$line['fldaktiv'];
    if ($aktiv=='J') {
      $anztables=$anztables+1;
      array_push($arrvontables,$line['fldvontblname']);
      array_push($arrnchtables,$line['fldvontblindex']);
      array_push($arrvonindex,$line['fldvontblindex']);
      array_push($arrnchindex,$line['fldnachindex']);
      $qrydb = "SELECT * FROM tbldatabase WHERE fldindex=".$line['fldid_nachdatabase'];
      //echo $qrydb."<br>";
      $resdb = $db->query($qrydb);
      $lindb = $resdb->fetchArray();
      //echo $lindb['fldpfad'];
      array_push($arrnchwebsite,$lindb['fldpfad']);
      array_push($arrnchdbtyp,$lindb['flddbtyp']);
    }
  }  

  $strvontables=json_encode($arrvontables);
  $strnchtables=json_encode($arrnchtables);
  $strvonindex=json_encode($arrvonindex);
  $strnchindex=json_encode($arrnchindex);
  $strnchwebsite=json_encode($arrnchwebsite);
  $strnchdbtyp=json_encode($arrnchdbtyp);
  //echo $strtables."<br>";
  $value="Anzeige starten";
  if ($onlyshow=="N") {
    $value="Sync starten";
  }
  echo "<form class='form-horizontal' method='post' action='sync.php?showsync=1&menu=".$menu."&onlyshow=".$onlyshow."'>";
  echo "<select name='typ' size='1'>";
  echo "<option style='background-color:#c0c0c0;' selected>local</option>";
  echo "<option style='background-color:#c0c0c0;' >remote</option>";
  echo "</select>";
  echo "<input type='hidden' name='status' value='sync' />";
  echo "<input type='hidden' name='anztables' value=".$anztables." />";
  echo "<input type='hidden' name='strvontables' value=".$strvontables." />";
  echo "<input type='hidden' name='strnchtables' value=".$strnchtables." />";
  echo "<input type='hidden' name='strvonindex' value=".$strvonindex." />";
  echo "<input type='hidden' name='strnchindex' value=".$strnchindex." />";
  echo "<input type='hidden' name='strnchwebsite' value=".$strnchwebsite." />";
  echo "<input type='hidden' name='strnchdbtyp' value=".$strnchdbtyp." />";
  echo "<dd><input type='submit' value='".$value."' /></dd>";
  echo "</form>";
  
	
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

function auslesen($menu,$onlyshow) {
  echo "<div class='alert alert-success'>";
  echo "Auslesen<br><br>";
  echo "<div>";

//  $websitetest="http://localhost/own/phpmysync/classes/syncremote.php?menu=".$menu;
  $aktpfad=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];  
  $callbackurl="http://".$aktpfad."?menu=".$menu;
  $anztables=$_POST["anztables"];
  $arrvontables=json_decode($_POST["strvontables"]);
  $strvontables=$arrvontables[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvontables=$strvontables.",".$arrvontables[$tablecount];
  }
  $arrvonindex=json_decode($_POST["strvonindex"]);
  $strvonindex=$arrvonindex[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strvonindex=$strvonindex.",".$arrvonindex[$tablecount];
  }
  $arrnchwebsite=json_decode($_POST["strnchwebsite"]);
  $strnchwebsite=$arrnchwebsite[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchwebsite=$strnchwebsite.",".$arrnchwebsite[$tablecount];
  }
  $website=$arrnchwebsite[0]."classes/syncremote.php?menu=".$menu;
  $arrnchdbtyp=json_decode($_POST["strnchdbtyp"]);
  $strnchdbtyp=$arrnchdbtyp[0];
  for($tablecount = 1; $tablecount < $anztables; $tablecount++) {
  	 $strnchdbtyp=$strnchdbtyp.",".$arrnchdbtyp[$tablecount];
  }
  

  echo "<div class='alert alert-info'>";
  echo "<table>";
//  echo "<tr><td>website (Test)</td><td> : ".$websitetest."</td></tr>";
  echo "<tr><td>website</td><td> : ".$website."</td></tr>";
  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
  echo "<tr><td>menu</td><td> : ".$menu."</td></tr>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "<tr><td>anztables</td><td> : ".$anztables."</td></tr>";
  echo "<tr><td>strtables</td><td> : ".$strvontables."</td></tr>";
  echo "<tr><td>strindex</td><td> : ".$strvonindex."</td></tr>";
  echo "<tr><td>strnchdbtyp</td><td> : ".$strnchdbtyp."</td></tr>";
  echo "</table>";
  echo "</div>";

  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='callbackurl' value='".$callbackurl."' />";
  echo "<input type='hidden' name='onlyshow' value='".$onlyshow."' />";
  echo "<input type='hidden' name='action' value='einspielen' />";
  echo "<input type='submit' value='Daten einspielen' />";
  echo "</form>";
  
  
}

function fernabfrage($menu,$onlyshow) {
  echo "fernabfrage<br><br>";

  $website="http://localhost/own/phpmysync/classes/syncremote.php?menu=".$menu;
  $aktpfad=$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];  
  $callbackurl="http://".$aktpfad."?menu=".$menu;

  echo "<div class='alert alert-info'>";
  echo "<table>";
  echo "<tr><td>website</td><td> : ".$website."</td></tr>";
  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
  echo "<tr><td>menu</td><td> : ".$menu."</td></tr>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "</table>";
  echo "</div>";
  
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='hidden' name='callbackurl' value='".$callbackurl."' />";
  echo "<input type='hidden' name='onlyshow' value='".$onlyshow."' />";
  echo "<input type='hidden' name='action' value='auslesen' />";
  echo "<input type='submit' value='Daten auslesen' />";
  echo "</form>";
  
}

function einspielen($onlyshow) {
  echo "einspielen<br><br>";
  echo "<div class='alert alert-info'>";
  echo "<table>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "</table>";
  echo "</div>";

  echo "abschliessen<br>";
}

function abschliessen($onlyshow) {
  echo "<br>";	
  echo "<div class='alert alert-info'>";
  if ($onlyshow=="J") {
    echo "Datenanzeige abgeschlossen.<br>";	
  } else {
    echo "Timestamp: 12:00<br>";
    echo "Datensynchronisation abgeschlossen.<br>";	
  }
  echo "onlyshow=".$onlyshow."<br>";	
  echo "</div>";
}

?>