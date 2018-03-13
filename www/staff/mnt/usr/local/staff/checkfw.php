#!/usr/local/bin/php -q
<?php
function check($ip) {
  $cmd="/sbin/ipfw show | /usr/bin/grep \"$ip \"";
//  echo $cmd;
  $fp=popen($cmd,"r");
  $c=0;
  while (!feof($fp)) {
    $str=fgets($fp,1024);
//    echo $c." ".$str."\n";
    $c++;    
  }
  pclose($fp);
  return($c);
}
$cmd="/sbin/ifconfig fxp0";
include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");
$pp=popen($cmd,"r");
while (!feof($pp)) {
  $str=fgets($pp,1024);
  $mem=explode(" ",$str);
  $ch=$mem[0];
  if (strlen(strstr($ch,"inet")) == 4) {
    $ip=$mem[1];
    if ((strlen(strstr($ip,"195.58")) > 5) && (strlen(strstr($ip,"10.195.58")) < 9)){
//      echo $mem[1]."\n";
      $dots=explode(".",$ip);
      $ips=$dots[0].".".$dots[1].".".$dots[2].".";
      $last=$dots[3]+1;
      $ips=$ips.$last;
      $rr=check($ips);
      if ($rr <  3 ) {
        echo $rr." ".$ips."\n\n";
        $query="select username from customers where ip like '$ips'";
        $res=mysql("mvs",$query);
        $num=mysql_num_rows($res);
        if ($num > 0) {
          $username=mysql_result($res,0,"username");
          $cmd="/etc/firewall/".$username;
          echo $cmd;
          $gg=popen($cmd,"r");
          while (!feof($gg)) {
            $strl=fgets($gg,1024);
            echo $strl;
          }
        }
      }
    }
  }
}
?>