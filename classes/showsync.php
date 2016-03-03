<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("showsyncfunc.php");
include("../config.php");
$menu=$_GET['menu'];
include("../sites/views/".$menu."/showtab.inc.php");
bootstraphead();
bootstrapbegin("Datenaustausch");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
$showsync = $_GET['showsync'];
if ($showsync==1) {
  $typ=$_POST['typ'];
  //echo $typ."=typ<br>"; 
  if ($typ=="local") { 	
    showsynclocal($menu,$database,$pfad);
  } else {
    showsyncremote($menu,$database,$pfad);
  }    
} else {
  showauswahl($menu,$database);
}
bootstrapend();
?>