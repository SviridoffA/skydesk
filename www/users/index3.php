<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
//  $query="select dv_log.uid,max(DATE_ADD(start,INTERVAL duration second )) as last from dv_log where start >= '2015-01-01' group by uid order by last";
//  $query="select dv_log.uid,max(start) as last  from dv_log where start > '2015-01-01'  group by uid order by last desc";
  $query="select users.*,users_pi.*,users_last.*,bills.* from users,users_pi,users_last,bills where bills.uid=users.uid and users.uid=users_pi.uid and users.uid=users_last.uid  order by users_last.last desc";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  echo "<table>";
  $k=0;
  for ($i=0;$i<$num;$i++) {
    $uid=mysql_result($res,$i,"users.uid");
    $last=mysql_result($res,$i,"users_last.last");
    $k++;
    $street=mysql_result($res,$i,"users_pi.address_street");
    $phone=mysql_result($res,$i,"users_pi.phone");
    $home_phone=mysql_result($res,$i,"users_pi._home_phone");
    $build=mysql_result($res,$i,"users_pi.address_build");
    $flat=mysql_result($res,$i,"users_pi.address_flat");
    $disable=mysql_result($res,$i,"users.disable");
    if ($disable ==1 ) {
      echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=_blank>$uid</a></td><td><font color=red>$last</font></td><td>$street $build $flat</td><td>\'$phone $home_phone</td></tr>";
    } else {
      echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=_blank>$uid</a></td><td>$last</td><td>$street $build $flat</td><td>\'$phone $home_phone</td></tr>";
    }
  }
  echo "</table>";

?>