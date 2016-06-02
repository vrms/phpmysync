<?php

function syncauswahl($database,$menu) {
  //$db = dbopen('../data/',$database);
  $db = new SQLite3('../data/'.$database);
  $qry = "SELECT * FROM tbltable";
  $results = $db->query($qry);

  echo "<form class='form-horizontal' method='post' action='sync.php?menu=".$menu."'>";
  echo "<input type='hidden' name='status' value='local'/>"; 
  echo "<br>";
  echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<th>#</th>";
  echo "<th>Von Datenbank</th>";
  echo "<th>Von Table</th>";
  echo "<th>Von Typ</th>";
  echo "<th>Nach Datenbank</th>";
  echo "<th>Nach Table</th>";
  echo "<th>Nach Typ</th>";
  echo "</tr>";
  $anz=0;
  while ($line = $results->fetchArray()) {
    $aktiv=$line['fldaktiv'];
	if ($aktiv=='J') {
	  $anz=$anz+1;
      $dbidlocal=$line['fldid_vondatabase'];
      $qrydblocal = "SELECT * FROM tbldatabase WHERE fldindex=".$dbidlocal;
      $resdblocal = $db->query($qrydblocal);
      if ($lindblocal = $resdblocal->fetchArray()) {
	    $selidlocal=$lindblocal['fldid_select'];
        $qrysellocal = "SELECT * FROM tblselect WHERE fldindex=".$selidlocal;
        $ressellocal = $db->query($qrysellocal);
        if ($linsellocal = $ressellocal->fetchArray()) {
          $typlocal=$linsellocal['fldbez'];
        }
	  }
      $dbidremote=$line['fldid_nachdatabase'];
      $qrydbremote = "SELECT * FROM tbldatabase WHERE fldindex=".$dbidremote;
      $resdbremote = $db->query($qrydbremote);
      if ($lindbremote = $resdbremote->fetchArray()) {
	    $selidremote=$lindbremote['fldid_select'];
        $qryselremote = "SELECT * FROM tblselect WHERE fldindex=".$selidremote;
        $resselremote = $db->query($qryselremote);
        if ($linselremote = $resselremote->fetchArray()) {
          $typremote=$linselremote['fldbez'];
        }
	  }
      echo "<tr>";
      echo "<td><input type='checkbox' name='chk".$anz."' value='true' checked></td>";
      echo "<td>".$lindblocal['fldbemerk']."</td>";
	  echo "<td>".$line['fldvontblname']."</td>";
	  echo "<td>".$typlocal."</td>";
	  echo "<td>".$lindbremote['fldbemerk']."</td>";
	  echo "<td>".$line['fldnachtblname']."</td>";
	  echo "<td>".$typremote."</td>";
      echo "</tr>";
      echo "<input type='hidden' name='ind".$anz."' value='".$line['fldindex']."'/>";
	}  
  }
  echo "</table>";

  echo "<input type='hidden' name='anz' value='".$anz."'/>";
  echo "<dd><input type='checkbox' name='nuranzeigen' value='anzeigen'/> nur anzeigen</dd>";
  echo "<dd><input type='submit' value='Austausch starten' /></dd>";
  echo "</form>";
}

