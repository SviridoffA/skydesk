#!/usr/local/bin/php -q
<?php
function syslogwrite($str) {

define_syslog_variables();
// open syslog, include the process ID and also send
// the log to standard error, and use a user defined
// logging mechanism
    openlog("arpchange", LOG_PID | LOG_PERROR, LOG_LOCAL0);
    $access = date("Y/m/d H:i:s");
    syslog(LOG_WARNING,"$access $str");

  closelog();
  return;
}
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$arp="/usr/sbin/arp";
$grep="/usr/bin/grep";
$cut="/usr/bin/cut";
$cmd="$arp -a | $grep -v incomplete | $grep -v ff:ff:ff:ff:ff:ff | $grep -v 195.58.234 | $grep -v 195.58.229 | $cut -d \" \" -f 2-4";
echo $cmd."\n";
$pp=popen($cmd,"r");
while (!feof($pp)) {
  $str=fgets($pp,1024);
  $str=substr($str,1,strlen($str)-2);
  $mac=substr($str,strlen($str)-17,18);
  $ip=substr($str,0,strlen($str)-22);
  if (!empty($mac)) {
    $query="INSERT into ip(ip,mac,date) values('$ip','$mac',now())\n";
    $res=mysql("mvs",$query);
    $str=mysql_error();
    if ($str) {
      if (strlen(strstr($str,"Duplicate entry")) >=16 ) {
//        echo "duplicate $ip\n";
        $q="select * from ip where ip like '$ip' and mac like '$mac'";
        $tst=mysql("mvs",$q);
        if (mysql_num_rows($tst) ==1 ) {
//           echo "not change mac ";
           $q="update ip set date=now() where ip like '$ip'";
//           syslogwrite("change mac for ip to $mac from $omac"); 
           mysql("mvs",$q);
        } else {
//           echo "change mac";
           $q="select * from ip where  ip like '$ip'";
           $rip=mysql("mvs",$q);
           $omac=mysql_result($rip,0,"mac");
           syslogwrite("change mac for ip $ip to $mac from $omac"); 
           $q="update ip set mac='$mac',date=now() where ip like '$ip'";
           $rip=mysql("mvs",$q);
        }

      } else {
        echo $query;
        echo $str;
      }
    }
  }
}
?>