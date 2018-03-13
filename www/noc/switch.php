<meta http-equiv="Content-Type" content="text/html; chars


et=utf8"> 

<?php
function info($ip,$community) {
  $data=snmpget($ip,$community,"1.3.6.1.2.1.1.1.0");
  echo "data=$data ip=$ip community=$community<br>";
  $data=ereg_replace("STRING: ","",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=trim($data);
  echo "data=$data";     
  return($data);
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

  $dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
  if (!$dbconn) {
    echo "An error occured.\n";
//    exit;
  }
  
  $result = pg_query($dbconn, "SELECT comment,id FROM node where id like '$idnode'");
  if (!$result) {
    echo "An error occured.\n";
//    exit;
  }
  $row = pg_fetch_row($result);
  $ip=$row[0];
  return($ip); 
}
function get_address($username) {
  $dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
  if (!$dbconn) {
    echo "An error occured.\n";
//    exit;
  }
  $result = pg_query($dbconn, "SELECT domain,idnode FROM client where domain like '$username'");
  if (!$result) {
    echo "An error occured.\n";
//    exit;
  }
  $row = pg_fetch_row($result);
  $ip=$row[1];
//  $ip=get_id($ip);
  return($ip); 

}
function getusers($dbconn,$username) {
$query="SELECT client.id,city.name,node.comment,client.domain,client.idnode,node.id,node.idcity,city.id  FROM client,node,city  where client.domain='$username' and client.idnode=node.id and city.id=node.idcity";
// echo "$query\n";
$result = pg_query($dbconn,$query);
if (!$result) {
  echo "An error occured.\n";
//  exit;
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
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
  $ip="";
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
  }
  return($ip);
}
function mac_users($mac) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  $query="select * from users_last where mac like '$mac'";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $mem['id']=mysql_result($res,0,"id");
    $mem['types']=mysql_result($res,0,"types");
    $mem['uid']=mysql_result($res,0,"uid");
    return($mem);
  } 
}

function users($ip) {
  $query="select * from ipuser1 where ip like '$ip' order by edate desc";
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
  $username="";
  if ($num > 0) {
    $username=mysql_result($res,0,"username");
  }
  return($username);
}
function address($user,$sdate) {
/*
$query="SET character_set_client = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_connection = cp1251";
$res=mysql("sky_switch",$query);
$query="SET character_set_results = cp1251";
$res=mysql("sky_switch",$query);
*/
mysql_set_charset("utf8");

$query="select username,count(*) as enter from sessions where mvsip like '$user' and dateStart > date_sub(now(),interval 1 month) group by username order by enter desc";
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
if ($num) {
  for ($i=0;$i<$num;$i++) {
    $users=mysql_result($res,0,"username");
    $access=mysql_result($res,0,"enter");
    $query="select * from customers where username like '$users'";
    $resa=mysql("sky_switch",$query);
    $address=mysql_result($resa,0,"address");
    $s=" $users ($access) $address";
    return($s);
  }
} else {
  return;
}
}

mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
//  echo phpinfo();

// $query="SET character_set_client = cp1251";
// $res=mysql("sky_switch",$query);
// $query="SET character_set_connection = cp1251";
// $res=mysql("sky_switch",$query);
// $query="SET character_set_results = cp1251";
// $res=mysql("sky_switch",$query);

// include_once('/home/sl/connect.inc');


$switch=$_GET["switch"];
$sport=$_GET["sport"];
$esport=$_GET["esport"];

  echo "<form>
Current switch $switch <br>
Switch
<select name=switch>";
// $query="SET character_set_client = cp1251";
// $res=mysql("switch",$query);
// $query="SET character_set_connection = cp1251";
// $res=mysql("switch",$query);
// $query="SET character_set_results = cp1251";
// $res=mysql("switch",$query);

$query="select * from switch where status=1 order by ip";
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $address=mysql_result($res,$i,"address");
//  $address=convert_cyr_string($address,"w","k");
  $sel="";
  if ($switch == $ip) $sel="SELECTED";
  echo "<option value=$ip $sel>$ip $address</option>";
}
echo "</select>
port <input type=text name=sport size=2 value=$sport> (a - all port)
exclude port <input type=text name=esport size=2 value=$esport>
<input type=submit>
</form>
";
// echo $query;
if ((empty($switch))||(empty($sport))) {
exit;
}
// echo "switch=$switch sport=$sport<br>";

// $switch=$argv[1];
// $sport=$argv[2];

