<?php
include('menu.php');
mysql_connect("195.72.157.253","krasnet","openfree");
$query="select * from optic_box_description";
$res=mysql("krasnet",$query);
$num=mysql_num_rows($res);
echo "<table>";
echo "<tr><td>Model</td><td>For_output</td></tr>";
for ($i=0;$i<$num;$i++) {
  $id=mysql_result($res,$i,"id");
  $model=mysql_result($res,$i,"model");
  $for_output=mysql_result($res,$i,"for_output");
  echo "<tr><td>$model</td><td>$for_output</td></tr>";
}
echo "</table>";
?>