<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
function get_start($uid) {
  $query="select min(start) as det from dv_log where uid=$uid";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $fees=mysql_result($res,0,"det");
    return($fees);
  }
}

function get_tp($uid) {
  $query="select tarif_plans.*,dv_main.* from tarif_plans,dv_main where tarif_plans.id=dv_main.tp_id and dv_main.uid=$uid";
//  echo "$query<br>";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    $fees=mysql_result($res,0,"tarif_plans.month_fee");
    return($fees);
  }
}

function get_metr($metr) {
  preg_match("/([0123456789]+)/",$metr,$match,PREG_OFFSET_CAPTURE, 0);
  $num=count($match);
  if ($num > 0) {
//    var_dump($match);
    $metr_digit=$match[0][0];
    return($metr_digit);
  } 
  return(0);
}
function getaddr($build) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from __dom_list where id=$build";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  $name=mysql_result($res,0,"name");
  return($name);
}

function getaddr_user($uid) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from __dom_list where id=$build";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  $name=$name." ".mysql_result($res,0,"address_street");
  $name=$name." ".mysql_result($res,0,"address_build");
  $name=$name." ".mysql_result($res,0,"address_flan");
  return($name);
}

function fees($uid,$year,$month) {
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select * from fees where uid=$uid and date >= '$year-$month-01 00:00:00' and date <= '$year-$month-31 23:59:59'";
//  echo $query;
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $sum=mysql_result($res,$i,"sum");
    $dsc=mysql_result($res,$i,"dsc");
    $aid=mysql_result($res,$i,"aid");
    $ret['dsc']=$ret['dsc'].$dsc." ".$sum."($aid)<br>";
    $ret['sum']=$ret['sum']+$sum;
  }
  return($ret);
}

function vlanlist($build) {
  mysql_connect("localhost","switch","flvbycjdctvflvby");
  $query="select vlanbuild.*,vlan.*  from vlan,vlanbuild where vlanbuild.buildid=$build and vlanbuild.vlanid=vlan.id order by vlan.vlan";
//  echo $query;
  $res=mysql("switch",$query);
  $num=mysql_num_rows($res);

  for ($i=0;$i<$num;$i++) {
    $name=mysql_result($res,$i,"vlan.name");
    $vlan=mysql_result($res,$i,"vlan.vlan");
    $str=$str."<$vlan> $name <br>";
  }
  return($str);
}

function opticlist($build) {
  mysql_connect("localhost","switch","flvbycjdctvflvby");
  $query="select *  from links_optica where buildid=$build";
  $res=mysql("switch",$query);
  $num=mysql_num_rows($res);

  for ($i=0;$i<$num;$i++) {
    $status=mysql_result($res,$i,"linktype");
    $address=mysql_result($res,$i,"linkbuild");
    $str=getaddr($address);
    switch ($status) {
      case 1:
        $ss="<Медный линк>";
        break;
      case 2:
        $ss="<Медный линк, Оптика присутсвует>";
        break;
      case 3:
        $ss="<Оптика 100 Мбит>";
        break;
      case 4:
        $ss="<Оптика 1 гбит>";
        break;
       
    }
    $str=$str." $ss ";
  }
  return($str);
}

function switchlist($build) {
  mysql_connect("localhost","switch","flvbycjdctvflvby");
  $query="select * from switch where buildid=$build and id !=0";
  $res=mysql("switch",$query);
//  echo "switchlist ".mysql_error($res);
  $num=mysql_num_rows($res);
//  $str="num=$num $query";
//  $str="<table>";
// $str="";
  for ($i=0;$i<$num;$i++) {
    $name=mysql_result($res,$i,"name");
    $ip=mysql_result($res,$i,"ip");
//    $str="<tr><td>$ip</td><td>$name</td></tr>";
    $str=$str."$ip $name<br>";
  }
//  $str=$str."</table>";
  return($str);
}
?>
<form>
Выбрать период
<select name=month>
<option value=1 >Январь</option>
<option value=2>Февраль</option>
<option value=3>Март</option>
<option value=4>Апрель</option>
<option value=5>Май</option>
<option value=6>Июнь</option>
<option value=7>Июль</option>
<option value=8>Август</option>
<option value=9>Сентябрь</option>
<option value=10>Октябрь</option>
<option value=11>Ноябрь</option>
<option value=12>Декабрь</option>
</select>
<select name=year>
<option value=2012>2012</option>
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option selected value=2016>2016</option>
</select>
<input type=submit>
</form>
<?php
  mysql_connect("91.223.48.25","root","");

