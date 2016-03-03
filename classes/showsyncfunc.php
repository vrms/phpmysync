<?php

function showauswahl($menu,$database) {
//  $db = new SQLite3('../data/'.$database);
//  $qry = "SELECT * FROM tbltable";
//  $results = $db->query($qry);

  echo "<form class='form-horizontal' method='post' action='showsync.php?showsync=1&menu=".$menu."'>";
  echo "<select name='typ' size='1'>";
  echo "<option style='background-color:#c0c0c0;' >local</option>";
  echo "<option style='background-color:#c0c0c0;' selected>remote</option>";
  echo "</select>";
  echo "<dd><input type='submit' value='Anzeige starten' /></dd>";
  echo "</form>";
	
}

function showsynclocal($menu,$database,$pfad) {
  $db = new SQLite3('../data/'.$database);
  $qry = "SELECT * FROM tbltable";
  $results = $db->query($qry);

  $dbtable="tblfahrtenbuch";
  $dbsyncnr=1;
  $website="allnosync.php?menu=".$menu;	
  echo "<form class='form-horizontal' method='post' action='".$website."'>";
  echo "<input type='submit' value='All NoSync' />";
  echo "<input type='hidden' name='pfad' value='".$pfad."' />";
  echo "<input type='hidden' name='dbtable' value='".$dbtable."' />";
  echo "<input type='hidden' name='database' value='".$database."' />";
  echo "<input type='hidden' name='dbsyncnr' value='".$dbsyncnr."' />";
  echo "</form>";	

  echo "<br>";
  while ($line = $results->fetchArray()) {
    $aktiv=$line['fldaktiv'];
    if ($aktiv=='J') {
      //$dbidlocal=$line['fldid_vondatabase'];
      //$qrydblocal = "SELECT * FROM tbldatabase WHERE fldindex=".$dbidlocal;
      //$resdblocal = $db->query($qrydblocal);
      //if ($lindblocal = $resdblocal->fetchArray()) {

      //}
      $dbtable=$line['fldvontblname'];
      //echo $dbtable."<br>";

      $dbtyp="MYSQL";
      $dblocal="dbjoorgportal";
      $dbuser="root";
      $dbpassword="mysql";
      $timestamp="2015-01-01 06:00:00";

  echo "<table>";
  echo "<tr><td>Pfad</td><td> : ".$pfad."</td></tr>";
  echo "<tr><td>Datenbank</td><td> : ".$dblocal."</td></tr>";
  echo "<tr><td>Table</td><td> : ".$dbtable."</td></tr>";
  echo "<tr><td>dbsyncnr</td><td> : ".$dbsyncnr."</td></tr>";
  echo "<tr><td>timestamp</td><td> : ".$timestamp."</td></tr>";
  echo "</table>";

      $dblocal=dbopentyp($dbtyp,$dblocal,$dbuser,$dbpassword);
      $col="*";
      $dbsyncnr="1";
      $qryval = "SELECT ".$col." FROM ".$dbtable." WHERE fldtimestamp>'".$timestamp."' AND flddbsyncnr=".$dbsyncnr;
	   //echo $qryval."<br>";
      $resval = dbquerytyp($dbtyp,$dblocal,$qryval);
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
      }
      echo "</table>";
    }
  }  

}

function showsyncremote($menu,$database,$pfad) {
  echo "<br><br>";	
  $remotedatabase="/var/www/html/android/own/joorgsqlite/data/joorgsqlite.db";
  $dbtable="tblfahrtenbuch";
  $fldindex="fldindex";
  $website="http://localhost/own/phpmysyncremote/classes/syncremoteSQLITE3.php?menu=".$menu."&dbtable=".$dbtable."&showsync=J";	
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

?>