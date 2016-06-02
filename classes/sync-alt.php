<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("syncfunc.php");
include("../config.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
$status=$_POST['status'];
$sql=$_POST['sql'];
bootstraphead();
bootstrapbegin("Datenaustausch");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
$fldindex=$pararray['fldindex'];
//$pfad="localhost:8080/own/mysync/classes/";
switch ( $status ) {
  case 'local':
    $urladr=$_POST['urladr'];
    $nuranzeigen=$_POST['nuranzeigen'];
    synclocal($database,$menu,$urladr,$pfad,$nuranzeigen);
  break;
  case 'senden':
    syncsenden();
  break;
  case 'empfangen':
    $datcntremote=$_POST['datcntremote'];
    $nuranzeigen=$_POST['nuranzeigen'];
    $dbtable=$_POST['dbtable'];
	 $fldindex=$_POST['dbindex'];
    $timestamp=$_POST['timestamp'];
    syncempfangen($database,$nuranzeigen,$datcntremote,$dbtable,$fldindex,$timestamp);
  break;
  case 'fertig':
    $nuranzeigen=$_POST['nuranzeigen'];
    $dbtable=$_POST['dbtable'];
    $timestamp=$_POST['timestamp'];
    syncfertig($database,$nuranzeigen,$dbtable,$timestamp);
  break;
  default:
    syncauswahl($database,$menu);
}
bootstrapend();

?>