$month=$_GET['month'];
$year=$_GET['year'];
$sday=1;
if (!empty($month)) {
} else {
  $year=date("Y");
  $month=date("m");
}

if (!empty($year)) {
} else {
  $year=2014;
}


  switch ($month) {
    case 1:
      $fday=31;
      break;
    case 2:
      $fday=28;
      break;
    case 3:
      $fday=31;
      break;
    case 4:
      $fday=30;
      break;
    case 5:
      $fday=31;
      break;
    case 6:
      $fday=30;
      break;
    case 7:
      $fday=31;
      break;
    case 8:
      $fday=31;
      break;
    case 9:
      $fday=30;
      break;
    case 10:
      $fday=31;
      break;
    case 11:
      $fday=30;
      break;
    case 12:
      $fday=31;
      break;
  }


function payments($uid,$sdate,$ldate) {
  mysql_connect("91.223.48.25","root","");
//  echo "sdate=$sdate ldate=$ldate";
  mysql_set_charset("utf8");
  $query="select sum(sum) as total from payments where date >= '$sdate' and date <= '$ldate 23:59:59' and uid=$uid";
//  echo "$query<br>";
  $res1=mysql("abills",$query);
  $total=mysql_result($res1,0,"total");
  return($total);
}

mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
$sdate=$year."-".$month."-".$sday;
$ldate=$year."-".$month."-".$fday;
$query="select users.*,users_pi.* from users,users_pi where users.uid=users_pi.uid and users.registration >= '$year-$month-$sday' and users.registration <= '$year-$month-$fday' ";
$res=mysql("abills",$query);
//echo $query;
echo mysql_error();
$num=mysql_num_rows($res);
// echo "num=$num";
switch ($month) {
  case 1:
    $m="Январь";
    break;
  case 2:
    $m="Февраль";
    break;
  case 3:
    $m="Март";
    break;
  case 4:
    $m="Апрель";
    break;
  case 5:
    $m="Май";
    break;
  case 6:
    $m="Июнь";
    break;
  case 7:
    $m="Июль";
    break;
  case 8:
    $m="Август";
    break;
  case 9:
    $m="Сентябрь";
    break;
  case 10:
    $m="Октябрь";
    break;
  case 11:
    $m="Ноябрь";
    break;
  case 12:
    $m="Декабрь";
    break;
}
echo "<b> $m $year</b>";
echo "<table border=1>";
echo "<tr><td>Номер</td><td>Клиент</td><td>Дата регистрации</td><td>Данные о метраже</td><td>Кол-во витой</td><td>Оптика</td><td>Оптика метров</td></tr>";
for ($i=0;$i<$num;$i++) {
  $k=$i+1;
  $login=mysql_result($res,$i,"users.id");
  $fio=mysql_result($res,$i,"users_pi.fio");
  $uid=mysql_result($res,$i,"users_pi.uid");
  $address="<br>".mysql_result($res,$i,"users_pi.address_street");
  $address=$address." ".mysql_result($res,$i,"users_pi.address_build");
  $address=$address." ".mysql_result($res,$i,"users_pi.address_flat");
  $metr=mysql_result($res,$i,"users_pi.___metr");
  $vols=mysql_result($res,$i,"users_pi.__vols");
  $metr_digit=get_metr($metr);
  $dsc=fees($uid,$year,$month);
  $total_sum=$total_sum+$dsc['sum'];
  $descr=$dsc['dsc'];
  $total=payments($uid,$sdate,$ldate);
  $vols_digit=get_metr($vols);
  $fees=get_tp($uid);
  $start=get_start($uid);
  $registration=mysql_result($res,$i,"users.registration");
  $id=mysql_result($res,$i,"__dom_list.id");
  echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=_blank>$login $uid $fio $address</a></td><td>$registration</td><td>$metr</td><td>$metr_digit</td><td>$vols</td><td>$vols_digit</td><td>$descr</td><td>$total</td><td>$fees</td><td>pp$start</td></tr>";
  $total_fees=$total_fees+$fees;
  $total_metr=$total_metr+$metr_digit;
  $total_vols=$total_vols+$vols_digit;
  $total_total=$total_total+$total;
  
}
echo "</table>";
echo "<br><b>Всего кабеля $total_metr метров</b>";
echo "<br><b>Всего оптического кабеля $total_vols метров</b><br><br>";
echo "<br><b>Всего начислений на новых абонентов $total_sum рублей</b><br><br>";
echo "<br><b>Всего оплачено за новых абонентов $total_total рублей</b><br><br>";
echo "<br><b>Всего абонплаты у новых абонентов $total_fees рублей</b><br><br>";
?>