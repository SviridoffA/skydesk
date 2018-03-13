<?php

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
$query="select users.*,users_pi.*,users_last.* from users,users_pi,users_last  where users_last.uid=users.uid and users.uid=users_pi.uid and users.disable=0 and users_pi.__dom=$build";
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
    $last=mysql_result($res,$i,"users_last.last");
    $types=mysql_result($res,$i,"users_last.types");
    $tst=getdv($uid);
    if ($tst > 0) {
      $str=$str."<tr><td><font color=green>$k</font></td><td><font color=green>$id</font></td><td><font color=green>$street $build $flat</font></td><td><font color=green><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></font></td><td>$types</td></tr>";
    } else {
      $str=$str."<tr><td>$k</td><td>$id</td><td>$street $build $flat</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=\"_blank\">$uid</a></td>><td>$last</td><td>$types</td></tr>";
    }  
  }
  $str=$str."</table>";
  return($str);
}



function getnumberusers1($build) {
  mysql_connect("91.223.48.25","root","");
    mysql_set_charset("utf8");
    $query="select count(*) as total from users_pi where __dom=$build";
    $res=mysql("abills",$query);
   $get1=mysql_result($res,0,"total");	
 
  return($get1);
}

function info($ip,$community) {
  $data=snmpget($ip,$community,"1.3.6.1.2.1.1.1.0");
  echo "data=$data ip=$ip community=$community<br>";
  $data=ereg_replace("STRING: ","",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=ereg_replace("\n"," ",$data);
  $data=trim($data);
  echo "data=$data";     
  return($data);
}

function linkinfo1($build) {
  $query="select * from links_optica where buildid=$build";
  //echo "$query\n";
mysql_connect("localhost","root","zabbix");
  $res=mysql("sky_switch",$query);
  echo mysql_error();
  $num=mysql_num_rows($res);
  for ($i=0;$i<$num;$i++) {
    $buildid=mysql_result($res,$i,"buildid");
    $linktype=mysql_result($res,$i,"linktype");	
	$linkcolor=mysql_result($res,$i,"linktype");	
    $linkbuild=mysql_result($res,$i,"linkbuild");
	$linktypexxx=mysql_result($res,$i,"linktype");	
    $id=mysql_result($res,$i,"id");
   
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
    }
	
	switch ($linkcolor) {
      case 1:
		$color="#303030";
        break;
      case 2:
		$color="#435790";
        break;
      case 3:
		$color="#ff9900";
        break;
      case 4:
		$color="#33cc33";
        break;
    }
	
	switch ($linktypexxx) {
      case 1:
        $typexxx="Медный линк";
        break;
      case 2:
        $typexxx="Медный линк, оптика присутсвует";
        break;
      case 3:
        $typexxx="Оптика 100 Мбит";
        break;
      case 4:
        $typexxx="Оптика 1 Гбит";
        break;
    }
	
    $str['linktype']=$linktype;  
	$str['linkbuild']=$linkbuild;
	$str['linkcolor']=$color;
	$str['linktypexxx']=$types; 
//	$str['linkbuildgeo']=$linkbuildgeo;
	return($str);
  }

}
?>