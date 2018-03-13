#!/usr/local/bin/php -q
<?php
$str="ifconfig -a | grep ppp | grep UP";
$pp=popen($str,"r");
while (!feof($pp)) {
  $ll=fgets($pp,1024);
 $count++;
}
if ($count > 0) $count--;
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select count(*) as us from users";
$res=mysql("mvs",$query);
$num=mysql_result($res,0,"us");
echo "$count\n$num\n";
?>