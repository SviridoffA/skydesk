<?php
$db=mysql_connect("localhost","root","htvjyn");
mysql_select_db("mvs", $db); 

$query="select * from switchmac1 where mac '00:00:f0:7f:4c:d1'";

$res=mysql_query($query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ipswitch=mysql_result($res,$i,"ipswitch");
  $port=mysql_result($res,$i,"port");
  echo "$ipswitch $port\n";
}
?>