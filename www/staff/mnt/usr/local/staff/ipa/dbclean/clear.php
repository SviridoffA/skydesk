#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select distinct username from data";
$res=mysql("mvs",$query);
echo "$query\n";
echo mysql_error()."\n";
$num=mysql_num_rows($res);
for ($i=0;$i < $num;$i++) {
  $username=mysql_result($res,$i,"username");
  $q="select date_sub(max(startDate),interval 3 day) as dd from data where service like '$username'";
  echo "$q\n";
  $resd=mysql("mvs",$q);
  echo mysql_error()."\n";
  $nn=mysql_num_rows($resd);
  if ($nn > 0) {
    $dd=mysql_result($resd,0,"dd");
    $q="delete from data where bytes=0 and service like '$username' and startDate < '$dd'";
    echo "$q\n";
    $resdd=mysql("mvs",$q);
    echo mysql_error()."\n";
  }
} 
?>