<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ru" dir="LTR"><head>
<title>Noc</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   
</head>   
<?php
function array_sort(&$array) { 
   if(!$array) return $keys; 
   $keys=func_get_args(); 
   array_shift($keys); 
   array_sort_func($keys); 
   usort($array,"array_sort_func");        
} 

function array_sort_func($a,$b=NULL) { 
   static $keys; 
   if($b===NULL) return $keys=$a; 
   foreach($keys as $k) { 
      if(@$k[0]=='!') { 
         $k=substr($k,1); 
         if(@$a[$k]!==@$b[$k]) { 
            return strcmp(@$b[$k],@$a[$k]); 
         } 
      } 
      else if(@$a[$k]!==@$b[$k]) { 
         return strcmp(@$a[$k],@$b[$k]); 
      } 
   } 
   return 0; 
} 

function get_id($idnode) {
  $dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
  if (!$dbconn) {
    echo "An error occured.\n";
    exit;
  }
  $result = pg_query($dbconn, "SELECT comment,id FROM node where id like '$idnode'");
  if (!$result) {
    echo "An error occured.\n";
    exit;
  }
  $row = pg_fetch_row($result);
  $ip=$row[0];
  return($ip); 
}
function get_address($username) {
  $dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
  if (!$dbconn) {
    echo "An error occured.\n";
    exit;
  }
  $result = pg_query($dbconn, "SELECT domain,idnode FROM client where domain like '$username'");
  if (!$result) {
    echo "An error occured.\n";
    exit;
  }
  $row = pg_fetch_row($result);
  $ip=$row[1];
  $ip=get_id($ip);
  return($ip); 

}
function getusers($dbconn,$username) {
$query="SELECT client.id,city.name,node.comment,client.domain,client.idnode,node.id,node.idcity,city.id  FROM client,node,city  where client.domain='$username' and client.idnode=node.id and city.id=node.idcity";
// echo "$query\n";
$result = pg_query($dbconn,$query);
if (!$result) {
  echo "An error occured.\n";
  exit;
}
          
  while ($row = pg_fetch_row($result)) {
    $num++;
    $city=$row[0];
//    $node=$row[1];
    $ret=$city."  ".$node;
    return($ret);
  }
}


function mac($mac) {
  $query="select * from ipmac where mac like '$mac' order by cdate desc";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  $ip="";
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
  }
  return($ip);
}

function users($ip) {
  $query="select * from ipuser where ip like '$ip' order by edate desc";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  $username="";
  if ($num > 0) {
    $username=mysql_result($res,0,"username");
  }
  return($username);
}
function address($user,$sdate) {
$query="select username,count(*) as enter from sessions where mvsip like '$user' and dateStart > date_sub(now(),interval 1 month) group by username order by enter desc";
// echo $query;
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
if ($num) {
  for ($i=0;$i<$num;$i++) {
    $users=mysql_result($res,0,"username");
    $access=mysql_result($res,0,"enter");
    $query="select * from customers where username like '$users'";
    $resa=mysql("mvs",$query);
    $address=mysql_result($resa,0,"address");
    $s=" $users ($access) $address";
    return($s);
  }
} else {
  return;
}
}
// $cmd="/usr/local/bin/snmpwalk -v 1 -c public -O n 10.90.90.94 .1.3.6.1.2.1.17.7.1.2.3.1";
echo "<table border=1>";
// include_once('/home/sl/connect.inc');
mysql_connect("localhost","root","zabbix");
$query="select * from errors order by sdate desc limit 100";
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $port=mysql_result($res,$i,"port");
  $sdate=mysql_result($res,$i,"sdate");
  $inerror=mysql_result($res,$i,"inerror");
  $outerror=mysql_result($res,$i,"outerror");
  $deltain=mysql_result($res,$i,"deltain");
  $deltaout=mysql_result($res,$i,"deltaout");
  echo "<tr><td>$sdate</td><td><a href=switch.php?switch=$ip&sport=$port&esport=>$ip</a></td><td>$port</td><td>$inerror</td><td>$outerror</td><td>$deltain</td><td>$deltaout</td></tr>";
//  echo "<tr><td>$sdate</td><td>$ip</td><td>$port</td><td>$inerror</td><td>$outerror</td><td>$deltain</td><td>$deltaout</td></tr>";
}
echo "</table>";
exit;
$q="select * from switch where ip like '$switch'";
$rr=mysql("sky_switch",$q);
$stype=mysql_result($rr,0,"name");
$community=mysql_result($rr,0,"community");


// echo phpinfo();
  array_sort($lines,'address','ip');
//  echo "<pre>";
//  var_dump($lines);
//  echo "</pre>";
  $num=count($lines);
  for ($i=0;$i<$num;$i++) {
      $port=$lines[$i][0];
      $mac=$lines[$i]['mac'];
      $ip=$lines[$i]['ip'];
      $link=$lines[$i]['link'];
      $username=$lines[$i]['username'];
      $address=$lines[$i]['address'];
      $str=sprintf("<tr><td>%d</td><td><a href=mac.php3?mac=%s>%s</a></td><td>%15s</td><td><a href=https://stat.mvs.net.ua/BOSS/client/client_active.php3?Id=%s>%s</a></td><td>%s</td></tr>",$port,$mac,$mac,$ip,$link,$username,$address); 
      echo $str;

  }
  echo "</table>";
?>