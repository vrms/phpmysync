<?php
include("bootstrapfunc.php");
include("../config.php");
bootstraphead();
bootstrapbegin($headline."<br>");
$ini_array = parse_ini_file("../version.txt");
$versdat=$ini_array['versdat'];
$versnr=$ini_array['versnr'];
$ini_locarr = parse_ini_file("http://horald.github.io/joorgsqlite/versionphpmysync.txt");
$neueversdat=$ini_locarr['versdatphpmysync'];
$neueversnr=$ini_locarr['versnrphpmysync'];
echo "<a href='../index.php' class='btn btn-primary btn-sm active' role='button'>Menü</a> "; 
echo "<pre>";
echo "<table>";
echo "<tr><td>Stand</td>  <td>: ".$versdat."</td></tr>";
echo "<tr><td>aktuelle Version</td><td>: ".$versnr."</td></tr>";
echo "<tr><td>Stand</td>  <td>: ".$neueversdat."</td></tr>";
echo "<tr><td>neue Version</td><td>: ".$neueversnr."</td></tr>";
echo "<tr><td>Sourcecode unter</td><td>: <a href='https://github.com/horald/phpmysync' target='_blank'>github:phpmysync</a></td></tr>";
echo "<tr><td>.</td> <td></td></tr>";
echo "<tr><td>Autoinc-Start/dbsyncnr</td>  <td>: ".$autoinc_start."</td></tr>";
echo "<tr><td>Autoinc-Step</td>  <td>: ".$autoinc_step."</td></tr>";
echo "</table>";
echo "</pre>";
bootstrapend();
?>