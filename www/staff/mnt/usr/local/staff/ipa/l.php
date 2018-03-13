#!/usr/local/bin/php421 -q
<?php
set_time_limit(0);
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
include_once('/usr/local/staff/ipa/read.inc');
$query="select year(subdate(now(), interval 10 day)) as y,month(subdate(now(), interval
10 day)) as m,dayofmonth(subdate(now(), interval 10 day)) as d from customers";
$res=mysql("mvs",$query);
$sd=sprintf("%04d",mysql_result($res,0,"y")).".".sprintf("%02d",mysql_result($res,0,"m")).".".sprintf("%02d",mysql_result($res,0,"d"));
// echo $sd;
// exit;
$query="select * from customers";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
 $sd="2002.12.01";
for ($i=0;$i < $num;$i++) {
  $username=mysql_result($res,$i,"username");
//   echo $username."\n";
  readdata($username,$username,$sd,date("Y.m.d"));
  readdata($username,$username."_chat",$sd,date("Y.m.d"));
  readdata($username,$username."_game",$sd,date("Y.m.d"));

}

?>