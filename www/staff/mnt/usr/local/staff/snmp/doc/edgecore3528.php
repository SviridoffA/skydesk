<?php

class edgecore3528 extends edgecore {

// oid for get mac address and port from witch
   private $snmpmac = '1.3.6.1.2.1.17.4.3.1.2';
   private $tftp = "10.195.58.248";

// community
   public $community='rwtenretni';


   function getmac($ip) {
     $a=snmpwalkoid($ip,$this->community,$this->snmpmac);

     for (reset($a); $i = key($a); next($a)) {
//       preg_match
       
       echo "$i: $a[$i]\n";
     }

 
   }

   function speedport($ip,$port) {
      $data=snmpget($ip,$this->community,"IF-MIB::ifSpeed.$port");
      $data=ereg_replace("Gauge32: ","",$data);
      $str=$this->statusport($ip,$port);
      if ($str == "lowerLayerDown(7)") {
         if (($port > 24 ) && ($port < 29)) {
           $data=$data/8*100;
         } else {
           $data=$data/8*10;
         }
      }
      return($data);
   }


   function savecfg($ipm,$file) {
     echo "savecfg($ip,$file)\n";
   } 

   function cfg_mrtg_port($ip,$port,$community) {
     $desc=$this->descport($ip,$port);
     $mac=$this->macport($ip,$port);
     $alias=$this->aliasport($ip,$port);
     $type=$this->typeport($ip,$port);

//     echo $type;
     if ($port < 29 ){
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

     $str="";
     if ($port > 28 ) return($str);
     
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


   function savetotftp($ip,$file,$tftp) {
     
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.3.0 i 4
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.6.0 a 10.90.90.4
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.4.0 s 90.31
// snmpset -v2c -c rwtenretni 10.90.90.31 1.3.6.1.4.1.259.6.10.94.1.24.1.8.0 i 2

// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.5.0 i 2 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.1.0 i 2
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.3.0 i 4
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.6.0 a 10.90.90.4 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.4.0 s 90.33 
// snmpset -v2c -c rwtenretni 10.90.90.33 1.3.6.1.4.1.259.6.10.94.1.24.1.8.0 i 2


// type file (Value = (1: opcode), (2: config), (3: bootRom), (5: loader))

snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.5.0","integer",2);

// source type (Values = (1: file), (2: runningCfg), (3: startUpCfg), (4: tftp), (5: unit), (6: http))

snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.1.0","integer",2);

// source file (Value = ES3528_52M_opcode_V1.1.3.8.bix)
//
// snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.2.0","string"," ");

// destanation file Values = (1: file), (2: runningCfg), (3: startUpCfg), (4: tftp), (5: unit), (6: http)

snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.3.0","integer",4);


snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.6.0","address",$tftp);

snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.4.0","string",$file);

snmp2_set($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.8.0","integer",2);

   }



}
?>
