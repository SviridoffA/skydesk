#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select * from customers order by username";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
$total=0;
for ($i=0;$i <$num ;$i++) {
  $username=mysql_result($res,$i,"username");
  $query="select distinct TunnelClientEndpoint from radacct where username like '$username' and TunnelClientEndpoint not like ''  and TunnelClientEndpoint not like '195.72.156.6' and TunnelClientEndpoint not like '195.72.156.210'";
  $rres=mysql("mvs",$query);
  $nnum=mysql_num_rows($rres);
  if ($nnum > 1) {
    $total++;
    echo $username."\n";
    for ($j=0;$j <$nnum;$j++) {
      $ip=mysql_result($rres,$j,"TunnelClientEndpoint");
      echo "    $ip\n";
    }
  } else {
    if ($nnum == 1 ) {
      $ip=mysql_result($rres,0,"TunnelClientEndpoint");
      $query="select * from customers where username like '$username' and ip like '$ip'";
      $qres=mysql("mvs",$query);
      $qnum=mysql_num_rows($qres);
      if ($qnum == 0) {
        $query="select * from customers where username like '$username'";
        $qres=mysql("mvs",$query);
        $ipc=mysql_result($qres,0,"ip");
        echo "$username ($ipc) $ip\n";
        $query="update customers set ip='$ip' where username like '$username'";
        echo $query."\n";
      } 
    }
  }
}
echo "total=$total\n";