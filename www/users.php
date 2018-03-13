<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ru" dir="LTR"><head>
<title>Noc</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf8">
   
      </head>
      
      <body>
      
<?php
function users_info($uid) {
  $query="select users.*,users_pi.*,bills.* from users,users_pi,bills where bills.uid=users.uid and users_pi.uid=$uid and users.uid=users_pi.uid";
//  echo "$query\n";
  $rres=mysql("abills",$query);
  mysql_set_charset("utf8");
  $address['street']=mysql_result($rres,0,"users_pi.address_street");
  $address['build']=mysql_result($rres,0,"users_pi.address_build");
  $address['flat']=mysql_result($rres,0,"users_pi.address_flat");
  $address['login']=mysql_result($rres,0,"users.id");
  $address['deposit']=mysql_result($rres,0,"bills.deposit");
  $address['credit']=mysql_result($rres,0,"users.credit");
  
  
  return($address);
}
mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");

$query="select uid,sum(duration) as total ,count(*) as sess from dv_log_2015_9 where start >= '2015-11-02' and start <'2015-11-30' group by uid having sess >= 30 order by sess";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
echo "<table border=1>";
echo "<tr><td>Номер</td><td>UID</td><td>login</td><td>Сессий</td><td>Адрес</td><td>Баланс</td></tr>";
for ($i=0;$i<$num;$i++) {
  $k=$i+1;
  $uid=mysql_result($res,$i,"uid");
  $sess=mysql_result($res,$i,"sess");
  $mem=users_info($uid);
//  var_dump($mem);
  $addr=$mem['street']." ".$mem['build']." ".$mem['flat'];
  $id=$mem['login'];
  $balans=$mem['deposit']+$mem['credit'];
  if ($balans < 0) {
    $balans="<font color=red>$balans</font";
  }
  echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></td><td>$id</td><td><b>$sess</b></td><td>$addr</td><td>$balans</td></tr>";
}
echo "</table>";
?>