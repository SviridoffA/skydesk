<?php
class edgecore3526 extends switchoid {
// community
   private $community='rwtenretni';
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
}

?>