<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
function getaddr($build) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  mysql_set_charset("utf8");
  $query="select * from __dom_list where id=$build";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  $name=mysql_result($res,0,"name");
  return($name);
}

function vlanlist($build) {
  mysql_connect("localhost","root","zabbix");
  $query="select vlanbuild.*,vlan.*  from vlan,vlanbuild where vlanbuild.buildid=$build and vlanbuild.vlanid=vlan.id order by vlan.vlan";
//  echo $query;
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
  $str="";
  for ($i=0;$i<$num;$i++) {
    $name=mysql_result($res,$i,"vlan.name");
    $vlan=mysql_result($res,$i,"vlan.vlan");
    $str=$str."<$vlan> $name <br>";
  }
  return($str);
}

function opticlist($build) {
  mysql_connect("localhost","root","zabbix");
  $query="select *  from links_optica where buildid=$build";
  $res=mysql("sky_switch",$query);
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
function getusers($build) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  mysql_set_charset("utf8");
  $query="select users_pi.*,dv_calls.* from users_pi,dv_calls where users_pi.__dom=$build and users_pi.uid=dv_calls.uid";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
//  echo $query.mysql_error();
  return($num);
}

function switchlist($build) {
  mysql_connect("localhost","root","zabbix");
  $query="select * from switch where buildid=$build and id !=0";
  $res=mysql("sky_switch",$query);
  echo $query;
  echo "switchlist ".mysql_error($res);
  $num=mysql_num_rows($res);
  $str="num=$num $query";
//  $str="<table>";
  $str="";
  for ($i=0;$i<$num;$i++) {
    $name=mysql_result($res,$i,"name");
    $ip=mysql_result($res,$i,"ip");
//    $str="<tr><td>$ip</td><td>$name</td></tr>";
    $str=$str."$ip $name<br>";
  }
//  $str=$str."</table>";
  return($str);
}

mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
$query="select __dom_list.name,__dom_list.id,users_pi.__dom,count(*) as total from users,users_pi,__dom_list where __dom_list.id=users_pi.__dom and users.uid=users_pi.uid and users.disable=0 group by __dom order by total,__dom_list.name";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
echo "num=$num ppppp";
echo "<table border=1>";
$l=0;
for ($i=0;$i<$num;$i++) {
  $k=$i+1;
  $sw="";
  $address=mysql_result($res,$i,"__dom_list.name");
  $users=mysql_result($res,$i,"total");
  $id=mysql_result($res,$i,"__dom_list.id");
//  $sw=switchlist($id);
  $vl=vlanlist($id);
  $op=opticlist($id);
  $numusers=getusers($id);
  if (($numusers == 0) && ($users > 2)) {
    $l++;
    echo "<tr><td>$l</td><td>$k</td><td><a href=build.php?build=$id>$address</a></td><td>$users</td><td>$sw</td><td>$vl</td><td>$op</td></tr>";
  }
}
echo "</table>";
?>
