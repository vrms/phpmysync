<?php
include("bootstrapfunc.php");
$action=$_POST['action'];
$onlyshow=$_POST['onlyshow'];
$callbackurl=$_POST['callbackurl'];
bootstraphead();
bootstrapbegin("Datenaustausch");
echo "syncremote<br><br>";

  echo "<div class='alert alert-info'>";
  echo "<table>";
  echo "<tr><td>callbackurl</td><td> : ".$callbackurl."</td></tr>";
  echo "<tr><td>action</td><td> : ".$action."</td></tr>";
  echo "<tr><td>onlyshow</td><td> : ".$onlyshow."</td></tr>";
  echo "</table>";
  echo "</div>";

  echo "<form class='form-horizontal' method='post' action='".$callbackurl."&onlyshow=".$onlyshow."'>";
  if ($action=="einspielen") {
    echo "<input type='hidden' name='status' value='fertig' />";
    echo "<input type='submit' value='Daten fertig' />";
  } else {
    echo "<input type='hidden' name='status' value='einspielen' />";
    echo "<input type='submit' value='Daten einspielen' />";
  }  
  echo "</form>";

bootstrapend();
?>