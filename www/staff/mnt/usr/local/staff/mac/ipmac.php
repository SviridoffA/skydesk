<?php
mysql_connect("195.72.157.242","root","htvjyn");

$query="select distinct mac from switchmac1 order by mac";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $mac=mysql_result($res,$i,"mac");
  $query="select * from ipmac where mac like '$mac' order by cdate desc";
  $rr=mysql("mvs",$query);
  $nn=mysql_num_rows($rr);
  if ($nn > 0) {
    $ip=mysql_result($rr,0,"ip");
  } else {
    $ip="";
    $k++;
  }

  echo "$mac   $ip\n";
}
echo "total $num unknown $k\n";
?>