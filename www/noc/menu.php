<?php
echo "<table>";
$query="SET character_set_client = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_connection = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_results = cp1251";
$res=mysql("sky_switch",$query);

$query="select * from switch where status=1 order by ip";
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
   $ips=mysql_result($res,$i,"ip");
   $address=mysql_result($res,$i,"address");
   echo "<tr><td><a href=index.php?ip=$ips>$ips</a></td><td>$address</td></tr>";
}

echo "</table>";
?>