<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
<a href=index.php>Список домов</a><br><br>

<?php

function getlist() {

mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
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

function getlistcomments() {

mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
$query="select * from job";
$res=mysql("sky_switch",$query);
echo $query;
echo mysql_error();
$num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $address=mysql_result($res,$i,"name");
    $id=mysql_result($res,$i,"id");
    $str=$str."<option value=$id>$address</option>";
  
  }
  return($str);
}

function getdv($uid) {
mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");
$query="select * from dv_calls where uid=$uid";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
return($num);
}

function getusers($build) {

mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
mysql_set_charset("utf8");
//$query="select users.*,users_pi.*,users_last.* from users,users_pi,users_last  where users_last.uid=users.uid and users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
//$query="select users.*, from users,users_pi where users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
$query="select users.id, users.disable, users_pi.uid, users_pi.fio, users_pi.phone from users, users_pi where users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
$k=0;
$str="<table>";
  for ($i=0;$i<$num;$i++) {
    $sw="";
    $k++;
    $id=mysql_result($res,$i,"users.id");
//    $street=mysql_result($res,$i,"users_pi.address_street");
//    $build=mysql_result($res,$i,"users_pi.address_build");
//    $flat=mysql_result($res,$i,"users_pi.address_flat");
    $uid=mysql_result($res,$i,"users_pi.uid");
    $name=mysql_result($res,$i,"users_pi.fio");
    $phone=mysql_result($res,$i,"users_pi.phone");
//    $last=mysql_result($res,$i,"users_last.last");
//    $types=mysql_result($res,$i,"users_last.types");
    $tst=getdv($uid);
    if ($tst > 0) {
    $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td><font color=green>$name</font></td></a></font></td><td>$phone</td></tr>";   
//   $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><font color=green>$street $build $flat</font></td><td><font color=green><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></font></td><td>$types</td></tr>";
    } else {
//    $str=$str."<tr><td>$k</td><td>$id</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</td><td>$nam у$street $build $flat</td></a></font></td><td>$phone</td></tr>";
    $str=$str."<tr><td><font color=red>$k</font></td><td><font color=red>$id</font></td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></td>><td><font color=red>$name</font></td><td>$phone</td></tr>";
    }  
  }
  $str=$str."</table>";
  return($str);
}



function getaddr($build) {
  mysql_connect("91.223.48.25","skydesk","skyinet@list.ru");
  mysql_set_charset("utf8");
  $query="select * from __dom_list where id=$build";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  $name=mysql_result($res,0,"name");
  return($name);
}
$build=$_GET['build'];
$user=$_SERVER["REMOTE_USER"];

