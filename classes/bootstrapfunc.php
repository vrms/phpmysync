<?php

function bootstraphead($loadbootstrap) {
include("../config.php");
echo "<!DOCTYPE html>";
echo "<html lang='de'>";
echo "<head>";
echo "<meta charset='utf-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>";
echo "<link href='../includes/bootstrap/css/bootstrap.css' rel='stylesheet'>";
echo "<link href='../includes/bootstrap/datetime/css/bootstrap-datetimepicker.min.css' rel='stylesheet' media='screen'>";
echo "<script src='../includes/bootstrap/js/jquery-latest.js'></script>";
      //echo "  <script type='text/javascript'>";
      //echo "      $(function () {";
      //echo "          $('#dtpicker1').datetimepicker();";
      //echo "      });";
      //echo "  </script>";

//fullcalendar
echo "<link href='../includes/fullcalendar/fullcalendar/fullcalendar.css' rel='stylesheet' />";
echo "<link href='../includes/fullcalendar/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />";
echo "<script src='../includes/fullcalendar/lib/jquery.min.js'></script>";
echo "<script src='../includes/fullcalendar/lib/jquery-ui.custom.min.js'></script>";
echo "<script src='../includes/fullcalendar/fullcalendar/fullcalendar.min.js'></script>";
echo "<script src='../includes/fullcalendar/js/jsoncalendar.js'></script>";

//auswahl
echo "<script src='auswahl.js'></script>";

echo "<title>".$headline."</title>";
echo "</head>";
}

function bootstrapbegin($headline,$showheadline) {
  echo "<body>";
  echo "<div class='row-fluid'>";
  echo "<div class='span12'>";
  //echo "<h1 align='center'>".$headline."</h1>";
  if ($headline<>"") {
    echo "<legend>".$headline."</legend>";
  }
}

function bootstrapend() {
?>        
<script type="text/javascript" src="../includes/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="../includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../includes/bootstrap/datetime/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../includes/bootstrap/datetime/js/locales/bootstrap-datetimepicker.de.js" charset="UTF-8"></script>
<script type="text/javascript" src="../includes/bootstrap/datetime/js/special/mydatetime.de.js"></script>
<?php        

  echo "</div>";
  echo "</div>";
  echo "</body>";
  echo "</html>";
}

?>