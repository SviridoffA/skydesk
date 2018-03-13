<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
  mysql_connect("91.223.48.25","root","");
  mysql_set_charset("utf8");
  $query="select users_last.* from users_last,users,bills where bills.uid=users.uid and users_last.uid=users.uid and users_last.last like '0000-00-00 00:00:00'";

//  $query="select users_last.* from users_last,users,bills where bills.uid=users.uid  and users.disable=0 and users_last.uid=users.uid and users_last.last like '0000-00-00 00:00:00'";
//  $query="select users_last.* from users_last,users,bills where bills.uid=users.uid and bills.deposit >0 and users.disable=0 and users_last.uid=users.uid and users_last.last like '0000-00-00 00:00:00'";
//  $query="select dv_log.uid,max(DATE_ADD(start,INTERVAL duration second )) as last from dv_log where start >= '2015-01-01' group by uid order by last";
//  $query="select users_pi.*   from users,users_pi where users.disable=0 and users_pi.uid=users.uid";
  $res=mysql("abills",$query);
  $num=mysql_num_rows($res);
  echo "<table>";
  $k=0;
  for ($i=0;$i<$num;$i++) {
    $uid=mysql_result($res,$i,"users_last.uid");
//    $last=mysql_result($res,$i,"lasat");
//    $duration=mysql_result($res,$i,"duration");
    $query="select DATE_ADD(start,INTERVAL duration second ) as last  from dv_log where uid=$uid order by start desc";
    $res1=mysql("abills",$query);
    $nn=mysql_num_rows($res1);
    if ($nn > 0) {
      $last=mysql_result($res1,0,"last");
      $query="update users_last set last='$last' where uid=$uid";
      $res2=mysql("abills",$query);
      echo $query;
    }
  }
  echo "</table>";

?>