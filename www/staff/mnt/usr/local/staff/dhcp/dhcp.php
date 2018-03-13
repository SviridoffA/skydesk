<?php
/*
create table ippools(
id int not null auto_increment,
ip varchar(30),
status int,
mac varchar(30),
circuitid varchar(40),
agentid varchar(40),
leasedtime datetime,
leased datetime
);

*/
$mac="00:00:00:22:22:24";
$circuitid="00:04:00:df:01:07";
$agentid="11223344";
$remoteid="00:06:00:0a:b8:ed:e8:80";
$relayagentinfo="0x0106000400df010702080006000ab8ede880";
$relayagentinfo="0x010600040800010702080006000ab8ede880";
                 
function balans($relayagentinfo) {
  echo "$relayagentinfo\n";
  return(1);
}
function double($circuitid,$agentid) {
  return(0);
}
function alreadyleased($circuitid,$agentid,$mac) {
  return(0);
}
function setip($ip,$mac,$agentid,$circuitid,$leased) {

  $query="update ippools set leasedtime=ADDTIME(now(), '0 0:5:00'),leased=ADDTIME(now(), '0 0:5:00'),mac='$mac',agentid='$agentid',circuitid='$circuitid' where ip like '$ip'";  
  echo $query;
  $res=mysql("mvs",$query);
  echo mysql_error();
//  return();
  
}

function getfreeip($pool) {
  $query="select * from ippools where leasedtime <= now()";
  $res=mysql("mvs",$query);
  echo mysql_error();
  $num=mysql_num_rows($res);
  echo "num=$num\n";
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
  } else {
    $ip="172.16.0.26";
  }
  return($ip);
}
function getipmac($pool,$mac) {
  $query="select * from ippools where  mac like '$mac'";
  $res=mysql("mvs",$query);
  echo mysql_error();
  $num=mysql_num_rows($res);
  echo "num=$num\n";
  if ($num > 0) {
    $ip=mysql_result($res,0,"ip");
  } else {
    $ip="";
  }
  return($ip);
}
function getall($pool) {
   $mem['gateway']="172.16.0.1";
   $mem['mask']="255.255.255.0";
   return($mem);
}
mysql_connect("localhost","root","htvjyn");
echo "balans\n";
$balans=balans($relayagentinfo);
// $balans=1;
if ($balans > 0 ) {
  $pool="main";
  echo "main\n";
  $ip=getipmac($pool,$mac);
  if (empty($ip)) $ip=getfreeip($pool);
  echo "ip=$ip\n";
  setip($ip,$mac,$agentid,$circuitid,60);
} else {
  $pool="nomoney";
  $ip=getip($pool,$mac);
}
$mem=getall($pool);
echo $mem['gateway']."\n";
echo $mem['mask']."\n";
echo $ip."\n";
?>