function synclocal($database,$menu,$urladr,$pfad,$nuranzeigen) {
  $db = new SQLite3('../data/'.$database);
  $anz=$_POST['anz'];
  
  for( $i=1; $i <= $anz; $i++ ) {
    if ($_POST['chk'.$i]=='true') {
      //echo $_POST['chk'.$i]."=chk,".$_POST['ind'.$i]."<br>";
      $qry = "SELECT * FROM tbltable WHERE fldindex=".$_POST['ind'.$i];
      $results = $db->query($qry);
      if ($line = $results->fetchArray()) {
  	     $dbtable=$line['fldvontblname'];
  	     $dbindex=$line['fldvontblindex'];
        echo "<div class='alert alert-warning'>";
        $dbid=$line['fldid_vondatabase'];
        $qrydb = "SELECT * FROM tbldatabase WHERE fldindex=".$dbid;
        $resdb = $db->query($qrydb);
        if ($lindb = $resdb->fetchArray()) {
	      //$urladr=$lindb['fldpfad'];
		  $dblocal=$lindb['fldbez'];
		  $dbtyp=$lindb['flddbtyp'];
		  $dbuser=$lindb['flddbuser'];
		  $dbpassword=$lindb['flddbpassword'];
		  $dbsyncnr=$lindb['flddbsyncnr'];
		  //echo $dblocal.",".$dbtyp.",".$dbuser.",".$dbpassword."=db,typ,user,password<br>";
	    }
        $dbidnch=$line['fldid_nachdatabase'];
        $dbindexnch=$line['fldnachtblindex'];
        $qrydbnch = "SELECT * FROM tbldatabase WHERE fldindex=".$dbidnch;
        $resdbnch = $db->query($qrydbnch);
        if ($lindbnch = $resdbnch->fetchArray()) {
	      $urladr=$lindbnch['fldpfad'];
		   $dbsyncnrremote=$lindbnch['flddbsyncnr'];
		   $dbtypnch=$lindbnch['flddbtyp'];
        } 
		  
		$qryval = "SELECT * FROM tblsyncstatus WHERE fldtable='".$dbtable."'";
		//echo $qryval."=qryval<br>";
        $results = $db->query($qryval);
        if ($linval = $results->fetchArray()) {
          $timestamp=$linval['fldtimestamp'];
        } else {
          $timestamp="";
        }	
	    //echo $timestamp."=timestamp<br>";
      
        if ($timestamp=='') { 	  
          $website=$urladr."classes/syncremote".$dbtypnch.".php?menu=".$menu."&dbtable=".$dbtable."&pfad=".$pfad."&fldindexloc=".$dbindex."&fldindexremote=".$dbindexnch."&nuranzeigen=".$nuranzeigen."&urladr=".$urladr;
	    } else {
          $website=$urladr."classes/syncremote".$dbtypnch.".php?menu=".$menu."&dbtable=".$dbtable."&pfad=".$pfad."&fldindexloc=".$dbindex."&fldindexremote=".$dbindexnch."&nuranzeigen=".$nuranzeigen."&urladr=".$urladr."&dbsyncnr=".$dbsyncnrremote."&urltimestamp=".urlencode($timestamp);
	    }
        echo $website."<br>";
//        echo "</div>";

      $timestamp="2015-01-01 06:00:00";

  echo "<table>";
  echo "<tr><td>Pfad</td><td> : ".$pfad."</td></tr>";
  echo "<tr><td>Datenbank</td><td> : ".$dblocal."</td></tr>";
  echo "<tr><td>Table</td><td> : ".$dbtable."</td></tr>";
  echo "<tr><td>dbsyncnr</td><td> : ".$dbsyncnr."</td></tr>";
  echo "<tr><td>timestamp</td><td> : ".$timestamp."</td></tr>";
  echo "</table>";

 
        $dbopen=dbopentyp($dbtyp,$dblocal,$dbuser,$dbpassword);
//      $dblocal = new SQLite3($dblocal);
        $col = "";
        $lincnt = 1;
        $count = 0;
		if ($dbtyp=='MYSQL') {
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
		} else {
		  $query="SELECT name,sql FROM sqlite_master WHERE type='table' AND name='".$dbtable."'";
          $results = dbquerytyp($dbtyp,$dbopen,$query);
          $arrcol = array();
          if ($row = dbfetchtyp($dbtyp,$results)) {
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
		}

        $qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr." AND flddbsyncstatus='SYNC'";
	     echo $qryval."<br>";
//        $resval = $dblocal->query($qryval);
        $resval = dbquerytyp($dbtyp,$dbopen,$qryval);
        $datcnt=0;
        echo "</div>";
		

        echo "<form class='form-horizontal' method='post' action='".$website."sync.php'>";

		
        while ($linval = dbfetchtyp($dbtyp,$resval)) {
        	  
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
            $index=$linval[$fldindex];
			//echo $index."=index<br>";
            $updsql="UPDATE ".$dbtable." SET ".$updsql." WHERE ".$dbindex."=".$index;
            $inssql = "INSERT INTO ".$dbtable."(".$col.") VALUES (".$val.");";
            echo "<input type='hidden' name='index".$datcnt."' value='".$index."'/>";
            echo "<input type='hidden' name='updsql".$datcnt."' value='".$updsql."'/>";
            echo "<input type='hidden' name='inssql".$datcnt."' value='".$inssql."'/>";
	      }
	    	
	    }

		
        echo "<input type='hidden' name='datcnt' value='".$datcnt."'/>";
        echo "<input type='hidden' name='pfad' value='".$pfad."' />";
        echo "<input type='hidden' name='database' value='".$dblocal."' />";
        echo "<dd><input type='submit' value='Daten senden' /></dd>";
        echo "</form>";
	  
  	    echo "<br>";
        echo "<div class='alert alert-info'>";
	    echo $datcnt." Datensätze senden.";
	    echo "</div>";   
		
	  }
	}
  }
  
/*
//  include($website);
*/

} 

