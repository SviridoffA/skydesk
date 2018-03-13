function getlist() {

mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
$query="select * from __dom_list order by name";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $address=mysql_result($res,$i,"__dom_list.name");
    $id=mysql_result($res,$i,"__dom_list.id");
    $str=$str."<option value=$id>$address</option>";
  
  }
  return($str);
}

function getdv($uid) {
mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
$query="select * from dv_calls where uid=$uid";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
return($num);
}

function getusers($build) {

mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
$query="select users.*,users_pi.* from users,users_pi where users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
$k=0;
$str="<table>";
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $k++;
    $id=mysql_result($res,$i,"users.id");
    $street=mysql_result($res,$i,"users_pi.address_street");
    $build=mysql_result($res,$i,"users_pi.address_build");
    $flat=mysql_result($res,$i,"users_pi.address_flat");
    $uid=mysql_result($res,$i,"users_pi.uid");
    $tst=getdv($uid);
    if ($tst > 0) {
      $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><font color=green>$street $build $flat</font></td><td><font color=green>$uid</font></td>></tr>";
    } else {
      $str=$str."<tr><td>$k</td><td>$id</td><td>$street $build $flat</td><td>$uid</td>></tr>";
    }  
  }
  $str=$str."</table>";
  return($str);
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
$build=$_GET['build'];
$address=getaddr($build);
echo "buildid=$build <b><br>address=$address</b><br><br>";
mysql_connect("localhost","root","zabbix");
mysql("sky_switch","SET NAMES 'cp1251'");
mysql("sky_switch","SET CHARACTER SET 'cp1251'");
