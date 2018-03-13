#!/usr/local/bin/php -q
<?php
$user=$argv[1];
$sdate=$argv[2];
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
    echo " $users ($access) $address\n";
    return;
  }
} else {
  echo "\n";
}
}

include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

$pp=popen("/usr/local/sbin/fping -g $user","r");
while (!feof($pp)) {
  $str=fgets($pp,1024);
//  echo $str;
  if (strlen(strstr($str,"is alive")) > 6) {
//    echo $str;
    $ip=substr($str,0,strpos($str," "));
    echo "$ip ";
    address($ip,"");
  }
}


?>



