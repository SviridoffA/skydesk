<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<form>
<select name=group>
<option value=1>Юридические лица</option>
<option value=0>Все</option>
</select>
<input type=submit>
</form>
<?php
$group=$_GET['group'];
echo "group=$group";
mysql_connect("91.223.48.25","root","");
mysql_set_charset("utf8");
if ($group) {
  $query="select msgs_messages.*,users.*,users_pi.*,msgs_chapters.*,groups.* from  groups,users_pi,msgs_messages,users,msgs_chapters where users.gid=3 and users.gid=groups.gid and msgs_messages.chapter=msgs_chapters.id and users_pi.uid=users.uid and users.uid=msgs_messages.uid and users.disable=0 and closed_date like '0000-00-00' order by msgs_messages.date";
} else {
  $query="select msgs_messages.*,users.*,users_pi.*,msgs_chapters.*,groups.* from  groups,users_pi,msgs_messages,users,msgs_chapters where users.gid=groups.gid and msgs_messages.chapter=msgs_chapters.id and users_pi.uid=users.uid and users.uid=msgs_messages.uid and users.disable=0 and closed_date like '0000-00-00' order by msgs_messages.date";
}
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
echo "<table border=1>";
for ($i=0;$i<$num;$i++) {
  $uid=mysql_result($res,$i,"users.uid");
  $date=mysql_result($res,$i,"date");
  $k=$i+1;
  $message=mysql_result($res,$i,"msgs_messages.subject");
  $chapter=mysql_result($res,$i,"msgs_chapters.name");

  $priority=mysql_result($res,$i,"priority");
  $gid=mysql_result($res,$i,"groups.descr");
/*
  $=mysql_result($res,$i,"");
  $=mysql_result($res,$i,"");
  $=mysql_result($res,$i,"");
  $=mysql_result($res,$i,"");
  $=mysql_result($res,$i,"");
  $=mysql_result($res,$i,"");
*/  
  echo "<tr><td>$k</td><td><a href=https://91.223.48.25:9443/admin/index.cgi?index=15&UID=$uid target=_blank>$uid</a></td><td>$gid</td><td>$date</td><td>$priority</td><td>$chapter</td><td>$message</td></tr>";
}
echo "</table>";

?>