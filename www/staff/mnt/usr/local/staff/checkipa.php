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

  $query="insert into rules(rules) values($rulestat)";
  mysql("mvs",$query);
  echo mysql_error();
  $query="insert into rules(rules) values($rulestop)";
  mysql("mvs",$query);


  $query="insert into rules(rules) values($rulein)";
  mysql("mvs",$query);

  $query="insert into rules(rules) values($ruleout)";
  mysql("mvs",$query);

  $query="insert into rules(rules) values($rulechatin)";
  mysql("mvs",$query);

  $query="insert into rules(rules) values($rulechatout)";
  mysql("mvs",$query);

  $query="insert into rules(rules) values($rulegameout)";
  mysql("mvs",$query);

  $query="insert into rules(rules) values($rulegamein)";
  mysql("mvs",$query);
}
// var_dump($mem);
// var_dump($stat);
?>