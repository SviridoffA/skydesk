<meta http-equiv="Content-Type" content="text/html; charset=utf8">

<?php
function compareport($port,$esport) {
  $mem=explode(",",$esport);
  $num=count($mem);
//  echo "num=$num";
  if ($num==1) {
    if ($port == $esport ) { 
      return(0); 
    } else {
      return(1);
    }
  } else {
//    echo "above 2<br>";
    for ($i=0;$i<$num;$i++) {
    if ($port == $mem[$i] ) { 
      return(0); 
    } 
    
    }
  }
  return(1);
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
  return($ip); 
*/  
}
function get_address($username) {
/*
  $dbconn = pg_pconnect("host=localhost port=5432 dbname=boss");
  if (!$dbconn) {
    echo "An error occured.\n";
    exit;
  }
  $result = pg_query($dbconn, "SELECT client.domain,client.idnode,client.id,ppp.login,ppp.id FROM client,ppp where ppp.login like '$username' and ppp.id=client.id");
  if (!$result) {
    echo "An error occured.\n";
    exit;
  }
  $row = pg_fetch_row($result);
  $ip=$row[1];
  $ip=get_id($ip);
  return($ip); 
*/
}
function getusers($dbconn,$username) {
$query="SELECT client.id,city.name,node.comment,client.domain,client.idnode,node.id,node.idcity,city.id,ppp.id,ppp.login  FROM client,node,city  where ppp.login ='$username' and ppp.id=client.id and client.idnode=node.id and city.id=node.idcity";
// echo "$query\n";
/*
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

function mac_users($mac) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  $query="select * from users_last where mac like '$mac'";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $mem['id']=mysql_result($res,0,"id");
    $mem['types']=mysql_result($res,0,"types");
    $mem['uid']=mysql_result($res,0,"uid");
//    var_dump($mem);
    return($mem);
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
$query="select username,count(*) as enter from sessions where mvsip like '$user' and dateStart > date_sub(now(),interval 1 month) group by username order by enter desc";
// echo $query;
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
// include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
// $cmd="/usr/local/bin/snmpwalk -v 1 -c public -O n 10.90.90.94 .1.3.6.1.2.1.17.7.1.2.3.1";
// include_once('connect.inc');
mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");

$switch=$_GET["switch"];
$sport=$_GET["sport"];
$esport=$_GET["esport"];
$sdate=$_GET["sdate"];

// $switch="192.168.10.150";
// $sport="a";
// $esport="";
// $sdate="2015-06-01";


  echo "<form>
Current switch $switch <br>
Switch
<select name=switch>";
mysql_set_charset("utf8");
$query="select * from switch  where status=1 order by address";
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
after date <input type=text name=sdate size=14 value=$sdate>
<input type=submit>
</form>
";
if ((empty($switch))||(empty($sport))) {
//!!!! exit;
}
// mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
// $sport=$argv[2];
echo "switch=$switch sport=$sport<br>";


$q="select * from switchmac where ipswitch like '$switch' and cdate >= '$sdate'";
$rr=mysql("sky_switch",$q);
$num=mysql_num_rows($rr);
// echo "num=$num $q";

  echo "<table>";
$ll=0;
for ($i=0;$i<$num;$i++) {
  $address="";
  $username="";
  $ip="";
  $mac=mysql_result($rr,$i,"mac");
  $port=mysql_result($rr,$i,"port");
  $cdate=mysql_result($rr,$i,"cdate");
  $fdate=mysql_result($rr,$i,"fdate");
//  if ((($sport == $port) || ($sport == "a")) && ($esport != $port)) {
    if ((($sport == $port) || ($sport == "a")) && ($esport != $port) && compareport($port,$esport)){
    $ip=mac($mac);
    if (!empty($ip)) {
      $username=users($ip);
      if (!empty($username)) {
//        $address=get_address($username);
      }
    }
    $link=getusers($dbconn,$username);
 
    $lines[$ll][0]=$port;
    $lines[$ll]['mac']=$mac;
    $lines[$ll]['ip']=$ip;
    $lines[$ll]['link']=$link;
      $uu=mac_users($mac);
      $username=$uu['id'];
      $types=$uu['types'];
      $uid=$uu['uid'];
    
    $lines[$ll]['username']=$username;
    $lines[$ll]['types']=$types;
    $lines[$ll]['uid']=$uid;
    
    $lines[$ll]['address']=$address;
    $lines[$ll]['cdate']=$cdate;
    $lines[$ll]['fdate']=$fdate;
//  }
  }
  $ll++;
}
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
      $types=$lines[$i]['types'];
      $uid=$lines[$i]['uid'];
      $address=$lines[$i]['address'];
      $fdate=$lines[$i]['fdate'];
      $cdate=$lines[$i]['cdate'];
      $str=sprintf("<tr><td>%d</td><td>
      <a href=mac.php3?mac=%s target=_blank>%s</a>
      </td><td>%15s</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=%s target=_blank>
      %s</a></td><td>%s</td><td>&nbsp;&nbsp;%s
      </td><td>&nbsp;&nbsp;&nbsp;&nbsp;%s</td></tr>",$port,$mac,$mac,$ip,
      $uid,$username,$address,$fdate,$cdate); 
      echo $str;

  }
  echo "</table>";
?>