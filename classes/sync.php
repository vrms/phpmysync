<?php
include("bootstrapfunc.php");
include("dbtool.php");
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
switch ( $status ) {
  case 'sync':
    $typ=$_POST['typ'];
    if ($typ=="local") { 	
      auslesen($menu,$onlyshow);
    } else {
    	fernabfrage($menu,$onlyshow);
    }
    //if ($typ=="local") { 	
    //  showsynclocal($menu,$database,$pfad,$onlyshow);
    //} else {
    //  showsyncremote($menu,$database,$pfad);
    //}    
  break;
  case 'senden':
    $datcnt=$_POST['datcnt'];
    $dbtable=$_POST['dbtable'];
    $dbvontyp=$_POST['dbvontyp'];
    syncsenden($database,$datcnt,$dbvontyp,$dbtable);
  break;
  case 'einspielen':
    einspielen($onlyshow);
  break;
  case 'fertig':
    abschliessen($onlyshow);
  break;
  default:
    showauswahl($menu,$database,$onlyshow);
}
bootstrapend();
?>