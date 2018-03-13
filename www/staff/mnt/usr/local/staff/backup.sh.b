#!/usr/local/bin/php -q
<?php
function run($cmd) {
  $pp=popen($cmd,"r");
  $str = fread($pp, 100000);
  pclose($pp);
  return($str);
}
function savetable($table,$d) {
  $str="/usr/local/bin/mysqldump -phtvjyn mvs $table > /var/backup/$d/$table.sql";
  $res=run($str);
  echo $str."\n";
  if (strlen($res) > 5) {
    $str="$d sql dump table $table failed\n"; 
    $fp=fopen("/var/log/backup.log","a");
    fputs($fp,$str); 
    fclose($fp);
  }
  return($res);
}

$d=date("Ymd");
mkdir("/var/backup/$d",0700);
copy("/etc/ppp/chap-secrets","/var/backup/$d/chap-secrets");
copy("/usr/local/apache/servers/statmvs.mariupol.net/boss","/var/backup/$d/boss");
copy("/etc/rc.conf","/var/backup/$d/rc.conf");
copy("/usr/local/etc/ipa.conf","/var/backup/$d/ipa.conf");
copy("/etc/firewall/firewall.net","/var/backup/$d/firewall.net");
copy("/usr/local/apache/servers/statmvs.mariupol.net/auth","/var/backup/$d/auth");
/*
savetable("access_log",$d);
savetable("begstat",$d);
savetable("customers",$d);
savetable("deklar",$d);
savetable("dogovor",$d);
savetable("invoice",$d);
savetable("invoicerec",$d);
savetable("invps",$d);
savetable("ip",$d);
savetable("payment",$d);
savetable("pricelist",$d);
savetable("services",$d);
savetable("site_faq",$d);
savetable("site_news",$d);
savetable("site_request",$d);
savetable("site_special",$d);
savetable("summary",$d);
savetable("typeservice",$d);
savetable("usercontrol",$d);
savetable("sessions",$d);
savetable("data",$d);
*/

$str="/usr/local/bin/mysqldump -phtvjyn mvs > /var/backup/$d/mvs.sql";
$res=run($str);
echo $str;
if (strlen($res) > 5) {
  $str="$d sql dump failed\n"; 
  $fp=fopen("/var/log/backup.log","a");
  fputs($fp,$str); 
  fclose($fp);
}
$str="/usr/bin/gzip /var/backup/$d/mvs.sql";
$res=run($str);
if (strlen($res) > 5) {
  $str="$d sql dump gzip failed\n"; 
  $fp=fopen("/var/log/backup.log","a");
  fputs($fp,$str); 
  fclose($fp);
}
?>