$address=getaddr($build);
echo "buildid=$build <b><br>address=$address</b><br><br>";
mysql_connect("localhost","root","zabbix");
mysql("sky_switch","SET NAMES 'cp1251'");
mysql("sky_switch","SET CHARACTER SET 'cp1251'");
echo "--- $build ----";
$remove=$_GET['idswitchremove'];
if (!empty($remove)) {
  $query="update switch set buildid=0 where id=$remove";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$fileupload=$_GET['fileupload'];
if (!empty($fileupload)) {
  $date="";
  $path="/var/www/images/$build";  
  $query="insert into photo(buildid,path,date,user) VALUES ($build,'',now(),'$user')";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}


$adddesc=$_GET['adddesc'];
if (!empty($adddesc)) {
// echo phpinfo();
mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
//  mysql("sky_switch","SET NAMES 'utf8'");
//  mysql("sky_switch","SET CHARACTER SET 'utf8'");
  $desc=$_GET['desc'];
  $add_job=$_GET['add_job'];
  $query="insert into comments(domid,user,date,description,types) values($build,'$user',now(),'$desc','$add_job')";
  $res=mysql("sky_switch",$query);
  echo $query;
  echo mysql_error();
}

$idvlanremove=$_GET['idvlanremove'];
if (!empty($idvlanremove)) {
  $query="delete from vlanbuild where id=$idvlanremove";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$delete_links_optic=$_GET['delete_links_optic'];
if (!empty($delete_links_optic)) {
  $query="delete from links_optica where buildid=$build and id=$delete_links_optic";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$add=$_GET['idswitchadd'];
if (!empty($add)) {
  $query="update switch set buildid=$build where id=$add";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}


$idvlanadd=$_GET['idvlanadd'];
if (!empty($idvlanadd)) {
  $query="insert into vlanbuild(vlanid,buildid) values($idvlanadd,$build )";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$addoptic=$_GET['addoptic'];
if (!empty($addoptic)) {
  $query="insert into optica(buildid,status) values($build,'$addoptic')";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$add_links_optic=$_GET['add_links_optic'];
if (!empty($add_links_optic)) {
  $linktype=$_GET['linktype'];
  $query="insert into links_optica(buildid,linkbuild,linktype) values($build,'$add_links_optic',$linktype)";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

$delete_optic=$_GET['delete_optic'];
if (!empty($delete_optic)) {
  $query="delete from optica where buildid=$delete_optic";
  $res=mysql("sky_switch",$query);
  echo mysql_error();
}

// $idvlanadd=$_GET['idvlanadd'];
//if (!empty($idvlanadd)) {
//  $query="insert into vlanbuild(vlanid,buildid) values($idvlanadd,$build )";
//  $res=mysql("sky_switch",$query);
//  echo mysql_error();
//}



// mysql("sky_switch","SET NAMES 'cp1251'");
// mysql("sky_switch","SET CHARACTER SET 'cp1251'");
mysql("sky_switch","SET character_set_results = utf8");
$query="select * from switch where buildid=$build and status=1";
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
echo "<table>";
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $name=mysql_result($res,$i,"name");
  $idswitch=mysql_result($res,$i,"id");
  echo "<tr><td>$ip</td><td>$name</td><td><form name=remove ><input name=idswitchremove type=hidden value=$idswitch><input type=hidden name=build value=$build><input type=submit value=\"remove switch\"></form></td></tr>";
}
?>
</table>


<?php

$query="select vlan.*,vlanbuild.* from vlan,vlanbuild where vlanbuild.buildid=$build and vlan.id=vlanbuild.vlanid order by vlan.vlan";
// echo $query;
$res=mysql("sky_switch",$query);
$num=mysql_num_rows($res);
echo "<table>";
for ($i=0; $i< $num; $i++) {
  $vlan=mysql_result($res,$i,"vlan.vlan");
  $name=mysql_result($res,$i,"vlan.name");
  $id_vlan_build=mysql_result($res,$i,"vlanbuild.id");
  if ($i > 0 ) {
    $sql_vlan=$sql_vlan." and vlan != $vlan";
  } else {
    $sql_vlan=$sql_vlan." vlan != $vlan";
  }
  echo "<tr><td>$vlan</td><td>$name</td><td><form name=remove ><input name=idvlanremove type=hidden value=$id_vlan_build><input type=hidden name=build value=$build><input type=submit value=\"remove vlan\"></form></td></tr>";
}
?>
</table>






<?php
  $query="select * from switch where buildid=0 and status=1";
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
//  echo "num=$num ".$query;
?>  

<form name=addswitch>
<input type=hidden name=build value=<?php echo $build;?>>
<select name=idswitchadd>
  
<?php
  for ($i=0;$i<$num;$i++) {
    $ip=mysql_result($res,$i,"ip");
    $idswitch=mysql_result($res,$i,"id");
    $address=mysql_result($res,$i,"address");
    echo "<option value=$idswitch>$ip $address </option>";
//    echo "$idswitch $ip $address<br>";
  }
?>
</select> 
<input type=submit value="add switch">
</form>


<?php
  $query="select * from vlan";
  if (!empty($sql_vlan )) {
    $query=$query." where ".$sql_vlan." order by vlan";
  }
//  echo $query;
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
//  echo "num=$num ".$query;
?>  

<form name=addvlan>
<input type=hidden name=build value=<?php echo $build;?>>
<select name=idvlanadd>
  
<?php
  for ($i=0;$i<$num;$i++) {
    $id=mysql_result($res,$i,"id");
    $vlan=mysql_result($res,$i,"vlan");
    $name=mysql_result($res,$i,"name");
    echo "<option value=$id>$vlan $name </option>";
//    echo "$idswitch $ip $address<br>";
  }
?>
</select> 
<input type=submit value="add vlan">
</form>
<form name=optica>
<input type=hidden name=build value=<?php echo $build;?>>
<?php
/*
  $dd=0;
  $query="select * from optica where buildid=$build";
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $dd++;
    $status=mysql_result($res,$i,"status");
  switch ($status) {
    case 1:
      echo "Оптика присутсвует не подключена ";    
      break;
    case 2:
      echo "Оптика подключена 100Мбит ";    
      break;
    case 3:
      echo "Оптика подключена 1 Гбит ";    
      break;
      
  }  
  echo "<input type=hidden name=delete_optic value=\"$build\">";
  echo "<input type=submit value=\"remove optic\">";
  }
  echo "</form>";
  if ($dd==0) {
    echo "<form name=addoptics><input type=hidden name=build value=\"$build\">";
    echo "<select name=addoptic>";
    echo "<option value=1>Присутвует не подключена</option>";
    echo "<option value=2>Подключена 100Мбит</option>";
    echo "<option value=3>Подключена 1 Гбит</option>";
    echo "</select>";
    echo "<input type=submit  value=\"add optic\">";
    echo "</form>";
  }
*/  
?>
</form>




<b>Линки</b><br>

<?php
  $query="select * from links_optica where buildid=$build";
  $res=mysql("sky_switch",$query);
  $num=mysql_num_rows($res);
  
  echo "<table>";
  for ($i=0;$i<$num;$i++) {
    $linkbuild=mysql_result($res,$i,"linkbuild");
    $linktype=mysql_result($res,$i,"linktype");
    $linkbuildid=mysql_result($res,$i,"id");
    $address=getaddr($linkbuild);
    switch ($linktype) {
      case 1:
        $types="Медный линк";
        break;
      case 2:
        $types="Медный линк, оптика присутсвует";
        break;
      case 3:
        $types="Оптика 100 Мбит";
        break;
      case 4:
        $types="Оптика 1 Гбит";
        break;
      case 5:
        $types="Оптика GPON";
        break;
    }
    echo "<tr><td><a href=build.php?build=$linkbuild>$address $types </a></td>";  
    echo "<td><form><input type=hidden name=delete_from_links_optic value=\"$build\">";
    echo "<input type=hidden name=delete_links_optic value=\"$linkbuildid\">";
    echo "<input type=hidden name=build value=\"$build\">";
    echo "<input type=submit value=\"remove optic links\"></form></td></tr>";
  }  
  echo "</table>";
  echo "<br><br>";
  
  echo "<b>Добавить линк</b><br>";
  echo "<form name=addlinks>";
  echo "<input type=hidden name=build value=$build>";
  echo "<select name=add_links_optic>";
  echo getlist();
  echo "</select>";
  echo "<select name=linktype>";
  echo "<option value=1>Медный линк</option>";
  echo "<option value=2>Медный линк, Оптика присутсвует</option>";
  echo "<option value=3>Оптический линк 100 Мбит</option>";
  echo "<option value=4>Оптический линк 1 Гбит</option>";
  echo "<option value=5>Оптический линк GPON</option>";
  echo "</select>";
  echo "<input type=submit value=\"add links optic\">";
?>
</form>

<br><br><br><b>К дому подключены</b><br><br>
<?php
  $query="select * from links_optica where linkbuild=$build";
mysql_connect("localhost","root","zabbix");
  $res=mysql("sky_switch",$query);
  echo mysql_error();
  $num=mysql_num_rows($res);
  
//  echo "<table>";
  for ($i=0;$i<$num;$i++) {
    $linkbuild=mysql_result($res,$i,"buildid");
    $linktype=mysql_result($res,$i,"linktype");
    $linkbuildid=mysql_result($res,$i,"id");
    $address=getaddr($linkbuild);
    switch ($linktype) {
      case 1:
        $types="Медный линк";
        break;
      case 2:
        $types="Медный линк, оптика присутсвует";
        break;
      case 3:
        $types="Оптика 100 Мбит";
        break;
      case 4:
        $types="Оптика 1 Гбит";
        break;
      case 5:
        $types="Оптика GPON";
        break;
    }
    echo "<a href=build.php?build=$linkbuild>$address $types</a><br>";  
//    echo "<tr><td>$address $types</td>";  
//    echo "<td><form><input type=hidden name=delete_from_links_optic value=\"$build\">";
//    echo "<input type=hidden name=delete_links_optic value=\"$linkbuildid\">";
//    echo "<input type=hidden name=build value=\"$build\">";
//    echo "<input type=submit value=\"remove optic links\"></form></td></tr>";
  }  
//  echo "</table>";
  echo "<br><br>";

echo "<b>Клиенты</b>";
$str=getusers($build);
echo $str;

mysql_connect("localhost","root","zabbix");
mysql_set_charset("utf8");
$query="select comments.*,job.* from comments,job where comments.domid=$build and job.typeid=comments.types order by comments.date";
$re1=mysql("sky_switch",$query);
$nn2=mysql_num_rows($re1);
echo "<br><br>";
echo "<table>";
for($k=0;$k<$nn2;$k++) {
  $date=mysql_result($re1,$k,"date");
  $user=mysql_result($re1,$k,"user");
  $desc=mysql_result($re1,$k,"description");
  $typ=mysql_result($re1,$k,"job.name");
  echo "<tr><td>$date</td><td>$user</td><td>$typ</td><td>$desc</td></tr>";
}
echo "</table>";

echo "<br><br>";
    echo "<form name=addcomm>";

    echo "<select name=add_job>";
    echo getlistcomments();    
//    echo "<option value=1>Информационное </option>";
//    echo "<option value=2>Задача </option>";
    echo "</select>";
echo "<br>";
    echo "<textarea name=\"desc\"></textarea>";
    echo "<input type=hidden name=adddesc value=\"adddesc\">";
    echo "<input type=hidden name=build value=\"$build\"><br>";
    echo "<input type=submit value=\"add description\"></form>";


echo "<form name=addphoto method=\"post\" enctype=\"multipart/form-data\">";
echo "<input type=file name=fileupload>";
echo "<input type=\"submit\" value=\"Upload Image\" name=\"submit\">";
echo "</form>";
