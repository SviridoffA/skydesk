#!/usr/local/bin/php -q
<?php
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

$switch="10.90.89.92";
$community="tenretni";
$cmd="/usr/local/bin/snmpwalk -v 1 -c $community -O n $switch 1.3.6.1.2.1.17.4.3.1.2";
$pp=popen($cmd,"r");
while (!feof($pp)) {
  $str=trim(fgets($pp,1024));
  if (strlen($str) > 2 ) {
  
//  echo $str."\n";
  $str=ereg_replace(".1.3.6.1.2.1.17.7.1.2.3.1.","",$str);
//  echo $str."\n";

//  preg_match("/.1.3.6.1.2.1.17.7.1.2.2.1.2.([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = INTEGER: ([\d]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
  preg_match("/([\d]+).([\d]+).([\d]+).([\d]+).([\d]+).([\d]+) = INTEGER: ([\d]+)/",$str,$mem,PREG_OFFSET_CAPTURE,0);
//  var_dump($mem);
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

  $mac="$mac1:$mac2:$mac3:$mac4:$mac5:$mac6";
//  $mac=dechex($mem[2][0]).":".dechex($mem[3][0]).":".dechex($mem[4][0]).":".dechex($mem[5][0]).":".dechex($mem[6][0]).":".dechex($mem[7][0]);
//   echo $mac;

  $port=$mem[7][0];


  $query="insert into switchmac(ipswitch,mac,port,cdate,fdate) VALUES('$switch','$mac','$port',now(),now())";
  $res=mysql("mvs",$query);
  $err=mysql_error();
//  echo $err;
  if (!empty($err)) {
    $query="update switchmac set cdate=now() where mac like '$mac' and ipswitch like '$switch' and port like '$port'";
    $res=mysql("mvs",$query);
//    echo "update";
  } else {
//    echo "not update";  
  }


/*
  $query="select * from ip where mac like '$mac'";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
    $addr=address($ip,"");
  } else {
    $ip="";
    $addr="";
  }
*/
//  echo "$port ($ip): $mac $addr\n";
  }
}

?>