$q="select * from switch where ip like '$switch'";
// echo $q;
$rr=mysql("sky_switch",$q);
$community=mysql_result($rr,0,"community");
echo "community=$community";
$stype=info($switch,$community);
echo "stype=$stype";
$stype=trim($stype);
$stype=ereg_replace("\"","",$stype);
// $stype="DES-1210-28/ME 6.02.019";
echo "stype=$stype";
switch ($stype) {





/*
Edge-Core FE L2 Switch ES3528M
ES-2108-G
GS-4012F
Layer2+ Fast Ethernet Standalone Switch ES3510
*/
  case "Linux LTP-4X 2.6.22.18 #1 Tue Dec 15 11:06:13 NOVT 2015 armv5tejl":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.4.1.35265.1.22.3.12.1.7";
    break;
  case "DES-1210-28/ME          6.02.019":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DES-1210-28/ME          6.07.B072":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-1210-12TS/ME 7.00.B082":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DES-1210-28/ME          6.07.B048":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-1100-06/ME          1.00.015":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DES-1210-28/ME          6.07.B069":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-1100-10/ME V1.00.010":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-3120-24SC Gigabit Ethernet Switch":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DES-1210-28/ME 6.02.019":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DES-1210-28/ME          6.07.B048":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-1100-10/ME V1.00.010": 
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-1100-06/ME          1.00.015": 
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "DGS-3120-24SC Gigabit Ethernet Switch":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
    
  case "DES-1210-28/ME          6.02.019": 
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "D-Link DES-3200-18 Fast Ethernet Switch":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "PLANET WGSD-1022C":
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
//    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.3";
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.3.1.2";
    break;
  case "PLANET WGSD-1022 - 8+2G Managed Switch":
// 1.3.6.1.2.1.17.7.1.2.2.1
//    $cmd="/usr/bin/snmpwalk -v 1 -c tenretni -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2.2";
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "GSD1022":
// 1.3.6.1.2.1.17.7.1.2.2.1
//    $cmd="/usr/bin/snmpwalk -v 1 -c tenretni -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2.2";
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
  case "Cisco3560":    
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.3.1.1.2";
    break;
  case "Cisco3750":    
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.3.1.1.2";
    break;
  case "PLANET WGSW-2840":    
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.3.1.2";
    break;

  default:
    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.4.3.1.2";
//    $cmd="/usr/bin/snmpwalk -v 1 -c $community -O n $switch .1.3.6.1.2.1.17.7.1.2.2.1.2";
    break;
}
 echo $cmd;
$pp=popen($cmd,"r");
  echo "<table>";
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

//  preg_match("/.1.3.6.1.2.1.17.7.1.2.2.1.2.([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = INTEGER: ([\d]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
// echo "<br>stype=$stype<br>";
  switch ($stype) {
    case "Linux LTP-4X 2.6.22.18 #1 Tue Dec 15 11:06:13 NOVT 2015 armv5tejl":
//      preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = Hex-STRING: ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
      preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) =\sHex-STRING:([\s]+)([\d\w\W]+)\s([\d\w\W]+)\s([\d\w\W]+)\s([\d\w\W]+)\s([\d\w\W]+)\s([\d\w\W]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);

     $mem2[1][0]=hexdec($mem[7][0]);
     $mem2[2][0]=hexdec($mem[8][0]);
     $mem2[3][0]=hexdec($mem[9][0]);
     $mem2[4][0]=hexdec($mem[10][0]);
     $mem2[5][0]=hexdec($mem[11][0]);
     $mem2[6][0]=hexdec($mem[12][0]);
     $mem2[7][0]=hexdec($mem[13][0]);


     $mem[1][0]=$mem2[1][0];
     $mem[2][0]=$mem2[2][0];
     $mem[3][0]=$mem2[3][0];
     $mem[4][0]=$mem2[4][0];
     $mem[5][0]=$mem2[5][0];
     $mem[6][0]=$mem2[6][0];
     $mem[7][0]=$mem2[7][0];
     echo "<pre>";
//     var_dump($mem);
     echo "</PRE>";
      break;
    case  "Cisco3560":
      preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = Hex-STRING: ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+) ([\d\w]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);

     $mem2[1][0]=hexdec($mem[7][0]);
     $mem2[2][0]=hexdec($mem[8][0]);
     $mem2[3][0]=hexdec($mem[9][0]);
     $mem2[4][0]=hexdec($mem[10][0]);
     $mem2[5][0]=hexdec($mem[11][0]);
     $mem2[6][0]=hexdec($mem[12][0]);
     $mem2[7][0]=$mem[1][0];


     $mem[1][0]=$mem2[1][0];
     $mem[2][0]=$mem2[2][0];
     $mem[3][0]=$mem2[3][0];
     $mem[4][0]=$mem2[4][0];
     $mem[5][0]=$mem2[5][0];
     $mem[6][0]=$mem2[6][0];
     $mem[7][0]=$mem2[7][0];
      break;
    default:
      preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = INTEGER: ([\d]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
      break;
  }
