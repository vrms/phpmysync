<?php
include("bootstrapfunc.php");
include("dbtool.php");
include("nosyncfunc.php");
$menu=$_GET['menu'];
$dbindex=$_GET['dbindex'];
bootstraphead();
bootstrapbegin("Datenaustausch");
echo "<a href='showtab.php?menu=".$menu."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
//echo $dbindex."=dbindex<br>";
nosyncfunc($dbindex);
bootstrapend();
?>