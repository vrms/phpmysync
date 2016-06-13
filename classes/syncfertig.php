<?php
include("bootstrapfunc.php");
include("dbtool.php");
$callbackurl=$_POST['callbackurl'];

bootstraphead();
bootstrapbegin("Datenaustausch");
$callbackurl=str_replace("sync.php","showtab.php",$callbackurl);
echo "<a href='".$callbackurl."'  class='btn btn-primary btn-sm active' role='button'>Zurück</a> ";
echo "<div class='alert alert-info'>";
echo "Datensynchronisation abgeschlossen.";
echo "</div>";
bootstrapend();
?>