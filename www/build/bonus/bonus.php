<?php
function get_feeds($uid) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from fees where uid=$uid and date < '2015-03-01' order by date desc";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $fees=mysql_result($res,$i,"sum");
    switch ($fees) {
      case 210:
        return($fees);  
        break;
      case 230:
        return($fees);  
        break;
      case 270:
        return($fees);  
      case 350:
        return($fees);  
      case 380:
        return($fees);  
        break;
    }
  }
}
function check_payment($uid,$sdate) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select sum(sum) as total from payments where method!=4 and uid=$uid and date > '$sdate' and date < '2015-03-01'"; 
  $res=mysql("abills",$query);
  echo mysql_error();
  $payments=mysql_result($res,0,"total");
  return($payments);  
  
}

function check_user($uid,$sum,$sdate) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select users.*,dv_users_bills_view.* from users,dv_users_bills_view where dv_users_bills_view.uid=users.uid and users.uid=$uid";
  $res=mysql("abills",$query);
  $disable=mysql_result($res,0,"users.disable");
  $tp_id=mysql_result($res,0,"dv_users_bills_view.tp_id");
  $deposit=mysql_result($res,0,"dv_users_bills_view.deposit");
  $ret['disable']=$disable;
  $ret['deposit']=$deposit;
  $ret['tp_id']=$tp_id;
  return($ret);  
}
mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");

$query="select * from payments where method=4 and date < '2014-06-04' and date > '2014-04-01 00:00:00' order  by date";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
echo "<table border=1>";
$k=0;
for ($i=0;$i<$num;$i++) {
  $k++;
  $uid=mysql_result($res,$i,"uid");
  $sdate=mysql_result($res,$i,"date");
  $sum=mysql_result($res,$i,"sum");
  if ($sum >= 165) {
    $ret=check_user($uid,$sum,$sdate);
    $disable=$ret['disable'];
    $deposit=$ret['deposit'];
    $tp_id=$ret['tp_id'];
    $fees=get_feeds($uid);
    $pay=check_payment($uid,$sdate);
    switch ($tp_id) {
      case 20:
        $last=(($deposit+$fees)/$fees)*330-330;
        break;
      case 21:
        $last=(($deposit+$fees)/$fees)*430-430;
        break;
      case 22:
        $last=(($deposit+$fees)/$fees)*480-480;
        break;    
    }
    if (empty($pay)) {
    echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td>$sdate</td><td>$sum</td><td>$disable</td><td>$fees</td><td>$tp_id</td><td>$deposit</td><td>$last</td><td>$pay</td></tr>";
    } else {
    echo "<tr><td><font color=red>$k</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td>$sdate</td><td>$sum</td><td>$disable</td><td>$fees</td><td>$tp_id</td><td>$deposit</td><td>$last</td><td>$pay</td></tr>";
    }
  }
}
echo "</table>";
?>