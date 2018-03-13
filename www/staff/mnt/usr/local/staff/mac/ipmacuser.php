<?php
mysql_connect("195.72.157.242","root","htvjyn");

$query="select distinct mac from switchmac1 order by mac";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $user="";
  $mac=mysql_result($res,$i,"mac");
  $query="select * from ipmac where mac like '$mac' order by cdate desc";
  $rr=mysql("mvs",$query);
  $nn=mysql_num_rows($rr);
  if ($nn > 0) {
    $ip=mysql_result($rr,0,"ip");
    $query="select * from ipuser user where ip like '$ip' order by sdate";
    $rs=mysql("mvs",$query);
    $ns=mysql_num_rows($rs);
    $u++;
    if ($ns > 0) {
      $user=mysql_result($rs,0,"username");
    } else {
      $user="";
      $uu++;
    }
  } else {
    $ip="";
    $k++;
  }

  echo "$mac   $ip   $user\n";
}
echo "total mac $num unknown $k total $u unknown $uu \n";
?>