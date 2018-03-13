#!/usr/local/bin/php5 -q
<?php

class switchoid {

   private $sysDescroid="SNMPv2-MIB::sysDescr.0";
   private $ifIndex="IF-MIB::ifIndex";
   private $community="public";

   public function info($ip) {
      $data=snmpget($ip,$this->community,$this->sysDescroid);
      $data=ereg_replace("STRING: ","",$data);
      return($data);
   }

   function ports($ip) {
      $port=snmpwalk($ip,$this->community,$this->ifIndex);
      return($port);
   }

   function statusport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifOperStatus.$port");
      $data=ereg_replace("INTEGER: ","",$data);
      return($data);
   }
   function descport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifDescr.$port");
      $data=ereg_replace("STRING: ","",$data);
      return($data);
   }
   function aliasport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifAlias.$port");
      $data=ereg_replace("STRING: ","",$data);
      return($data);;
   }
 
   function typeport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifType.$port");
      $data=ereg_replace("INTEGER: ","",$data);
      return($data);
   }

   function macport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifPhysAddress.$port");
      $data=ereg_replace("STRING: ","",$data);
      return($data);
   }
   function speedport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifSpeed.$port");
      $data=ereg_replace("Gauge32: ","",$data);
      return($data);
   }
/*  */
   function cfg_mrtg_port($ip,$port,$community) {
     $desc=$this->descport($ip,$port);
     $mac=$this->macport($ip,$port);
     $alias=$this->aliasport($ip,$port);
     $type=$this->typeport($ip,$port);
     $speed=$this->speedport($ip,$port);
     $speeddesc=$speed/1000;
     $speeddesc=$speeddesc.".0 kBytes/s"; 
     $system=$this->info($ip);
     $str="### Interface $port >> Descr: '$desc' | Name: 'Port $port'| Ip: '' | Eth: '$mac' ###\n";
     $str=$str."Target[".$ip."_$port]: $port:".$this->community."@$ip:::::2\n";
     $str=$str."SetEnv[".$ip."_$port]: MRTG_INT_IP=\"\" MRTG_INT_DESCR=\"$desc\"\n";
     $str=$str."MaxBytes[".$ip."_$port]: $speed\n";
     $str=$str."Title[".$ip."_$port]: Traffic Analysis for $port -- $alias\n";
     $str=$str."PageTop[".$ip."_$port]: <h1>Traffic Analysis for $port -- $alias</h1>\n";
     $str=$str."  <div id=\"sysdetails\">\n";
     $str=$str."  <table>\n";
     $str=$str."    <tr><td>System:</td><td>$system</td></tr>\n";
     $str=$str."      <tr><td>Maintainer:</td><td></td></tr>\n";
     $str=$str."      <tr><td>Description:</td><td>$desc</td></tr>\n";
     $str=$str."      <tr><td>ifType:</td><td>$type</td></tr>\n";
     $str=$str."      <tr><td>ifName:</td><td>Port $port</td></tr>\n";
     $str=$str."      <tr><td>Max Speed:</td><td>$speeddesc</td></tr>\n";
     $str=$str."</table></div>\n";
     return($str);
  }
  function cfg_mrtg_port_all($ip,$community) {
    $port=$this->ports($ip);
    $num=count($port);
    for ($i=0;$i<$num;$i++) {
      $index=$port[$i];
      $index=ereg_replace("INTEGER: ","",$index);
      $cfg=$cfg.$this->cfg_mrtg_port($ip,$index,"tenretni");
    }
    return($cfg);
  }
}


include('cisco.php');
include('edgecore.php');
include('edgecore3526.php');
include('edgecore3528.php');

include("/usr/local/apache/servers/statmvs.mariupol.net/include/connect.inc");

// $a = new edgecore3528();
// $a->ports("10.90.90.31");
 $a = new edgecore();
// $a->info("195.72.157.250");
// $a->ports("195.72.157.250");
// $a->statusport("195.72.157.250",10002);
// $a->aliasport("195.72.157.250",10003);
// echo $a->cfg_mrtg_port_all("195.72.157.254","public");
$query="select * from switch where name like 'edgecore%'";
$res=mysql("mvs",$query);
echo mysql_error();
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $mem=$a->get_forward_transition($ip);
  $a->save_forward_db($mem);
//  var_dump($mem);
  
} 


?>