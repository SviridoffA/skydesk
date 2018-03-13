<form>
</form>
<?php
mysql_connect("91.223.48.25","root","");
$sdate=$_GET['sdate'];
$edate=$_GET['edate'];

$query="select __dom_list.name,count(*) as total from msgs_messages,users_pi,__dom_list where users_pi.uid=msgs_messages.uid and users_pi.__dom=__dom_list.id and msgs_messages.date >= '$sdate' and msgs_messages.date >= '$edate' group by __dom_list.id order by total";
$res=mysql("abills",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $name=mysql_result($res,$i,"__dom_list.name");
  $total=mysql_result($res,$i,"total");
  echo "$name $total\n"; 
}

?>