#!/usr/local/bin/php -q
<?php
set_time_limit(0);
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
include_once('/usr/local/staff/ipa/read.inc');
$days=10;
$query="select year(subdate(now(), interval $days day)) as y,month(subdate(now(),interval $days  day)) as m,dayofmonth(subdate(now(), interval $days day)) as d from customers";
$res=mysql("mvs",$query);
echo mysql_error();
$sd=sprintf("%04d",mysql_result($res,0,"y")).".".sprintf("%02d",mysql_result($res,0,"m")).".".sprintf("%02d",mysql_result($res,0,"d"));
echo $sd;
// exit;
$query="select * from customers where username like 'anton'";
$res=mysql("mvs",$query);
echo mysql_error();
$num=mysql_num_rows($res);
// $sd="2002.12.01";
for ($i=0;$i < $num;$i++) {
  $username=mysql_result($res,$i,"username");
//   echo $username."\n";
  readdata($username,$username,$sd,date("Y.m.d"));
  readdata($username,$username."_chat",$sd,date("Y.m.d"));
  readdata($username,$username."_game",$sd,date("Y.m.d"));

}
$query="delete from data where service like '%_chat' and bytes=0";
mysql("mvs",$query);
$query="delete from data where service like '%_game' and bytes=0";
mysql("mvs",$query);
?>