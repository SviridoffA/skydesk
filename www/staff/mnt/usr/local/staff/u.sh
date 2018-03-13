#!/usr/local/bin/php -q
<?php
function run($cmd) {
  $pp=popen($cmd,"r");
  $str = fread($pp, 100000);
  pclose($pp);
  return($str);
}

function mvsip($int) {
  $str="cat /var/run/$int.pid";
  $pid=run($str)-1;
  $str="ps -xaw|grep pp|grep $pid";
  $s=run($str);
  preg_match("/([\d]+.[\d]+.[\d]+.[\d]+)/",$s,$matches);
  $ip=$matches[0];
  run("kill $pid");
  return($ip);
}

$str="/sbin/ifconfig -a | grep ppp | grep UP";
$pp=popen($str,"r");
$count=0;
while (!feof($pp)) {
  $ll=trim(fgets($pp,1024));
  $mem=explode(":",$ll);
  $inc=0;
  if ($ll) {
    $str="/sbin/ipfw show|/usr/bin/grep ".$mem[0];
    $pps=popen($str,"r");
    while (!feof($pps)) {
      $s=fgets($pps,1024);
      $inc++;
    }
    if ($inc < 3) {
      $ip=mvsip($mem[0]);
      $dates=date("Y-m-d H:m:s");
      $ll="checkuser $dates $ip\n";
      $fp=fopen("/var/log/authup","a");
      fputs($fp,$ll);
      fclose($fp); 
      echo $mem[0]." No\n";
    } else {
      echo $mem[0]." Ok\n";
    }
  }
    $count++;
}
if ($count > 0) $count--;
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select count(*) as us from users";
$res=mysql("mvs",$query);
$num=mysql_result($res,0,"us");
echo "$count\n$num\n";
?>