//  echo "<pre>";
// var_dump($mem);
//  echo "</pre>";


  $vlan=sprintf("%s",$mem[1][0]);
//  if (strlen($mac1) == 1) { 
//    $s1="0".$mac1;
//    $mac1=$s1;
//  }
  $mac1=sprintf("%s",dechex($mem[2][0]));
  if (strlen($mac1) == 1) { 
    $s1="0".$mac1;
    $mac1=$s1;
  }
  $mac2=sprintf("%+02s",dechex($mem[3][0]));
  if (strlen($mac2) == 1) { 
    $s1="0".$mac2;
    $mac2=$s1;
  }
  $mac3=sprintf("%+02s",dechex($mem[4][0]));
  if (strlen($mac3) == 1) { 
    $s1="0".$mac3;
    $mac3=$s1;
  }
  $mac4=sprintf("%+02s",dechex($mem[5][0]));
  if (strlen($mac4) == 1) { 
    $s1="0".$mac4;
    $mac4=$s1;
  }
  $mac5=sprintf("%+02s",dechex($mem[6][0]));
  if (strlen($mac5) == 1) { 
    $s1="0".$mac5;
    $mac5=$s1;
  }
  $mac6=sprintf("%+02s",dechex($mem[7][0]));
  if (strlen($mac6) == 1) { 
    $s1="0".$mac6;
    $mac6=$s1;
  }


  $mac="$mac1:$mac2:$mac3:$mac4:$mac5:$mac6";
//  echo "<br>mac=$mac<br>";
//  $mac=dechex($mem[2][0]).":".dechex($mem[3][0]).":".dechex($mem[4][0]).":".dechex($mem[5][0]).":".dechex($mem[6][0]).":".dechex($mem[7][0]);

  $port=$mem[8][0];
//   echo "$mac $port<br>";


  $query="insert into switchmac(ipswitch,mac,port,cdate,fdate) VALUES('$switch','$mac','$port',now(),now())";

//  $res=mysql("switch",$query);
//  $err=mysql_error();
  
//  echo $err;
  if (!empty($err)) {
    $query="update switchmac set cdate=now() where mac like '$mac' and ipswitch like '$switch' and port like '$port'";
//    $res=mysql("switch",$query);
//    echo "update";
  } else {
//    echo "not update";  
  }


/*
  $query="select * from ip where mac like '$mac'";
  $res=mysql("switch",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
    $addr=address($ip,"");
  } else {
    $ip="";
    $addr="";
  }
*/
//    echo "sport=$sport port=$port esport=$esport<br>";
    if ((($sport == $port) || ($sport == "a")) && ($esport != $port)){
//   echo "$mac $port<br>";
      $ip=mac($mac);
      if (!empty($ip)) {
        $username="";
        // users($ip);
        if (!empty($username)) {
          $address=get_address($username);
        }
      }
//      echo "$port ($mac): $ip $username $address\n";
//      $link=getusers($dbconn,$username);
 
      $lines[$ll][0]=$port;
      $lines[$ll]['mac']=$mac;
      $lines[$ll]['ip']=$ip;
      $lines[$ll]['link']=$link;
      $lines[$ll]['username']=$username;
      $lines[$ll]['address']=$address;
      $lines[$ll]['vlan']=$vlan;
    }
  }
  $ll++;
}
// echo "<pre>";
// var_dump($lines);
// echo "</pre>";
// echo phpinfo();
  array_sort($lines,'address','ip');
//  echo "<pre>";
//  var_dump($lines);
//  echo "</pre>";
  $num=count($lines);
  for ($i=0;$i<$num;$i++) {
      $port=$lines[$i][0];
      $mac=$lines[$i]['mac'];
      $vlan=$lines[$i]['vlan'];
      $ip=$lines[$i]['ip'];
      $link=$lines[$i]['link'];
      $username=$lines[$i]['username'];
      $uu=mac_users($mac);
      $username=$uu['id'];
      $types=$uu['types'];
      $uid=$uu['uid'];
      $address=$lines[$i]['address'];
//      $str=sprintf("<tr><td>%d</td><td><a href=mac.php3?mac=%s>%s</a></td><td>%15s</td><td></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=%s">%s</a></td><td>%s</td></tr>",$port,$mac,$mac,$ip,$uid,$username,$types); 
      $str=sprintf("<tr><td>%d</td><td>%d</td><td><a href=mac.php3?mac=%s>%s</a></td><td>%15s</td><td></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=%s target=\"_blank\">%s</a></td><td>%s</td></tr>",$port,$vlan,$mac,$mac,$ip,$uid,$username,$types); 
      echo $str;

  }
  echo "</table>";
?>
