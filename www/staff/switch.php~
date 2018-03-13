<?php

class switchoid {

   private $sysDescroid="SNMPv2-MIB::sysDescr.0";
//   private $ifIndex="IF-MIB::ifIndex";
   private $ifIndex="iso.3.6.1.2.1.2.2.1.1";
   
//   private $ifInError="IF-MIB::ifInErrors";
//   private $ifInError="iso.3.6.1.2.1.10.7.2.1.3";
   private $ifInError="iso.3.6.1.2.1.10.7.2.1.3";

//   private $ifOutError="IF-MIB::ifOutErrors";
   private $ifOutError="iso.3.6.1.2.1.10.7.2.1.16";
   private $ifMacReceiveError="iso.3.6.1.2.1.10.7.2.1.16";
   private $StpPriority="1.3.6.1.2.1.17.2.2";
   private $LastTopologyChange="1.3.6.1.2.1.17.2.3";
   public $community="public";

   public function stp_priority($ip,$community) {
      $data=snmpget($ip,$this->community,$this->StpPriority);
      $data=ereg_replace("INTEGER: ","",$data);
      return($data);
   }

   public function last_topology_changed($ip,$community) {
      $data=snmpget($ip,$this->community,$this->LastTopologyChanged);
      $data=ereg_replace("INTEGER: ","",$data);
      return($data);
   }

   public function info($ip) {
      $data=snmpget($ip,$this->community,$this->sysDescroid);
      $data=ereg_replace("STRING: ","",$data);
      $data=ereg_replace("\n"," ",$data);
      $data=ereg_replace("\n"," ",$data);
      $data=ereg_replace("\n"," ",$data);
      $data=ereg_replace("\n"," ",$data);
      $data=trim($data);

      return($data);
   }

   function ports($ip) {
      $port=snmpwalk($ip,$this->community,$this->ifIndex);
      return($port);
   }

   function ports_error($ip) {
      $value=snmpwalk($ip,$this->community,$this->ifInError);
//      echo "walk 1\n";
      $value1=snmpwalk($ip,$this->community,$this->ifOutError);
//      echo "walk 2\n";
      $port=snmpwalk($ip,$this->community,$this->ifIndex);
//      echo "walk 3\n";
      $num=count($port);
      for ($i=0;$i<$num;$i++) {
        $port[$i]=ereg_replace("INTEGER: ","",$port[$i]);
        $value[$i]=ereg_replace("Counter32:","",$value[$i]);
        $value1[$i]=ereg_replace("Counter32:","",$value1[$i]);
        $mem[$i][0]=$ip;
        $mem[$i][1]=$port[$i];
        $mem[$i][2]=$value[$i];
        $mem[$i][3]=$value1[$i];
//        echo $mem[$i][0]."\n";
      }
      return($mem);
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

//     echo $type;
     $tt=strlen(strstr($desc,"Virtual-Access"));
     if ($tt==0) {
     switch ($type) {
       case "ethernetCsmacd(6)":
         if ($port > 24 ) {
           $speed=125000000;
         } else {
           $speed=12500000;
         }
         break;
       case "gigabitEthernet(117)":
         $speed=125000000;
         break;
       default:
         if ($port > 24 ) {
           $speed=125000000;
         } else {
           $speed=12500000;
         }
         break;

     }

//     $speed=$this->speedport($ip,$port);



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
     $str=$str."  </table></div>\n";
  }  
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
include('cisco3750.php');
include('dlink.php');
include('wgsd1022.php');
include('edgecore.php');
include('edgecore3526.php');
include('edgecore3528.php');
include('edgecore4624.php');

include("/home/sl/staff/connect.inc");

// $a = new edgecore3528();
// $a->ports("10.90.90.31");
 $a = new edgecore();
// $a->info("195.72.157.250");
// $a->ports("195.72.157.250");
// $a->statusport("195.72.157.250",10002);
// $a->aliasport("195.72.157.250",10003);
// echo $a->cfg_mrtg_port_all("195.72.157.254","public");

/*
$query="select * from switch where name like 'edgecore%'";
$res=mysql("mvs",$query);
echo mysql_error();
$num=mysql_num_rows($res);
for ($i=0;$i<$num;$i++) {
  $ip=mysql_result($res,$i,"ip");
  $mem=$a->get_forward_transition($ip);
  $a->save_forward_db($mem);
  
} 
*/

?>