#!/usr/local/bin/php -q 
<?php
if ($argc < 2 ) {
  echo $argv[0]."  interface\n";
  exit;
}
$intf=$argv[1];
$cmd="/usr/local/bin/snmpwalk -v 1 -c tenretni 195.58.229.154 interfaces.ifTable.ifEntry.ifDescr";
$pp=popen($cmd,"r");
while (!feof($pp)) {
  $str=fgets($pp,1024);
//  echo $str;
  $mem=explode(" ",$str);
//  var_dump($mem);
  if ( strlen(strstr($mem[3],$intf)) >4) {
//    var_dump($mem);
//    echo $str;
    $mem1=explode(".",$mem[0]);
    $key=count($mem1);
    $inum=trim($mem1[$key-1]);
//    echo $inum;
    $cmd="/usr/local/bin/snmpget -v 1 -c tenretni 195.58.229.154 interfaces.ifTable.ifEntry.ifOutOctets.".$inum;
//    echo $cmd;
    $get1=popen($cmd,"r");
    while (!feof($get1)) {
      $out=fgets($get1,1024);
//      echo $out;
      $mem=explode(" ",$out);
      $keys=count($mem);
      $outo=trim($mem[$keys-1]);
      echo $outo." ";
    }   
    $cmd="/usr/local/bin/snmpget -v 1 -c tenretni 195.58.229.154 interfaces.ifTable.ifEntry.ifInOctets.".$inum;
//    echo $cmd;
    $get2=popen($cmd,"r");
    while (!feof($get2)) {
      $in=fgets($get2,1024);
//      echo $in;
      $mem=explode(" ",$in);
      $keys=count($mem);
      $ino=trim($mem[$keys-1]);
      echo "\n".$ino;
    }   
  }
}
// echo $outo."\n".$ino;
?>