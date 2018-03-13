#!/usr/local/bin/php -q
<?php
function getlast($ip,$community) {
  $cmd="snmpwalk -v 1 -c $community $ip 1.3.6.1.2.1.17.2.3";
//  echo $cmd."\n";
  $pp=popen($cmd,"r");
  while (!feof($pp)) {
    $str=trim(fgets($pp,1024));
    if (strlen($str) > 10 ) {
      $ret=$str;
    }
  }
  return($ret);
}

include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

$query="select * from switch order by ip";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i < $num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $community=mysql_result($res,$i,"community");
  $name=mysql_result($res,$i,"name");
  $t=getlast($ip,$community);
  echo "$ip $name $t\n";
}

?>