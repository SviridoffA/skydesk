#!/usr/local/bin/php -q
<?php
include('/usr/local/apache/servers/statmvs.mariupol.net/include/function.inc');
include('/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc');
set_time_limit(3600);
$query="select * from customers where status < 10 and username not like 'r_line'";
$mres=mysql("mvs",$query);
$mnum=mysql_num_rows($mres);
echo "$mnum";
for($mm=0;$mm<$mnum;$mm++) {
  $username=mysql_result($mres,$mm,"username");
  echo "username=$username<br>\n";

  balans($username);

}
?>