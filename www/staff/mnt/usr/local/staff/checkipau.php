#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select * from customers";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $rulestat=mysql_result($res,$i,"rulestat");
  $rulestop=mysql_result($res,$i,"rulestop");
  $rulein=mysql_result($res,$i,"rulein");
  $ruleout=mysql_result($res,$i,"ruleout");
  $pipein=mysql_result($res,$i,"pipein");
  $pipeout=mysql_result($res,$i,"pipeout");
  $rulegamein=mysql_result($res,$i,"rulegamein");
  $rulegameout=mysql_result($res,$i,"rulegameout");
  $rulechatin=mysql_result($res,$i,"rulechatin");
  $rulechatout=mysql_result($res,$i,"rulechatout");
  $username=mysql_result($res,$i,"username");
  $mem[$rulestat]++;
  $mem[$rulestop]++;
  $mem[$rulein]++;
  $mem[$ruleout]++;
  $mem[$rulegamein]++;
  $mem[$rulegameout]++;
  $mem[$rulechatin]++;
  $mem[$rulechatout]++;
  $stat[$rulestat][$username]="rulestat";
  $stat[$rulestop][$username]="rulestop";
  $stat[$rulein][$username]="rulein";
  $stat[$ruleout][$username]="ruleout";
  $stat[$rulechatin][$username]="rulechatin";
  $stat[$rulechatout][$username]="rulechatout";
  $stat[$rulegameout][$username]="rulegameout";
  $stat[$rulegamein][$username]="rulegamein";

  $query="insert into rulesu(rules,username,name) values($rulestat,'$username','stat')";
  mysql("mvs",$query);
  echo mysql_error();
  $query="insert into rulesu(rules,username,name) values($rulestop,'$username','stat')";
  mysql("mvs",$query);


  $query="insert into rulesu(rules,username,name) values($rulein,'$username','in')";
  mysql("mvs",$query);

  $query="insert into rulesu(rules,username,name) values($ruleout,'$username','out')";
  mysql("mvs",$query);

  $query="insert into pipeu(pipe,username,name) values($pipein,'$username','in')";
  mysql("mvs",$query);

  $query="insert into pipeu(pipe,username,name) values($pipeout,'$username','out')";
  mysql("mvs",$query);

  $query="insert into rulesu(rules,username,name) values($rulechatin,'$username','chatin')";
  mysql("mvs",$query);

  $query="insert into rulesu(rules,username,name) values($rulechatout,'$username','chatout')";
  mysql("mvs",$query);

  $query="insert into rulesu(rules,username,name) values($rulegameout,'$username','gameout')";
  mysql("mvs",$query);

  $query="insert into rulesu(rules,username,name) values($rulegamein,'$username','gamein')";
  mysql("mvs",$query);
}
// var_dump($mem);
// var_dump($stat);
?>