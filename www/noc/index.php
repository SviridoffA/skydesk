<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ru" dir="LTR"><head>
<title>Noc</title>
   <meta http-equiv="Content-Type" content="text/html; charset=cp1251">
   
   </head>
   
<body>
<table>
<tr>
<td valign=top>
<?php
// include('/home/sl/connect.inc');
mysql_connect("localhost","root","zabbix");
include('menu.php');

?>
</td><td>
<?php
$ip=$_GET["ip"];
if (!empty($ip)) echo "ip=$ip<br>";
if (!empty($ip)) {
$query="SET character_set_client = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_connection = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_results = cp1251";
$res=mysql("sky_switch",$query);

  $query="select * from switch where ip like '$ip'";
  $res=mysql("sky_switch",$query);
  $community=mysql_result($res,0,"community");
  $port=snmpwalk($ip,$community,"1.3.6.1.2.1.2.2.1.1");
    $num=count($port);
    for ($i=0;$i<$num;$i++) {
      $index=$port[$i];
      $index=ereg_replace("INTEGER: ","",$index);
      $desc=snmpget($ip,$community,"1.3.6.1.2.1.31.1.1.1.18.$index");
      $desc=ereg_replace("STRING: ","",$desc);
      $desc=ereg_replace("\"","",$desc);
      $p=$ip."_".$index;
      echo "$p $desc<br>";
      $file="/mrtg/".$p."-day.png";
      $tst="/var/www".$file;
      if (file_exists($tst)) {
        echo "<a href=../mrtg/$p.html><img src=$file></a><br>";
      }
    }
} else {
// echo "root";
}

?>

</td>
</tr>
</table>
</body>
</html>