function synsenden() {
echo "synsenden<br>";
}

function syncempfangen($database,$nuranzeigen,$datcntremote,$dbtable,$fldindex,$timestamp) {
  $db = new SQLite3('../data/'.$database);
  $dbtyp="MYSQL";
  $dbase="dbjoorgportal";
  $dbuser="root";
  $dbpassword="mysql";
  $dbremote=dbopentyp($dbtyp,$dbase,$dbuser,$dbpassword);
  echo "<div class='alert alert-success'>";
  echo $datcntremote." Datensätze empfangen am ".$timestamp."<br>";

  for( $i=1; $i <= $datcntremote; $i++ ) {
    echo "<div class='alert alert-success'>";
    $index=$_POST['index'.$i];
    $qryval = "SELECT * FROM ".$dbtable." WHERE ".$fldindex."=".$index;
	 echo $qryval."<br>";
//    $results = $db->query($qryval);
    $results = dbquerytyp($dbtyp,$dbase,$qryval);
    if ($linval = dbfetchtyp($dbtyp,$results)) {
      $sql=$_POST['updsql'.$i];
    } else {
      $sql=$_POST['inssql'.$i];
    }	
    $sql=str_replace("#","'",$sql);
    echo $sql."<br>";
    echo "</div>";
    if ($nuranzeigen<>"anzeigen") {
      //$query = $db->exec($sql);
      dbexecutetyp($dbtyp,$dbremote,$sql); 
    }  
  }
  echo "</div>";
  syncfertig($database,$nuranzeigen,$dbtable,$timestamp);
  
}


function syncfertig($database,$nuranzeigen,$dbtable,$timestamp) {
  $db = new SQLite3('../data/'.$database);
  if ($nuranzeigen<>"anzeigen") {
    if ($timestamp=="") {
      $sql="INSERT INTO tblsyncstatus (fldtable,fldtimestamp) VALUES ('".$dbtable."',datetime('now', 'localtime'))";
    } else {
      $sql="UPDATE tblsyncstatus SET fldtimestamp=datetime('now', 'localtime') WHERE fldtable='".$dbtable."'";
    }  
    //echo $sql."=sql<br>";
    $query = $db->exec($sql);
  }

  if ($timestamp=="") {
    $datetime = new DateTime();
    $timestamp=$datetime->format('d.m.Y H:i:s');  
  }	
  echo "<div class='alert alert-success'>";
  if ($nuranzeigen<>"anzeigen") {
    echo "Daten gesendet.<br>";
    echo "Datenaustausch abgeschlossen am ".$timestamp;
  } else {
    echo "Datenaustausch angezeigt vom ".$timestamp;
  }  
  echo "</div>";
}

?>