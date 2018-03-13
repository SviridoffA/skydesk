<?php

function get_aid($uid) {
    mysql_connect("91.223.48.25","root","");
    mysql_set_charset("utf8");
    $query="select * from bills where uid=$uid";
    $res=mysql("abills",$query);
    $aid=mysql_result($res,0,"id");
    return($aid);    
        
}

function add_bill($uid,$add_bonus,$last_deposit) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="update bills set deposit=$last_deposit+$add_bonus where uid=$uid";
  $res=mysql("abills",$query);        
}

function add_bonus_payment($uid,$summ,$last_deposit,$aid) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from payments where uid=$uid and aid=77";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  if ($num == 0) {
    $bill_id=get_aid($uid);
    $query="insert into payments(date,sum,dsc,last_deposit,bill_id,uid,method,aid,ext_id)  values('2015-04-01',$summ,'add bonus 9+3',$last_deposit,$bill_id,$uid,4,77,'bonus20150331')"; 
//    $res=mysql("abills",$query);
//    add_bill($uid,$summ,$last_deposit);   
    echo "$query<br>";
  }
  return;
}

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
        break;
      case 350:
        return($fees);  
        break;
      case 380:
        return($fees);  
        break;
    }
  }
}

function last_feeds($uid) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from fees where uid=$uid and date >= '2015-03-01' order by date";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $fees=mysql_result($res,$i,"sum");
    switch ($fees) {
      case 330:
        return($fees);  
        break;
      case 430:
        return($fees);  
        break;
      case 480:
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
function payment_after($uid) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select sum(sum) as total from payments where uid=$uid and  date >= '2015-03-01'"; 
  $res=mysql("abills",$query);
  echo mysql_error();
  $payments=mysql_result($res,0,"total");
  return($payments);  
  
}

function check_payment_date($uid,$sdate) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select sum(sum) as total from payments where method!=4 and uid=$uid and date >= '$sdate 00:00:00' and date <= '$sdate 23:59:59'"; 
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
    $sdate=substr($sdate,0,10);
    $disable=$ret['disable'];
    $deposit=$ret['deposit'];
    $tp_id=$ret['tp_id'];
    $fees=get_feeds($uid);
//    $pay=check_payment($uid,$sdate);
    $pay=check_payment_date($uid,$sdate);
    if (($sum*3) <= $pay) {
      $status=1;
    } else {
      $status=0;
    }
//    echo "sum=$sum pay=$pay status=$status<br> ";
    
    if (($pay > 0) && ($status ==1)) {
    $payafter=payment_after($uid);
    $abon=last_feeds($uid);
    $befo_deposit=$deposit-$payafter+$abon;
    $month=$befo_deposit/$fees;
    $add_bonus=($abon-$fees)*$month;
    $last=$deposit+$add_bonus;
    if ($add_bonus >0) {
    add_bonus_payment($uid,$add_bonus,$deposit);
    $str="<tr><td>abon=$abon payafter=$payafter befo_deposit=$befo_deposit month=$month add_bonus=$add_bonus last=$last</td><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td>$sdate</td><td>$sum</td><td>$disable</td><td>$fees</td><td>$tp_id</td><td>$deposit</td><td>$last</td><td>$pay</td><td>$add_bonus</td></tr>\n";
    $fp=fopen("/tmp/bonus.log","a");
//    fputs($fp,$str);
    fclose($fp);
    echo $str;
//    exit;
    }
    }
    } else {
//    echo "<tr><td><font color=red>$k</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td>$sdate</td><td>$sum</td><td>$disable</td><td>$fees</td><td>$tp_id</td><td>$deposit</td><td>$last</td><td>$pay</td></tr>";
    }
  }
echo "</table>";
?>