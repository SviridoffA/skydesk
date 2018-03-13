#!/usr/local/bin/php -q
<?php

function save_mac($mac,$switch,$port) {
  $query="select * from switchmac1 where mac like '$mac' and ipswitch like '$switch'  order by cdate desc";
//  echo "$query\n";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num ==0) {
    $query="insert into switchmac1(ipswitch,mac,port,cdate,fdate) VALUES('$switch','$mac','$port',now(),now())";
    $res=mysql("mvs",$query);
//    echo "$query\n";
    echo mysql_error();
  } else {
    $oldport=mysql_result($res,0,"port");
    $id=mysql_result($res,0,"id");
    if ($port != $oldport ) {
      $query="insert into switchmac1(ipswitch,mac,port,cdate,fdate) VALUES('$switch','$mac','$port',now(),now())";
      $res=mysql("mvs",$query);
//      echo "$query\n";
      echo mysql_error();
    } else {
      $query="update switchmac1 set cdate=now() where id like '$id' and mac like '$mac' and ipswitch like '$switch' and port like '$port'";
      $res=mysql("mvs",$query);
//      echo "$query\n";
      echo mysql_error();
      
    }
  }

  return;
}





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
/*
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
*/
  return($ip); 
}
function get_address($username) {
/*
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
*/
  return($ip); 

}
function getusers($dbconn,$username) {
/*
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
*/
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
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
// $cmd="/usr/local/bin/snmpwalk -v 1 -c public -O n 10.90.90.94 .1.3.6.1.2.1.17.7.1.2.3.1";
/*
$dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
if (!$dbconn) {
  echo "An error occured.\n";
      exit;
}
*/

// mysql_connect("195.72.157.242","root","htvjyn");



$q="select * from switch where status=1  and ip not like '195.72.157.254'";
$rr=mysql("mvs",$q);
$num=mysql_num_rows($rr);
for ($i=0;$i<$num;$i++) {


  $stype=mysql_result($rr,$i,"name");
  $switch=mysql_result($rr,$i,"ip");
  $community=mysql_result($rr,$i,"community");

switch ($stype) {
  case "DLINK3028":
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DLINK3526":
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;

  case "WGSD1022":
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "GSD1022":
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "Cisco3560":    
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.3.1.1.2";
    break;
  default:
    $cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.4.3.1.2";
    break;
}


// echo $cmd;
$pp=popen($cmd,"r");
$ll=0;
while (!feof($pp)) {
  $address="";
  $username="";
  $ip="";
  $str=trim(fgets($pp,1024));
//   echo $str."<br>";
  if (strlen($str) > 2 ) {
  
//  echo $str."\n";
  $str=ereg_replace(".1.3.6.1.2.1.17.7.1.2.3.1.","",$str);
//  echo $str."\n";

  switch ($stype) {
    case  "Cisco3560":
  

  preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = Hex-STRING: ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
//  var_dump($mem);
  $ips=$mem[3][0].".".$mem[4][0].".".$mem[5][0].".".$mem[6][0];
  $mac1=sprintf("%s",strtolower($mem[7][0]));
  if (strlen($mac1) == 1) { 
    $s1="0".$mac1;
    $mac1=$s1;
  }
  $mac2=sprintf("%+02s",strtolower($mem[8][0]));
  if (strlen($mac2) == 1) { 
    $s1="0".$mac2;
    $mac2=$s1;
  }
  $mac3=sprintf("%+02s",strtolower($mem[9][0]));
  if (strlen($mac3) == 1) { 
    $s1="0".$mac3;
    $mac3=$s1;
  }
  $mac4=sprintf("%+02s",strtolower($mem[10][0]));
  if (strlen($mac4) == 1) { 
    $s1="0".$mac4;
    $mac4=$s1;
  }
  $mac5=sprintf("%+02s",strtolower($mem[11][0]));
  if (strlen($mac5) == 1) { 
    $s1="0".$mac5;
    $mac5=$s1;
  }
  $mac6=sprintf("%+02s",strtolower($mem[12][0]));
  if (strlen($mac6) == 1) { 
    $s1="0".$mac6;
    $mac6=$s1;
  }


/*
    preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = Hex-STRING: ([\d ]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
  

  var_dump($mem);

  $mac1=sprintf("%s",$mem[1][0]);
  if (strlen($mac1) == 1) { 
    $s1="0".$mac1;
    $mac1=$s1;
  }
  $mac2=sprintf("%+02s",$mem[2][0]);
  if (strlen($mac2) == 1) { 
    $s1="0".$mac2;
    $mac2=$s1;
  }
  $mac3=sprintf("%+02s",$mem[3][0]);
  if (strlen($mac3) == 1) { 
    $s1="0".$mac3;
    $mac3=$s1;
  }
  $mac4=sprintf("%+02s",$mem[4][0]);
  if (strlen($mac4) == 1) { 
    $s1="0".$mac4;
    $mac4=$s1;
  }
  $mac5=sprintf("%+02s",$mem[5][0]);
  if (strlen($mac5) == 1) { 
    $s1="0".$mac5;
    $mac5=$s1;
  }
  $mac6=sprintf("%+02s",$mem[6][0]);
  if (strlen($mac6) == 1) { 
    $s1="0".$mac6;
    $mac6=$s1;
  }
*/
      break;


    default:
      preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = INTEGER: ([\d]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
  $mac1=sprintf("%s",dechex($mem[1][0]));
  if (strlen($mac1) == 1) { 
    $s1="0".$mac1;
    $mac1=$s1;
  }
  $mac2=sprintf("%+02s",dechex($mem[2][0]));
  if (strlen($mac2) == 1) { 
    $s1="0".$mac2;
    $mac2=$s1;
  }
  $mac3=sprintf("%+02s",dechex($mem[3][0]));
  if (strlen($mac3) == 1) { 
    $s1="0".$mac3;
    $mac3=$s1;
  }
  $mac4=sprintf("%+02s",dechex($mem[4][0]));
  if (strlen($mac4) == 1) { 
    $s1="0".$mac4;
    $mac4=$s1;
  }
  $mac5=sprintf("%+02s",dechex($mem[5][0]));
  if (strlen($mac5) == 1) { 
    $s1="0".$mac5;
    $mac5=$s1;
  }
  $mac6=sprintf("%+02s",dechex($mem[6][0]));
  if (strlen($mac6) == 1) { 
    $s1="0".$mac6;
    $mac6=$s1;
  }
      break;
  }


  $mac="$mac1:$mac2:$mac3:$mac4:$mac5:$mac6";

  $port=$mem[7][0];

  
  save_mac($mac,$switch,$port);
//  exit;

/*
  $query="insert into switchmac(ipswitch,mac,port,cdate,fdate) VALUES('$switch','$mac','$port',now(),now())";
  $res=mysql("mvs",$query);
  $err=mysql_error();
  
  if (!empty($err)) {
    $query="update switchmac set cdate=now() where mac like '$mac' and ipswitch like '$switch' and port like '$port'";
    $res=mysql("mvs",$query);
  }

*/

  }
  $ll++;
}

}
?>