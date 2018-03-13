#!/usr/local/bin/php -q
<?php

$cmd="/sbin/ifconfig | /usr/bin/grep ppp | /usr/bin/grep UP | /usr/bin/cut -d \":\" -f1";
$pp=popen($cmd,"r");
$count=0;
while (!feof($pp)) {
   $str=trim(fgets($pp,1024));
//   echo $str;
   if ($str) {
     if ($count) {
       $query=$query." and interface not like '$str'";
       $query1=$query1." and interface not like '$str'";
     } else {
       $query="select * from users where interface not like '$str'";
       $query1="delete from  users where interface not like '$str'";
     }
   }
   $count++;
}
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$res=mysql("mvs",$query);
$res1=mysql("mvs",$query1);
$num=mysql_num_rows($res);
if ($num) {
  for ($i=0;$i < $num;$i++) {
     $int=mysql_result($res,$i,"interface");
     echo "$int\n";
  }
}
// echo $query1;
$cmd="/sbin/ifconfig | /usr/bin/grep ppp | /usr/bin/grep -v UP | /usr/bin/cut -c 1-6";
$pp=popen($cmd,"r");
$count=0;
while (!feof($pp)) {
  $str=trim(fgets($pp,1024));
  $str=ereg_replace(":","",$str);
  echo "$str\n";
  if ($str) {
    $cmd1="/sbin/ipfw show |/usr/bin/grep $str|/usr/bin/cut -c 1-6";
    $pp1=popen($cmd1,"r");
    while (!feof($pp1)) {
      $str1=trim(fgets($pp1,1024));
      if ($str1) {
        $cmd2="/sbin/ipfw delete $str1";
        $pp2=popen($cmd2,"r");
        while (!feof($pp2)) {
          $str2=fgets($pp2,1024);
        }
        pclose($pp2);
      }
    }
    pclose($pp1);
  }
}
?>