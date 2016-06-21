<?php
include("bootstrapfunc.php");
include("stdlib/dbtool.php");
include("syncfunc.php");
include("../config.php");
$menu=$_GET['menu'];
$onlyshow=$_GET['onlyshow'];
if ($onlyshow=="") {
  $onlyshow="N";
}	
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin("Datenaustausch");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
$status=$_POST['status'];
//echo $status."=status<br>";
switch ( $status ) {
  case 'sync':
    $typ=$_POST['typ'];
    if ($typ=="local") { 	
      auslesen($menu,$database,$onlyshow);
    } else {
      fernabfrage($menu,$onlyshow);
    }
  break;
  case 'senden':
    $datcnt=$_POST['datcnt'];
    $dbtable=$_POST['dbtable'];
    $dbvontyp=$_POST['dbvontyp'];
    syncsenden($database,$datcnt,$dbvontyp,$dbtable);
  break;
  case 'einspielen':
    einspielen($menu,$onlyshow);
  break;
  case 'fertig':
    abschliessen($onlyshow,$database);
  break;
  default:
    showauswahl($menu,$database,$onlyshow);
}
bootstrapend();
?>