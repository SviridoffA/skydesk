#!/usr/local/bin/php -q
<?php
include('/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc');
$query="select id,sdate,edate,username,to_days(edate)-to_days(sdate)+1 as days from summary";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i < $num;$i++) {
  $days=mysql_result($res,$i,"days");
  if ($days > 31) {
    $username=mysql_result($res,$i,"username");
    $id=mysql_result($res,$i,"id");
    $sdate=mysql_result($res,$i,"sdate");
    $edate=mysql_result($res,$i,"edate");
    echo "$username,$id,$sdate,$edate\n";
  }
}
?>