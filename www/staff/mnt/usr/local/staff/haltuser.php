#!/usr/local/bin/php -q
<?php
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select distinct userchange from usercontrol";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i < $num;$i++) {
  $username=mysql_result($res,$i,"userchange");
  $q="select datefrom,vardata from usercontrol where varchange like 'tarif' and userchange like '$username' order by datefrom";
  $res1=mysql("mvs",$q);
  $nn=mysql_num_rows($res1);
//  echo "$nn $q\n";
  $datefrom=mysql_result($res1,$nn-1,"datefrom");
  $tarif=mysql_result($res1,$nn-1,"vardata");
  if ($tarif == "100") {
    $qq="insert into halts(username,date) values('$username','$datefrom');\n";
    $res2=mysql("mvs",$qq);
    $total++;
  }
}
echo $total."\n";
?>