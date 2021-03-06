<?php
class edgecore3526 extends edgecore {
// community
   public $community='rwtenretni';
   private $iosoid="1.3.6.1.4.1.259.8.1.5.1.7.1.0";

   function savetotftp($ip,$file,$tftp) {
      snmpset($ip,$this->community,"1.3.6.1.4.1.259.6.10.71.1.6.1","integer",2);

      snmpset($ip,$this->community,"1.3.6.1.4.1.259.6.10.71.1.6.2","string","startup1.cfg");
      snmpset($ip,$this->community,"1.3.6.1.4.1.259.6.10.71.1.6.3","string",$file);

      snmpset($ip,$this->community,"1.3.6.1.4.1.259.6.10.71.1.6.4","address",$tftp);
      snmpset($ip,$this->community,"1.3.6.1.4.1.259.6.10.94.1.24.1.8","integer",4);
     
   }

   function getios($ip) {
      $ios=snmpget($ip,$this->community,$this->iosoid);
      echo $ios;
   }
   function cfg_mrtg_port($ip,$port,$community) {
     $desc=$this->descport($ip,$port);
     $mac=$this->macport($ip,$port);
     $alias=$this->aliasport($ip,$port);
     $type=$this->typeport($ip,$port);

//     echo $type;
     if ($port < 27 ){
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
     if ($port > 26 ) return($str);


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


}

?>
