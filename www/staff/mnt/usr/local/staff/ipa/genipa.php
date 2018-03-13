<?php
function check($username) {
  $query="select * from summary where username like '$username' order by sdate desc ";
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num >0) {
     $payment=mysql_result($res,0,"payments");
     $mb=mysql_result($res,0,"mbyte");
     if (($payment > 0 ) || ($mb > 100)) return(1);
  }
  if ($num >1) {
     $payment=mysql_result($res,1,"payments");
     $mb=mysql_result($res,1,"mbyte");
     if (($payment > 0 ) || ($mb > 10)) return(1);
  }
  $query="select * from sessions where username like '$username' and dateStart > date_sub(now(),interval 2 month)";   
  $res=mysql("mvs",$query);
  $num=mysql_num_rows($res);
  if ($num > 0) {
    echo "$username\n";
    return(1);
  }
  return(0);
}
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$query="select * from customers order by username";
$res=mysql("mvs",$query);
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $username=mysql_result($res,$i,"username");
  $test=check($username);
  if (($test))  {
//    echo "$username $test\n";
    
  }
}

?>